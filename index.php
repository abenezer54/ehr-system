<?php
session_start();
include 'config/db_config.php';

$error = "";
if (isset($_SESSION['role'])){
    switch ($_SESSION['role']) {
        case "admin":
            header("Location: views/doctor/view.php");
            break;
        case "user":
            header("Location: views/user/view.php");
            break;
        case "staff":
            header("Location: views/patient/view.php");
            break;
        default:
            break;
    }
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
    $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $hashed_password, $role);
            $stmt->fetch();
            
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;

                // Redirect based on user role
                switch ($role) {
                    case "admin":
                        header("Location: views/doctor/list.php");
                        break;
                    case "user":
                        header("Location: views/user/view.php");
                        break;
                    case "staff":
                        header("Location: views/patient/list.php");
                        break;
                    default:
                        break;
                }
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No user found with that username.";
        }
        
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EHR System</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/header.css">
</head>
<body>
    <?php include("includes/header.php"); ?>
    <div class="container">
        <h2>Login</h2>
        <?php
        if (!empty($error)) {
            echo "<p style='color:red;'>$error</p>";
        }
        ?>
        <p id="error" style="color:red;"></p>
        <form method="POST" action="index.php" onsubmit="return validateForm()">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>
    </div>

    <?php include("includes/footer.php"); ?>
    <script src="assets/js/header.js"></script>
    <script>
        function validateForm() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorElement = document.getElementById('error');

            if (username === '' || password === '') {
                errorElement.textContent = 'Both username and password are required.';
                return false;
            }

            // Basic validation passed, clear error message
            errorElement.textContent = '';
            return true;
        }
    </script>
</body>
</html>
