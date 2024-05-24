<?php
include_once __DIR__ . '/../config/database.php';

class Patient {
    // Database connection
    private $connection;

    // Constructor with database connection
    public function __construct($connection) {
        $database = new Database();
        $this->connection = $connection;
    }

    private $table_name = "patient";

    public function getPatientById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function deletePatient($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Create new patient
    public function createPatient($name, $gender, $date_of_birth, $email, $phone, $address) {
        $sql = "INSERT INTO patient (name, gender, date_of_birth, email, phone, address) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssssss", $name, $gender, $date_of_birth, $email, $phone, $address);
        return $stmt->execute();
    }

    // Read all patients
    public function getAllPatients() {
        $sql = "SELECT * FROM patient";
        $result = $this->connection->query($sql);
        return $result;
    }

    // Update patient
    public function updatePatient($id, $name, $gender, $date_of_birth, $email, $phone, $address) {
        $sql = "UPDATE patient SET name = ?, gender = ?, date_of_birth = ?, email = ?, phone = ?, address = ? WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssssssi", $name, $gender, $date_of_birth, $email, $phone, $address, $id);
        return $stmt->execute();
    }

    // Delete patient
    public function getPatientRecords($patient_id) {
        $sql = "SELECT * FROM record WHERE patient_id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function searchPatients($query) {
        $sql = "SELECT * FROM patient WHERE name LIKE ? OR email LIKE ? OR phone LIKE ?";
        $stmt = $this->connection->prepare($sql);
        $search_term = "%" . $query . "%";
        $stmt->bind_param("sss", $search_term, $search_term, $search_term);
        $stmt->execute();
        $result = $stmt->get_result();
        $patients = [];
        while ($row = $result->fetch_assoc()) {
            $patients[] = $row;
        }
        return $patients;
    }

    // Filter patients by age
    public function filterPatientsByAge($age) {
        switch ($age) {
            case 'lt10':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) < 10";
                break;
            case '10_20':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 10 AND 20";
                break;
            case '21_30':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 21 AND 30";
                break;
            case '31_40':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 31 AND 40";
                break;
            case '41_50':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 41 AND 50";
                break;
            case '51_60':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 51 AND 60";
                break;
            // Add more cases as needed
            case 'gt70':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) > 70";
                break;
            default:
                $sql = "SELECT * FROM patient";
                break;
        }
        $result = $this->connection->query($sql);
        return $result;
    }
    
    // Sort patients by name
public function sortPatientsByName() {
    $sql = "SELECT * FROM patient ORDER BY name";
    $result = $this->connection->query($sql);
    return $result;
}

// Sort patients by age
public function sortPatientsByAge() {
    $sql = "SELECT * FROM patient ORDER BY TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE())";
    $result = $this->connection->query($sql);
    return $result;
}

}
