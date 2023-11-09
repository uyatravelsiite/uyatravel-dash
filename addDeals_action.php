<?php
include("inc/config.php");
include("inc/firebaseRDB.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deal_name = $_POST['deal_name'];
    $deal_price = $_POST['deal_price'];
    $deal_description = $_POST['deal_description'];
    $deal_tc = $_POST['deal_tc'];
    $deal_comment = $_POST['deal_comment'];
    $main_image = $_FILES['main_image']; // Update to use $_FILES

    if (empty($deal_name) || empty($deal_price)) {
        echo "Deal Name and Price are required";
    } elseif (!is_numeric($deal_price)) {
        echo "Price must be a number";
    } else {
        // Initialize the Firebase Realtime Database
        $rdb = new firebaseRDB($databaseURL);

        // Check if the deal with the same name already exists
        $retrieve = $rdb->retrieve("/deals", "deal_name", "EQUAL", $deal_name);
        $data = json_decode($retrieve, true);

        if (count($data) > 0) {
            echo "Deal with the same name already exists.";
        } else {
            // Insert the deal information into the database
            $insert = $rdb->insert("/deals",  [
                "deal_name" => $deal_name,
                "deal_price" => (float)$deal_price, // Convert to a float
                "deal_description" => $deal_description,
                "deal_tc" => $deal_tc,
                "deal_comment" => $deal_comment,
            ]);

            $result = json_decode($insert, true);
            if (isset($result['name'])) {
                // Deal Information Captured successfully
                echo '<script>alert("Deal Information Captured.");</script>';
                
                if (isset($main_image) && $main_image['error'] === UPLOAD_ERR_OK) {
                    $uploadDirectory = 'uploads/';
                    $mainImagePath = $uploadDirectory . $main_image['name'];
                    
                    // Check if the directory exists, if not, create it
                    if (!file_exists($uploadDirectory)) {
                        mkdir($uploadDirectory, 0777, true);
                    }
                    
                    if (move_uploaded_file($main_image['tmp_name'], $mainImagePath)) {
                        // Successfully uploaded the main image
                        // Now, you can save the image path to your database
                        // Example: You can save $mainImagePath to your database
                    } else {
                        echo 'Error uploading the main image.';
                    }
                }
            } else {
                echo '<script>alert("Deal Information Error.");</script>';
            }
        }
    }

    header('Location: addDeals.php'); // Redirect to the page where you display deals
    exit(); // Ensure no further code execution after redirection
}
?>
