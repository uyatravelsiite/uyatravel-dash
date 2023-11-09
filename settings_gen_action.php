<?php
include("inc/config.php");
include("inc/firebaseRDB.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have form input fields named "site_title" and "site_about"
    $site_title = $_POST['site_title'];
    $site_about = $_POST['site_about'];

    // Initialize Firebase Realtime Database
    $rdb = new firebaseRDB($databaseURL);

    // Check if the site_title already exists
    $existing_data = $rdb->retrieve("/generalSettings");
    $existing_data = json_decode($existing_data, true);

    if (count($existing_data) > 0) {
        // Update the existing data with the new values
        $update_data = $rdb->update("/generalSettings", $existing_data[0]['id'], [
            "site_title" => $site_title,
            "site_about" => $site_about,
        ]);

        if ($update_data) {
            // Successfully updated the data
            // You can redirect to a success page or do other actions here
            header("Location: settings.php");
            exit;
        } else {
            // Handle update failure (e.g., database error)
            echo "Update failed. Please try again.";
        }
    } else {
        // Insert a new record with the site_title
        $insert_data = $rdb->insert("/generalSettings", [
            "site_title" => $site_title,
            "site_about" => $site_about,
        ]);

        if ($insert_data) {
            // Successfully inserted new data
            // You can redirect to a success page or do other actions here
            header("Location: settings.php");
            exit;
        } else {
            // Handle insert failure (e.g., database error)
            echo "Insert failed. Please try again.";
        }
    }
} else {
    // Handle cases where the form was not submitted
    // You can display an error message or redirect to an error page
    echo "Form not submitted.";
}
?>
