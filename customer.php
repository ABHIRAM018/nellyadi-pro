<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Purchase</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color:white;
            color: #ffffff;
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
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"],
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }
        input[type="submit"]:hover,
        .button:hover {
            background-color:black;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h2>Add Purchase</h2>
            <label for="customerName">Customer Name:</label>
            <input type="text" id="customerName" name="customerName" required>
            <label for="productName">Product Name:</label>
            <select id="productName" name="productName">
                <?php
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

                // Fetch product names from Products table
                $sql = "SELECT ProductName, ProductPrice FROM Products";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["ProductName"] . "'>" . $row["ProductName"] . " - $" . $row["ProductPrice"] . "</option>";
                    }
                }

                // Close connection
                $conn->close();
                ?>
            </select>
            <label for="productQuantity">Product Quantity:</label>
            <input type="number" id="productQuantity" name="productQuantity" min="1" required>
            <label for="purchaseDate">Purchase Date:</label>
            <input type="date" id="purchaseDate" name="purchaseDate" required>
            <input type="submit" name="submit" value="Add Purchase">
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
            $customerName = $_POST['customerName'];
            $productName = $_POST['productName'];
            $productQuantity = $_POST['productQuantity'];
            $purchaseDate = $_POST['purchaseDate'];

            // Fetch product price from Products table
            $sql_price = "SELECT ProductPrice FROM Products WHERE ProductName='$productName'";
            $result_price = $conn->query($sql_price);
            $row_price = $result_price->fetch_assoc();
            $productPrice = $row_price["ProductPrice"];

            // Calculate total price
            $totalPrice = $productPrice * $productQuantity;

            // Insert data into Customers table
            $sql_insert = "INSERT INTO Customers (CustomerName, ProductName, ProductPrice, ProductQuantity, PurchaseDate, TotalPrice)
                            VALUES ('$customerName', '$productName', '$productPrice', '$productQuantity', '$purchaseDate', '$totalPrice')";

            if ($conn->query($sql_insert) === TRUE) {
                // Display purchase details
                echo "<div id='print-content'>";
                echo "<h2>Purchase Details</h2>";
                echo "<p style='color: black;'>Customer Name: $customerName</p>";
                echo "<p style='color: black;'>Product Name: $productName</p>";
                echo "<p style='color: black;'>Product Quantity: $productQuantity</p>";
                echo "<p style='color: black;'>Purchase Date: $purchaseDate</p>";
                echo "<p style='color: black;'>Total Price: $totalPrice</p>";
                echo "</div>";

                // Reduce product quantity in ProductInventory table
                $sql_inventory = "UPDATE ProductInventory SET Quantity = Quantity - $productQuantity WHERE ProductName='$productName'";
                $conn->query($sql_inventory);
            } else {
                echo "<p style='color: red;'>Error: " . $sql_insert . "<br>" . $conn->error . "</p>";
            }

            // Close connection
            $conn->close();
        }
        ?>

        <!-- Print button -->
        <div style="text-align: center;">
        <br><button onclick="printContent('print-content')" class="button">Print Purchase Details</button><br>
        </div>
        <!-- Navigation buttons -->
        <div style="text-align: center;"><br>
    <a href="home.php" class="button">Add Purchase</a>
    <a href="customer.php" class="button">BILLING</a>
    <a href="best.php" class="button">BEST ONES</a>
</div>


        <script>
            function printContent(id) {
                var content = document.getElementById(id);
                var originalContent = document.body.innerHTML;
                document.body.innerHTML = content.innerHTML;
                window.print();
                document.body.innerHTML = originalContent;
            }
        </script>
    </div>
</body>
</html>
