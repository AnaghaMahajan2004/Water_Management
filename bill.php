<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            background-image: url("display_bg.jpg");
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            background-image: url("display_bg2.webp");
            background-size: cover;         
            background-repeat: no-repeat;  
            background-position: center;  
            background-attachment: fixed;
        }
        h2 {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            background-color: #007bff; /* Blue */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button[type="submit"]:hover {
            background-color: #0056b3; /* Darker Blue */
        }
        .image{
            height:200px;
            width:300px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="ashoka_logo.webp" alt="Lion Capital of Ashoka" style="max-width: 150px;" class="image">
        <h2>Water Bill</h2>
        <form action="generate_bill.php" method="post">
            <label for="customerid">Enter Customer ID:</label>
            <input type="text" id="customerid" name="customerid" required>
            <button type="submit">Generate Bill</button>
        </form>
    </div>
</body>
</html>
