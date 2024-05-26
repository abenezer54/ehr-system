<?php
include_once '../../config/database.php';
include_once '../../models/Doctor.php';
include_once '../../models/Validator.php'; 

// Initialize database connection
$database = new Database();
$connection = $database->getConnection();

// Initialize Doctor object
$doctor = new Doctor($connection);

// Initialize Validator object
$validator = new Validator();

// Initialize an array to store errors
$errors = array();

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

            // Validate form data
            if (!$validator->validateRequired($name)) {
                $errors['name'] = "Name is required.";
            } elseif (!$validator->validateAlphabetic($name)) {
                $errors['name'] = "Name can only contain alphabets.";
            }

            if (!$validator->validateRequired($email)) {
                $errors['email'] = "Email is required.";
            } elseif (!$validator->validateEmail($email)) {
                $errors['email'] = "Invalid email format.";
            }

            if (!$validator->validateRequired($phone)) {
                $errors['phone'] = "Phone number is required.";
            } elseif (!$validator->validateStringLength($phone, 10, 15)) {
                $errors['phone'] = "Phone number must be between 10 and 15 characters.";
            } elseif (!$validator->validatePattern($phone, '/^\d+$/')) {
                $errors['phone'] = "Invalid phone number format.";
            }

            // Update doctor if there are no validation errors
            if (empty($errors)) {
                if ($doctor->updateDoctor($id, $name, $specialty, $email, $phone, $address)) {
                    // Set alert message
                    echo "<script>alert('Doctor updated successfully.');</script>";
                    // Redirect to list page
                    echo "<script>window.location.href = 'list.php';</script>";
                    exit; // Terminate script execution after redirection
                } else {
                    echo "Error updating doctor.";
                }
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
    <link rel="stylesheet" href="../../assets/css/doc-edit.css">
    <title>Edit Doctor</title>
</head>
<body>
    <?php include("../../includes/header.php"); ?>
    <div class="container">
        <!-- Check if doctor details are loaded -->
        <?php if ($doctor_data): ?>
            <h2>Edit Doctor</h2>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo $doctor_data['name']; ?>" required>
    <?php if(isset($errors['name'])) echo "<span class='error'>{$errors['name']}</span>"; ?>
    <br>    
    <label>Specialty:</label>
    <select name="specialty">
        <option value="">Select Specialization</option>
        <option value="Anesthesiology">Anesthesiology</option>
        <option value="Cardiology">Cardiology</option>
        <option value="Clinical Laboratory Scientists">Clinical Laboratory Scientists</option>
        <option value="Dentistry">Dentistry</option>
        <option value="Dermatology">Dermatology</option>
        <option value="Endocrinology">Endocrinology</option>
        <option value="Gastroenterology">Gastroenterology</option>
        <option value="General Surgery">General Surgery</option>
        <option value="Hematology">Hematology</option>
        <option value="Nephrology">Nephrology</option>
        <option value="Neurology">Neurology</option>
        <option value="Nurse">Nurse</option>
        <option value="Obstetrics and Gynecology">Obstetrics and Gynecology</option>
        <option value="Oncology">Oncology</option>
        <option value="Ophthalmology">Ophthalmology</option>
        <option value="Orthopedics">Orthopedics</option>
        <option value="Otolaryngology (ENT)">Otolaryngology (ENT)</option>
        <option value="Pediatrics">Pediatrics</option>
        <option value="Plastic Surgery">Plastic Surgery</option>
        <option value="Psychiatry">Psychiatry</option>
        <option value="Pulmonology">Pulmonology</option>
        <option value="Radiologists">Radiologists</option>
        <option value="Radiology">Radiology</option>
        <option value="Rheumatology">Rheumatology</option>
        <option value="Urology">Urology</option>
    </select>
    <br>
    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $doctor_data['email']; ?>" required>
    <?php if(isset($errors['email'])) echo "<span class='error'>{$errors['email']}</span>"; ?>
    <br>
    <label>Phone:</label>
    <input type="text" name="phone" value="<?php echo $doctor_data['phone']; ?>">
    <?php if(isset($errors['phone'])) echo "<span class='error'>{$errors['phone']}</span>"; ?>
    <br>
    <label>Address:</label>
    <input type="text" name="address" value="<?php echo $doctor_data['address']; ?>"><br>
    <input type="submit" value="Update Doctor">
</form>
        <?php else: ?>
            <p>Doctor not found.</p>
        <?php endif; ?>
    </div>
    <?php include("../../includes/footer.php"); ?>
</body>
</html>


<!-- HTML form for editing doctor details -->

<style>
    .error {
        color: #ff6666; /* Light red */
    }
</style>
