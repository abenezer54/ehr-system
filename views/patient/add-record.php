<?php
// Include the database configuration file
include_once '../../config/database.php';

// Initialize database connection
$database = new Database();
$connection = $database->getConnection();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $description = $_POST['description'];

    // Insert data into record table
    $sql = "INSERT INTO record (patient_id, doctor_id, description) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iis", $patient_id, $doctor_id, $description);

    if ($stmt->execute()) {
        echo "Record added successfully.";
    } else {
        echo "Error adding record: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Record</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h1>Add Record</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="patient_id">Patient ID:</label>
        <input type="number" id="patient_id" name="patient_id" required><br><br>
        
        <label for="doctor_id">Doctor ID:</label>
        <input type="number" id="doctor_id" name="doctor_id" required><br><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>
        
        <input type="submit" value="Add Record">
    </form>
</body>
</html>
