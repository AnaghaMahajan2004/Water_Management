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
$source_name = $_POST['source_name'];
$location = $_POST['location'];
$capacity = $_POST['capacity'];

// SQL query to insert data into WATER_SOURCE table
$sql = "INSERT INTO WATER_SOURCE (Source_Name, Location, Capacity) VALUES ('$source_name', '$location', '$capacity')";

if ($connection->query($sql) === TRUE) {
    // Fetch the inserted record
    $inserted_id = $connection->insert_id;
    $result = $connection->query("SELECT * FROM WATER_SOURCE WHERE Source_Name = '$source_name'");
    $inserted_water_source = $result->fetch_assoc();

    // Display the success message and inserted water source information
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Water Source Insertion Success</title>";
    echo "<style>";
    echo "body { font-family: Arial, sans-serif; background-color:#e1efff; margin: 0; padding: 0; }";
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
    echo "<h2>Water Source Insertion Successful</h2>";
    echo "<ul>";
    echo "<li><strong>Source ID:</strong> " . $inserted_water_source['Source_Id'] . "</li>";
    echo "<li><strong>Source Name:</strong> " . $inserted_water_source['Source_Name'] . "</li>";
    echo "<li><strong>Location:</strong> " . $inserted_water_source['Location'] . "</li>";
    echo "<li><strong>Capacity:</strong> " . $inserted_water_source['Capacity'] . " liters</li>";
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
