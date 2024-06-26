<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List and Regular Customers</title>
    <style>
         body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color:black;
            color: black;
            background-image: url('image1.jpg'); 
            background-size: cover;
            background-position: center;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        h3 {
            margin-top: 30px;
            color: #555;
        }
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Product List and Regular Customers</h2>
    
    <h3 style="text-align: center; color: white;"  >Products List </h3>
    <table>
        <tr>
            <th style="text-align: center;">Product Name</th>
            <th>Total Quantity Purchased</th>
        </tr>
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

        // Fetch product names and total quantity purchased from Customers table
        $sql = "SELECT ProductName, SUM(ProductQuantity) AS TotalQuantity FROM Customers GROUP BY ProductName ORDER BY TotalQuantity DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ProductName"] . "</td>";
                echo "<td>" . $row["TotalQuantity"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No products found</td></tr>";
        }

        // Close connection
        $conn->close();
        ?>
    </table>

    <h3 style="text-align: center;color: white;">Regular Customers</h3>
    <table>
        <tr>
            <th style="text-align: center;">Customer Name</th>
            <th style="text-align: center;">Total Purchases</th>
        </tr>
        <?php
        // Database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch regular customers and their total purchases
        $sql = "SELECT CustomerName, COUNT(*) AS TotalPurchases FROM Customers GROUP BY CustomerName ORDER BY TotalPurchases DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["CustomerName"] . "</td>";
                echo "<td>" . $row["TotalPurchases"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No regular customers found</td></tr>";
        }

        // Close connection
        $conn->close();
        ?>
         
    </table>
    <div style="text-align: center;">
    <a href="home.php" class="button" style="display: inline-block; background-color: #4CAF50; color: white; text-align: center; padding: 14px 20px; text-decoration: none; margin: 10px 5px; cursor: pointer; border: none; border-radius: 4px;">Add Purchase</a>
    <a href="customer.php" class="button" style="display: inline-block; background-color: #008CBA; color: white; text-align: center; padding: 14px 20px; text-decoration: none; margin: 10px 5px; cursor: pointer; border: none; border-radius: 4px;">BILLING</a>
    <a href="best.php" class="button" style="display: inline-block; background-color: #f44336; color: white; text-align: center; padding: 14px 20px; text-decoration: none; margin: 10px 5px; cursor: pointer; border: none; border-radius: 4px;">BEST ONCES</a>
</div>


</body>
</html>
