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
$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];

// SQL query to insert data into USER table
$sql = "INSERT INTO USER (Name, Username, Password, Role, Mobile_No, Email_Id) VALUES ('$name', '$username', '$password', '$role', '$mobile', '$email')";

if ($connection->query($sql) === TRUE) {
    // Fetch the inserted record
    $inserted_id = $connection->insert_id;
    $result = $connection->query("SELECT * FROM USER WHERE User_Id = $inserted_id");
    $inserted_user = $result->fetch_assoc();
    
    // Display the success message and inserted user information
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>User Insertion Success</title>";
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
    echo "<h2>User Insertion Successful</h2>";
    echo "<ul>";
    echo "<li><strong>User ID:</strong> " . $inserted_user['User_Id'] . "</li>";
    echo "<li><strong>Name:</strong> " . $inserted_user['Name'] . "</li>";
    echo "<li><strong>Username:</strong> " . $inserted_user['Username'] . "</li>";
    echo "<li><strong>Role:</strong> " . $inserted_user['Role'] . "</li>";
    echo "<li><strong>Mobile Number:</strong> " . $inserted_user['Mobile_No'] . "</li>";
    echo "<li><strong>Email:</strong> " . $inserted_user['Email_Id'] . "</li>";
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
