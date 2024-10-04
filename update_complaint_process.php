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

// Get complaint ID from the form
$complaintid = $_POST['complaintid'];

// Check if the complaint exists
$check_query = "SELECT * FROM COMPLAINTS WHERE Complaint_Id = '$complaintid'";
$result = $connection->query($check_query);
if ($result->num_rows === 0) {
    echo "Complaint ID does not exist.";
} else {
    // Prepare update data
    $update_fields = array();
    if (!empty($_POST['resolutiondate'])) {
        $update_fields[] = "Date_Of_Complaint_Resolution = '" . $_POST['resolutiondate'] . "'";
    }

    // Build the update query
    $update_query = "UPDATE COMPLAINTS SET " . implode(", ", $update_fields) . " WHERE Complaint_Id = '$complaintid'";

    // Execute the update query
    if ($connection->query($update_query) === TRUE) {
        // Fetch the updated complaint record
        $result = $connection->query("SELECT * FROM COMPLAINTS WHERE Complaint_Id = '$complaintid'");
        $updated_complaint = $result->fetch_assoc();

        // Display the success message and updated complaint information
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Complaint Update Success</title>";
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
        echo "<h2>Complaint Update Successful</h2>";
        echo "<ul>";
        echo "<li><strong>Complaint ID:</strong> " . $updated_complaint['Complaint_Id'] . "</li>";
        echo "<li><strong>Customer ID:</strong> " . $updated_complaint['Customer_Id'] . "</li>";
        echo "<li><strong>Date of Complaint:</strong> " . $updated_complaint['Date_Of_Complaint'] . "</li>";
        echo "<li><strong>Description:</strong> " . $updated_complaint['Description'] . "</li>";
        echo "<li><strong>Date of Complaint Resolution:</strong> " . $updated_complaint['Date_Of_Complaint_Resolution'] . "</li>";
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
