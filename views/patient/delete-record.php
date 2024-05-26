<?php
include_once '../../config/database.php';

$database = new Database();
$connection = $database->getConnection();

$message = "";
$class = "";

if (isset($_GET['id'])) {
    $record_id = $_GET['id'];

    // Delete record from the database
    $sql = "DELETE FROM record WHERE record_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $record_id);

    if ($stmt->execute()) {
        $message = "Record deleted successfully.";
        $class = "success";
    } else {
        $message = "Error deleting record: " . $stmt->error;
        $class = "error";
    }

    // Close the statement
    $stmt->close();
} else {
    $message = "Invalid request.";
    $class = "error";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Record</title>
    <link rel="stylesheet" href="../../assets/css/delete-record.css">
</head>
<body>
    <div class="container">
        <p class="message <?php echo $class; ?>"><?php echo $message; ?></p>
        <button onclick="window.location.href='list.php'">Go Back</button>
    </div>
</body>
</html>
