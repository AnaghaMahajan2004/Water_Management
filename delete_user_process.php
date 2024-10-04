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

// Get user ID from the form
$user_id = $_POST['user_id'];

// Check if user ID exists
$user_check_query = "SELECT * FROM USER WHERE User_Id=$user_id LIMIT 1";
$result = $connection->query($user_check_query);
$user = $result->fetch_assoc();

if ($user) { // If user exists
    echo '<script>';
    echo 'if(confirm("Are you sure you want to delete this user info?")) {';
    echo 'window.location.href = "delete_user_confirm.php?user_id=' . $user_id . '";';
    echo '} else {';
    echo 'window.location.href = "delete_user.php";';
    echo '}';
    echo '</script>';
} else { // If user doesn't exist
    echo "No user with User ID: $user_id found.";
}

// Close connection
$connection->close();
?>
