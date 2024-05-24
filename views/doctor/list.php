<?php
include_once '../../config/database.php';
include_once '../../models/Doctor.php';

// Initialize database connection
$database = new Database();
$connection = $database->getConnection();

// Initialize Doctor object
$doctor = new Doctor($connection);

// Fetch doctors based on search, filter, and sort criteria
$doctors = [];

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
        $doctors = $doctor->searchDoctorsByName($_GET['search_name']);
    } elseif (isset($_GET['filter_specialty']) && !empty($_GET['filter_specialty'])) {
        $doctors = $doctor->filterDoctorsBySpecialization($_GET['filter_specialty']);
    } elseif (isset($_GET['sort']) && $_GET['sort'] === "name") {
        $doctors = $doctor->sortDoctorsByName();
    } elseif (isset($_GET['sort']) && $_GET['sort'] === "specialty") {
        $doctors = $doctor->sortDoctorsBySpecialization();
    } else {
        $doctors = $doctor->getAllDoctors()->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../../assets/css/list.css"> -->
    <link rel="stylesheet" href="../../assets/css/doc-list.css">

    <title>Doctor List</title>
</head>
<body>
    <?php include("../../includes/header.php"); ?>
    <div class="container">
        
        <!-- Doctor Cards -->
        <div class="card-container">
            <?php if (!empty($doctors)): ?>
                <?php foreach ($doctors as $row) : ?>
                    <div class="card">
                        <h2><?php echo $row['name']; ?></h2>
                        <p>Email: <?php echo $row['email']; ?></p>
                        <p>Specialty: <?php echo $row['specialty']; ?></p>
                        <p>Phone: <?php echo $row['phone']; ?></p>
                        <p>Address: <?php echo $row['address']; ?></p>
                        <a href="view.php?id=<?php echo $row['id']; ?>">View</a>
                        <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this doctor?');">Delete</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No doctors found.</p>
            <?php endif; ?>
        </div>
        <aside>
        <div class="add">
                <button><a href="add.php">Add Doctor</a></button>
        </div>

        <!-- Add Doctor Button -->
        <div class="doc-container">

            <!-- Search Bar -->
            <form method="GET" action="">
                <input type="text" name="search_name" placeholder="Search by Name">
                <button type="submit">Search</button>
            </form>

        <!-- Filter by Specialization -->
            <form method="GET" action="">
                <select name="filter_specialty">
                    <option value="">Filter by Specialization</option>
                    <option value="Cardiology">Cardiology</option>
                    <option value="Dermatology">Dermatology</option>
                    <option value="Endocrinology">Endocrinology</option>
                    <option value="Gastroenterology">Gastroenterology</option>
                    <option value="Hematology">Hematology</option>
                    <option value="Nephrology">Nephrology</option>
                    <option value="Neurology">Neurology</option>
                    <option value="Oncology">Oncology</option>
                    <option value="Ophthalmology">Ophthalmology</option>
                    <option value="Orthopedics">Orthopedics</option>
                    <option value="Pediatrics">Pediatrics</option>
                    <option value="Psychiatry">Psychiatry</option>
                    <option value="Pulmonology">Pulmonology</option>
                    <option value="Radiology">Radiology</option>
                    <option value="Rheumatology">Rheumatology</option>
                    <option value="Urology">Urology</option>
                    <option value="Dentistry">Dentistry</option>
                    <option value="General Surgery">General Surgery</option>
                    <option value="Obstetrics and Gynecology">Obstetrics and Gynecology</option>
                    <option value="Otolaryngology (ENT)">Otolaryngology (ENT)</option>
                    <option value="Plastic Surgery">Plastic Surgery</option>
                    <option value="Anesthesiology">Anesthesiology</option>
                </select>
                <button type="submit">Filter</button>
            </form>

            <!-- Sorting -->
            <form method="GET" action="">
                <button type="submit" name="sort" value="name">Sort by Name</button>
                <br>
                <button type="submit" name="sort" value="specialty">Sort by Specialization</button>
            </form>
        </div>
        </aside>
    </div>
    <?php include("../../includes/footer.php"); ?>
</body>
</html>
