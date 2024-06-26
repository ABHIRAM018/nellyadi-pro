<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Project Home</title>
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
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #ffffff;
            margin-bottom: 20px;
            animation: slideInDown 1s ease;
        }

        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .button:hover {
            background-color: #45a049;
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to ANALIZ</h1>
        <p>"AnalizRetail" is a cutting-edge retail analytics platform. It leverages data insights to optimize operations, and boost sales. With intuitive visualizations and powerful algorithms, Analiz helps retailers stay ahead in the competitive market.</p>
        <p>Please select an option below:</p>
        <a href="home.php" class="button">Add Purchase</a>
        <a href="customer.php" class="button">BILLING </a>
        <a href="best.php" class="button">BEST ONCES</a>
        <a href="graph.php" class="button">graph</a>
        <!-- Add more buttons or links as needed -->
    </div>
</body>
</html>
