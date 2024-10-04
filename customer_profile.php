<?php
session_start(); // Start the session at the top

if (!isset($_SESSION['customer_id'])) {
    // If the customer is not logged in, redirect them to the login page
    header("Location: customer_login.html");
    exit();
}

// Database connection
$servername = "192.168.56.1";
$username = "root";
$password = "anagha@2004";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customer_id = $_SESSION['customer_id'];

// Query to fetch customer and meter details
$sql = "SELECT c.Customer_Name, c.Mobile_No, c.Email_Id, c.Address, 
               m.Meter_Id, m.Installation_Date, m.Status 
        FROM customer AS c
        LEFT JOIN meter AS m ON c.Customer_Id = m.Customer_Id
        WHERE c.Customer_Id = ?";

// Prepare the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id); // Bind the customer ID to the query
$stmt->execute();
$result = $stmt->get_result();

// Fetch the customer and meter details
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No data found for the customer.";
    exit();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            /* background-color: #f0f0f0; */
            background-image: url("profile_bg.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }

        .profile-container {
            margin: 20px;
            padding: 20px;
            background-color: #dbdbec;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-family: Helvetica, sans-serif;


        }

        h1 {
            text-align: center;
            color: black;
            font-family: "Cambria Math", cursive;
            font-size:50px;
        }

        .profile-details {
            margin-top: 20px;
        }

        .profile-details p {
            font-size: 18px;
            margin: 10px 0;
        }

        .profile-details span {
            font-weight: bold;
        }
        nav {
            /* background-color: #333; */
            background-image: url("https://foodautomation.com.au/wp-content/uploads/2014/03/polygon-bg-grey.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            padding: 10px;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        nav ul li {
            float: left;
        }

        nav ul li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        nav ul li a:hover {
            background-color: #111;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav>
        <ul>
            <li><a href="home.html">Home</a></li>
            <li><a href="policies.html">Policies</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="customer_dashboard_process.php">Dashboard</a></li>
        </ul>
    </nav>

    <div class="profile-container">
        <h1>Customer Profile</h1>
        <div class="profile-details">
            <p><span>Name:</span> <?php echo htmlspecialchars($row['Customer_Name']); ?></p>
            <p><span>Contact Number:</span> <?php echo htmlspecialchars($row['Mobile_No']); ?></p>
            <p><span>Email:</span> <?php echo htmlspecialchars($row['Email_Id']); ?></p>
            <p><span>Address:</span> <?php echo htmlspecialchars($row['Address']); ?></p>
            <p><span>Meter ID:</span> <?php echo htmlspecialchars($row['Meter_Id'] ?? 'N/A'); ?></p>
            <p><span>Meter Installation Date:</span> <?php echo htmlspecialchars($row['Installation_Date'] ?? 'N/A'); ?></p>
            <p><span>Meter Status:</span> <?php echo htmlspecialchars($row['Status'] ?? 'N/A'); ?></p>
        </div>
    </div>

</body>
</html>
