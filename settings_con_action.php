<?php
include("inc/config.php");
include("inc/firebaseRDB.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have form input fields named according to your HTML form
    $address = $_POST['address'];
    $gmap = $_POST['gmap'];
    $pn1 = $_POST['pn1'];
    $pn2 = $_POST['pn2'];
    $email = $_POST['email'];
    $fb = $_POST['fb'];
    $insta = $_POST['insta'];
    $tw = $_POST['tw'];
    $iframe = $_POST['iframe'];

    // Initialize Firebase Realtime Database
    $rdb = new firebaseRDB($databaseURL);

    // Define a path for Contact Settings in your Firebase database
    $path = "/contactSettings";

    // Create an associative array with the desired structure
    $data = [
        "address" => $address,
        "gmap" => $gmap,
        "phoneNumbers" => [
            "pn1" => $pn1,
            "pn2" => $pn2,
        ],
        "email" => $email,
        "socialLinks" => [
            "fb" => $fb,
            "insta" => $insta,
            "tw" => $tw,
        ],
        "iframeSrc" => $iframe,
    ];

    // Update the data at the specified path
    $update_data = $rdb->update($path, $key, $data);

    if ($update_data) {
        // Successfully updated the data
        // You can redirect to a success page or perform other actions here
        header("Location: settings.php");
        exit;
    } else {
        // Handle update failure (e.g., database error)
        echo "Update failed. Please try again.";
    }
} else {
    // Handle cases where the form was not submitted
    // You can display an error message or redirect to an error page
    echo "Form not submitted.";
}
?>
