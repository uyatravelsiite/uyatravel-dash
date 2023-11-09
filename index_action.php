<?php
include("inc/config.php");
include("inc/firebaseRDB.php");
require('inc/essentials.php');

$admin_name = $_POST['admin_name'];
$admin_pass = $_POST['admin_pass'];

$rdb = new firebaseRDB($databaseURL);
$retrieve = $rdb->retrieve("/admin", "admin_name", "EQUAL", $admin_name); // Fix the variable name here
$data = json_decode($retrieve, true); // Using `true` to get an associative array

if (count($data) > 0) {
    // Successful login, redirect to dashboard.php
    header("Location: dashboard.php");
    exit; // Ensure that no further code execution happens after the redirect
} else {
    $insert = $rdb->insert("/admin", [
        "admin_name" => $admin_name,
        "admin_pass" => $admin_pass,
    ]);
    $result = json_decode($insert, true);
    if (isset($result['admin_pass'])) {
        // Successful registration, you can also redirect to dashboard.php here if needed
    }
}
?>
