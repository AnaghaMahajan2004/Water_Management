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

// Prepare data for insertion
$customer_id = $_POST['customer_id'];
$previous_reading = $_POST['previous_reading'];
$current_reading = $_POST['current_reading']; // Add this line to retrieve current reading
$bill_date = $_POST['bill_date'];

// Calculate water consumption
$water_consumption = $current_reading - $previous_reading;

// SQL query to insert data into BILLING table
$sql = "INSERT INTO BILLING (Customer_Id, Previous_Reading, Current_Reading, Bill_Date, Water_Consumption) 
        VALUES ('$customer_id', '$previous_reading', '$current_reading', '$bill_date', '$water_consumption')";

if ($connection->query($sql) === TRUE) {
    // Fetch the inserted record
    $inserted_id = $connection->insert_id;
    $result = $connection->query("SELECT * FROM BILLING WHERE Bill_Id = '$inserted_id'");
    $inserted_billing = $result->fetch_assoc();
    
    // Display the success message and inserted billing information
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Billing Insertion Success</title>";
    echo "<style>";
    echo "body { font-family: Arial, sans-serif; background-color: #e1efff; margin: 0; padding: 0; }";
    echo ".container { max-width: 600px; margin: 20px auto; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }";
    echo "h2 { text-align: center; margin-bottom: 20px; color: #333333; }";
    echo "ul { list-style-type: none; padding: 0; }";
    echo "li { margin-bottom: 10px; }";
    echo "button { padding: 10px 20px; background-color: #007bff; border: none; border-radius: 4px; color: #ffffff; font-size: 16px; cursor: pointer; transition: background-color 0.3s ease; }";
    echo "button:hover { background-color: #0056b3; }";
    echo "</style>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<h2>Billing Insertion Successful</h2>";
    echo "<ul>";
    echo "<li><strong>Bill ID:</strong> " . $inserted_billing['Bill_Id'] . "</li>";
    echo "<li><strong>Customer ID:</strong> " . $inserted_billing['Customer_Id'] . "</li>";
    echo "<li><strong>Previous Reading:</strong> " . $inserted_billing['Previous_Reading'] . "</li>";
    echo "<li><strong>Current Reading:</strong> " . $inserted_billing['Current_Reading'] . "</li>";
    echo "<li><strong>Bill Date:</strong> " . $inserted_billing['Bill_Date'] . "</li>";
    echo "<li><strong>Water Consumption (in kilo litres):</strong> " . $inserted_billing['Water_Consumption'] . "</li>";
    echo "<li><strong>Amount:</strong> Rs " . $inserted_billing['Amount'] . "</li>"; // Assuming 'Amount' field exists in the BILLING table
    echo "</ul>";
    echo "<button onclick='redirectToHomePage()'>Back to Home Page</button>";
    echo "</div>";
    echo "<script>";
    echo "function redirectToHomePage() { window.location.href = 'display.php'; }";
    echo "</script>";
    echo "</body>";
    echo "</html>";
} else {
    echo "Error: " . $sql . "<br>" . $connection->error;
}

// Close connection
$connection->close();
?>
