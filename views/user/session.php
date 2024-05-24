<?php
session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user'){
        echo $_SESSION['role'];
        header("Location: /404.php");
        exit();
    }
?>