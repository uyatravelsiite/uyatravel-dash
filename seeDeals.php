<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Deals</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        #dealsDiv{
            display: flex;
            flex-wrap;
        }
        .dealsCard{
            border: 1px lightgray solid;
            height: 570px;
            width: 290px;
            margin: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-direction: column;
            transition: border-color .3s;
        }

        .dealsCard:hover{
            border-color: darkblue;
        }

        .thumb{
            width: 220px;
            height: 160px;
            cursor: pointer;
        }

        .detbtns{
            background-color: navy;
            color: white;
            width: 90%;
            margin-bottom: 15px;
        }

        .detbtns:hover{
            color: wheat;
        }

        .title{
            color: darkblue;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            padding-left: 5px;
            padding-right: 5px;
            width: 100%;
            text-align: center;
        }

        @media screen and (max-width: 767px){
            #dealsDiv{
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div id = "dealsDiv" class = "container">
        
    </div>

    <script type = "module">

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

        var OuterDiv = document.getElementById('dealsDiv');
        var ArrayOfDeals = [];
        window.addEventListener('load', GetAllDeals);

        function GetAllDeals(){
            const dbref = ref(realdb);

            get(child(dbref, "deals"))
            .then((snapshot) => {
                snapshot.forEach(deal => {
                    ArrayOfDeals.push(deal.val());
                });
                AddAllDeals();
            })
        }

        function AddAllDeals(){
            let i = 0;
            ArrayOfDeals.forEach(deal => {
                AddADeal(deal, i++);
            });
            AssignAllEvents();
        }

        function AddADeal(partdeal, index){
            let html = 
            `
            <img src = "`+ partdeal.LinksOfImagesArray[0] +`" class="thumb mt-2" id="thumb-`+ index +`">
            <p class = "title" id = "title-`+ index +`">`+ getShortTitle(partdeal.deal_name) +`></p>
            <h5 class = "price">R`+ partdeal.deal_price +`</h5>
            <button class="detbtns btn" id="detbtn-`+ index +`"></button>
            `

            let newDeal = document.createElement('div');
            newDeal.classList.add('dealsCard');
            newDeal.innerHTML = html;
            OuterDiv.append(newDeal);
        }

        function getShortTitle(title){
            if(title.length > 49) title = title.substring(0,47);
            else return title;
            return title + "...";
        }

        function GetDealIndex(id){
            var indstart = id.indexOf('-') + 1;
            var indend = id.length;
            return Number(id.substring(indstart, indend));
        }

        function GoToDealDetails(event){
            var index = GetDealIndex(event.target.id);
            localStorage.Deal = JSON.stringify(ArrayOfDeals[index]);
            window.location = "deals_details.php";
        }

        function AssignAllEvents(){
            var btns = document.getElementsByClassName('detbtns');
            var titles = document.getElementsByClassName('title');
            var thumbs = document.getElementsByClassName('thumb');

            for(let i = 0; i < btns.length; i++){
                btns[i].addEventListener('click', GoToDealDetails);
                titles[i].addEventListener('click', GoToDealDetails);
                thumbs[i].addEventListener('click', GoToDealDetails);
            }
        }
    </script>
</body>
</html>