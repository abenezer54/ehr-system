<?php
session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'staff'){
        echo $_SESSION['role'];
        header("Location: /404.php");
        exit();
    }
?>