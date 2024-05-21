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
    
    // Get doctor details by ID
    $doctor_data = $doctor->getDoctorById($id);
    
    // Check if doctor exists
    if ($doctor_data) {
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $name = $_POST['name'];
            $specialty = $_POST['specialty'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            
            // Update doctor
            if ($doctor->updateDoctor($id, $name, $specialty, $email, $phone, $address)) {
                echo "Doctor updated successfully.";
                // Redirect to list page or any other page
                // header("Location: list.php");
            } else {
                echo "Error updating doctor.";
            }
        }
    } else {
        echo "Doctor not found.";
    }
} else {
    echo "Doctor ID not provided.";
}
?>

<!-- HTML form for editing doctor details -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo $doctor_data['name']; ?>" required><br>
    <label>Specialty:</label>
    <input type="text" name="specialty" value="<?php echo $doctor_data['specialty']; ?>"><br>
    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $doctor_data['email']; ?>" required><br>
    <label>Phone:</label>
    <input type="text" name="phone" value="<?php echo $doctor_data['phone']; ?>"><br>
    <label>Address:</label>
    <input type="text" name="address" value="<?php echo $doctor_data['address']; ?>"><br>
    <input type="submit" value="Update Doctor">
</form>
