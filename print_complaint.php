<!DOCTYPE html>
<html>
<head>
    <title>Print Complaint Information</title>
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

<table id="complaintsTable" border="1" style="display:none;">
    <thead>
        <tr>
            <th>Complaint_Id</th>
            <th>Customer_Id</th>
            <th>Date_Of_Complaint</th>
            <th>Description</th>
            <th>Date_Of_Complaint_Resolution</th>
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

        // Fetch data from COMPLAINTS table
        $sql = "SELECT * FROM COMPLAINTS";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Complaint_Id"] . "</td>";
                echo "<td>" . $row["Customer_Id"] . "</td>";
                echo "<td>" . $row["Date_Of_Complaint"] . "</td>";
                echo "<td>" . $row["Description"] . "</td>";
                echo "<td>" . $row["Date_Of_Complaint_Resolution"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No results found</td></tr>";
        }
        $conn->close();
        ?>
    </tbody>
</table>

<script>
    function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.autoTable({ html: '#complaintsTable' });
        doc.save('complaint_information.pdf');
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
