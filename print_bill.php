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
        .bill-details {
            margin-bottom: 20px;
        }
        .customer-details,
        .meter-details,
        .billing-details,
        .amount-due {
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
        if (isset($_POST['customerid'])) {
            $customerid = $connection->real_escape_string($_POST['customerid']);

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

                    // Display bill details
                    echo '<div class="bill-details">';
                    echo '<p><strong>Bill Date:</strong> ' . date("Y-m-d") . '</p>';
                    echo '<p><strong>Due Date:</strong> ' . date("Y-m-d", strtotime("+30 days")) . '</p>';
                    echo '</div>';

                    // Display customer details
                    echo '<div class="customer-details">';
                    echo '<h3>Customer Details</h3>';
                    echo '<p><strong>Customer ID:</strong> ' . $customer_row['Customer_Id'] . '</p>';
                    echo '<p><strong>Customer Name:</strong> ' . $customer_row['Customer_Name'] . '</p>';
                    echo '<p><strong>Address:</strong> ' . $customer_row['Address'] . '</p>';
                    echo '<p><strong>Mobile Number:</strong> ' . $customer_row['Mobile_No'] . '</p>';
                    echo '<p><strong>Email:</strong> ' . $customer_row['Email_Id'] . '</p>';
                    echo '</div>';

                    // Display meter details
                    echo '<div class="meter-details">';
                    echo '<h3>Meter Details</h3>';
                    echo '<p><strong>Meter ID:</strong> ' . ($billing_row['Meter_Id'] ?? 'N/A') . '</p>';
                    echo '<p><strong>Installation Date:</strong> ' . ($billing_row['Installation_Date'] ?? 'N/A') . '</p>';
                    echo '<p><strong>Meter Status:</strong> ' . ($billing_row['Status'] ?? 'N/A') . '</p>';
                    echo '</div>';

                    // Display billing details
                    echo '<div class="billing-details">';
                    echo '<h3>Billing Details</h3>';
                    echo '<p><strong>Previous Reading:</strong> ' . $billing_row['Previous_Reading'] . '</p>';
                    echo '<p><strong>Current Reading:</strong> ' . $billing_row['Current_Reading'] . '</p>';
                    echo '<p><strong>Water Consumption:</strong> ' . $billing_row['Water_Consumption'] . '</p>';
                    echo '<p><strong>Amount:</strong> ' . $billing_row['Amount'] . '</p>';
                    echo '</div>';

                    // Display amount due
                    echo '<div class="amount-due">';
                    echo '<p><strong>Amount Due:</strong> ' . $billing_row['Amount'] . '</p>';
                    echo '</div>';
                } else {
                    echo "No billing information found for this customer.";
                }
            } else {
                echo "Customer ID not found.";
            }

            // Close result sets
            $customer_result->close();
            $billing_result->close();
        } else {
            echo "No customer ID provided.";
        }

        // Close connection
        $connection->close();
        ?>
        
        <button onclick="window.print()">Print Bill</button>
    </div>
</body>
</html>
