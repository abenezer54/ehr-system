<?php $picture = "../assets/img/patients2.jpg"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home Page</title>
    <link rel="stylesheet" href="../assets/css/admin-homepage.css">
</head>
<body>
    <?php include("../includes/header.php"); ?>

    <div class="container">
        <h1 class="welcome-message">Welcome to the Admin Homepage</h1>
        <div class="button-container">
            <button>
                <a href="doctor/list.php">
                    <img src="../assets/img/staff1.jpg" alt="Staff">
                    <span>Staff</span>
                </a>
            </button>
            <button>
                <a href="patient/list.php">
                    <img src="../assets/img/patients2.jpg" alt="Patients">
                    <span>Patients</span>
                </a>
            </button>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>
</body>
</html>
