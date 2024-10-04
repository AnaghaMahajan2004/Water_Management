<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $email = $_POST['email'];

    // Database connection
    $servername = "192.168.56.1";
    $username = "root";
    $password = "anagha@2004"; // Change this to your database password
    $dbname = "project";  // Change this to your database name

    $conn = new mysqli($servername, $username, $password, $dbname);
}
// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
}

$user_id = $_POST['user_id'];
$email = $_POST['email'];

// Prepare and bind
$stmt = $conn->prepare("SELECT * FROM user WHERE User_Id = ? AND Email_Id = ?");
$stmt->bind_param("ss", $user_id, $email);

// Execute statement
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    echo json_encode(['success' => true, 'message' => 'Credentials Valid. You may reset your password.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Credentials']);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>