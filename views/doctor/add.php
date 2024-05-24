<?php
include_once '../../config/database.php';
include_once '../../models/Doctor.php';
include_once '../../config/db_config.php';
include_once '../../models/Validator.php'; // Include the Validator class

$database = new Database();
$connection = $database->getConnection();

// Initialize Doctor object
$doctor = new Doctor($connection);

$validator = new Validator(); // Instantiate the Validator class

$errors = []; // Array to store validation errors

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $role = 'staff';

    // Validate form inputs
    if (!$validator->validateRequired($name)) {
        $errors['name'] = "Name is required.";
    }

    if (!$validator->validateRequired($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!$validator->validateEmail($email)) {
        $errors['email'] = "Invalid email format.";
    }

    if (!$validator->validateRequired($password)) {
        $errors['password'] = "Password is required.";
    } elseif (!$validator->validateStringLength($password, 8)) {
        $errors['password'] = "Password must be at least 8 characters long.";
    }

    // If there are no validation errors, proceed with insertion
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sss", $name, $hashed_password, $role);
        $stmt->execute();
        $stmt->close();

        // Create new doctor
        if ($doctor->createDoctor($name, $specialty, $email, $phone, $address)) {
            echo "Doctor created successfully.";
            // Redirect to list page or any other page
             header("Location: list.php");
        } else {
            echo "Error creating doctor.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>

    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/add.css">
</head>
<body>
  
<?php include('../../includes/header.php')?>

<form class="add-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label>Name:</label>
    <input type="text" name="name" required>
    <?php if(isset($errors['name'])) echo "<span class='error'>{$errors['name']}</span>"; ?>
    <br>
    <label>Specialty:</label>
    <input type="text" name="specialty"><br>
    <label>Email:</label>
    <input type="email" name="email" required>
    <?php if(isset($errors['email'])) echo "<span class='error'>{$errors['email']}</span>"; ?>
    <br>
    <label>Password:</label>
    <input type="password" name="password" required>
    <?php if(isset($errors['password'])) echo "<span class='error'>{$errors['password']}</span>"; ?>
    <br>
    <label>Phone:</label>
    <input type="text" name="phone"><br>
    <label>Address:</label>
    <input type="text" name="address"><br>
    <input type="submit" value="Add Doctor">
</form>
<?php include('../../includes/footer.php')?>
</body>
</html>
