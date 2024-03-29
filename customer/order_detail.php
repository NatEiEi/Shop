<?php 
    require_once __DIR__ . '/db.php'; 
    include_once __DIR__ . '/navbar.php';
  
    $OrderID = $_GET['OrderID'];
    $OrderQuery = "SELECT * FROM `order` WHERE OrderID = '$OrderID'";
    $statement = $pdo->prepare($OrderQuery);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $orders = $statement->fetchAll(PDO::FETCH_ASSOC);
        $orderInfo = $orders[0];
    }
    
    $AddressQuery = "SELECT Name , Country , Province , Postal , Type
                    FROM address a, addresslist al
                    WHERE a.AddressID = al.AddressID AND al.OrderID = '$OrderID'";
    $statement = $pdo->prepare($AddressQuery);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $addressLists = $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    $ProductQuery = "SELECT p.ProductID , ProductName , pl.Qty , PricePerUnit 
                    FROM product p, productlist pl
                    WHERE p.ProductID = pl.ProductID AND pl.OrderID = '$OrderID'";
    $statement = $pdo->prepare($ProductQuery);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    //customer and invoice details
    $infoBuy = [];
    $infoBill = [];
    $infoShip = [];

    foreach ($addressLists as $row) {
        if($row['Type'] == "Buy") {
            $infoBuy =[
                "Name" => $row['Name'],
                "Province" => $row['Province'], 
                "Country" => $row['Country'], 
                "Postal" => $row['Postal']
            ];
        }
        
        if($row['Type'] == "Bill"){
            $infoBill = [
                "Name" => $row['Name'],
                "Province" => $row['Province'], 
                "Country" => $row['Country'], 
                "Postal" => $row['Postal']
            ];
        }
        if($row['Type'] == "Ship"){
            $infoShip = [
                "Name" => $row['Name'],
                "Province" => $row['Province'], 
                "Country" => $row['Country'], 
                "Postal" => $row['Postal']
            ];
        }
    }
    $totalPrice = 0;

?>



<head>
    <link rel="stylesheet" href="css/cart.css">
</head>
<body>
<div class="container">
    <h1>Order Detail</h1>
    <ul>
        <p>Order Status : <?= $orderInfo['Status']?></p>
        <p>Date : <?= $orderInfo['Date']?></p>
    </ul>
    <ul>
        <?php if(isset($products)): ?>
            <?php foreach($products as $product): 
                $fileName = $product['ProductID'];
                $filePath = "../images/" . $fileName . ".jpg"; 


                if (file_exists($filePath)) {
                } else {
                    $filePath = "../images/boss_Dog.jpg";
                }
                $price = $product['PricePerUnit'] * $product['Qty'];
                $totalPrice = $totalPrice + $price;
        ?>  
            <li class="item">
                <img src="<?= $filePath ?>" alt="Product Image">
                <div class="name"><?= $product['ProductName'] ?></div>
                <div class="qty">Quantity : <?= $product['Qty'] ?></div>
                <div class="price">Price : <?= $price ?> THB</div>
            </li>
            <?php endforeach; ?>
        <?php endif ?>
    </ul>


    <p class="price">Total Price :  <?= $totalPrice ?> THB</p>
    
    <!-- <p>ประเภทการชำระเงิน : <?= $Payment ?></p> -->
    

    <p>ที่อยู่ผู้ซื้อ</p>
    <p>ชื่อผู้ซื้อ : <?= $infoBuy["Name"] ?> จังหวัด : <?= $infoBuy["Province"] ?> ประเทศ : <?= $infoBuy["Country"] ?> รหัสไปรณีษ์ : <?= $infoBuy["Postal"] ?></p>
    
    <p>ที่อยู่ออกบิล</p>
    <p>ชื่อ : <?= $infoBill["Name"] ?> จังหวัด : <?= $infoBill["Province"] ?> ประเทศ : <?= $infoBill["Country"] ?> รหัสไปรณีษ์ : <?= $infoBill["Postal"] ?></p>
    
    <p>ที่อยู่จัดส่ง</p>
    <p>ชื่อ : <?= $infoShip["Name"] ?> จังหวัด : <?= $infoShip["Province"] ?> ประเทศ : <?= $infoShip["Country"] ?> รหัสไปรณีษ์ : <?= $infoShip["Postal"] ?></p>
    
    <?php if($orderInfo['Status'] == "Waiting For Payment"): ?>
        <a href="transfer_slip.php?OrderID=<?= $OrderID ?>"><input type="button" class="btn_Purchase" value="Transfer slip"></a>
        <br><br>
        <a href="order_cancel.php"><input type="button" class="btn_Purchase" value="Cancel Order"></a>
    <?php endif ?>
    
    <hr>
    <a href="E-receipt.php?OrderID=<?= $OrderID ?>"><input type="button" class="btn_Purchase" value="Print E-receipt"></a>
</body>
