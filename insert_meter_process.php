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

// Get customer ID from the form
$customer_id = $_POST['customer_id'];

// Check if the customer exists in the database
$customer_query = "SELECT * FROM CUSTOMER WHERE Customer_Id = '$customer_id'";
$customer_result = $connection->query($customer_query);

if ($customer_result->num_rows > 0) {
    // Customer exists, check if meter record exists with null values
    $meter_query = "SELECT * FROM METER WHERE Customer_Id = '$customer_id' AND Installation_Date IS NULL AND Status IS NULL";
    $meter_result = $connection->query($meter_query);

    if ($meter_result->num_rows > 0) {
        // Meter record with null values exists, proceed to insert meter information
        // Display the form to insert meter information
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Meter Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e1efff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555555;
        }
        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Insert Meter Information</h2>
        <form action="insert_meter_info_process.php" method="post">
            <input type="hidden" name="customer_id" value="' . $customer_id . '">

            <label for="installation_date">Date of Installation:</label>
            <input type="date" id="installation_date" name="installation_date" required>

            <label for="status">Status of Meter:</label>
            <select id="status" name="status" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>';
    } else {
        // Meter record with null values does not exist
        echo "Customer with Customer ID " . $customer_id . " has an existing meter record.";
    }
} else {
    // Customer does not exist
    echo "Customer with Customer ID " . $customer_id . " does not exist.";
}

// Close connection
$connection->close();
?>
