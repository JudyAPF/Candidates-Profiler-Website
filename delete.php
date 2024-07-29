<?php
require("config.php");

if (isset($_GET['id'])) {
    $candidateId = $_GET['id'];

    // Retrieve the image file path from the database
    $sql = "SELECT picture FROM candidates WHERE idno = ?";
    $stmt = $connect->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $connect->error);
    }

    $stmt->bind_param("i", $candidateId);
    $stmt->execute();
    $stmt->bind_result($imagePath);

    if ($stmt->fetch()) {
        // Delete the image file
        if (unlink($imagePath)) {
            // Image file deleted successfully, now delete the database record
            $stmt->close();

            // Use prepared statement to avoid SQL injection
            $sql = "DELETE FROM candidates WHERE idno = ?";
            $stmt = $connect->prepare($sql);

            if (!$stmt) {
                die("Prepare failed: " . $connect->error);
            }

            $stmt->bind_param("i", $candidateId);

            if ($stmt->execute()) {
                $stmt->close();
                $connect->close();
                header("Location: index.php");
                exit();
            } else {
                echo "Error deleting record: " . $stmt->error;
            }
        } else {
            echo "Error deleting image file.";
        }
    } else {
        echo "Image not found in the database.";
    }
} else {
    echo "Invalid request.";
    exit();
}
?>
