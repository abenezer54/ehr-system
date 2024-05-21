<?php
include_once '../../config/database.php';
include_once '../../models/Patient.php';

// Initialize database connection
$database = new Database();
$connection = $database->getConnection();

// Initialize Patient object
$patient = new Patient($connection);

// Check if patient ID is provided in URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Get patient details by ID to display
    $patient_data = $patient->getPatientById($id);

    // Check if patient exists
    if ($patient_data) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Delete patient by ID
            if ($patient->deletePatient($id)) {
                echo "Patient deleted successfully.";
                // Redirect to list page or any other page
                header("Location: list.php");
                exit;
            } else {
                echo "Error deleting patient.";
            }
        }
    } else {
        echo "Patient not found.";
    }
} else {
    echo "Patient ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Patient</title>
    <link rel="stylesheet" href="../../assets/css/delete.css">
</head>
<body>
    <h1>Delete Patient</h1>
    <?php if ($patient_data): ?>
    <p>Are you sure you want to delete the following patient?</p>
    <div class="card">
        <h2><?php echo $patient_data['name']; ?></h2>
        <p><strong>ID:</strong> <?php echo $patient_data['id']; ?></p>
        <p><strong>Gender:</strong> <?php echo $patient_data['gender']; ?></p>
        <p><strong>Date of Birth:</strong> <?php echo $patient_data['date_of_birth']; ?></p>
        <p><strong>Email:</strong> <?php echo $patient_data['email']; ?></p>
        <p><strong>Phone:</strong> <?php echo $patient_data['phone']; ?></p>
        <p><strong>Address:</strong> <?php echo $patient_data['address']; ?></p>
    </div>
    <form class="confirm-delete-form" method="post">
        <input type="submit" value="Delete">
        <a class="cancel-link" href="list.php">Cancel</a>
    </form>
    <?php else: ?>
    <p>Patient not found.</p>
    <?php endif; ?>
</body>
</html>
