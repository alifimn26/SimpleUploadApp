<?php
include 'db_connect.php';

$sql = "SELECT * FROM short_clips ORDER BY upload_time DESC";
$result = $conn->query($sql);

$clips = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clips[] = $row;
    }
}

echo json_encode($clips);

$conn->close();
?>
