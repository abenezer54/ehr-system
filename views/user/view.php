<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';
include_once '../../models/Patient.php';
include_once '../../models/Doctor.php';
?>
<?php
session_start();

// Check if the user is logged in and has the role of 'user'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: /ehr-system/404.php");
    exit();
}

// Check if the user's patient ID is set in the session
if (!isset($_SESSION['user_id'])) {
    echo "Patient ID not found in session.";
    exit();
}
// Initialize database connection
$database = new Database();
$connection = $database->getConnection();

// Initialize Patient object
$patient = new Patient($connection);
$doctor = new Doctor($connection);

$patient_id = $patient->getIdByName($_SESSION['username']);

// Include necessary files
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

    // Initialize Patient and Doctor objects
    $patient = new Patient($connection);
    $doctor = new Doctor($connection);

    

    // Get patient details by ID
    $patient_data = $patient->getPatientById($patient_id);
    
    
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
        $records = $patient->getPatientRecords($patient_id);
        
        // Display patient records
        echo "<h2>Patient Records</h2>";
        if ($records->num_rows > 0) {
            while ($record = $records->fetch_assoc()) {
                echo "<div class='record'>";

                $doctor_id = $record['doctor_id'];
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
        if ($patient_data){
            echo "patient data";
        
        }
       
        echo "Patient not found or invalid patient ID.";
    }
    ?>
    
</body>
</html>