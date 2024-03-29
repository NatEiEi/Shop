<?php
    require '../db.php'; 
    include __DIR__ . '/adminLogin.php';

    date_default_timezone_set('Asia/Bangkok');
    // $currentYearBE = date("Y") + 543;
    $currentYearBE = date("Y");
    echo "<p style='text-align: center;'>วันที่ : " .date("d-m") ."-$currentYearBE " . " เวลา : " . date("H:i:s") ."</p>";


    echo 
        '<center>
        Filter by date :
        <form action="report.php" method="GET">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date">
        
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date">
        
            <button type="submit">Submit</button>
        </form>
        </center>';


    if (empty($_GET['start_date'])) {
        $start_date = '2023-01-01 00:00:00';
    } else {
        $start_date = date('Y-m-d 00:00:00', strtotime($_GET['start_date']));
    }
    if (empty($_GET['end_date'])) {
        $end_date = date('Y-m-d 23:59:59');
    } else {
        $end_date = date('Y-m-d 23:59:59', strtotime($_GET['end_date']));
    }

    echo "<center>Filter Start Date : $start_date - End Date : $end_date</center>";

    $query =    "SELECT pl.ProductID , p.ProductName , p.PricePerUnit , p.Cost , SUM(Qty) as total_Qty 
                    FROM productlist pl , product p 
                    WHERE pl.ProductID = p.ProductID 
                        AND OrderID IN 
                            (SELECT OrderID FROM `order` 
                                    WHERE Status != 'Canceled' AND Date BETWEEN '$start_date' AND '$end_date') 
                    GROUP BY ProductID 
                    ORDER BY ProductID";
                    
    
    $statement = $pdo->prepare($query);
    $statement->execute();

    if($statement->rowCount() > 0) {
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        echo "
            <br><br>
            <table border='1' style='width: 60%; margin: 0 auto;'>
            <tr>
                <th style='width: 15%;'>Product ID</th>
                <th style='width: 15%;'>Product Name</th>
                <th style='width: 15%;'>Price / Unit</th>
                <th style='width: 15%;'>Cost / Unit</th>
                <th style='width: 10%;'>Qty</th>
                <th style='width: 15%;'>รวม</th>
                <th style='width: 15%;'>กำไร</th>
            </tr>";
        $TotalSum = 0;
        $TotalProfit = 0;
        foreach ($products as $product) {
            $Sum = $product['PricePerUnit'] * $product['total_Qty'];
            $profit = $Sum - ($product['Cost'] * $product['total_Qty']);
            $TotalSum += + $Sum;
            $TotalProfit += $profit;
            echo "<tr>
                    <td style='text-align: center;'>{$product['ProductID']}</td>
                    <td style='text-align: center;'>{$product['ProductName']}</td>
                    <td style='text-align: center;'>{$product['PricePerUnit']}</td>
                    <td style='text-align: center;'>{$product['Cost']}</td>
                    <td style='text-align: center;'>{$product['total_Qty']}</td>
                    <td style='text-align: center;'>{$Sum}</td>
                    <td style='text-align: center;'>{$profit}</td>
                </tr>";
        }
        echo "</table>";
        echo "<p style='text-align: end; padding:0px 20%;'>รายได้รวม $TotalSum บาท</p>";
        echo "<p style='text-align: end; padding:0px 20%;'>กำไรรวม $TotalProfit บาท</p>";

        echo "<div style='text-align: end; padding:0px 20%;'>
                    <a href='printReport.php?start_date=$start_date&end_date=$end_date'>
                        <button style='padding:10px 10px;background-color: #000FFF;color: white;'>PRINT REPORT</button>
                    </a>
                </div>";

    } else {
        echo "No records found...";
    }
?>