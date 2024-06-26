<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly and Yearly Profit Analysis</title>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 20px; background-color: #f2f2f2; color: #333;">

    <div style="max-width: 800px; margin: 0 auto;">
        <h1 style="text-align: center;">Monthly and Yearly Profit Analysis</h1>
        <canvas id="monthlyProfitChart" width="800" height="400"></canvas>
        <canvas id="yearlyProfitChart" width="800" height="400"></canvas>
        <canvas id="productsAnalysisChart" width="800" height="400"></canvas>
    </div>

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

    // Fetch monthly profit data
    $monthlyProfitData = array();
    for ($month = 1; $month <= 12; $month++) {
        $sql = "SELECT SUM(TotalPrice) AS monthly_profit FROM Customers WHERE MONTH(PurchaseDate) = $month";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $monthlyProfitData[] = $row['monthly_profit'] ? $row['monthly_profit'] : 0;
    }

    // Fetch yearly profit data
    $yearlyProfitData = array();
    for ($year = date('Y') - 5; $year <= date('Y'); $year++) {
        $sql = "SELECT SUM(TotalPrice) AS yearly_profit FROM Customers WHERE YEAR(PurchaseDate) = $year";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $yearlyProfitData[$year] = $row['yearly_profit'] ? $row['yearly_profit'] : 0;
    }

    // Fetch product analysis data
    $productAnalysisData = array();
    $sql = "SELECT p.ProductName, 
            SUM(c.ProductQuantity * p.ProductPrice) AS revenue, 
            SUM(c.ProductQuantity * pi.Quantity) AS cogs 
            FROM Customers c
            JOIN Products p ON c.ProductName = p.ProductName
            JOIN ProductInventory pi ON c.ProductName = pi.ProductName
            GROUP BY p.ProductName";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $profit = $row['revenue'] - $row['cogs'];
        $productAnalysisData[$row['ProductName']] = $profit;
    }

    // Close connection
    $conn->close();
    ?>

    <script>
        // Monthly profit chart
        var monthlyProfitChart = new Chart(document.getElementById('monthlyProfitChart'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Monthly Profit',
                    data: <?php echo json_encode($monthlyProfitData); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        // Yearly profit chart
        var yearlyProfitChart = new Chart(document.getElementById('yearlyProfitChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode(range(date('Y') - 5, date('Y'))); ?>,
                datasets: [{
                    label: 'Yearly Profit',
                    data: <?php echo json_encode(array_values($yearlyProfitData)); ?>,
                    fill: false,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        // Products analysis chart
        var productsAnalysisChart = new Chart(document.getElementById('productsAnalysisChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($productAnalysisData)); ?>,
                datasets: [{
                    label: 'Profit per Product',
                    data: <?php echo json_encode(array_values($productAnalysisData)); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
