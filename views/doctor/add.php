
<?php
include_once '../../config/database.php';
include_once '../../models/Doctor.php';
include_once '../../config/db_config.php';


$database = new Database();
$connection = $database->getConnection();

// Initialize Doctor object
$doctor = new Doctor($connection);

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
        // header("Location: list.php");
    } else {
        echo "Error creating doctor.";
    }
}
?>

<!-- HTML form for adding a new doctor -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label>Name:</label>
    <input type="text" name="name" required><br>
    <label>Specialty:</label>
    <input type="text" name="specialty"><br>
    <label>Email:</label>
    <input type="email" name="email" required><br>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <label>Phone:</label>
    <input type="text" name="phone"><br>
    <label>Address:</label>
    <input type="text" name="address"><br>
    <input type="submit" value="Add Doctor">
</form>
