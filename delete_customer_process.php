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
$customer_id = $_POST['customer_id'];

// Check if the customer exists in the CUSTOMER table
$customer_check_query = "SELECT * FROM CUSTOMER WHERE Customer_Id = '$customer_id'";
$result = $connection->query($customer_check_query);
$customer = $result->fetch_assoc();

if ($customer) {
    // Check if the customer has related records in the meter and billing tables
    $meter_check_query = "SELECT * FROM METER WHERE Customer_Id = '$customer_id'";
    $billing_check_query = "SELECT * FROM BILLING WHERE Customer_Id = '$customer_id'";
    
    $meter_result = $connection->query($meter_check_query);
    $billing_result = $connection->query($billing_check_query);
    
    // If no related records found, proceed with deletion
    if ($meter_result->num_rows == 0 && $billing_result->num_rows == 0) {
        $delete_customer_query = "DELETE FROM CUSTOMER WHERE Customer_Id = '$customer_id'";
        
        if ($connection->query($delete_customer_query) === TRUE) {
            // Display deletion result
            echo "<!DOCTYPE html>";
            echo "<html lang='en'>";
            echo "<head>";
            echo "<meta charset='UTF-8'>";
            echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
            echo "<title>Customer Deletion Result</title>";
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
            echo "<h2>Customer Deletion Result</h2>";
            echo "<p>Customer with ID: $customer_id deleted successfully.</p>";
            echo "<button onclick='redirectToHomePage()'>Back to Home Page</button>";
            echo "</div>";
            echo "<script>";
            echo "function redirectToHomePage() { window.location.href = 'display.php'; }";
            echo "</script>";
            echo "</body>";
            echo "</html>";
        } else {
            echo "Error deleting customer: " . $connection->error;
        }
    } else {
        // Delete related records from meter and billing tables
        $delete_meter_query = "DELETE FROM METER WHERE Customer_Id = '$customer_id'";
        $delete_billing_query = "DELETE FROM BILLING WHERE Customer_Id = '$customer_id'";
        
        if ($connection->query($delete_meter_query) === TRUE && $connection->query($delete_billing_query) === TRUE) {
            // Then delete the customer record
            $delete_customer_query = "DELETE FROM CUSTOMER WHERE Customer_Id = '$customer_id'";
            
            if ($connection->query($delete_customer_query) === TRUE) {
                // Display deletion result
                echo "<!DOCTYPE html>";
                echo "<html lang='en'>";
                echo "<head>";
                echo "<meta charset='UTF-8'>";
                echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
                echo "<title>Customer Deletion Result</title>";
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
                echo "<h2>Customer Deletion Result</h2>";
                echo "<p>Customer with ID: $customer_id and its related records deleted successfully.</p>";
                echo "<button onclick='redirectToHomePage()'>Back to Home Page</button>";
                echo "</div>";
                echo "<script>";
                echo "function redirectToHomePage() { window.location.href = 'display.php'; }";
                echo "</script>";
                echo "</body>";
                echo "</html>";
            } else {
                echo "Error deleting customer: " . $connection->error;
            }
        } else {
            echo "Error deleting related records: " . $connection->error;
        }
    }
} else {
    echo "No customer with ID: $customer_id found.";
}

// Close connection
$connection->close();
?>
