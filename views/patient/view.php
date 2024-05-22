<?php
include_once '../../config/database.php';
include_once '../../models/Patient.php';
include_once '../../models/Doctor.php';
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
    $doctor = new Doctor($connection);

    // Check if patient ID is provided in URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        // Validate the ID
        if (!is_numeric($id)) {
            echo "Invalid patient ID.";
            exit;
        }

        // Get patient details by ID
        $patient_data = $patient->getPatientById($id);
        
        // Check if patient exists
        if ($patient_data && isset($patient_data['id'])) {
            // Display patient details
            echo "<div class='card'>";
            echo "<h2>" . htmlspecialchars($patient_data['name']) . "</h2>";
            echo "<p><strong>ID:</strong> " . htmlspecialchars($patient_data['id']) . "</p>";
            echo "<p><strong>Gender:</strong> " . htmlspecialchars($patient_data['gender']) . "</p>";
            echo "<p><strong>Date of Birth:</strong> " . htmlspecialchars($patient_data['date_of_birth']) . "</p>";
            echo "<p><strong>Email:</strong> " . htmlspecialchars($patient_data['email']) . "</p>";
            echo "<p><strong>Phone:</strong> " . htmlspecialchars($patient_data['phone']) . "</p>";
            echo "<p><strong>Address:</strong> " . htmlspecialchars($patient_data['address']) . "</p>";
            echo "</div>";

            // Get patient records
            $records = $patient->getPatientRecords($id);
            
            // Display patient records
            echo "<h2>Patient Records</h2>";
            if ($records->num_rows > 0) {
                while ($record = $records->fetch_assoc()) {
                    echo "<div class='record'>";

                    $doctor_id = $doctor->getDoctorById($record['doctor_id']);
                    $doctor_name = $doctor->getDoctorNameById($doctor_id);

                    echo "<p><strong>Doctor Name:</strong> " . $doctor_name . "</p>";
                    echo "<p><strong>Doctor ID:</strong> " . $doctor_id . "</p>";
                    echo "<p><strong>Description:</strong> " . htmlspecialchars($record['description']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No records found for this patient.</p>";
            }
        } else {
            echo "Patient not found or invalid patient ID.";
        }
    } else {
        echo "Patient ID not provided.";
    }
    ?>
    
</body>
</html>
