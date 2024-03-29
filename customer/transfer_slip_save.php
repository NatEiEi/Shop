<?php
    require_once __DIR__ . '/db.php'; 
    include_once __DIR__ . '/navbar.php';

    $OrderID = $_POST['OrderID'];
    if (isset($_POST["Name"])) {
        $Name = $_POST["Name"];

        // $query = "INSERT INTO Product(ProductID, ProductName, PricePerUnit, Cost, QtyStock , Detail) VALUES('$ProductID','$ProductName', '$Cost', '$PricePerUnit', '$QtyStock' , '$Detail')";
        // $statement = $pdo->prepare($query);
        // $statement->execute();

        if(isset($_FILES['imageUpload'])) {
            $file_name = $_FILES['imageUpload']['name'];
            $file_tmp = $_FILES['imageUpload']['tmp_name'];

            $newName = $OrderID . "." . "jpg";

            move_uploaded_file($file_tmp,"../images/slip/".$newName);
            $query =    "UPDATE `order` SET Status = 'Waiting For Verification'
                        WHERE OrderID = '$OrderID'";

            $statement = $pdo->prepare($query);
            $statement->execute();
            echo "Insert Product Successfully...";
        }
        
    }
?>