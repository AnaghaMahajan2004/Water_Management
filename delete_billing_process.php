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

// Get bill ID from the form
$bill_id = $_POST['bill_id'];

// Check if bill ID exists
$billing_check_query = "SELECT * FROM BILLING WHERE Bill_Id='$bill_id' LIMIT 1";
$result = $connection->query($billing_check_query);
$billing = $result->fetch_assoc();

if ($billing) { // If bill exists
    echo '<script>';
    echo 'if(confirm("Are you sure you want to delete this billing information?")) {';
    echo 'window.location.href = "delete_billing_confirm.php?bill_id=' . $bill_id . '";';
    echo '} else {';
    echo 'window.location.href = "delete_billing.php";';
    echo '}';
    echo '</script>';
} else { // If bill doesn't exist
    echo "No billing information with Bill ID: $bill_id found.";
}

// Close connection
$connection->close();
?>
