<?php
  require('inc/essentials.php');
  require('inc/config.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - New Bookings</title>
  
  <?php require('inc/links.php'); ?>
</head>

<body class="bg-light">

  <?php require('inc/header.php'); ?>

  <div class="container-fluid" id="main-content">
    <div class="row">
      <div class="col-lg-10 ms-auto p-4 overflow-hidden">
        <h3 class="mb-4">NEW BOOKINGS</h3>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">

            <div class="text-end mb-4">
             <input type="text" oninput="searchByName(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Search by Name...">

            </div>

            <!--Table creation -->
            <div class="table-responsive">
              <table class="table table-hover border" style="min-width: 1200px;">
                <thead>
                  <tr class="bg-dark text-light">
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Adults</th>
                    <th scope="col">Children</th>
                    <th scope="col">Trip</th>
                    <th scope="col">Email</th>
                    <th scope="col">Number</th>
                 
                  </tr>
                </thead>
                <tbody id="table-data">  
                                 
                </tbody>     
              </table>
              <td>
                
         
              </td>
            </div>

            <script type='module'>
              //Fill the table
              var bkNo = 0;
              var tbody = document.getElementById('table-data');

              function AddItemTable(fname,lname,adult,child,trip,email,num){
                let trow = document.createElement("tr");

                let td1 = document.createElement('td');
                let td2 = document.createElement('td');
                let td3 = document.createElement('td');
                let td4 = document.createElement('td');
                let td5 = document.createElement('td');
                let td6 = document.createElement('td');
                let td7 = document.createElement('td');
                let td8 = document.createElement('td');

                td1.innerHTML=++bkNo;
                td2.innerHTML=fname;
                td3.innerHTML=lname;
                td4.innerHTML=adult;
                td5.innerHTML=child;
                td6.innerHTML=trip;
                td7.innerHTML=email;
                td8.innerHTML=num;
                

                trow.appendChild(td1);
                trow.appendChild(td2);
                trow.appendChild(td3);
                trow.appendChild(td4);
                trow.appendChild(td5);
                trow.appendChild(td6);
                trow.appendChild(td7);
                trow.appendChild(td8);

                tbody.appendChild(trow);
                
                
              }
     
              function AddAllItemsTable(theBookings){
                bkNo=0;
                tbody.innerHTML="";
                theBookings.forEach(element => {
                  AddItemTable(element.first_name, element.last_name, element.adult, element.children, element.trip, element.email, element.number)
                });
                

              }
              import { initializeApp } from "https://www.gstatic.com/firebasejs/10.5.0/firebase-app.js";
              import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.5.0/firebase-analytics.js";
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
              const analytics = getAnalytics(app);

              import { getDatabase, ref, child, onValue, get}
              from "https://www.gstatic.com/firebasejs/10.5.0/firebase-database.js";

              const db = getDatabase();

              //Get All Data
              function GetAllData(){
                const dbRef = ref(db);

                get(child(dbRef, "enquiryForm"))
                .then((snapshot) => {
                  var bkngs =[];

                  snapshot.forEach(childSnapshot => {
                    bkngs.push(childSnapshot.val());
                  });

                  AddAllItemsTable(bkngs);
                });
              }

              function GetAllDataRealtime(){
                const dbRef = ref(db, "enquiryForm");

                onValue(dbRef,(snapshot)=>{
                  var bkngs = []

                  snapshot.forEach(childSnapshot => {
                    bkngs.push(childSnapshot.val());
                  });
                  AddAllItemsTable(bkngs);
                })
              }
              
  function searchByName(first_name) {
    // Your search logic here
    console.log("Search input: " + first_name);

    const dbRef = ref(db, "enquiryForm");
    onValue(dbRef, (snapshot) => {
      const bkngs = [];

      snapshot.forEach((childSnapshot) => {
        const data = childSnapshot.val();
        data.key = childSnapshot.key; // Add the key to the data

        // Check if the first_name contains the input name
        if (data.first_name.toLowerCase().includes(first_name.toLowerCase())) {
          bkngs.push(data);
        }
      });

      AddAllItemsTable(bkngs);
    });
  }

              window.onload = GetAllDataRealtime;
            </script>

          </div>
        </div>

      </div>
    </div>
  </div>



  <!-- Assign Room Number modal 

  <div class="modal fade" id="assign-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="assign_room_form">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Assign Room</h5>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold">Room Number</label>
              <input type="text" name="room_no" class="form-control shadow-none" required>
            </div>
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              Note: Assign Room Number only when user has been arrived!
            </span>
            <input type="hidden" name="booking_id">
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
            <button type="submit" class="btn custom-bg text-white shadow-none">ASSIGN</button>
          </div>
        </div>
      </form>
    </div>
  </div>
            -->


  <?php require('inc/scripts.php'); ?>

  

</body>
</html>