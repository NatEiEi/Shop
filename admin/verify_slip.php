<?php
    require '../db.php'; 
    include __DIR__ . '/adminLogin.php';

    $OrderID = $_GET['OrderID'];

    $query =    "UPDATE `order` SET Status = 'Shipping'
            WHERE OrderID = '$OrderID'";

    $statement = $pdo->prepare($query);
    $statement->execute();
    echo "เข้าสู่กระบวนการขนส่ง";
?>

