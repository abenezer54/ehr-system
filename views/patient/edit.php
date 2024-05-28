<?php
include_once '../../config/database.php';
include_once '../../models/Patient.php';

// Initialize database connection
$database = new Database();
$connection = $database->getConnection();

// Initialize Patient object
$patient = new Patient($connection);

// Error array to store validation errors
$errors = [];

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
            $name = trim($_POST['name']);
            $gender = $_POST['gender'];
            $date_of_birth = $_POST['date_of_birth'];
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);
            
            // Validate name
            if (empty($name)) {
                $errors['name'] = "Name is required.";
            } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
                $errors['name'] = "Only letters and white space allowed.";
            }

            // Validate gender
            if (empty($gender) || ($gender !== 'male' && $gender !== 'female')) {
                $errors['gender'] = "Valid gender is required.";
            }

            // Validate date of birth
            if (empty($date_of_birth)) {
                $errors['date_of_birth'] = "Date of birth is required.";
            } else {
                $currentDate = new DateTime();
                $date300YearsAgo = (new DateTime())->sub(new DateInterval('P300Y'));
                $dob = DateTime::createFromFormat('Y-m-d', $date_of_birth);
                if (!$dob || $dob < $date300YearsAgo || $dob > $currentDate) {
                    $errors['date_of_birth'] = "Date of birth should be within the last 300 years.";
                }
            }

            // Validate email
            if (empty($email)) {
                $errors['email'] = "Email is required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email format.";
            }

            // Validate phone
            if (empty($phone)) {
                $errors['phone'] = "Phone number is required.";
            } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
                $errors['phone'] = "Phone number must be 10 digits.";
            }

            // Validate address
            if (empty($address)) {
                $errors['address'] = "Address is required.";
            }

            // If no errors, update patient
            if (empty($errors)) {
                if ($patient->updatePatient($id, $name, $gender, $date_of_birth, $email, $phone, $address)) {
                    echo "Patient updated successfully.";
                    // Redirect to list page or any other page
                    header("Location: list.php");
                    exit;
                } else {
                    echo "Error updating patient.";
                }
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
    <link rel="stylesheet" href="../../assets/css/patient-edit.css">
</head>
<body>
    <?php include('../../includes/header.php'); ?>
    
    <div class="container">
        <h1>Edit Patient</h1>
        <?php if ($patient_data): ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($patient_data['name']); ?>" required>
            <?php if (isset($errors['name'])) echo "<p class='error-message'>{$errors['name']}</p>"; ?>
            
            <label>Gender:</label>
            <div class="gender-options">
                <input type="radio" id="male" name="gender" value="male" <?php echo ($patient_data['gender'] == 'male') ? 'checked' : ''; ?>>
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="female" <?php echo ($patient_data['gender'] == 'female') ? 'checked' : ''; ?>>
                <label for="female">Female</label>
            </div>
            <?php if (isset($errors['gender'])) echo "<p class='error-message'>{$errors['gender']}</p>"; ?>
            
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($patient_data['date_of_birth']); ?>" required>
            <?php if (isset($errors['date_of_birth'])) echo "<p class='error-message'>{$errors['date_of_birth']}</p>"; ?>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($patient_data['email']); ?>" required>
            <?php if (isset($errors['email'])) echo "<p class='error-message'>{$errors['email']}</p>"; ?>
            
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($patient_data['phone']); ?>" required>
            <?php if (isset($errors['phone'])) echo "<p class='error-message'>{$errors['phone']}</p>"; ?>
            
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($patient_data['address']); ?>" required>
            <?php if (isset($errors['address'])) echo "<p class='error-message'>{$errors['address']}</p>"; ?>
            
            <input type="submit" value="Update Patient">
        </form>
        <?php else: ?>
        <p class="error-message">Patient not found.</p>
        <?php endif; ?>
    </div>

    <?php include('../../includes/footer.php'); ?>
</body>
</html>
