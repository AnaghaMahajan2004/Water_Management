<!DOCTYPE html>
<html>
<head>
    <title>Print Billing Information</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.19/jspdf.plugin.autotable.min.js"></script>
    <style>
        /* Style for the back to home page button */
        .back-button {
            background-color: #007bff; /* Blue */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 8px;
        }

        .back-button:hover {
            background-color: #0056b3; /* Darker Blue */
        }

        #message {
            text-align: center;
            margin-top: 20px;
        }
        body{
            background-image: url("display_bg2.webp");
            background-size: cover;         
            background-repeat: no-repeat;  
            background-position: center;  
            background-attachment: fixed;
        }
    </style>
</head>
<body>

<div id="message">
    <h2>Data downloaded successfully</h2>
    <button class="back-button" onclick="goBack()">Back to Dashboard</button>
</div>

<table id="billingTable" border="1" style="display:none;">
    <thead>
        <tr>
            <th>Bill_Id</th>
            <th>Customer_Id</th>
            <th>Previous_Reading</th>
            <th>Current_Reading</th>
            <th>Bill_Date</th>
            <th>Water_Consumption</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Database connection
        $servername = "192.168.56.1";
        $username = "root";
        $password = "anagha@2004";
        $dbname = "project";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch data from BILLING table
        $sql = "SELECT * FROM BILLING";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Bill_Id"] . "</td>";
                echo "<td>" . $row["Customer_Id"] . "</td>";
                echo "<td>" . $row["Previous_Reading"] . "</td>";
                echo "<td>" . $row["Current_Reading"] . "</td>";
                echo "<td>" . $row["Bill_Date"] . "</td>";
                echo "<td>" . $row["Water_Consumption"] . "</td>";
                echo "<td>" . $row["Amount"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No results found</td></tr>";
        }
        $conn->close();
        ?>
    </tbody>
</table>

<script>
    function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.autoTable({ html: '#billingTable' });
        doc.save('billing_information.pdf');
    }

    function goBack() {
        window.location.href = 'display.php';
    }

    window.onload = function() {
        downloadPDF();
    };
</script>

</body>
</html>
