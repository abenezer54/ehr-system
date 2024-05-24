<?php
    session_start();
    echo $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .container {
            text-align: center;
            padding: 20px;
            background: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 10em;
            margin: 0;
            color: #e74c3c;
        }

        p {
            font-size: 1.5em;
            margin: 10px 0;
        }

        a {
            text-decoration: none;
            color: #3498db;
            font-size: 1em;
            border: 2px solid #3498db;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        a:hover {
            background-color: #3498db;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <p>Oops! The page you are looking for cannot be found.</p>
        <a href="/">Go Back Home</a>
    </div>
</body>
</html>
