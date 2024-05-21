<?php
include_once '../../config/database.php';
include_once '../../models/Patient.php';

$database = new Database();
$db = $database->getConnection();
$patient = new Patient($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if ($patient->createPatient($name, $gender, $date_of_birth, $email, $phone, $address)) {
        echo "Patient added successfully.";
    } else {
        echo "Failed to add patient.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h1>Add Patient</h1>
    <form method="post" action="add.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="gender">Gender:</label>
        <input type="text" id="gender" name="gender" required><br>
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br>
        <button type="submit">Add Patient</button>
    </form>
</body>
</html>
