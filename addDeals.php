<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - DEALS</title>
  <?php require('inc/links.php'); ?>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
    }

    .imagesDivStyle{
      width: 610px;
      border: 1px gray solid;
      padding: 5px;
      margin-left: 300px;
      margin-bottom: 20px;
    }

    .imgs{
      height: 80px;
      width: 100px;
      border: 1px black dashed;
      margin: 5px;
    }

    label{
      display: inline-block;
      width: 120px;
      margin-left: 300px
    }

    input,
    textarea{
      width: 600px;
      border: gray 1px solid;
      resize: none;
      padding: 8px
    }


    textarea{
      height: 100px;
    }

    .pointers{
      border: 1px darkslateblue dashed;
    }

    #pdlab{
      height: 100px;
      vertical-align: top;  
    }

    #controldiv{
      width: 740px;
    }

    #loadlab{
      width: 200px;
    }
  </style>

  
</head>
<body>
<?php require('inc/header.php'); ?>




        
              <label class = "dealName">Deal Name</label><input type="text" id="deal_name" name="deal_name"> <br></br>
              <label class = "dealName">Price</label><input type="number" id="deal_price" name="deal_price" required min="1" title="Deal price must be greater than 1"><br></br>
              <label class = "dealName">Deal Description</label> <textarea id="deal_description" name="deal_description"></textarea> <br></br>
              <label class = "dealName">Deal Terms and Conditions</label> <textarea id="deal_tc" name="deal_tc"></textarea> <br></br>
              <label class = "dealName">Comment</label> <textarea id="deal_comment" name="deal_comment"></textarea> <br></br>

              <div id="imagesDiv"></div>

              <div id="controldiv">
                <label id="loadlab"></label>
                <button id="adddealbtn">Add Deal</button>
                <button id="selimgsbtn">Select Images</button>
                <label id="label"></label>
              </div>


  <script type="module">
    //References and variables

    var Files = [];
    var FileReaders = [];
    var ImageLinksArray = [];

    const imgdiv = document.getElementById('imagesDiv');
    const selBtn = document.getElementById('selimgsbtn');
    const addBtn = document.getElementById('adddealbtn');
    const proglab = document.getElementById('loadlab');

    function addingDeal(){
      const name = document.getElementById('deal_name').value;
      console.log(name);
      const price = document.getElementById('deal_price').value;
      const description = document.getElementById('deal_description').value;
      const tscs = document.getElementById('deal_tc').value;
      const comment = document.getElementById('deal_comment').value;
    return {name, price, description, tscs, comment}
    }

    function OpenFileDialog(){
      let inp = document.createElement('input');
      inp.type = 'file';
      inp.multiple = 'multiple';

      inp.onchange = (e) => {
        AssignImgsFilesArray(e.target.files);
        CreateImgTags();
      }

      inp.click();
    }
    //limits the amount of Images to be added to 10.
    function AssignImgsFilesArray(thefiles){
      let num = Files.length + thefiles.length;
      let looplim = (num <= 10) ? thefiles.length : (10-Files.length)

      for (let i = 0; i < looplim; i++){
        Files.push(thefiles[i]);
      }

      if( num > 10) alert("Maximum 10 images are allowed!");
    }

    function CreateImgTags(){
      imgdiv.innerHTML='';
      imgdiv.classList.add('imagesDivStyle');

      for(let i = 0; i < Files.length; i++){
        FileReaders[i] = new FileReader();

        FileReaders[i].onload = function(){
          var img = document.createElement('img');
          img.id = 'imgNo' + i;
          img.classList.add('imgs');
          img.src = FileReaders[i].result;
          imgdiv.append(img);
        }

        FileReaders[i].readAsDataURL(Files[i]);
      }
      
      let lab = document.getElementById('label');
      lab.innerHTML = 'clear images';
      lab.style = 'cursor:pointer;display:block;color:navy; font-size:12px';
      lab.addEventListener('click', ClearImages);
      imgdiv.append(lab);
    }

    function ClearImages(){
      Files=[];
      ImageLinksArray=[];
      imgdiv.innerHTML = '';
      imgdiv.classList.remove('imagesDivStyle');
    }

    function getShortTitle(){
      const {name} = addingDeal()
      return name.replace(/[^a-zA-Z0-9]/g,"");
    }

    function GetImgUploadProgress(){
      return 'Images Uploaded ' + ImageLinksArray.length + ' of ' + Files.length
    }

    function IsAllImagesUploaded(){
      return ImageLinksArray.length == Files.length;
    }

    function RestoreBack(){
      selBtn.disabled = false;
      addBtn.disabled = false;
      proglab.innerHTML='';
    }

    //Events
    selBtn.addEventListener('click', OpenFileDialog);
    addBtn.addEventListener('click', UploadAllImages);

    //Image upload to Firebase Storage
    function UploadAllImages() {
      selBtn.disabled = true;
      addBtn.disabled = true;

        // Check if the deal price is greater than zero
  const price = document.getElementById('deal_price').value;
  if (price <= 0) {
    alert("Deal price must be greater than 1.");
    RestoreBack();
    return;
  }


      ImageLinksArray=[];

      for (let i = 0; i < Files.length; i++) {
        uploadImage(Files[i], i);    
      }
    }

    function uploadImage(imgToUpload, imgNo){
      const metadata = {
        contentType: imgToUpload.type
      };

      const storage = getStorage();

      const ImageAddress="TheImages/" + getShortTitle(name) + "/img#" + (imgNo+1);

      const storageRef = sRef(storage, ImageAddress);

      const UploadTask = uploadBytesResumable(storageRef, imgToUpload, metadata);

      UploadTask.on('state_changed', (snapshot) => {
        proglab.innerHTML = GetImgUploadProgress();
      },
      
      (error) => {
        alert("error: image upload failed");
      },

      () => {
        getDownloadURL(UploadTask.snapshot.ref).then((downloadURL) => {
          ImageLinksArray.push(downloadURL);
          if(IsAllImagesUploaded()){
            proglab.innerHTML = "All Images Uploaded";
            uploadDeal(name);
          }
        });
      }
      );
      
    }

    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.5.0/firebase-app.js";
  
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
      apiKey: "AIzaSyBiya-MbWDnCcsM-CL36LvY7oduMMxVRsQ",
      authDomain: "uya-travel.firebaseapp.com",
      databaseURL: "https://uya-travel-default-rtdb.firebaseio.com",
      projectId: "uya-travel",
      storageBucket: "uya-travel.appspot.com",
      messagingSenderId: "283228218463",
      appId: "1:283228218463:web:1320b719aabcf813dfa7ea",
      measurementId: "G-ZQYT7T1X7E"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    
    //import firebase storage functions
    import {getStorage, ref as sRef, uploadBytesResumable, getDownloadURL}
    from "https://www.gstatic.com/firebasejs/10.5.0/firebase-storage.js";

    //Firebase Realtime Database
    import {getDatabase, ref, set, child, get}
    from "https://www.gstatic.com/firebasejs/10.5.0/firebase-database.js";
    const realdb = getDatabase();

    //Upload the Deal
    function uploadDeal(){
      const {name, price, description, tscs, comment} = addingDeal();
      set(ref(realdb, "deals/" + getShortTitle()), {
        deal_name: name,
        deal_price: price,
        deal_description: description,
        deal_tc: tscs,
        deal_comment: comment,
        LinksOfImagesArray: ImageLinksArray
      });

      alert("Upload Successful");
      RestoreBack();
    }
  </script>

</body>