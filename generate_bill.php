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

// Get customer ID from the form
if (isset($_POST['customerid'])) {
    $customerid = $connection->real_escape_string($_POST['customerid']);

    // Retrieve customer details
    $customer_query = "SELECT * FROM CUSTOMER WHERE Customer_Id = '$customerid'";
    $customer_result = $connection->query($customer_query);
    if ($customer_result->num_rows > 0) {
        $customer_row = $customer_result->fetch_assoc();

        // Retrieve billing details including meter details
        $billing_query = "SELECT BILLING.*, METER.Meter_Id, METER.Installation_Date, METER.Status 
                          FROM BILLING 
                          LEFT JOIN METER ON BILLING.Customer_Id = METER.Customer_Id
                          WHERE BILLING.Customer_Id = '$customerid' 
                          ORDER BY BILLING.Bill_Date DESC 
                          LIMIT 1";
        $billing_result = $connection->query($billing_query);
        if ($billing_result->num_rows > 0) {
            $billing_row = $billing_result->fetch_assoc();

            // Include print_bill.php page
            include "print_bill.php";
        } else {
            echo "No billing information found for this customer.";
        }
    } else {
        echo "Customer ID not found.";
    }
} else {
    echo "No customer ID provided.";
}

?>
