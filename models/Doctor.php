<?php
include_once __DIR__ . '/../config/database.php';
class Doctor {
    // Database connection
    private $connection;

    // Constructor with database connection
    public function __construct($connection) {
        $database = new Database();
        $this->connection = $connection;
    }

    // Create new doctor
    public function createDoctor($name, $specialty, $email, $phone, $address) {
        $sql = "INSERT INTO doctor (name, specialty, email, phone, address) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssss", $name, $specialty, $email, $phone, $address);
        return $stmt->execute();
    }

    // Read all doctors
    public function getAllDoctors() {
        $sql = "SELECT * FROM doctor";
        $result = $this->connection->query($sql);
        return $result;
    }

    // Read doctor by ID
    public function getDoctorById($id) {
        $sql = "SELECT id FROM doctor WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['id'] ?? null; // Return the ID or null if not found
    }
    public function getDoctorNameById($id) {
        $sql = "SELECT name FROM doctor WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['name'] ?? null; // Return the name or null if not found
    }
    
    

    // Update doctor
    public function updateDoctor($id, $name, $specialty, $email, $phone, $address) {
        $sql = "UPDATE doctor SET name = ?, specialty = ?, email = ?, phone = ?, address = ? WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssssi", $name, $specialty, $email, $phone, $address, $id);
        return $stmt->execute();
    }

    // Delete doctor
    public function deleteDoctor($id) {
        $sql = "DELETE FROM doctor WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
