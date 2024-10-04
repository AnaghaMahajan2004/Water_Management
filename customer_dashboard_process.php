<?php
session_start(); // Start session at the top

if (!isset($_SESSION['customer_id'])) {
    // If not logged in, redirect to login page
    header("Location: customer_login.html");
    exit();
}

$servername = "192.168.56.1";
$username = "root";
$password = "anagha@2004";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customer_id = $_SESSION['customer_id'];

// SQL query to fetch details for the logged-in customer
$sql = "SELECT c.Customer_Id, c.Customer_Name, b.Water_Consumption, b.Amount, 
        co.Complaint_Id, co.Description, co.Date_Of_Complaint, co.Date_Of_Complaint_Resolution 
        FROM customer AS c
        JOIN billing AS b ON c.Customer_Id = b.Customer_Id
        LEFT JOIN complaints AS co ON c.Customer_Id = co.Customer_Id
        WHERE c.Customer_Id = ?";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id); // Bind the customer_id to the query
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            /* background-color: #f0f0f0; */
            background-image: url("dashboard.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            
        }
        h1{
            font-family: 'Dancing Script', cursive;
            font-size:60px;
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

        .dashboard {
            margin: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #4800e2;
            color: white;
        }
    </style>
</head>
<body>

<nav>
        <ul>
            <li><a href="home.html">Home</a></li>
            <li><a href="policies.html">Policies</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="customer_profile.php">Profile</a></li>
        </ul>
    </nav>

    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['customer_name']); ?></h1>
    <div class="dashboard">
        <table>
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Water Consumption (m³)</th>
                    <th>Amount (₹)</th>
                    <th>Complaint ID</th>
                    <th>Description</th>
                    <th>Date of Complaint</th>
                    <th>Date of Resolution</th>
                    <th>Print Bill</th>
                </tr>
            </thead>
            <tbody>
<?php
// Display the fetched data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . htmlspecialchars($row['Customer_Id']) . '</td>
                <td>' . htmlspecialchars($row['Customer_Name']) . '</td>
                <td>' . htmlspecialchars($row['Water_Consumption']) . '</td>
                <td>' . htmlspecialchars($row['Amount']) . '</td>
                <td>' . htmlspecialchars($row['Complaint_Id'] ?? 'N/A') . '</td>
                <td>' . htmlspecialchars($row['Description'] ?? 'N/A') . '</td>
                <td>' . htmlspecialchars($row['Date_Of_Complaint'] ?? 'N/A') . '</td>
                <td>' . htmlspecialchars($row['Date_Of_Complaint_Resolution'] ?? 'N/A') . '</td>
                <td>
                    <form action="customer_printbill.php" method="get">
                        <input type="hidden" name="customerid" value="' . htmlspecialchars($row['Customer_Id']) . '">
                        <button type="submit">Print</button>
                    </form>
                </td>
              </tr>';
    }
} else {
    echo '<tr><td colspan="9">No Data Found</td></tr>';
}


// Close the connection
$conn->close();
?>
            </tbody>
        </table>
    </div>
</body>
</html>
