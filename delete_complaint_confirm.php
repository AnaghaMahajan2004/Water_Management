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

// Get complaint ID from the URL
$complaint_id = $_GET['complaint_id'];

// SQL query to delete complaint
$sql = "DELETE FROM COMPLAINTS WHERE Complaint_Id = $complaint_id";

if ($connection->query($sql) === TRUE) {
    // Display deletion result and add a button to return to the home page
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Complaint Deletion Result</title>";
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
    echo "<h2>Complaint Deletion Result</h2>";
    echo "<p>Complaint with Complaint ID: $complaint_id deleted successfully.</p>";
    echo "<button onclick='redirectToHomePage()'>Back to Home Page</button>";
    echo "</div>";
    echo "<script>";
    echo "function redirectToHomePage() { window.location.href = 'display.php'; }";
    echo "</script>";
    echo "</body>";
    echo "</html>";
} else {
    echo "Error deleting complaint: " . $connection->error;
}

// Close connection
$connection->close();
?>
