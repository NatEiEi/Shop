<?php
    require '../db.php'; 
    session_start();

    
    // if (isset($_SESSION['CustID'])) {
    //     date_default_timezone_set('Asia/Bangkok');
    //     $CustID = $_SESSION['CustID'];
    //     $query = "INSERT INTO log (Date, CustID, Action) VALUES (NOW(), '$CustID', 'Logout')";
    //     $statement = $pdo->prepare($query);
    //     $statement->execute();
    // }
    
    unset($_SESSION['EmployeeID']);
    unset($_SESSION['FName']);
    unset($_SESSION['LName']);
    unset($_SESSION['Role']);
    session_destroy();
    header('Location: selectProduct.php');
?>