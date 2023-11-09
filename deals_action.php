<?php 
include("inc/config.php");
include("inc/firebaseRDB.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    // Assuming you have form input fields named according to your HTML form
    $deal_name = $_POST['deal_name'];
    $deal_price = $_POST['deal_price'];
    $deal_description = $_POST['deal_description'];
    $deal_tc = $_POST['deal_tc'];
    $deal_comment = $_POST['deal_comment'];

    // Initialize Firebase Realtime Database
    $rdb = new firebaseRDB($databaseURL);

     // Define a path for Add Deals in your Firebase database
     $path = "/deals";
}
?>