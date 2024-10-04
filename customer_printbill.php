<?php
session_start(); // Start session to access logged in customer data

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

// Get customer ID from the session
$customerid = $_SESSION['customer_id'];

// Retrieve customer details
$customer_query = "SELECT * FROM CUSTOMER WHERE Customer_Id = '$customerid'";
$customer_result = $connection->query($customer_query);

if ($customer_result->num_rows > 0) {
    $customer_row = $customer_result->fetch_assoc();

    // Retrieve billing details including meter details
    $billing_query = "SELECT BILLING.*, METER.Meter_Id, METER.Installation_Date, METER.Status 
                      FROM BILLING 
                      LEFT JOIN METER ON BILLING.Customer_Id = METER.Customer_Id
                      WHERE BILLING.Customer_Id = '$customerid' 
                      ORDER BY BILLING.Bill_Date DESC 
                      LIMIT 1";
    $billing_result = $connection->query($billing_query);

    if ($billing_result->num_rows > 0) {
        $billing_row = $billing_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 100px;
        }
        .bill-details, .customer-details, .meter-details, .billing-details, .amount-due {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }
        h3 {
            margin-top: 0;
            font-size: 20px;
            color: #333;
        }
        p {
            margin: 5px 0;
            color: #666;
        }
        .amount-due {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="ashoka_logo.webp" alt="Lion Capital of Ashoka">
            <h2>Water Bill</h2>
        </div>
        
        <div class="bill-details">
            <p><strong>Bill Date:</strong> <?php echo date("Y-m-d"); ?></p>
            <p><strong>Due Date:</strong> <?php echo date("Y-m-d", strtotime("+30 days")); ?></p>
        </div>

        <div class="customer-details">
            <h3>Customer Details</h3>
            <p><strong>Customer ID:</strong> <?php echo $customer_row['Customer_Id']; ?></p>
            <p><strong>Customer Name:</strong> <?php echo $customer_row['Customer_Name']; ?></p>
            <p><strong>Address:</strong> <?php echo $customer_row['Address']; ?></p>
            <p><strong>Mobile Number:</strong> <?php echo $customer_row['Mobile_No']; ?></p>
            <p><strong>Email:</strong> <?php echo $customer_row['Email_Id']; ?></p>
        </div>

        <div class="meter-details">
            <h3>Meter Details</h3>
            <p><strong>Meter ID:</strong> <?php echo ($billing_row['Meter_Id'] ?? 'N/A'); ?></p>
            <p><strong>Installation Date:</strong> <?php echo ($billing_row['Installation_Date'] ?? 'N/A'); ?></p>
            <p><strong>Meter Status:</strong> <?php echo ($billing_row['Status'] ?? 'N/A'); ?></p>
        </div>

        <div class="billing-details">
            <h3>Billing Details</h3>
            <p><strong>Previous Reading:</strong> <?php echo $billing_row['Previous_Reading']; ?></p>
            <p><strong>Current Reading:</strong> <?php echo $billing_row['Current_Reading']; ?></p>
            <p><strong>Water Consumption:</strong> <?php echo $billing_row['Water_Consumption']; ?></p>
            <p><strong>Amount:</strong> <?php echo $billing_row['Amount']; ?></p>
        </div>

        <div class="amount-due">
            <p><strong>Amount Due:</strong> <?php echo $billing_row['Amount']; ?></p>
        </div>

        <button onclick="window.print()">Print Bill</button>
    </div>
</body>
</html>

<?php
    } else {
        echo "No billing information found for this customer.";
    }
} else {
    echo "Customer ID not found.";
}

// Close result sets and connection
$customer_result->close();
$billing_result->close();
$connection->close();
?>
