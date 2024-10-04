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

// Get source ID from the form
$source_id = $_POST['source_id'];

// Check if the source exists in the WATER_SOURCE table
$source_check_query = "SELECT * FROM WATER_SOURCE WHERE Source_Id = '$source_id'";
$source_result = $connection->query($source_check_query);
$source = $source_result->fetch_assoc();

if ($source) {
    // Check if the source has associated testing records in the WATER_TESTING table
    $testing_check_query = "SELECT * FROM WATER_TESTING WHERE Source_Id = '$source_id'";
    $testing_result = $connection->query($testing_check_query);

    if ($testing_result->num_rows == 0) {
        // If no associated testing records found, proceed with deletion
        $delete_source_query = "DELETE FROM WATER_SOURCE WHERE Source_Id = '$source_id'";
        
        if ($connection->query($delete_source_query) === TRUE) {
            // Display deletion result and add a button to return to the home page
            echo "<!DOCTYPE html>";
            echo "<html lang='en'>";
            echo "<head>";
            echo "<meta charset='UTF-8'>";
            echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
            echo "<title>Water Source Deletion Result</title>";
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
            echo "<h2>Water Source Deletion Result</h2>";
            echo "<p>Water source with ID: $source_id deleted successfully.</p>";
            echo "<button onclick='redirectToHomePage()'>Back to Home Page</button>";
            echo "</div>";
            echo "<script>";
            echo "function redirectToHomePage() { window.location.href = 'display.php'; }";
            echo "</script>";
            echo "</body>";
            echo "</html>";
        } else {
            echo "Error deleting water source: " . $connection->error;
        }
    } else {
        // If associated testing records found, delete them first
        $delete_testing_query = "DELETE FROM WATER_TESTING WHERE Source_Id = '$source_id'";
        
        if ($connection->query($delete_testing_query) === TRUE) {
            // Then delete the source record
            $delete_source_query = "DELETE FROM WATER_SOURCE WHERE Source_Id = '$source_id'";
            
            if ($connection->query($delete_source_query) === TRUE) {
                // Display deletion result and add a button to return to the home page
                echo "<!DOCTYPE html>";
                echo "<html lang='en'>";
                echo "<head>";
                echo "<meta charset='UTF-8'>";
                echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
                echo "<title>Water Source Deletion Result</title>";
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
                echo "<h2>Water Source Deletion Result</h2>";
                echo "<p>Water source with ID: $source_id and its associated testing records deleted successfully.</p>";
                echo "<button onclick='redirectToHomePage()'>Back to Home Page</button>";
                echo "</div>";
                echo "<script>";
                echo "function redirectToHomePage() { window.location.href = 'display.php'; }";
                echo "</script>";
                echo "</body>";
                echo "</html>";
            } else {
                echo "Error deleting water source: " . $connection->error;
            }
        } else {
            echo "Error deleting water testing records: " . $connection->error;
        }
    }
} else {
    echo "No water source with ID: $source_id found.";
}

// Close connection
$connection->close();
?>
