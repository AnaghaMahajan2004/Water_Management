<?php
session_start(); // Start session

$servername = "192.168.56.1";
$username = "root";
$password = "anagha@2004";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to verify user
    $sql = "SELECT customer_id, customer_name FROM customer_login WHERE (customer_username = ? OR customer_id = ?) AND password = ?";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $username, $password);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($customer_id, $customer_name);
        $stmt->fetch();
        
        // Set session variables
        $_SESSION['customer_id'] = $customer_id;
        $_SESSION['customer_name'] = $customer_name;

        // Redirect to dashboard
        header("Location: customer_dashboard_process.php");
        exit();
    } else {
        echo "Invalid credentials. Please try again.";
    }
}

// Close the connection
$conn->close();
?>
