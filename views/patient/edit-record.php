<?php
include_once '../../config/database.php';
include_once '../../models/Doctor.php';

$database = new Database();
$connection = $database->getConnection();
$doctor = new Doctor($connection);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $record_id = $_POST['record_id'];
    $doctor_id = $_POST['doctor_id'];
    $description = $_POST['description'];

    // Validate doctor ID
    if (!$doctor->getDoctorById($doctor_id)) {
        echo "Error: Doctor ID does not exist.";
    } else {
        // Update record in the database
        $sql = "UPDATE record SET doctor_id = ?, description = ? WHERE record_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("isi", $doctor_id, $description, $record_id);

        if ($stmt->execute()) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
} elseif (isset($_GET['id'])) {
    $record_id = $_GET['id'];

    // Fetch record details
    $sql = "SELECT * FROM record WHERE record_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $record_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $record = $result->fetch_assoc();
    $stmt->close();

    if (!$record) {
        echo "Record not found.";
        exit;
    }

    // Fetch list of doctors
    $doctors = $doctor->getAllDoctors();
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h1>Edit Record</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="record_id" value="<?php echo htmlspecialchars($record['record_id']); ?>">
        <label for="doctor_id">Doctor:</label>
        <select id="doctor_id" name="doctor_id" required>
            <?php
            while ($doc = $doctors->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($doc['id']) . "' " . ($doc['id'] == $record['doctor_id'] ? 'selected' : '') . ">" . htmlspecialchars($doc['name']) . "</option>";
            }
            ?>
        </select><br><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required><?php echo htmlspecialchars($record['description']); ?></textarea><br><br>
        
        <input type="submit" value="Update Record">
    </form>
</body>
</html>
