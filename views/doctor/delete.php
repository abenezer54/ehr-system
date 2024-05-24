<?php
include_once '../../config/database.php';
include_once '../../models/Doctor.php';

// Initialize database connection
$database = new Database();
$connection = $database->getConnection();

// Initialize Doctor object
$doctor = new Doctor($connection);

// Check if doctor ID is provided in URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get doctor details by ID to display
    $doctor_data = $doctor->getDoctorById($id);

    // Check if doctor exists
    if ($doctor_data) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Start transaction
            $connection->begin_transaction();

            try {
                // Delete user by doctor ID
                $sql_user = "DELETE FROM users WHERE username = ?";
                $stmt_user = $connection->prepare($sql_user);
                $stmt_user->bind_param("s", $doctor_data['name']);
                $stmt_user->execute();
                $stmt_user->close();

                // Delete doctor by ID
                if ($doctor->deleteDoctor($id)) {
                    // Commit transaction
                    $connection->commit();
                    echo "Doctor deleted successfully.";
                    // Redirect to list page or any other page
                    header("Location: list.php");
                    exit;
                } else {
                    // Rollback transaction if doctor deletion fails
                    $connection->rollback();
                    echo "Error deleting doctor.";
                }
            } catch (Exception $e) {
                // Rollback transaction if any exception occurs
                $connection->rollback();
                echo "Error: " . $e->getMessage();
            }
        }
    } else {
        echo "Doctor not found.";
    }
} else {
    echo "Doctor ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Doctor</title>
    <link rel="stylesheet" href="../../assets/css/delete.css">
</head>
<body>
    <h1>Delete Doctor</h1>
    <?php if ($doctor_data): ?>
    <p>Are you sure you want to delete the following doctor?</p>
    <div class="card">
        <h2><?php echo $doctor_data['name']; ?></h2>
        <p><strong>ID:</strong> <?php echo $doctor_data['id']; ?></p>
        <p><strong>Specialty:</strong> <?php echo $doctor_data['specialty']; ?></p>
        <p><strong>Email:</strong> <?php echo $doctor_data['email']; ?></p>
        <p><strong>Phone:</strong> <?php echo $doctor_data['phone']; ?></p>
        <p><strong>Address:</strong> <?php echo $doctor_data['address']; ?></p>
    </div>
    <form method="post">
        <input type="submit" value="Delete">
        <a href="list.php">Cancel</a>
    </form>
    <?php else: ?>
    <p>Doctor not found.</p>
    <?php endif; ?>
</body>
</html>
