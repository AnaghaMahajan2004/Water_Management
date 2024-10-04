<?php
session_start(); // Start the session

// Database configuration
$host = 'localhost'; // Your database host
$db = 'project'; // Your database name
$user = 'root'; // Your database username
$pass = 'anagha@2004'; // Your database password

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exception
} catch (PDOException $e) {
    // Handle connection error
    echo "Database connection failed: " . $e->getMessage();
    exit(); // Stop further execution
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: user.html");
    exit(); // Stop further execution
}

$username = $_SESSION['username']; // Fetch the username from the session

// Handle insert, update, delete actions
$action = isset($_GET['action']) ? $_GET['action'] : '';
if ($action) {
    // Switch case for different actions
    switch ($action) {
        case 'insert_user':
        case 'update_user':
        case 'delete_user':
            // Redirect to corresponding action pages
            header("Location: {$action}.php");
            exit();

        case 'insert_customer':
        case 'update_customer':
        case 'delete_customer':
            header("Location: {$action}.php");
            exit();

        case 'insert_water_source':
        case 'update_water_source':
        case 'delete_water_source':
            header("Location: {$action}.php");
            exit();

        case 'insert_complaint':
        case 'update_complaint':
        case 'delete_complaint':
            header("Location: {$action}.php");
            exit();

        case 'insert_water_testing':
        case 'update_water_testing':
        case 'delete_water_testing':
            header("Location: {$action}.php");
            exit();

        case 'insert_meter':
        case 'update_meter':
        case 'delete_meter':
            header("Location: {$action}.php");
            exit();

        case 'insert_billing':
        case 'update_billing':
        case 'delete_billing':
            header("Location: {$action}.php");
            exit();

        default:
            echo "Invalid action.";
            exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Management</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6; /* Light grey background */
            background-image: url("display_bg.jpg");
            color: #333;
        }

        .container {
            max-width: 1200px; /* Increased width for more space */
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff; /* White background */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            border-radius: 8px; /* Rounded corners */
            background-image: url("display_bg2.webp");
        }

        .profile-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
            font-size: 36px;
            color: white;
            display: flex;
            align-items: center;
        }

        .profile-icon:hover {
            color: #0056b3;
        }

        .profile-content {
            position: absolute;
            top: 60px;
            right: 0;
            /* background-color: #ffffff; */
            background-image: url("display_bg2.webp");
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            display: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            color:black;
            font-family:Calibri;
        }

        .profile-icon.clicked .profile-content {
            display: block;
        }

        .logout-button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            background-color: #007bff;
            color: #ffffff;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .logout-button:hover {
            background-color: #0056b3;
        }

        /* Navigation and dropdown menu styling */
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007bff;
            padding: 10px 20px;
            color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .nav a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav a.active, .nav a:hover {
            background-color: #0056b3;
        }

        .sub-nav {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .dropdown {
            position: relative;
            margin: 0 10px;
        }

        .dropdown-title {
            background-color: #007bff;
            color: #fff;
            padding: 12px 24px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .dropdown-title:hover {
            background-color: #0056b3;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #ffffff;
            border: 1px solid #ccc;
            width: 200px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            top: 100%;
            left: 0;
            z-index: 1;
        }

        .dropdown-content a {
            color: #333;
            padding: 10px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
        }

        .dropdown-content a:hover {
            background-color: #f0f0f0;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            color: #333;
        }

        th {
            background-color: #007bff;
            color: #ffffff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="profile-icon" onclick="toggleProfileFlap()">
        <i class="fas fa-user-circle"></i>
        <div class="profile-content">
            <p><?php echo htmlspecialchars($username); ?></p>
            <form action="logout.php" method="post">
                <input type="submit" value="Logout" class="logout-button">
            </form>
        </div>
    </div>

    <div class="nav">
        <a href="home.html">HOME</a>
        <a href="?page=user" class="<?php echo isset($_GET['page']) && $_GET['page'] == 'user' ? 'active' : ''; ?>">USER</a>
        <a href="?page=customer" class="<?php echo isset($_GET['page']) && $_GET['page'] == 'customer' ? 'active' : ''; ?>">CUSTOMER</a>
        <a href="?page=water_source" class="<?php echo isset($_GET['page']) && $_GET['page'] == 'water_source' ? 'active' : ''; ?>">WATER SOURCE</a>
        <a href="?page=complaints" class="<?php echo isset($_GET['page']) && $_GET['page'] == 'complaints' ? 'active' : ''; ?>">COMPLAINTS</a>
        <a href="?page=water_testing" class="<?php echo isset($_GET['page']) && $_GET['page'] == 'water_testing' ? 'active' : ''; ?>">WATER TESTING</a>
        <a href="?page=meter" class="<?php echo isset($_GET['page']) && $_GET['page'] == 'meter' ? 'active' : ''; ?>">METER</a>
        <a href="?page=billing" class="<?php echo isset($_GET['page']) && $_GET['page'] == 'billing' ? 'active' : ''; ?>">BILLING</a>
    </div>

    <div class="sub-nav">
        <div class="dropdown">
            <a href="#" class="dropdown-title">Insert</a>
            <div class="dropdown-content">
                <a href="?action=insert_user">User</a>
                <a href="?action=insert_customer">Customer</a>
                <a href="?action=insert_water_source">Water Source</a>
                <a href="?action=insert_complaint">Complaints</a>
                <a href="?action=insert_water_testing">Water Testing</a>
                <a href="?action=insert_meter">Meter</a>
                <a href="?action=insert_billing">Billing</a>
            </div>
        </div>

        <div class="dropdown">
            <a href="#" class="dropdown-title">Update</a>
            <div class="dropdown-content">
                <a href="?action=update_user">User</a>
                <a href="?action=update_customer">Customer</a>
                <a href="?action=update_water_source">Water Source</a>
                <a href="?action=update_complaint">Complaints</a>
                <a href="?action=update_water_testing">Water Testing</a>
                <a href="?action=update_meter">Meter</a>
                <a href="?action=update_billing">Billing</a>
            </div>
        </div>

        <div class="dropdown">
            <a href="#" class="dropdown-title">Delete</a>
            <div class="dropdown-content">
                <a href="?action=delete_user">User</a>
                <a href="?action=delete_customer">Customer</a>
                <a href="?action=delete_water_source">Water Source</a>
                <a href="?action=delete_complaint">Complaints</a>
                <a href="?action=delete_water_testing">Water Testing</a>
                <a href="?action=delete_meter">Meter</a>
                <a href="?action=delete_billing">Billing</a>
            </div>
        </div>

        <div class="dropdown">
    <a href="#" class="dropdown-title">Print</a> 
    <div class="dropdown-content">
        <a href="bill.php">Print Bill</a>
        <a href="print_user.php">Print User Information</a>
        <a href="print_customer.php">Print Customer Information</a>
        <a href="print_meter.php">Print Meter Information</a>
        <a href="print_water_source.php">Print Water Source Information</a>
        <a href="print_complaint.php">Print Complaint Information</a>
        <a href="print_billing.php">Print Billing Information</a>
        <a href="print_water_testing.php">Print Water Testing Information</a>
    </div>
</div>
    </div>

    <?php
    // Retrieve and display table data based on the page requested
    $page = isset($_GET['page']) ? $_GET['page'] : 'user'; // Default to 'user' page

    switch ($page) {
        case 'user':
            $sql = "SELECT * FROM user";
            break;
        case 'customer':
            $sql = "SELECT * FROM customer";
            break;
        case 'water_source':
            $sql = "SELECT * FROM water_source";
            break;
        case 'complaints':
            $sql = "SELECT * FROM complaints";
            break;
        case 'water_testing':
            $sql = "SELECT * FROM water_testing";
            break;
        case 'meter':
            $sql = "SELECT * FROM meter";
            break;
        case 'billing':
            $sql = "SELECT * FROM billing";
            break;
        default:
            $sql = "SELECT * FROM user";
    }

    // Execute the query
    try {
        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
        exit(); // Stop further execution
    }
    ?>

    <table>
        <thead>
            <tr>
                <?php if (!empty($data)) {
                    // Display table headers based on data keys
                    foreach (array_keys($data[0]) as $key) {
                        echo "<th>" . htmlspecialchars($key) . "</th>";
                    }
                } ?>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data)) {
                // Display table rows
                foreach ($data as $row) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
            } ?>
        </tbody>
    </table>
</div>

<script>
// function toggleProfileFlap() {
//     var profileIcon = document.querySelector('.profile-icon');
//     profileIcon.classList.toggle('active');
// }
function toggleProfileFlap() {
    var profileIcon = document.querySelector('.profile-icon');
    profileIcon.classList.toggle('clicked');
}

// Close the profile flap if clicking outside both the profile icon and the profile content
document.addEventListener('click', function(event) {
    var profileIcon = document.querySelector('.profile-icon');
    var profileContent = document.querySelector('.profile-content');
    
    // Check if the click is outside both the profile icon and the content
    var isClickInside = profileIcon.contains(event.target) || profileContent.contains(event.target);

    // If the click was outside, remove the 'clicked' class to close the dropdown
    if (!isClickInside && profileIcon.classList.contains('clicked')) {
        profileIcon.classList.remove('clicked');
    }
});


</script>

</body>
</html>
