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
    
    public function getIdByName($username) {
        $sql = "SELECT id FROM patient WHERE name = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['id'] ?? null; // Return the name or null if not found
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
            case 'lt1':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) < 1";
                break;
            case '1_5':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 1 AND 5";
                break;
            case '6_10':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 6 AND 10";
                break;
            case '11_15':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 11 AND 15";
                break;
            case '16_20':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 16 AND 20";
                break;
            case '21_25':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 21 AND 25";
                break;
            case '26_30':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 26 AND 30";
                break;
            case '31_35':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 31 AND 35";
                break;
            case '36_40':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 36 AND 40";
                break;
            case '41_45':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 41 AND 45";
                break;
            case '46_50':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 46 AND 50";
                break;
            case '51_55':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 51 AND 55";
                break;
            case '56_60':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 56 AND 60";
                break;
            case '61_65':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 61 AND 65";
                break;
            case '66_70':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 66 AND 70";
                break;
            case '71_75':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 71 AND 75";
                break;
            case '76_80':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 76 AND 80";
                break;
            case '81_85':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 81 AND 85";
                break;
            case '86_90':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 86 AND 90";
                break;
            case '91_95':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 91 AND 95";
                break;
            case '96_100':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 96 AND 100";
                break;
            case 'gt100':
                $sql = "SELECT * FROM patient WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) > 100";
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

// Method to fetch patient records
public function getPatientRecords($patient_id, $date = '', $doctor_id = '') {
    $query = "SELECT * FROM record WHERE patient_id = ?";
    $params = [$patient_id];
    $types = "i";

    if ($date) {
        $query .= " AND DATE(created_at) = ?";
        $params[] = $date;
        $types .= "s";
    }

    if ($doctor_id) {
        $query .= " AND doctor_id = ?";
        $params[] = $doctor_id;
        $types .= "i";
    }

    $stmt = $this->connection->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt->get_result();
}

}
