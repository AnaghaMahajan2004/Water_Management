<?php
// Database connection details
$servername = "192.168.56.1";
$username = "root";
$password = "anagha@2004"; // Update to your database password
$dbname = "project";  // Update to your database name

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Query to get table names
$sql = "SHOW TABLES";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    // Output table names and columns
    while ($row = $result->fetch_array()) {
        $table = $row[0];
        echo "<h2>Table: $table</h2>";

        // Query to get columns for the current table
        $columnsSql = "DESCRIBE $table";
        $columnsResult = $connection->query($columnsSql);

        if ($columnsResult->num_rows > 0) {
            echo "<ul>";
            while ($columnRow = $columnsResult->fetch_assoc()) {
                echo "<li>" . $columnRow['Field'] . " - " . $columnRow['Type'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "No columns found for table $table.<br>";
        }
    }
} else {
    echo "No tables found.";
}

// Close connection
$connection->close();
?>
