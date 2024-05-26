<?php
session_start(); // Start the session to access session variables

include_once '../../config/database.php';
include_once '../../models/Patient.php';
include_once '../../models/Doctor.php';

// Initialize database connection
$database = new Database();
$connection = $database->getConnection();

// Initialize Patient and Doctor objects
$patient = new Patient($connection);
$doctor = new Doctor($connection);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_record'])) {
    // Get form data
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $description = $_POST['description'];

    // Validate doctor ID
    if (!$doctor->getDoctorById($doctor_id)) {
        echo "Error: Doctor ID does not exist.";
    } else {
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <link rel="stylesheet" href="../../assets/css/patient-view.css">
</head>
<body>
    <?php include("../../includes/header.php"); ?>
    <div class="container">
        <?php
        // Check if patient ID is provided in URL
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // Validate the ID
            if (!is_numeric($id)) {
                echo "Invalid patient ID.";
                exit;
            }

            // Get patient details by ID
            $patient_data = $patient->getPatientById($id);
            
            // Check if patient exists
            if ($patient_data && isset($patient_data['id'])) {
                // Display patient details
                echo "<div class='card'>";
                echo "<h2>" . htmlspecialchars($patient_data['name']) . "</h2>";
                echo "<p><strong>ID:</strong> " . htmlspecialchars($patient_data['id']) . "</p>";
                echo "<p><strong>Gender:</strong> " . htmlspecialchars($patient_data['gender']) . "</p>";
                echo "<p><strong>Date of Birth:</strong> " . htmlspecialchars($patient_data['date_of_birth']) . "</p>";
                echo "<p><strong>Email:</strong> " . htmlspecialchars($patient_data['email']) . "</p>";
                echo "<p><strong>Phone:</strong> " . htmlspecialchars($patient_data['phone']) . "</p>";
                echo "<p><strong>Address:</strong> " . htmlspecialchars($patient_data['address']) . "</p>";
                echo "</div>";

                // Search form
                echo "<div class='card'>";
                echo "<h2>Search Records</h2>";
                echo "<form method='get' action=''>";
                echo "<input type='hidden' name='id' value='" . htmlspecialchars($patient_data['id']) . "'>";
                echo "<label for='search_date'>Search by Date:</label>";
                echo "<input type='date' id='search_date' name='search_date'>";
                echo "<label for='search_doctor'>Search by Doctor:</label>";
                echo "<select id='search_doctor' name='search_doctor'>";
                echo "<option value=''>--Select Doctor--</option>";
                $doctors = $doctor->getAllDoctors();
                while ($doc = $doctors->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($doc['id']) . "'>" . htmlspecialchars($doc['name']) . "</option>";
                }
                echo "</select>";
                echo "<input type='submit' value='Search'>";
                echo "</form>";
                echo "</div>";

                // Patient Records
                echo "<div class='card'>";
                echo "<h2>Patient Records</h2>";
                $records = $patient->getPatientRecords($id, $_GET['search_date'] ?? '', $_GET['search_doctor'] ?? '');
                if ($records->num_rows > 0) {
                    while ($record = $records->fetch_assoc()) {
                        echo "<div class='record'>";
                        
                        if (isset($record['doctor_id'])) {
                            $doctor_id = $record['doctor_id'];
                            $doctor_name = $doctor->getDoctorNameById($doctor_id);
                            echo "<p><strong>Doctor Name:</strong> " . htmlspecialchars($doctor_name) . "</p>";
                            echo "<p><strong>Doctor ID:</strong> " . htmlspecialchars($doctor_id) . "</p>";
                        }
                        
                        if (isset($record['description'])) {
                            echo "<p><strong>Description:</strong> " . htmlspecialchars($record['description']) . "</p>";
                        }
                        
                        if (isset($record['record_id'])) {  // Updated to use record_id
                            echo "<a href='edit-record.php?id=" . htmlspecialchars($record['record_id']) . "' class='edit-link'>Edit</a>";
                            echo "<a href='delete-record.php?id=" . htmlspecialchars($record['record_id']) . "' class='delete-link' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>";
                        } else {
                            echo "<p class='error-message'>Error: Record ID is missing.</p>";
                        }

                        echo "</div>";
                    }
                } else {
                    echo "<p>No records found for this patient.</p>";
                }

                // Add Patient Record form
if (isset($_SESSION['role']) && $_SESSION['role'] == 'staff') {
    echo "<div class='card'>";
    echo "<h2>Add Patient Record</h2>";
    echo "<form method='post' action=''>";
    echo "<input type='hidden' name='patient_id' value='" . htmlspecialchars($patient_data['id']) . "'>";
    echo "<label for='doctor_id'>Doctor:</label>";
    echo "<select id='doctor_id' name='doctor_id' required>";
    
    // Reset internal pointer of $doctors
    mysqli_data_seek($doctors, 0);
    
    while ($doc = $doctors->fetch_assoc()) {
        echo "<option value='" . htmlspecialchars($doc['id']) . "'>" . htmlspecialchars($doc['name']) . "</option>";
    }
    echo "</select><br><br>";
    echo "<label for='description'>Description:</label><br>";
    echo "<textarea id='description' name='description' rows='4' cols='50' required></textarea><br><br>";
    echo "<input type='submit' name='add_record' value='Add Record'>";
    echo "</form>";
    echo "</div>";
}

            } else {
                echo "<p class='error-message'>Patient not found or invalid patient ID.</p>";
            }
        } else {
            echo "<p class='error-message'>Patient ID not provided.</p>";
        }
        ?>
    </div>
    
</body>
<?php include('../../includes/footer.php')?>
</html>
