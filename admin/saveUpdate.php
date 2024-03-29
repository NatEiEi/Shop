<?php
    require '../db.php'; 
    include __DIR__ . '/adminLogin.php';


    $ProductID = $_POST["ProductID"];
    $ProductName = $_POST["ProductName"];
    $PricePerUnit = $_POST["PricePerUnit"];
    $QtyStock = $_POST["QtyStock"];
    $Detail = $_POST["Detail"];


    $query =    "UPDATE Product SET ProductID = '$ProductID' , ProductName = '$ProductName' , 
                PricePerUnit = '$PricePerUnit', QtyStock = '$QtyStock', Detail = '$Detail'
                WHERE ProductID = '$ProductID'";
    $statement = $pdo->prepare($query);
    $statement->execute();
    echo "Updated Successfully...";
    
?>
