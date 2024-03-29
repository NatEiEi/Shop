<?php
    require_once __DIR__ . '/db.php'; 
    include_once __DIR__ . '/navbar.php';


    $ProductID = $_GET["ProductID"];

    $query = "SELECT * FROM product WHERE ProductID='$ProductID'";
    $statement = $pdo->prepare($query);
    $statement->execute();
    if($statement->rowCount() > 0) {
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    $product = $products[0];

    if(isset($_POST["ProdID"])) {
        $ProdID = $_POST["ProdID"];
        $Qty = $_POST["Qty"];

        
        if(isset($_SESSION["Username"])) {
            $Username = $_SESSION["Username"];
            $existingQuery = "SELECT * FROM cart WHERE Username = '$Username' AND ProductID = '$ProductID'";
            $existingStatement = $pdo->prepare($existingQuery);
            $existingStatement->execute();
            $existingProduct = $existingStatement->fetch(PDO::FETCH_ASSOC);
        
            if ($existingProduct) {
                $newQuantity = $existingProduct['Qty'] + $Qty;
                $updateQuery = "UPDATE cart SET Qty = '$newQuantity' WHERE Username = '$Username' AND ProductID = '$ProductID'";
                $updateStatement = $pdo->prepare($updateQuery);
                $updateStatement->execute();
            } else {
                $insertQuery = "INSERT INTO cart(Username, ProductID, Qty) VALUES ('$Username', '$ProductID', '$Qty')";
                $insertStatement = $pdo->prepare($insertQuery);
                $insertStatement->execute();
        
            }
            echo "<script>alert('เพิ่มสินค้าลงในตะกร้าสำเร็จแล้ว');</script>";
        } else {
            if (isset($_SESSION['CartArray'])) {
                $CartArray = $_SESSION['CartArray'];
                array_push($CartArray, ["ProductID" => $ProdID,"Qty" => $qty]);
                $_SESSION['CartArray'] = $CartArray;
            } else {
                $CartArray = array(["ProductID" => $ProdID,"Qty" => $qty]);
                $_SESSION['CartArray']=$CartArray;
            }
            echo "<script>alert('เพิ่มสินค้าลงในตะกร้าสำเร็จแล้ว');</script>";
        }
    }

    if ($product['QtyStock'] > 0){
        $qty = $product['QtyStock'];
        $activeForm = 1;
    } else {
        $qty = 'สินค้าหมด';
        $activeForm = 0;
    }
?>


<head>
</head>
<body>

<div class="container">
    <?php 
        $fileName = $product['ProductID'];
        $filePath = "../images/" . $fileName . ".jpg"; 

        if (file_exists($filePath)) {
        } else {
            $filePath = "../images/boss_Dog.jpg";
        }
    ?>
    <center>
    <h1><?= $product['ProductName'] ?></h1>
    <img src="<?= $filePath ?>" style="width:30%; height:300px;">
    <p class="detail">Detail : <?= $product['Detail'] ?></p>
    <p class="price">Price / Unit : THB <?= $product['PricePerUnit'] ?></p>
    <p class="price">จำนวนสินค้าคงเหลือ : <?= $qty ?></p>
    

    <form method="POST" id="BuyForm" action="ProductDetail.php?ProductID=<?= $product['ProductID'] ?>">
        <input type="hidden" name="ProdID" value="<?= $product['ProductID'] ?>">
        <input type="number" id="Qty" name="Qty" min=1 max=<?= $product['QtyStock'] ?> value="1" >
        <input type="submit" value="AddToCart">
        <a href="Purchase.php?ProductID=<?= $product['ProductID'] ?>&BuyMethod=BuyNow" id="purchaseLink"><input type="button" value="Buy Now"></a>
    </form>


    </center>

    <script>
        function disableForm() {
            var form = document.getElementById("BuyForm");
            var elements = form.elements;
            for (var i = 0; i < elements.length; i++) {
                elements[i].disabled = true;
        }
        }
        if (<?= $activeForm ?> == 0){
            disableForm();
        }
        
        document.getElementById('purchaseLink').addEventListener('click', function(event) {
            // ดึงค่าจำนวนที่ผู้ใช้เลือก
            var qtyValue = document.getElementById('Qty').value;
            // เพิ่มค่าที่เลือกไว้ใน URL ของลิงก์
            this.href += '&Qty=' + encodeURIComponent(qtyValue);
        });

    </script>
</body>

