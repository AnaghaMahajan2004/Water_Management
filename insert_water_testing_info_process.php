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

// Get form data
$source_id = $_POST['source_id'];
$date_of_testing = $_POST['date_of_testing'];
$ph_level = $_POST['ph_level'];
$amount_of_free_chlorine = $_POST['amount_of_free_chlorine'];
$turbidity = $_POST['turbidity'];

// Insert water testing information into the WATER_TESTING table
$insert_query = "INSERT INTO WATER_TESTING (Source_Id, Date_Of_Testing, PH_Level, Amount_Of_Free_Chlorine, Turbidity) 
                VALUES ('$source_id', '$date_of_testing', '$ph_level', '$amount_of_free_chlorine', '$turbidity')";

if ($connection->query($insert_query) === TRUE) {
    // Fetch the inserted record including the sample_id
    $inserted_id = $connection->insert_id;
    $water_testing_query = "SELECT * FROM WATER_TESTING WHERE Sample_Id = $inserted_id";
    $water_testing_result = $connection->query($water_testing_query);
    
    if ($water_testing_result && $water_testing_result->num_rows > 0) {
        // Display success message and inserted water testing information
        $inserted_water_testing_info = $water_testing_result->fetch_assoc();
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Water Testing Insertion Success</title>";
        echo "<style>";
        echo "body { font-family: Arial, sans-serif; background-color: #e1efff; margin: 0; padding: 0; }";
        echo ".container { max-width: 600px; margin: 20px auto; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }";
        echo "h2 { text-align: center; margin-bottom: 20px; color: #333333; }";
        echo "ul { list-style-type: none; padding: 0; }";
        echo "li { margin-bottom: 10px; }";
        echo "button { display: block; margin: 0 auto; padding: 10px 20px; background-color: #007bff; border: none; border-radius: 4px; color: #ffffff; font-size: 16px; cursor: pointer; transition: background-color 0.3s ease; }";
        echo "button:hover { background-color: #0056b3; }";
        echo "</style>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container'>";
        echo "<h2>Water Testing Insertion Successful</h2>";
        echo "<ul>";
        echo "<li><strong>Sample ID:</strong> " . $inserted_id . "</li>";
        echo "<li><strong>Source ID:</strong> " . $source_id . "</li>";
        echo "<li><strong>Date of Testing:</strong> " . $date_of_testing . "</li>";
        echo "<li><strong>PH Level:</strong> " . $ph_level . "</li>";
        echo "<li><strong>Amount of Free Chlorine:</strong> " . $amount_of_free_chlorine . "</li>";
        echo "<li><strong>Turbidity:</strong> " . $turbidity . "</li>";
        echo "</ul>";
        echo "<button onclick='redirectToHomePage()'>Back to Home Page</button>";
        echo "</div>";
        echo "<script>";
        echo "function redirectToHomePage() { window.location.href = 'display.php'; }";
        echo "</script>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "Error: No record found after insertion.";
    }
} else {
    echo "Error inserting record: " . $connection->error;
}

// Close connection
$connection->close();
?>
