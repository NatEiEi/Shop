<?php
    require '../db.php'; 
    include __DIR__ . '/adminLogin.php';

    if (isset($_GET["begin"])){
        $begin = $_GET["begin"];
        $end = $_GET["end"];
    } else {
        $begin = "";
        $end = "";
    }

    if (isset($_GET["FilterName"])) {
        $FilterName = $_GET["FilterName"];
        if ($end != "") {
            $query = "SELECT * FROM Product WHERE ProductName Like '%$FilterName%' AND ProductID between '$begin' and '$end' order by ProductID;";
        } else {
            $query = "SELECT * FROM Product WHERE ProductName Like '%$FilterName%';";
        }
    } else {
        $FilterName = "";
        if ($end != "") {
            $query = "SELECT * FROM Product WHERE ProductID between '$begin' and '$end' order by ProductID;";
        } else {
            $query = "SELECT * FROM Product";
        }
    }
    $statement = $pdo->prepare($query);
    $statement->execute();
    if($statement->rowCount() > 0) {
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    echo "<center><h1>Product List</h1></center>";
    echo 
        '<center>
        <FORM METHOD = "GET" ACTION = "selectProduct.php">
            รหัสตั้งแต่
            <Input Type="text" Name="begin" Size=4 MaxLength=4 value="">&nbsp&nbsp&nbsp&nbsp-
            &nbsp&nbsp&nbsp&nbsp&nbsp ถึง
            <Input Type="text" Name="end" Size=4 MaxLength=4 value="">
            <br>
            กรองชื่อ
            <Input Type="text" Name="FilterName" Size=4 MaxLength=4 value="">
            <Input Type="submit" Value="ยืนยัน">
            <Input Type="Reset" Value="reset"> 
        </FORM></
        center>';
    
    echo "Filter By ProductID : $begin - $end and By Name : $FilterName ";

    echo "
        <br><br>
        <table border='1' style='width: 60%; margin: 0 auto;'>
        <tr>
            <th style='width: 15%;'>Product ID</th>
            <th style='width: 15%;'>Product Name</th>
            <th style='width: 10%;'>Price / Unit</th>
            <th style='width: 10%;'>StockQty</th>
            <th style='width: 25%;'>Detail</th>
            <th style='width: 10%;'>Update</th>
            <th style='width: 10%;'>Delete</th>
        </tr>";

    foreach ($products as $row) {
        $ID = $row['ProductID'];
        echo "<tr>
            <td style='text-align: center;'>{$row['ProductID']}</td>
            <td style='text-align: center;'>{$row['ProductName']}</td>
            <td style='text-align: center;'>{$row['PricePerUnit']}</td>
            <td style='text-align: center;'>{$row['QtyStock']}</td>
            <td style='text-align: center;'>{$row['Detail']}</td>
            <td style='text-align: center;'><a href='updateProduct.php?ID=$ID'>
                <img src='../images/Update-Button-PNG.png'  alt='Update' width='50' height='25' ></a><br></td>
            <td style='text-align: center;'><a href='confirmDelete.php?ID=$ID'>
                <img src='../images/Junk_Icon.png'  alt='Update' width='25' height='25' ></a><br></td>
          </tr>";
    }
    echo "</table>";
?>
