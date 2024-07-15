<?php
include 'db_connect.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the file path from the database
    $sql = "SELECT clip_path FROM short_clips WHERE id = $id";
    $result = $conn->query($sql);
    if($row = $result->fetch_assoc()) {
        $filePath = $row['clip_path'];

        // Delete the file
        if(file_exists($filePath)) {
            unlink($filePath); // Delete the video file
        }

        // Delete the database entry
        $sql = "DELETE FROM short_clips WHERE id = $id";
        if($conn->query($sql) === TRUE) {
            echo "Clip deleted successfully";
        } else {
            echo "Error deleting clip: " . $conn->error;
        }
    } else {
        echo "Clip not found";
    }
    
    $conn->close();
} else {
    echo "No clip ID provided";
}
?>
