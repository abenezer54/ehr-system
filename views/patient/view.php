<?php
include_once '../../config/database.php';
include_once '../../models/Patient.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <link rel="stylesheet" href="../../assets/css/view.css">
</head>
<body>
    <?php
    // Initialize database connection
    $database = new Database();
    $connection = $database->getConnection();

    // Initialize Patient object
    $patient = new Patient($connection);

    // Check if patient ID is provided in URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        // Get patient details by ID
        $patient_data = $patient->getPatientById($id);
        
        // Check if patient exists
        if ($patient_data) {
            // Display patient details
            echo "<div class='card'>";
            echo "<h2>" . $patient_data['name'] . "</h2>";
            echo "<p><strong>ID:</strong> " . $patient_data['id'] . "</p>";
            echo "<p><strong>Gender:</strong> " . $patient_data['gender'] . "</p>";
            echo "<p><strong>Date of Birth:</strong> " . $patient_data['date_of_birth'] . "</p>";
            echo "<p><strong>Email:</strong> " . $patient_data['email'] . "</p>";
            echo "<p><strong>Phone:</strong> " . $patient_data['phone'] . "</p>";
            echo "<p><strong>Address:</strong> " . $patient_data['address'] . "</p>";
            echo "</div>";
        } else {
            echo "Patient not found.";
        }
    } else {
        echo "Patient ID not provided.";
    }
    ?>
</body>
</html>
