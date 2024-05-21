<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EHR System</title>
    <link rel="stylesheet" href="/assets/css/index.css">
</head>
<body>
    <header>
        <h1>Welcome to EHR System</h1>
        <nav>
            <ul>
                <li><a href="views/doctor/list.php">Doctors</a></li>
                <li><a href="views/patient/list.php">Patients</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Home Page</h2>
        <p>This is the homepage of the EHR System.</p>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> EHR System</p>
    </footer>
</body>
</html>
