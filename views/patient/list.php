<?php
include_once '../../config/database.php';
include_once '../../models/Patient.php';

$database = new Database();
$db = $database->getConnection();
$patient = new Patient($db);

$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$filter_age = isset($_GET['filter_age']) ? $_GET['filter_age'] : '';
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
    <link rel="stylesheet" href="../../assets/css/patients.css">
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
                    <a class = "btn" href="view.php?id=<?php echo htmlspecialchars($row['id']); ?>">View</a>
                    <a class = "btn" href="edit.php?id=<?php echo htmlspecialchars($row['id']); ?>">Edit</a>
                    <a class = "btn" href="delete.php?id=<?php echo htmlspecialchars($row['id']); ?>">Delete</a>
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
                        <option value="lt1">< 1</option>
                        <option value="1_5">1-5</option>
                        <option value="6_10">6-10</option>
                        <option value="11_15">11-15</option>
                        <option value="16_20">16-20</option>
                        <option value="21_25">21-25</option>
                        <option value="26_30">26-30</option>
                        <option value="31_35">31-35</option>
                        <option value="36_40">36-40</option>
                        <option value="41_45">41-45</option>
                        <option value="46_50">46-50</option>
                        <option value="51_55">51-55</option>
                        <option value="56_60">56-60</option>
                        <option value="61_65">61-65</option>
                        <option value="66_70">66-70</option>
                        <option value="71_75">71-75</option>
                        <option value="76_80">76-80</option>
                        <option value="81_85">81-85</option>
                        <option value="86_90">86-90</option>
                        <option value="91_95">91-95</option>
                        <option value="96_100">96-100</option>
                        <option value="gt100">> 100</option>
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
    <?php include('../../includes/footer.php')?>
</body>
</html>
