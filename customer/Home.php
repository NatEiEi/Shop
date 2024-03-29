<?php
    require_once __DIR__ . '/db.php'; 
    include_once __DIR__ . '/navbar.php';
    
    $query = "SELECT * FROM Product;";
    $statement = $pdo->prepare($query);
    $statement->execute();
    if($statement->rowCount() > 0) {
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
?>




<head>
    <link rel="stylesheet" href="css/itemCard.css">
</head>
<body>
<center><h1>Shop Store</h1></center>
<div class="container">
    <?php if(isset($products)): ?>
        <?php foreach($products as $product): 
            $fileName = $product['ProductID'];
            $filePath = "../images/" . $fileName . ".jpg"; 


            if (file_exists($filePath)) {
            } else {
                $filePath = "../images/boss_Dog.jpg";
            }
        ?>  
            <a href="ProductDetail.php?ProductID=<?= $product['ProductID'] ?>" style="text-decoration: none; color: black;">
                <div class="card">
                    <img src="<?= $filePath ?>" style="width:100%; height:200px;">
                    <p class="PName"><?= $product['ProductName'] ?></p>
                    <p class="detail"><?= $product['Detail'] ?></p>
                    <p class="price">THB <?= $product['PricePerUnit'] ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif ?>
</div>
  

</body>
</html>
