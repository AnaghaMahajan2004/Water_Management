<!DOCTYPE html>
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
            background-image: url("https://img.freepik.com/premium-photo/abstract-art-background-light-blue-white-colors-watercolor-painting-canvas-with-sky-gradient-fragment-artwork-paper-with-clouds-pattern-texture-backdrop-macro_113767-4949.jpg");
            background-repeat: no-repeat;
            background-size: cover;
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
            <label for="customer_id">Customer ID:</label>
            <input type="text" id="customer_id" name="customer_id" required>

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
</html>
