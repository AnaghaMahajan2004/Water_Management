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

// Get source ID from the form
$source_id = $_POST['source_id'];

// Check if the source ID exists in the water source table
$source_query = "SELECT * FROM WATER_SOURCE WHERE Source_Id = '$source_id'";
$source_result = $connection->query($source_query);

if ($source_result->num_rows > 0) {
    // Source with the provided ID exists, proceed to insert water testing information
    // Display the form to insert water testing information
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Water Testing Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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
        input[type="date"],
        input[type="number"] {
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
        <h2>Insert Water Testing Information</h2>
        <form action="insert_water_testing_info_process.php" method="post">
            <input type="hidden" name="source_id" value="' . $source_id . '">

            <label for="date_of_testing">Date of Testing:</label>
            <input type="date" id="date_of_testing" name="date_of_testing" required>

            <label for="ph_level">PH Level:</label>
            <input type="number" id="ph_level" name="ph_level" step="0.01" min="0" required>

            <label for="amount_of_free_chlorine">Amount of Free Chlorine:</label>
            <input type="number" id="amount_of_free_chlorine" name="amount_of_free_chlorine" step="0.01" min="0" required>

            <label for="turbidity">Turbidity:</label>
            <input type="number" id="turbidity" name="turbidity" step="0.01" min="0" required>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>';
} else {
    // Source with the provided ID doesn't exist
    echo "No source with source ID '$source_id' found.";
}

// Close connection
$connection->close();
?>
