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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .all {
            display: flex;
        }
        .container {
            flex: 3;
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .card-container {
            display: flex;
            width: 70%;
            flex-direction: column;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card h2 {
            margin: 0 0 10px;
            font-size: 24px;
        }
        .card p {
            margin: 5px 0;
        }
        .card a {
            display: inline-block;
            margin: 10px 5px 0 0;
            text-decoration: none;
            color: #007bff;
        }
        .side {
            flex: 1;
            padding: 20px;
            background-color: #f0f0f0;
            border-left: 1px solid #ccc;
        }
        .button-container {
            margin-bottom: 20px;
        }
        .button-container button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: left;
        }
        .button-container button a {
            color: white;
            text-decoration: none;
            display: block;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .form-container input, .form-container select, .form-container button {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include("../../includes/header.php"); ?>
    <div class="all">
        <div class="container">
            <div class="card-container">
                <h1>Patients List</h1>
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
        <div class="side">
            <div class="button-container">
                <button><a href="add.php">Add Patient</a></button>
                <button><a href="list.php">View All Patients</a></button>
            </div>
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
        </div>
    </div>
</body>
</html>
