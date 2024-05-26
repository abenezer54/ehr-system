<?php
include_once '../../config/database.php';
include_once '../../models/Patient.php';
include_once '../../models/Validator.php';

$database = new Database();
$db = $database->getConnection();
$patient = new Patient($db);
$validator = new Validator();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $gender = $_POST['gender']; // This will be either 'male' or 'female'
    $date_of_birth = $_POST['date_of_birth'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $role = 'user';

    // Validate form inputs
    $errors = array();

    // Validate name
    if (!$validator->validateRequired($name)) {
        $errors['name'] = "Name is required.";
    }

    // Validate gender
    if (!$validator->validateRequired($gender)) {
        $errors['gender'] = "Gender is required.";
    }

    // Validate date of birth
    if (!$validator->validateRequired($date_of_birth)) {
        $errors['date_of_birth'] = "Date of birth is required.";
    } elseif (!$validator->validateDate($date_of_birth, 'Y-m-d')) {
        $errors['date_of_birth'] = "Invalid date format.";
    } elseif ($validator->validateFutureDate($date_of_birth)) {
        $errors['date_of_birth'] = "Date of birth cannot be in the future.";
    } elseif ($validator->validateDateRange($date_of_birth, 'Y-m-d', date('Y-m-d', strtotime('-300 years')), date('Y-m-d'))) {
        $errors['date_of_birth'] = "Date of birth should be within the last 300 years.";
    }

    // Validate email
    if (!$validator->validateRequired($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!$validator->validateEmail($email)) {
        $errors['email'] = "Invalid email format.";
    }

    // Validate password
    if (!$validator->validateRequired($password)) {
        $errors['password'] = "Password is required.";
    } // Add more password validation rules if needed

    // Validate phone
    if (!$validator->validateRequired($phone)) {
        $errors['phone'] = "Phone number is required.";
    } elseif (!$validator->validatePhoneNumber($phone)) {
        $errors['phone'] = "Invalid phone number format.";
    }

    // Validate address
    if (!$validator->validateRequired($address)) {
        $errors['address'] = "Address is required.";
    } // Add more address validation rules if needed

    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Start a transaction
        $db->begin_transaction();
        try {
            // Insert into users table
            $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("sss", $name, $hashed_password, $role);
            $stmt->execute();
            $stmt->close();

            // Insert into patients table
            if ($patient->createPatient($name, $gender, $date_of_birth, $email, $phone, $address)) {
                // Commit the transaction
                $db->commit();
                echo "Patient added successfully.";
                header("Location: list.php");
            } else {
                // Rollback the transaction
                $db->rollback();
                echo "Failed to add patient.";
            }
        } catch (Exception $e) {
            // Rollback the transaction in case of error
            $db->rollback();
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/add-patient.css">
</head>
<body>
    <?php include('../../includes/header.php')?>
    <h1>Add Patient</h1>
    <form method="post" action="add.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        
        <label>Gender:</label><br>
        <input type="radio" id="male" name="gender" value="male" required>
        <label for="male">Male</label><br>
        <input type="radio" id="female" name="gender" value="female" required>
        <label for="female">Female</label><br>
        
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" required><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        
        <label for="password">Password:</label>
        <input type="password" id= "password" name="password" required><br>"

        <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" required><br>
    
    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required><br>
    
    <button type="submit">Add Patient</button>
</form>
<?php include('../../includes/footer.php')?>
</body>
</html>
