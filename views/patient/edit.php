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
    
    // Get patient details by ID
    $patient_data = $patient->getPatientById($id);
    
    // Check if patient exists
    if ($patient_data) {
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $name = $_POST['name'];
            $gender = $_POST['gender'];
            $date_of_birth = $_POST['date_of_birth'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            
            // Update patient
            if ($patient->updatePatient($id, $name, $gender, $date_of_birth, $email, $phone, $address)) {
                echo "Patient updated successfully.";
                // Redirect to list page or any other page
                header("Location: list.php");
                exit;
            } else {
                echo "Error updating patient.";
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
    <title>Edit Patient</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h1>Edit Patient</h1>
    <?php if ($patient_data): ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($patient_data['name']); ?>" required><br>
        
        <label>Gender:</label>
        <input type="radio" name="gender" value="male" <?php echo ($patient_data['gender'] == 'male') ? 'checked' : ''; ?>> Male
        <input type="radio" name="gender" value="female" <?php echo ($patient_data['gender'] == 'female') ? 'checked' : ''; ?>> Female<br>
        
        <label>Date of Birth:</label>
        <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($patient_data['date_of_birth']); ?>" required><br>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($patient_data['email']); ?>" required><br>
        
        <label>Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($patient_data['phone']); ?>" required><br>
        
        <label>Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($patient_data['address']); ?>" required><br>
        
        <input type="submit" value="Update Patient">
    </form>
    <?php else: ?>
    <p>Patient not found.</p>
    <?php endif; ?>
</body>
</html>
