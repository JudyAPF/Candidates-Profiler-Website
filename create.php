<?php
 
require "config.php";

// Function to safely sanitize input data
function sanitizeInput($input)
{
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Initialize a response array
$response = array();

// Check if the form was submitted and all required fields are set
if (
    isset($_POST['firstname']) &&
    isset($_POST['lastname']) &&
    isset($_POST['sex']) &&
    isset($_POST['address']) &&
    isset($_POST['party']) &&
    isset($_FILES['picture'])
) {
    // Sanitize and validate the data
    $firstname = sanitizeInput($_POST['firstname']);
    $lastname = sanitizeInput($_POST['lastname']);
    $mi = sanitizeInput($_POST['mi']);
    $sex = sanitizeInput($_POST['sex']);
    $address = sanitizeInput($_POST['address']);
    $party = sanitizeInput($_POST['party']);
    $picture = $_FILES['picture'];

    // Validate uploaded picture
    $allowedExtensions = array('jpg', 'jpeg', 'png');
    $pictureName = strtolower(basename($picture['name']));
    $pictureExtension = pathinfo($pictureName, PATHINFO_EXTENSION);

    if (!in_array($pictureExtension, $allowedExtensions)) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid picture format.';
    } else {

        $targetDirectory = "Uploaded_Image/";
        $targetFile = $targetDirectory . basename($_FILES["picture"]["name"]);

        if (move_uploaded_file($picture['tmp_name'], $targetFile)) {

            // Start a database transaction
            $connect->begin_transaction();

            // Insert the candidate data into the database using prepared statements
            $stmt = $connect->prepare("INSERT INTO candidates (firstname, lastname, mi, sex, address, party, picture) VALUES (?, ?, ?, ?, ?, ?, ?)");

            // Bind parameters
            $stmt->bind_param("sssssss", $firstname, $lastname, $mi, $sex, $address, $party, $targetFile);

            if ($stmt->execute()) {
                // Commit the transaction if everything is successful
                $connect->commit();
                $response['status'] = 'success';
                $response['message'] = 'Candidate added successfully.';
            } else {
                // Roll back the transaction if there's an error
                $connect->rollback();
                $response['status'] = 'error';
                $response['message'] = 'Failed to add candidate.';
            }

 
            $stmt->close();
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to move picture.';
        }
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Missing or invalid data.';
}

// Close the database connection
$connect->close();

// Return the response as JSON
echo json_encode($response);

 
