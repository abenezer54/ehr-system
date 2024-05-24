<?php
include_once '../../config/database.php';
include_once '../../models/Patient.php';

$database = new Database();
$db = $database->getConnection();
$patient = new Patient($db);

$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$filter_age = isset($_GET['filter_age']) ? $_GET['filter_age'] : '';
$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';

// Perform search, filter, and sort operations
if (!empty($search_query)) {
    $patients = $patient->searchPatients($search_query);
} elseif (!empty($filter_age)) {
    $patients = $patient->filterPatientsByAge($filter_age);
} elseif (!empty($filter_date)) {
    // Implement filter by diagnosis date if needed
} elseif (!empty($sort_by)) {
    if ($sort_by === 'name') {
        $patients = $patient->sortPatientsByName();
    } elseif ($sort_by === 'age') {
        $patients = $patient->sortPatientsByAge();
    } else {
        // Implement sorting by diagnosis date if needed
    }
} else {
    // Default: Get all patients
    $patients = $patient->getAllPatients();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Patients</title>
    <link rel="stylesheet" href="../../assets/css/list.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/Patientslist.css">

    <style>
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-top: 50px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            width: 100%;
        }

        .button-container button {
            margin-left: 10px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            width: 300px;
            padding: 20px;
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include("../../includes/header.php"); ?>
    
    <div class="container">
        <h1>Patients List</h1>
        <div class="form-container">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search by name, email, phone" value="<?php echo htmlspecialchars($search_query); ?>">
                <select name="filter_age">
                    <option value="">Filter by age</option>
                    <option value="lt10">1-10</option>
                    <option value="10_20">11-20</option>
                    <option value="21_30">21-30</option>
                    <option value="31_40">31-40</option>
                    <option value="41_50">41-50</option>
                    <option value="51_60">51-60</option>
                    <option value="gt70">>70</option>
                </select>
                <select name="sort_by">
                    <option value="">Sort by</option>
                    <option value="name" <?php if ($sort_by == 'name') echo 'selected'; ?>>Name</option>
                    <option value="age" <?php if ($sort_by == 'age') echo 'selected'; ?>>Age</option>
                </select>
                <button type="submit">Apply</button>
            </form>
        </div>
        <div class="button-container">
            <button><a href="add.php">Add Patient</a></button>
            <button><a href="list.php">View All Patients</a></button>
        </div>
        <div class="card-container">
            <?php foreach ($patients as $row): ?>
            <div class="card">
                <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                <p><strong>ID:</strong> <?php echo htmlspecialchars($row['id']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($row['gender']); ?></p>
                <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($row['date_of_birth']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></p>
                <a href="view.php?id=<?php echo htmlspecialchars($row['id']); ?>">View</a>
                <a href="edit.php?id=<?php echo htmlspecialchars($row['id']); ?>">Edit</a>
                <a href="delete.php?id=<?php echo htmlspecialchars($row['id']); ?>">Delete</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
