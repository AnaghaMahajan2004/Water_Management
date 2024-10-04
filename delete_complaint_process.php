<?php
// Database connection parameters
$servername = "192.168.56.1";
$username = "root";
$password = "anagha@2004";
$dbname = "project";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get complaint ID from the form
$complaint_id = $_POST['complaint_id'];

// Check if complaint ID exists
$complaint_check_query = "SELECT * FROM COMPLAINTS WHERE Complaint_Id=$complaint_id LIMIT 1";
$result = $connection->query($complaint_check_query);
$complaint = $result->fetch_assoc();

if ($complaint) { // If complaint exists
    echo '<script>';
    echo 'if(confirm("Are you sure you want to delete this complaint?")) {';
    echo 'window.location.href = "delete_complaint_confirm.php?complaint_id=' . $complaint_id . '";';
    echo '} else {';
    echo 'window.location.href = "delete_complaint.php";';
    echo '}';
    echo '</script>';
} else { // If complaint doesn't exist
    echo "No complaint with Complaint ID: $complaint_id found.";
}

// Close connection
$connection->close();
?>
