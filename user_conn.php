<?php
session_start(); // Start the session

$servername = "192.168.56.1";
$username = "root";
$password = "anagha@2004"; // Change this to your database password
$dbname = "project"; // Change this to your database name

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $connection->prepare("SELECT * FROM USER WHERE Username = ? AND Password = ?");
    $stmt->bind_param("ss", $username, $password);
    
    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Set the username in the session
        $_SESSION['username'] = $username;
        
        // Redirect to the display_user.php page
        header("Location: display.php");
        exit();
    } else {
        // If username and password don't match, display an error message
        echo "Invalid username or password.";
    }

    // Close the statement
    $stmt->close();
}


// Close connection
$connection->close();
?>
