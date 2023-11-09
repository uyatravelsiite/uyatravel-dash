<?php
$databaseURL = "https://uya-travel-default-rtdb.firebaseio.com/";

// Include the class definition and create an instance of the firebaseRDB class

$firebase = new firebaseRDB($databaseURL);

// Specify the database path where the data is located
$dbPath = "generalSettings";

// Use the retrieve method to fetch the data
$data = $firebase->retrieve($dbPath);

// Process and use the retrieved data
if ($data === false) {
    // Handle the case where the request failed
    echo "Error: Failed to retrieve data from Firebase.";
} else {
    $dataArray = json_decode($data, true);
    

    if (isset($dataArray['site_title'])) {
        $siteTitle = $dataArray['site_title'];
    } else {
        $siteTitle = "Data not available.";
    }
}
    // Check if "site_about" exists in the data
    if (isset($dataArray['site_about'])) {
        $siteAbout = $dataArray['site_about'];
    } else {
        $siteAbout = "Data not available.";
    }

?>
