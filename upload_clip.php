<style>

.container {
    display: flex;        /* Enables flexbox */
    flex-direction: column; /* Stack children vertically */
    justify-content: center; /* Center vertically in the container */
    align-items: center;  /* Center horizontally in the container */
    height: 100vh;        /* Full view height */
    text-align: center;   /* Centers text elements */
}

.btn {
    padding: 10px 20px;
    font-size: 16px;
    color: white;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s;
    text-decoration: none;
    margin: 10px;
}
.btn-success {
    background-color: #28a745;
}
.btn-success:hover {
    background-color: #218838;
}
.btn-primary:hover {
    background-color: #0069d9;
}
</style>



<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clip_name = $_FILES['clip']['name'];
    $clip_tmp_name = $_FILES['clip']['tmp_name'];
    $clip_folder = 'uploads/' . $clip_name;

    // Allowed video file types
    $allowed_file_types = array('video/mp4', 'video/quicktime');

    // Get the file type
    $file_type = mime_content_type($clip_tmp_name);

    // Check if the file type is allowed
    if (in_array($file_type, $allowed_file_types)) {
        // Ensure the uploads directory exists
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (move_uploaded_file($clip_tmp_name, $clip_folder)) {
            $sql = "INSERT INTO short_clips (clip_name, clip_path) VALUES ('$clip_name', '$clip_folder')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully.<br/>";
                echo "<a href='display_clips.html' class='btn btn-success'>View Clips</a>&nbsp;";
                echo "<a href='index.html' class='btn btn-primary'>Go to Home</a>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Failed to upload clip.";
        }
    } else {
        echo "Only MP4 and MOV files are allowed.";
    }
} else {
    echo "No file uploaded.";
}

$conn->close();
?>
