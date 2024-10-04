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

// Get meter ID from the form
$meterid = $_POST['meterid'];

// Check if the meter exists
$check_query = "SELECT * FROM METER WHERE Meter_Id = '$meterid'";
$result = $connection->query($check_query);
if ($result->num_rows === 0) {
    echo "Meter ID does not exist.";
} else {
    // Prepare update data
    $status = $_POST['status'];

    // Build the update query
    $update_query = "UPDATE METER SET Status = '$status' WHERE Meter_Id = '$meterid'";

    // Execute the update query
    if ($connection->query($update_query) === TRUE) {
        // Fetch the updated meter record
        $result = $connection->query("SELECT * FROM METER WHERE Meter_Id = '$meterid'");
        $updated_meter = $result->fetch_assoc();

        // Display the success message and updated meter information
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Meter Update Success</title>";
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
        echo "<h2>Meter Update Successful</h2>";
        echo "<ul>";
        echo "<li><strong>Meter ID:</strong> " . $updated_meter['Meter_Id'] . "</li>";
        echo "<li><strong>Installation Date:</strong> " . $updated_meter['Installation_Date'] . "</li>";
        echo "<li><strong>Status:</strong> " . $updated_meter['Status'] . "</li>";
        echo "</ul>";
        echo "<button onclick='redirectToHomePage()'>Back to Home Page</button>";
        echo "</div>";
        echo "<script>";
        echo "function redirectToHomePage() { window.location.href = 'display.php'; }";
        echo "</script>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "Error updating record: " . $connection->error;
    }
}

// Close connection
$connection->close();
?>
