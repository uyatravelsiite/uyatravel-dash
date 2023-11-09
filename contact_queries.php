<?php
require 'vendor/autoload.php';
require('inc/essentials.php');
require('inc/firebaseRDB.php');
require('inc/config.php');
// Initialize the Firebase database reference

// Initialize the Firebase database reference
$database = new \Firebase\FirebaseLib("https://uya-travel-default-rtdb.firebaseio.com", "AIzaSyBiya-MbWDnCcsM-CL36LvY7oduMMxVRsQ");

// Define the Firebase path for contact queries
$contactQueriesPath = 'contact';

// Fetch the data from the 'contactQueries' path
$contactQueriesData = $database->get($contactQueriesPath);

// Convert the JSON data to an array
$contactQueriesArray = json_decode($contactQueriesData, true);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_query"])) {
    $queryId = $_POST["query_id"];
    // Delete the query from the Firebase database
    $database->delete($contactQueriesPath . '/' . $queryId);
    // Reload the page to reflect the changes
    header("Location: contact_queries.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE-edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Queries</title>
  <?php require('inc/links.php'); ?>
  <style>
    /* Center the table within the container */
    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      height: 100vh;
    }

    /* Add some spacing for the table */
    .table {
      width: 80%;
    }
  </style>
</head>
<body class="bg-light">
<?php 
  
  require('inc/header.php'); 
  
?>
 <div class="container-fluid" id="main-content">
    <div class="row">
      <div class="col-lg-10 ms-auto p-4 overflow-hidden">
    <h1>Contact Queries</h1>
    <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            
          <div class="table-responsive">
              <table class="table table-hover border" style="min-width: 1200px;">
                <thead>
        <tr>
          <th>Email</th>
          <th>Name</th>
          <th>Subject</th>
          <th>Message</th>
          <th>Phone</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($contactQueriesArray as $queryId => $query) { ?>
          <tr>
            <td><?php echo $query['email']; ?></td>
            <td><?php echo $query['name']; ?></td>
            <td><?php echo $query['subject']; ?></td>
            <td><?php echo $query['message']; ?></td>
            <td><?php echo $query['phone']; ?></td>
            <td>
              <form method="post">
                <input type="hidden" name="query_id" value="<?php echo $queryId; ?>">
                <button type="submit" name="delete_query" class="btn btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <?php require('inc/scripts.php'); ?>

</body>
</html>
