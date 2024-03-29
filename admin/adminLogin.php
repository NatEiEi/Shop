<?php
    require '../db.php'; 

    session_start();

    if(isset($_SESSION['EmployeeID'])) {
        include __DIR__ . '/adminNavbar.php';
    }else {
        header('Location: adminAuthen.php');
    }

?>

