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
}
