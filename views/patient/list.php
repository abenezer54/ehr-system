<?php
include_once '../../config/database.php';
include_once '../../models/Patient.php';


$database = new Database();
$db = $database->getConnection();
$patient = new Patient($db);
$patients = $patient->getAllPatients();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Patients</title>
    <link rel="stylesheet" href="../../assets/css/list.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
</head>
<body>
    <?php
    include("../../includes/header.php"); ?>
    
    <div class="container">
    <button> <a href="add.php">
        Add Patient
    </a></button>
        <h1>Patients List</h1>
        <div class="card-container">
            <?php while ($row = $patients->fetch_assoc()): ?>
            <div class="card">
                <h2><?php echo $row['name']; ?></h2>
                <p><strong>ID:</strong> <?php echo $row['id']; ?></p>
                <p><strong>Gender:</strong> <?php echo $row['gender']; ?></p>
                <p><strong>Date of Birth:</strong> <?php echo $row['date_of_birth']; ?></p>
                <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
                <p><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
                <p><strong>Address:</strong> <?php echo $row['address']; ?></p>
                <a href="view.php?id=<?php echo $row['id']; ?>">View</a>
                <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
