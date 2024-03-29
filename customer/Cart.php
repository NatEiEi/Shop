<?php
    require_once __DIR__ . '/db.php'; 
    include_once __DIR__ . '/navbar.php';

    if (isset($_GET['Username'])){
        $Username = $_GET['Username'];
        $query = "SELECT p.ProductID, p.ProductName, c.Username, c.Qty , PricePerUnit
                FROM product p 
                INNER JOIN cart c ON p.ProductID = c.ProductID 
                WHERE c.Username='$Username'";
        $statement = $pdo->prepare($query);
        $statement->execute();
        if($statement->rowCount() > 0) {
            $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    } else {
        if (isset($_SESSION['CartArray'])) {
            $array = $_SESSION['CartArray'];
            $products = array();
            foreach($array as $arr) {
                $query = "SELECT * FROM product WHERE ProductID='{$arr['ProductID']}'";
                $statement = $pdo->prepare($query);
                $statement->execute();
                if($statement->rowCount() > 0) {
                    $prod = $statement->fetchAll(PDO::FETCH_ASSOC);
                    $prod = $prod[0];
                    array_push($products, ["ProductID" => $arr['ProductID'] ,"ProductName" => $prod['ProductName'] 
                    ,"PricePerUnit" => $prod['PricePerUnit'],"Qty" => $arr['Qty']]);
                }
            }
        }
    }


    $totalPrice = 0;

?>


<head>
    <link rel="stylesheet" href="css/cart.css">
</head>
<body>
<div class="container">
    <h1>Shopping Cart</h1>
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
                <div class="price">Price : <?= $price ?> THB
                
                <br><a href='deleteFormCart.php?ProductID=<?= $product['ProductID'] ?>&Username=<?= $Username ?>'>delete</a>

                </div>
            </li>
            <?php endforeach; ?>
        <?php endif ?>
    </ul>


    <p class="price">Total Price :  <?= $totalPrice ?> THB</p>

    <form method="GET" action="Purchase.php">
        <input type="hidden" name="Username" value="<?= $Username ?>">
        <input type="hidden" name="BuyMethod" value="BuyFromCart">
        <input type="submit" class="btn_Purchase" value="Purchase">
    </form>
    
</div>

</body>
</html>
