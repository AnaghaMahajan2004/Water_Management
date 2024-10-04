<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer Information</title>
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
        input[type="password"],
        input[type="email"],
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
        <h2>Update Customer Information</h2>
        <form action="update_customer_process.php" method="post">
            <label for="customerid">Customer ID:</label>
            <input type="text" id="customerid" name="customerid" required>

            <label for="name">Updated Name:</label>
            <input type="text" id="name" name="name">

            <label for="address">Updated Address:</label>
            <input type="text" id="address" name="address">

            <label for="mobileno">Updated Mobile Number:</label>
            <input type="text" id="mobileno" name="mobileno">

            <label for="email">Updated Email Address:</label>
            <input type="email" id="email" name="email">

            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
