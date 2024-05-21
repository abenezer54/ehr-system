<?php
include_once '../../config/database.php';
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

// Initialize Doctor object
$doctor = new Doctor($connection);

// Check if doctor ID is provided in URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Get doctor details by ID
    $doctor_data = $doctor->getDoctorById($id);
    
    // Check if doctor exists
    if ($doctor_data) {
        // Display doctor details
        echo "<div class='card'>";
        echo "<h2>" . $doctor_data['name'] . "</h2>";
        echo "<p><strong>ID:</strong> " . $doctor_data['id'] . "</p>";
        echo "<p><strong>Specialty:</strong> " . $doctor_data['specialty'] . "</p>";
        echo "<p><strong>Email:</strong> " . $doctor_data['email'] . "</p>";
        echo "<p><strong>Phone:</strong> " . $doctor_data['phone'] . "</p>";
        echo "<p><strong>Address:</strong> " . $doctor_data['address'] . "</p>";
        echo "</div>";
    } else {
        echo "Doctor not found.";
    }
} else {
    echo "Doctor ID not provided.";
}
?>
<link rel="stylesheet" href="../../assets/css/style.css">
</body>
</html>
