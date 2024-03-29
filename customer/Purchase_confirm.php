<?php
    require_once __DIR__ . '/db.php'; 
    include_once __DIR__ . '/navbar.php';

    $products = $_SESSION['ProductBuyList'];
    $totalPrice = 0;

    if (isset($_GET['Payment'] , $_GET['AddressBilling'] , $_GET['AddressShipping'] , $_GET['AddressBuy'])) {
        $AddressBuy = $_GET['AddressBuy'];
        $AddressBilling = $_GET['AddressBilling'];
        $AddressShipping = $_GET['AddressShipping'];
        $Username = $_GET['Username'];
        $Payment = $_GET['Payment'];

        $infoBuy = [];
        $infoBill = [];
        $infoShip = [];

        // AddressList Buying Address
        if ($AddressBuy == 'addAddressBuy') {
            $infoBuy =[
                "Name" => $_GET['addBuy_Name'],
                "Province" =>  $_GET['addBuy_Country'], 
                "Country" => $_GET['addBuy_Province'], 
                "Postal" => $_GET['addBuy_Postol']
            ];
        } else {
            $query = "SELECT * FROM address WHERE AddressID='$AddressBuy'";
            $statement = $pdo->prepare($query);
            $statement->execute();
            if($statement->rowCount() > 0) {
                $addresslist = $statement->fetchAll(PDO::FETCH_ASSOC);
                $infoBuy = $addresslist[0];
            }
        }

        // AddressList Billing Address
        if ($AddressBilling == 'addAddressBill') {
            $infoBill =[
                "Name" => $_GET['addBill_Name'],
                "Province" =>  $_GET['addBill_Country'], 
                "Country" => $_GET['addBill_Province'], 
                "Postal" => $_GET['addBill_Postol']
            ];
        }
        
        // AddressList Shipping Address
        if ($AddressShipping == 'addAddressShip') {
            $infoShip =[
                "Name" => $_GET['addShip_Name'],
                "Province" =>  $_GET['addShip_Country'], 
                "Country" => $_GET['addShip_Province'], 
                "Postal" => $_GET['addShip_Postol']
            ];
        }



        // ในกรณีที่อยู่ Bill ที่เลือกเหมือนซื้อหรือที่อยู่ส่ง
        if ($AddressBilling == 'sameBill_Buy') {
            $infoBill = $infoBuy;
        } else if ($AddressBilling == 'sameBill_Ship') {
            $infoBill = $infoShip;
        } else {
            $query = "SELECT * FROM address WHERE AddressID='$AddressBilling'";
            $statement = $pdo->prepare($query);
            $statement->execute();
            if($statement->rowCount() > 0) {
                $addresslist = $statement->fetchAll(PDO::FETCH_ASSOC);
                $infoBill = $addresslist[0];
            }
        }


        // ในกรณีที่อยู่ส่ง ที่เลือกเหมือนซื้อหรือที่บิล
        if ($AddressShipping == 'sameShip_Buy') {
            $infoShip = $infoBuy;
        } else if ($AddressShipping == 'sameShip_Bill') {
            $infoShip = $infoBill;
        } else {
            $query = "SELECT * FROM address WHERE AddressID='$AddressShipping'";
            $statement = $pdo->prepare($query);
            $statement->execute();
            if($statement->rowCount() > 0) {
                $addresslist = $statement->fetchAll(PDO::FETCH_ASSOC);
                $infoShip = $addresslist[0];
            }
        }
    }
?>


<head>
    <link rel="stylesheet" href="css/cart.css">
</head>
<body>
<div class="container">
    <h1>Payment</h1>
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
                <div class="price">Price : <?= $price ?> THB<br>delete</div>
            </li>
            <?php endforeach; ?>
        <?php endif ?>
    </ul>


    <p class="price">Total Price :  <?= $totalPrice ?> THB</p>

    <p>ประเภทการชำระเงิน : <?= $Payment ?></p>
    

    <p>ที่อยู่ผู้ซื้อ</p>
    <p>ชื่อผู้ซื้อ : <?= $infoBuy["Name"] ?> จังหวัด : <?= $infoBuy["Province"] ?> ประเทศ : <?= $infoBuy["Country"] ?> รหัสไปรณีษ์ : <?= $infoBuy["Postal"] ?></p>
    
    <p>ที่อยู่ออกบิล</p>
    <p>ชื่อ : <?= $infoBill["Name"] ?> จังหวัด : <?= $infoBill["Province"] ?> ประเทศ : <?= $infoBill["Country"] ?> รหัสไปรณีษ์ : <?= $infoBill["Postal"] ?></p>
    
    <p>ที่อยู่จัดส่ง</p>
    <p>ชื่อ : <?= $infoShip["Name"] ?> จังหวัด : <?= $infoShip["Province"] ?> ประเทศ : <?= $infoShip["Country"] ?> รหัสไปรณีษ์ : <?= $infoShip["Postal"] ?></p>
    
    <form method="GET" action="SaveOrder.php">
    <br><hr><br>
        <input type="hidden" name="Username" value="<?= $_GET['Username'] ?>">
        <input type="hidden" name="Payment" value="<?= $_GET['Payment'] ?>">
        <input type="hidden" name="AddressBuy" value="<?= $_GET['AddressBuy'] ?>">
        <input type="hidden" name="addBuy_Name" value="<?= $infoBuy["Name"] ?>">
        <input type="hidden" name="addBuy_Country" value="<?= $infoBuy["Province"] ?>">
        <input type="hidden" name="addBuy_Province" value="<?= $infoBuy["Country"] ?>">
        <input type="hidden" name="addBuy_Postol" value="<?= $infoBuy["Postal"] ?>">

        <input type="hidden" name="AddressBilling" value="<?= $_GET['AddressBilling'] ?>">
        <input type="hidden" name="addBill_Name" value="<?= $infoBill["Name"] ?>">
        <input type="hidden" name="addBill_Country" value="<?= $infoBill["Province"] ?>">
        <input type="hidden" name="addBill_Province" value="<?= $infoBill["Country"] ?>">
        <input type="hidden" name="addBill_Postol" value="<?= $infoBill["Postal"] ?>">

        <input type="hidden" name="AddressShipping" value="<?= $_GET['AddressShipping'] ?>">
        <input type="hidden" name="addShip_Name" value="<?= $infoShip["Name"] ?>">
        <input type="hidden" name="addShip_Country" value="<?= $infoShip["Province"] ?>">
        <input type="hidden" name="addShip_Province" value="<?= $infoShip["Country"] ?>">
        <input type="hidden" name="addShip_Postol" value="<?= $infoShip["Postal"] ?>">
        <input type="hidden" name="BuyMethod" value="<?= $_GET['BuyMethod'] ?>">
        <input type="submit" class="btn_Purchase" value="Confirm Payment">
        <a href="Purchase_cancel.php"><input type="button" class="btn_Purchase" value="Cancel"></a>
    </form>
    
</div>

</body>
</html>
