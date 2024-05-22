<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EHR System</title>
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
</head>
<body>
    <?php
    include("includes/header.php"); ?>
    <div class="container">
        <h2>Home Page</h2>
        <a href="views/doctor/list.php">View Doctors</a>
        <a href="views/patient/list.php">View Patients</a>
        <p>This is the homepage of the EHR System.</p>
    </div>

    <?php
    include("includes/footer.php"); ?>
</body>
</html>
