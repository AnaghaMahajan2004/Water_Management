<?php
session_start(); // Start the session

// Check if the user is logged in
if(!isset($_SESSION['username'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: user.html");
    exit(); // Stop further execution
}

$username = $_SESSION['username']; // Fetch the username from the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Management</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e1efff; /* Very light shade of blue */
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
            position: relative; /* Needed for absolute positioning */
        }

        .profile-circle {
            position: absolute;
            top: 20px; /* Adjust as needed */
            right: 20px; /* Adjust as needed */
            cursor: pointer;
        }

        .profile-circle img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }

        .profile-circle .profile-content {
            position: absolute;
            top: 120px; /* Adjust as needed */
            right: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            display: none;
        }

        .profile-circle.clicked .profile-content {
            display: block;
        }

        /* Updated button styling */
        .buttons input[type="submit"],
        .action-buttons input[type="submit"] {
            padding: 12px 24px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            margin-right: 10px;
            background-color: #007bff; /* Blue color */
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .buttons input[type="submit"]:hover,
        .action-buttons input[type="submit"]:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        /* End of button styling */
        .buttons form {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        /* Adjusted action buttons styling */
        .action-buttons {
            margin-top: 20px; /* Adjust as needed */
            display: flex;
            justify-content: space-between; /* Equal space between buttons */
            width: 100%; /* Set a fixed width for the container */
            margin-left: auto;
            margin-right: auto;
        }

        .action-buttons form {
            flex-grow: 1; /* Each form takes up equal space */
            margin: 0 5px; /* Adjust margin as needed */
        }


        /* Dropdown menu styling */
        .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #e1efff; /* Adjust to complement the background of the page */
        border: 1px solid #ccc;
        width: 200px; /* Adjust width as needed */
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        z-index: 1;
        border-radius: 5px;
        padding: 10px 0;
        text-align: center; /* Center align dropdown items */
    }

    .dropdown-content a {
        color: #333; /* Text color for dropdown items */
        padding: 10px 0;
        text-decoration: none;
        display: block;
        transition: background-color 0.3s ease;
    }

    .dropdown-content a:hover {
        background-color: #c9dcf9; /* Lighter shade of blue on hover */
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Updated button styling */
    .logout-button {
        padding: 12px 24px;
        font-size: 18px;
        border: none;
        cursor: pointer;
        margin-right: 10px;
        background-color: #007bff; /* Blue color */
        color: #fff;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .logout-button:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }


        /* End of dropdown menu styling */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff; /* Light background color for table */
            margin-top: 20px;
            margin-left: auto;
            margin-right: auto;
        }

        th,
        td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
            color: #333; /* Text color for table cells */
        }

        th {
            background-color: #f0f0f0; /* Light background color for table header */
        }

        .buttons {
            margin-top: 30px; /* Adjust as needed */
        }

        .top-left-image {
            position: absolute;
            top: 10;
            left: 0;
            width: 80%; /* Adjust width based on the profile circle's position */
            height: 130px; /* Adjust height as needed */
            background: url('water_image.jpg') no-repeat left top;
            background-size: cover;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="top-left-image"></div>
    <div class="profile-circle" onclick="toggleProfileFlap()">
        <img src="water_profile.webp" alt="Profile">
        <div class="profile-content">
            <p><?php echo $username; ?></p>
            <form action="logout.php" method="post">
                <input type="submit" value="Logout" class="logout-button">
            </form>

        </div>
    </div>
    <p style="color: #333; margin-top: 90px; margin-left: 710px; font-size: 14px; padding: 5px; width:100px">PROFILE</p>
    <?php
    // Display buttons for different data displays
    echo '
    <div class="buttons">
        <form action="" method="post">
            <input type="submit" name="display_user" value="USER">
            <input type="submit" name="display_customer" value="CUSTOMER">
            <input type="submit" name="display_water_source" value="WATER SOURCE">
            <input type="submit" name="display_complaints" value="COMPLAINTS">
            <input type="submit" name="display_water_testing" value="WATER TESTING">
            <input type="submit" name="display_meter" value="METER">
            <input type="submit" name="display_billing" value="BILLING">
        </form>
    </div>';

    // Check if any data button is clicked
    $dataButtonClicked = isset($_POST['display_user']) || isset($_POST['display_customer']) || isset($_POST['display_water_source']) || isset($_POST['display_complaints']) || isset($_POST['display_water_testing']) || isset($_POST['display_meter']) || isset($_POST['display_billing']);

    // Display insert, update, and delete buttons only if no data button is clicked or if any data button is clicked
    if (!$dataButtonClicked || $dataButtonClicked) {
        echo '
        <div class="action-buttons">
            <form action="" method="post">
                <div class="dropdown">
                    <input type="submit" name="insert_data" value="INSERT">
                    <div class="dropdown-content">
                        <a href="insert_user.php">Insert new user information</a>
                        <a href="insert_customer.php">Insert new customer information</a>
                        <a href="insert_meter.php">Insert new meter information</a>
                        <a href="insert_water_source.php">Insert new water source information</a>
                        <a href="insert_billing.php">Insert new billing information</a>
                        <a href="insert_complaint.php">Insert new complaint information</a>
                        <a href="insert_water_testing.php">Insert new water testing information</a>
                    </div>
                </div>
                <div class="dropdown">
                    <input type="submit" name="update_data" value="UPDATE">
                    <div class="dropdown-content">
                        <a href="update_user.php">Update user information</a>
                        <a href="update_customer.php">Update customer information</a>
                        <a href="update_meter.php">Update meter information</a>
                        <a href="update_water_source.php">Update water source information</a>
                        <a href="update_complaint.php">Update complaint information</a>
                    </div>
                </div>
                <div class="dropdown">
                    <input type="submit" name="delete_data" value="DELETE">
                    <div class="dropdown-content">
                        <a href="delete_user.php">Delete user information</a>
                        <a href="delete_customer.php">Delete customer information</a>
                        <a href="delete_meter.php">Delete meter information</a>
                        <a href="delete_water_source.php">Delete water source information</a>
                        <a href="delete_billing.php">Delete billing information</a>
                        <a href="delete_complaint.php">Delete complaint information</a>
                        <a href="delete_water_testing.php">Delete water testing information</a>
                    </div>
                </div>
                <div class="dropdown">
                    <input type="submit" name="print_data" value="PRINT">
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
            </form>
        </div>';
    }


    // Your PHP code for displaying table data based on button clicks
    if ($dataButtonClicked) {
        $servername = "192.168.56.1";
        $username = "root";
        $password = "anagha@2004"; // Change this to your database password
        $dbname = "project";  // Change this to your database name

        // Create connection
        $connection = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        // Function to display table data
        function displayTableData($tableName, $connection) {
            $query = "SELECT * FROM $tableName";
            $result = $connection->query($query);
       
            if ($result->num_rows > 0) {
                // Table data found, display it in a table
                echo "<table>";
                // Output table header
                echo "<tr>";
                $headerPrinted = false;
                while ($row = $result->fetch_assoc()) {
                    if (!$headerPrinted) {
                        foreach ($row as $key => $value) {
                            echo "<th>$key</th>";
                        }
                        echo "</tr>";
                        $headerPrinted = true;
                    }
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>";
                        // Check if the value is NULL and display "NULL" if it is
                        echo ($value === NULL) ? "NULL" : $value;
                        echo "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                // No table data found
                echo "No $tableName data found.";
            }
        }

        // Display data based on button click
        if (isset($_POST['display_user'])) {
            displayTableData('USER', $connection);
        }
        if (isset($_POST['display_customer'])) {
            displayTableData('CUSTOMER', $connection);
        }
        if (isset($_POST['display_water_source'])) {
            displayTableData('WATER_SOURCE', $connection);
        }
        if (isset($_POST['display_complaints'])) {
            displayTableData('COMPLAINTS', $connection);
        }
        if (isset($_POST['display_water_testing'])) {
            displayTableData('WATER_TESTING', $connection);
        }
        if (isset($_POST['display_meter'])) {
            displayTableData('METER', $connection);
        }
        if (isset($_POST['display_billing'])) {
            displayTableData('BILLING', $connection);
        }

        // Close connection
        $connection->close();
    }
    ?>
</div>
<script>
    function toggleProfileFlap() {
        var profileCircle = document.querySelector('.profile-circle');
        profileCircle.classList.toggle('clicked');
    }
</script>
</body>
</html>
