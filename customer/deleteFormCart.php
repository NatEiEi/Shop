<?php
    require_once __DIR__ . '/db.php'; 
    include_once __DIR__ . '/navbar.php';


    $ProductID = $_GET["ProductID"];
    $Username = $_GET["Username"];
    $query = "DELETE FROM Cart WHERE ProductID = '$ProductID' AND Username = '$Username'";
    $statement = $pdo->prepare($query);
    $statement->execute();

    echo "ลบสำเร็จเรียบร้อยแล้ว...";
    header("Location: Cart.php?Username=$Username");

?>
