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

// Get bill ID from the URL
$bill_id = $_GET['bill_id'];

// SQL query to get the customer ID associated with the bill ID
$sql_customer_id = "SELECT Customer_Id FROM BILLING WHERE Bill_Id = '$bill_id'";
$result_customer_id = $connection->query($sql_customer_id);

if ($result_customer_id->num_rows > 0) {
    $row = $result_customer_id->fetch_assoc();
    $customer_id = $row["Customer_Id"];

    // SQL queries to delete billing, customer, and meter records
    $sql_billing = "DELETE FROM BILLING WHERE Bill_Id = '$bill_id'";
    $sql_customer = "DELETE FROM CUSTOMER WHERE Customer_Id = '$customer_id'";
    $sql_meter = "DELETE FROM METER WHERE Customer_Id = '$customer_id'";

    // Perform deletion and display the result
    if ($connection->query($sql_billing) === TRUE && $connection->query($sql_customer) === TRUE && $connection->query($sql_meter) === TRUE) {
        // Display deletion result and add a button to return to the home page
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Billing Deletion Result</title>";
        echo "<style>";
        echo "body { font-family: Arial, sans-serif; background-color: #e1efff; margin: 0; padding: 0; }";
        echo ".container { max-width: 600px; margin: 20px auto; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }";
        echo "h2 { text-align: center; margin-bottom: 20px; color: #333333; }";
        echo "p { text-align: center; margin-bottom: 20px; }";
        echo "button { padding: 10px 20px; background-color: #007bff; border: none; border-radius: 4px; color: #ffffff; font-size: 16px; cursor: pointer; transition: background-color 0.3s ease; }";
        echo "button:hover { background-color: #0056b3; }";
        echo "</style>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<h2>Billing Deletion Result</h2>";
        echo "<p>Billing information with Bill ID: $bill_id and corresponding records deleted successfully.</p>";
        echo "<button onclick='redirectToHomePage()'>Back to Home Page</button>";
        echo "</div>";
        echo "<script>";
        echo "function redirectToHomePage() { window.location.href = 'display.php'; }";
        echo "</script>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "Error deleting billing information: " . $connection->error;
    }
} else {
    echo "No customer found for the provided bill ID.";
}

// Close connection
$connection->close();
?>
