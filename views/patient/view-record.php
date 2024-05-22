<?php
// Include the database configuration file
include_once '../../config/database.php';

// Initialize database connection
$database = new Database();
$connection = $database->getConnection();

// Check if patient ID is provided in URL
if (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];

    // Prepare and execute the query to fetch patient records
    $sql = "SELECT * FROM record WHERE patient_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any records found
    if ($result->num_rows > 0) {
        echo "<h1>Records for Patient ID: " . $patient_id . "</h1>";
        echo "<div class='container'>";

        // Loop through and display the records
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card'>";
            echo "<h2>Record ID: " . $row['record_id'] . "</h2>";
            echo "<p><strong>Doctor ID:</strong> " . $row['doctor_id'] . "</p>";
            echo "<p><strong>Description:</strong> " . $row['description'] . "</p>";
            echo "</div>";
        }

        echo "</div>";
    } else {
        echo "No records found for Patient ID: " . $patient_id;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Patient ID not provided.";
}

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient Records</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
</body>
</html>
