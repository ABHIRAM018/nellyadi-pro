<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
         body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #333333;
            color: #ffffff;
            background-image: url('image1.jpg'); 
            background-size: cover;
            background-position: center;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Product</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" required>

            <label for="productPrice">Product Price:</label>
            <input type="number" id="productPrice" name="productPrice" min="0" step="0.01" required>

            <label for="productQuantity">Product Quantity:</label>
            <input type="number" id="productQuantity" name="productQuantity" min="0" required>

            <input type="submit" name="submit" value="Add Product">
        </form>

        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root"; // Your MySQL username
    $password = ""; // Your MySQL password
    $dbname = "pro"; // Your MySQL database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productQuantity = $_POST['productQuantity'];

    // Calculate total price
    $totalPrice = $productPrice * $productQuantity;

    // Insert data into Products table
    $sql_products = "INSERT INTO Products (ProductName, ProductPrice, ProductQuantity, TotalPrice)
            VALUES ('$productName', '$productPrice', '$productQuantity', '$totalPrice')";

    // Insert data into ProductInventory table
    $sql_inventory = "INSERT INTO ProductInventory (ProductName, Quantity)
            VALUES ('$productName', '$productQuantity')";

    if ($conn->query($sql_products) === TRUE && $conn->query($sql_inventory) === TRUE) {
        echo "<p style='color: green;'>Product added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $sql_products . "<br>" . $conn->error . "</p>";
    }

    // Close connection
    $conn->close();
}
?>
<a href="home.php" class="button" style="display: inline-block; background-color: #4CAF50; color: white; text-align: center; padding: 14px 20px; text-decoration: none; margin: 10px 5px; cursor: pointer; border: none; border-radius: 4px;">Add Purchase</a>
<a href="customer.php" class="button" style="display: inline-block; background-color: #008CBA; color: white; text-align: center; padding: 14px 20px; text-decoration: none; margin: 10px 5px; cursor: pointer; border: none; border-radius: 4px;">BILLING</a>
<a href="best.php" class="button" style="display: inline-block; background-color: #f44336; color: white; text-align: center; padding: 14px 20px; text-decoration: none; margin: 10px 5px; cursor: pointer; border: none; border-radius: 4px;">BEST ONCES</a>

    </div>
</body>
</html>
