<?php
require 'vendor/autoload.php';

  require('inc/essentials.php');
  require('inc/firebaseRDB.php');
  require('inc/config.php');
  // Initialize the Firebase database reference

// Initialize the Firebase database reference
$database = new \Firebase\FirebaseLib("https://uya-travel-default-rtdb.firebaseio.com", "AIzaSyBiya-MbWDnCcsM-CL36LvY7oduMMxVRsQ");


// Define the Firebase path for new bookings
$newBookingsPath = 'enquiryForm';

// Fetch the data from the 'enquiryForm' path
$enquiryFormData = $database->get($newBookingsPath);

// Convert the JSON data to an array
$enquiryFormArray = json_decode($enquiryFormData, true);

// Count the number of entries in the 'enquiryForm' path
$totalNewBookings = count($enquiryFormArray);
// You may want to process the data or format it as needed
$totalNewBookings = (int)$totalNewBookings;


// Define the Firebase path for new user sign-ups
$newSignUpsPath = 'userSignUp';

// Fetch the data from the 'userSignUp' path
$newSignUpsData = $database->get($newSignUpsPath);

// Convert the JSON data to an array
$newSignUpsArray = json_decode($newSignUpsData, true);

// Count the number of new user sign-ups
$totalNewSignUps = count($newSignUpsArray);

// Define the Firebase path for contact queries
$contactQueriesPath = 'contact';

// Fetch the data from the 'contactQueries' path
$contactQueriesData = $database->get($contactQueriesPath);

// Convert the JSON data to an array
$contactQueriesArray = json_decode($contactQueriesData, true);

// Count the number of contact queries
$totalContactQueries = count($contactQueriesArray);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Dashboard</title>
  <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

  <?php 
  
    require('inc/header.php'); 
    
  ?>

  <div class="container-fluid" id="main-content">
    <div class="row">
      <div class="col-lg-10 ms-auto p-4 overflow-hidden">
        
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h3>DASHBOARD</h3>
        
        </div>

        <div class="row mb-4">
          <div class="col-md-3 mb-4">
            <a href="newbookings.php" class="text-decoration-none">
              <div class="card text-center text-success p-3">
                <h6>New Bookings</h6>
              </div>
            </a>
            </div>
    
          <div class="col-md-3 mb-4">
            <a href="rate_review.php" class="text-decoration-none">
              <div class="card text-center text-info p-3">
                <h6>Ratings & Reviews</h6>
</a>
</div>

            
          <div class="col-md-3 mb-4">
            <a href="contact_queries.php" class="text-decoration-none">
              <div class="card text-center text-info align-items:center">
                <h6></h6>
              </div>
            </a>
            </div>

          </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-3">
          <h5>Booking Analytics</h5>
          <select class="form-select shadow-none bg-light w-auto" onchange="booking_analytics(this.value)">
            <option value="1">Past 30 Days</option>
            <option value="2">Past 90 Days</option>
            <option value="3">Past 1 Year</option>
            <option value="4">All time</option>
          </select>
        </div>

        <div class="row mb-3">
          <div class="col-md-3 mb-4">
            <div class="card text-center text-primary p-3">
              <h6>Total Bookings</h6>
              <h1 class="mt-2 mb-0" id="total_bookings"><?php echo $totalNewBookings; ?></h1>
             <!-- <h4 class="mt-2 mb-0" id="total_amt">0</h4>  -->
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-center text-success p-3">
              <h6>Active Bookings</h6>
              <h1 class="mt-2 mb-0" id="active_bookings">3</h1>
            <!--  <h4 class="mt-2 mb-0" id="active_amt">0</h4> -->
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-center text-danger p-3">
              <h6>Cancelled Bookings</h6>
              <h1 class="mt-2 mb-0" id="cancelled_bookings">5</h1>
             <!-- <h4 class="mt-2 mb-0" id="cancelled_amt">0</h4> -->
            </div>
          </div>
        </div>


        <div class="d-flex align-items-center justify-content-between mb-3">
          <h5>User, Queries, Reviews Analytics</h5>
          <select class="form-select shadow-none bg-light w-auto" onchange="user_analytics(this.value)">
            <option value="1">Past 30 Days</option>
            <option value="2">Past 90 Days</option>
            <option value="3">Past 1 Year</option>
            <option value="4">All time</option>
          </select>
        </div>
      
        <div class="row mb-3">
          <div class="col-md-3 mb-4">
            <div class="card text-center text-success p-3">
              <h6>New Registration</h6>
              <h1 class="mt-2 mb-0" id="total_new_reg"><?php echo $totalNewSignUps; ?></h1>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-center text-primary p-3">
              <h6>Queries</h6>
              <h1 class="mt-2 mb-0" id="total_queries"><?php echo $totalContactQueries; ?></h1>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-center text-primary p-3">
              <h6>Reviews</h6>
              <h1 class="mt-2 mb-0" id="total_reviews">0</h1>
            </div>
          </div>
        </div>
  
        <!--
        <h5>Users</h5>
        <div class="row mb-3">
          <div class="col-md-3 mb-4">
            <div class="card text-center text-info p-3">
              <h6>Total</h6>
              <h1 class="mt-2 mb-0"><?php echo $current_users['total'] ?></h1>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-center text-success p-3">
              <h6>Active</h6>
              <h1 class="mt-2 mb-0"><?php echo $current_users['active'] ?></h1>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-center text-warning p-3">
              <h6>Inactive</h6>
              <h1 class="mt-2 mb-0"><?php echo $current_users['inactive'] ?></h1>
            </div>
          </div>
          <div class="col-md-3 mb-4">
            <div class="card text-center text-danger p-3">
              <h6>Unverified</h6>
              <h1 class="mt-2 mb-0"><?php echo $current_users['unverified'] ?></h1>
            </div>
          </div>
        </div>
          -->

      </div>
    </div>
  </div>
  

  <?php require('inc/scripts.php'); ?>

</body>
</html>