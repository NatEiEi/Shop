<?php
    require '../db.php'; 
    include __DIR__ . '/adminLogin.php';


    $OrderID = $_GET["OrderID"];
    
    $query =    "UPDATE `Order` SET Status = 'Canceled'
                WHERE OrderID = '$OrderID'";
    $statement = $pdo->prepare($query);
    $statement->execute();
    echo "Calcel Order : " . $OrderID . " Successfully...";
?>
