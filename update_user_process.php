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

// Get user ID from the form
$userid = $_POST['userid'];

// Check if the user exists
$check_query = "SELECT * FROM USER WHERE User_Id = '$userid'";
$result = $connection->query($check_query);
if ($result->num_rows === 0) {
    echo "User ID does not exist.";
} else {
    // Prepare update data
    $update_fields = array();
    if (!empty($_POST['username'])) {
        $update_fields[] = "Username = '" . $_POST['username'] . "'";
    }
    if (!empty($_POST['password'])) {
        $update_fields[] = "Password = '" . $_POST['password'] . "'";
    }
    if (!empty($_POST['role'])) {
        $update_fields[] = "Role = '" . $_POST['role'] . "'";
    }
    if (!empty($_POST['mobile'])) {
        $update_fields[] = "Mobile_No = '" . $_POST['mobile'] . "'";
    }
    if (!empty($_POST['email'])) {
        $update_fields[] = "Email_Id = '" . $_POST['email'] . "'";
    }

    // Build the update query
    $update_query = "UPDATE USER SET " . implode(", ", $update_fields) . " WHERE User_Id = '$userid'";

    // Execute the update query
    if ($connection->query($update_query) === TRUE) {
        // Fetch the updated user record
        $result = $connection->query("SELECT * FROM USER WHERE User_Id = '$userid'");
        $updated_user = $result->fetch_assoc();

        // Display the success message and updated user information
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>User Update Success</title>";
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
        echo "<h2>User Update Successful</h2>";
        echo "<ul>";
        echo "<li><strong>User ID:</strong> " . $updated_user['User_Id'] . "</li>";
        echo "<li><strong>Name:</strong> " . $updated_user['Name'] . "</li>";
        echo "<li><strong>Username:</strong> " . $updated_user['Username'] . "</li>";
        echo "<li><strong>Role:</strong> " . $updated_user['Role'] . "</li>";
        echo "<li><strong>Mobile Number:</strong> " . $updated_user['Mobile_No'] . "</li>";
        echo "<li><strong>Email:</strong> " . $updated_user['Email_Id'] . "</li>";
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
