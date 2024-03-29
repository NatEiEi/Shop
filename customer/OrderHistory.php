<?php
    require_once __DIR__ . '/db.php'; 
    include_once __DIR__ . '/navbar.php';

    $Username = $_GET['Username'];
    $query = "SELECT * FROM `order` WHERE Username='$Username'";

    $statement = $pdo->prepare($query);
    $statement->execute();
    if($statement->rowCount() > 0) {
        $orders = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
?>


<head>
    <link rel="stylesheet" href="css/cart.css">
</head>
<body>
<div class="container">
    <h1>Order History</h1>
    <ul>
        <?php if(isset($orders)): ?>
            <?php foreach($orders as $order): ?>  
            <li class="item">
                <div class="name"><?= $order['OrderID'] ?></div>
                <div class="qty">Date : <?= $order['Date'] ?></div>
                <div class="price">Status : <?= $order['Status'] ?><br>
                <a href="order_detail.php?OrderID=<?= $order['OrderID'] ?>">See More</a></div>
            </li>
            <?php endforeach; ?>
        <?php endif ?>
    </ul>

</div>

</body>
</html>
