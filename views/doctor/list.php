<?php
include_once '../../config/database.php';
include_once '../../models/Doctor.php';

// Initialize database connection
$database = new Database();
$connection = $database->getConnection();

// Initialize Doctor object
$doctor = new Doctor($connection);

// Get all doctors
$doctors = $doctor->getAllDoctors();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/list.css">
    <title>Doctor List</title>
</head>
<body>
</div>
<div class="add">
    <button> <a href="add.php">
        Add Doctor
    </a></button>
    </div>
    <div class="container">
        <h1>Doctor List</h1>
        <div class="card-container">
            <?php while ($row = $doctors->fetch_assoc()) : ?>
            <div class="card">
                <h2><?php echo $row['name']; ?></h2>
                <p>Email: <?php echo $row['email']; ?></p>
                <p>Specialty: <?php echo $row['specialty']; ?></p>
                <p>Phone: <?php echo $row['phone']; ?></p>
                <p>Address: <?php echo $row['address']; ?></p>
                <a href="view.php?id=<?php echo $row['id']; ?>">View</a>
                <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
