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

    // Read patient by ID
    public function getPatientById($id) {
        $sql = "SELECT * FROM patient WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Update patient
    public function updatePatient($id, $name, $gender, $date_of_birth, $email, $phone, $address) {
        $sql = "UPDATE patient SET name = ?, gender = ?, date_of_birth = ?, email = ?, phone = ?, address = ? WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssssssi", $name, $gender, $date_of_birth, $email, $phone, $address, $id);
        return $stmt->execute();
    }

    // Delete patient
    public function deletePatient($id) {
        $sql = "DELETE FROM patient WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
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
}
