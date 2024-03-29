<?php
    require_once __DIR__ . '/db.php'; 
    session_start();

    
    if (isset($_SESSION['Username'])) {
        date_default_timezone_set('Asia/Bangkok');
        $Username = $_SESSION['Username'];
        $query = "INSERT INTO log (Date, Username, Action) VALUES (NOW(), '$Username', 'Logout')";
        $statement = $pdo->prepare($query);
        $statement->execute();
    }
    

    unset($_SESSION['Username']);
    unset($_SESSION['FName']);
    unset($_SESSION['LName']);
    unset($_SESSION['CartArray']);
    session_destroy();
    header('Location: home.php');
?>