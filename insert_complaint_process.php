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
$description = $_POST['description'];
$date_of_complaint = date("Y-m-d");

// Check if the customer exists
$customer_query = "SELECT * FROM CUSTOMER WHERE Customer_Id = '$customer_id'";
$customer_result = $connection->query($customer_query);

if ($customer_result->num_rows === 0) {
    // Customer does not exist
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Complaint Insertion Failed</title>";
    echo "<style>";
    echo "body { font-family: Arial, sans-serif; background-color: #e1efff; margin: 0; padding: 0; }";
    echo ".container { max-width: 600px; margin: 20px auto; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }";
    echo "h2 { text-align: center; margin-bottom: 20px; color: #333333; }";
    echo "p { text-align: center; margin-bottom: 20px; }";
    echo "button { display: block; margin: 0 auto; padding: 10px 20px; background-color: #007bff; border: none; border-radius: 4px; color: #ffffff; font-size: 16px; cursor: pointer; transition: background-color 0.3s ease; }";
    echo "button:hover { background-color: #0056b3; }";
    echo "</style>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<h2>Complaint Insertion Failed</h2>";
    echo "<p>No customer with ID $customer_id exists.</p>";
    echo "<button onclick='redirectToHomePage()'>Back to Home Page</button>";
    echo "</div>";
    echo "<script>";
    echo "function redirectToHomePage() { window.location.href = 'display.php'; }";
    echo "</script>";
    echo "</body>";
    echo "</html>";
} else {
    // Customer exists, proceed with complaint insertion
    // SQL query to insert data into COMPLAINTS table
    $insert_query = "INSERT INTO COMPLAINTS (Customer_Id, Description, Date_Of_Complaint) 
                     VALUES ('$customer_id', '$description', '$date_of_complaint')";

    if ($connection->query($insert_query) === TRUE) {
        // Fetch the inserted record
        $inserted_id = $connection->insert_id;
        $result = $connection->query("SELECT * FROM COMPLAINTS WHERE Complaint_Id = $inserted_id");
        $inserted_complaint = $result->fetch_assoc();
        
        // Display the success message and inserted complaint information
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Complaint Insertion Success</title>";
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
        echo "<h2>Complaint Insertion Successful</h2>";
        echo "<ul>";
        echo "<li><strong>Complaint ID:</strong> " . $inserted_complaint['Complaint_Id'] . "</li>";
        echo "<li><strong>Customer ID:</strong> " . $inserted_complaint['Customer_Id'] . "</li>";
        echo "<li><strong>Description:</strong> " . $inserted_complaint['Description'] . "</li>";
        echo "<li><strong>Date of Complaint:</strong> " . $inserted_complaint['Date_Of_Complaint'] . "</li>";
        echo "<li><strong>Date of Resolution:</strong> ";
        echo isset($inserted_complaint['Date_Of_Resolution']) ? $inserted_complaint['Date_Of_Resolution'] : "NOT RESOLVED";
        echo "</li>";
        echo "</ul>";
        echo "<button onclick='redirectToHomePage()'>Back to Home Page</button>";
        echo "</div>";
        echo "<script>";
        echo "function redirectToHomePage() { window.location.href = 'display.php'; }";
        echo "</script>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "Error: " . $insert_query . "<br>" . $connection->error;
    }
}

// Close connection
$connection->close();
?>
