<?php
    require_once __DIR__ . '/db.php'; 
    include_once __DIR__ . '/navbar.php';
    include __DIR__ . '/counter.php';

    $counter = new counter();
    
    date_default_timezone_set('Asia/Bangkok');
    $currentYearBE = date("Y") + 543;
    echo "<p style='text-align: center;'>วันที่ : " .date("d-m") ."-$currentYearBE " . " เวลา : " . date("H:i:s") ."</p>";

    if (isset($_GET['Payment'], $_GET['AddressBilling'], $_GET['AddressShipping'], $_GET['Username'] , $_GET['AddressBuy'])) {
        $Payment = $_GET['Payment'];
        $AddressBuy = $_GET['AddressBuy'];
        $AddressBilling = $_GET['AddressBilling'];
        $AddressShipping = $_GET['AddressShipping'];
        $Username = $_GET['Username'];
        $BuyMethod = $_GET['BuyMethod'];


        // if ($Payment == 'addPayment') {
        //     $Payment = $counter->getPaymentCnt();
        //     $PaymentType = $_GET['addPay_Type'];
        //     $CardNumber = $_GET['addPay_CardNum'];
        //     $query =    "INSERT INTO Payment (PaymentID, PaymentType, Username , CardNumber) 
        //                 VALUES ('$Payment', '$PaymentType', '$Username' , '$CardNumber');";
        //     $statement = $pdo->prepare($query);
        //     $statement->execute();
        // }

        // insert to order table
        $OrderID = $counter->getOrderCnt();
        $insertOrderQuery = "INSERT INTO `order` (Username, OrderID, Date, Status, Payment) 
                            VALUES ('$Username', '$OrderID', NOW() , 'Preparing', '$Payment');";
        $Statement = $pdo->prepare($insertOrderQuery);
        $Statement->execute();


        //add list product to database
        $products = $_SESSION['ProductBuyList'];
        foreach ($products as $list) {
            $insertListQuery = "INSERT INTO `productlist` (ProductID, OrderID, Qty) VALUES ('{$list['ProductID']}', '$OrderID', '{$list['Qty']}');";
            $statement = $pdo->prepare($insertListQuery);
            $statement->execute();
    
            $newStock = $list['QtyStock'] - $list['Qty'];
            $query = "UPDATE product SET QtyStock = '$newStock' WHERE ProductID = '{$list['ProductID']}'";
            $statement = $pdo->prepare($query);
            $statement->execute();
        }
        


        if ($_GET['Username'] == 'GUEST'){
            // $CartArray = $_SESSION['CartArray'];
            // foreach ($CartArray as $list) {
            //     $insertListQuery = "INSERT INTO `productlist` (ProductID, OrderID, Qty) VALUES ('{$list['ProductID']}', '$OrderID', '{$list['Qty']}');";
            //     $statement = $pdo->prepare($insertListQuery);
            //     $statement->execute();
               
            //     $query = "SELECT * FROM product WHERE ProductID='{$list['ProductID']}'";
            //     $statement = $pdo->prepare($query);
            //     $statement->execute();
            //     $listQty = $statement->fetchAll(PDO::FETCH_ASSOC);
            //     $listQty = $listQty[0];
                
            //     $newStock = $listQty['QtyStock'] - $list['Qty'];
            //     $query = "UPDATE product SET QtyStock = '$newStock' WHERE ProductID = '{$list['ProductID']}'";
            //     $statement = $pdo->prepare($query);
            //     $statement->execute();
                
            //     //Clear Cart session
            //     unset($_SESSION['CartArray']);
            // }

            // delete from cart
            if ($BuyMethod == "BuyFromCart") {
                unset($_SESSION['CartArray']);
            }
            unset($_SESSION['ProductBuyList']);
            


        } else {

             // insert to productlist table

            // $query = "SELECT p.ProductID, p.ProductName, c.Username, c.Qty , PricePerUnit , p.QtyStock
            //         FROM product p 
            //         INNER JOIN cart c ON p.ProductID = c.ProductID 
            //         WHERE c.Username='$Username'";
            // $statement = $pdo->prepare($query);
            // $statement->execute();
            // if ($statement->rowCount() > 0) {
            //     $lists = $statement->fetchAll(PDO::FETCH_ASSOC);

            //     foreach ($lists as $list) {
            //         $insertListQuery = "INSERT INTO `productlist` (ProductID, OrderID, Qty) VALUES ('{$list['ProductID']}', '$OrderID', '{$list['Qty']}');";
            //         $statement = $pdo->prepare($insertListQuery);
            //         $statement->execute();
        
            //         $newStock = $list['QtyStock'] - $list['Qty'];
            //         $query = "UPDATE product SET QtyStock = '$newStock' WHERE ProductID = '{$list['ProductID']}'";
            //         $statement = $pdo->prepare($query);
            //         $statement->execute();
            //     }
                
            //     // delete from cart
            //     foreach ($lists as $list) {
            //         $deleteListQuery = "DELETE FROM `cart` WHERE ProductID = '{$list['ProductID']}' AND Username = '$Username';";
            //         $statement = $pdo->prepare($deleteListQuery);
            //         $statement->execute();
            //     }
            // }



            // $products = $_SESSION['ProductBuyList'];
            // foreach ($products as $list) {
            //     $insertListQuery = "INSERT INTO `productlist` (ProductID, OrderID, Qty) VALUES ('{$list['ProductID']}', '$OrderID', '{$list['Qty']}');";
            //     $statement = $pdo->prepare($insertListQuery);
            //     $statement->execute();
    
            //     $newStock = $list['QtyStock'] - $list['Qty'];
            //     $query = "UPDATE product SET QtyStock = '$newStock' WHERE ProductID = '{$list['ProductID']}'";
            //     $statement = $pdo->prepare($query);
            //     $statement->execute();
            // }
            
            // delete from cart
            if ($BuyMethod == "BuyFromCart") {
                foreach ($products as $list) {
                    $deleteListQuery = "DELETE FROM `cart` WHERE ProductID = '{$list['ProductID']}' AND Username = '$Username';";
                    $statement = $pdo->prepare($deleteListQuery);
                    $statement->execute();
                }
            }
            unset($_SESSION['ProductBuyList']);
            
        }
       

        

        // insert to AddressList Buying Address
        if ($AddressBuy == 'addAddressBuy') {
            $AddressBuy = $counter->getAddressCnt();
            $Name = $_GET['addBuy_Name'];
            $Country = $_GET['addBuy_Country'];
            $Province = $_GET['addBuy_Province'];
            $Postal = $_GET['addBuy_Postol'];
            $query =    "INSERT INTO Address (AddressID , Username , Name , Country , Province , Postal) 
                        VALUES ('$AddressBuy', '$Username', '$Name' , '$Country' , '$Province' , '$Postal');";
            $statement = $pdo->prepare($query);
            $statement->execute();
        }
        $insertBuyQuery = "INSERT INTO `addresslist` (AddressID, OrderID, Type) VALUES ('$AddressBuy', '$OrderID', 'Buy');";
        $statement = $pdo->prepare($insertBuyQuery);
        $statement->execute();
        

        // insert to AddressList Billing Address
        if ($AddressBilling == 'addAddressBill') {
            $AddressBilling = $counter->getAddressCnt();
            $Name = $_GET['addBill_Name'];
            $Country = $_GET['addBill_Country'];
            $Province = $_GET['addBill_Province'];
            $Postal = $_GET['addBill_Postol'];
            $query =    "INSERT INTO Address (AddressID , Username , Name , Country , Province , Postal) 
                        VALUES ('$AddressBilling', '$Username', '$Name' , '$Country' , '$Province' , '$Postal');";
            $statement = $pdo->prepare($query);
            $statement->execute();
        }
        



        // insert to AddressList Shipping Address
        if ($AddressShipping == 'addAddressShip') {
            $AddressShipping = $counter->getAddressCnt();
            $Name = $_GET['addShip_Name'];
            $Country = $_GET['addShip_Country'];
            $Province = $_GET['addShip_Province'];
            $Postal = $_GET['addShip_Postol'];
            $query =    "INSERT INTO Address (AddressID , Username , Name , Country , Province , Postal) 
                        VALUES ('$AddressShipping', '$Username', '$Name' , '$Country' , '$Province' , '$Postal');";
            $statement = $pdo->prepare($query);
            $statement->execute();
        }

        // ในกรณีที่อยู่Bill ที่เลือกเหมือนซื้อหรือที่อยู่ส่ง
        if ($AddressBilling == 'sameBill_Buy') {
            $insertBuyQuery = "INSERT INTO `addresslist` (AddressID, OrderID, Type) VALUES ('$AddressBuy', '$OrderID', 'Bill');";
            $statement = $pdo->prepare($insertBuyQuery);
            $statement->execute();
        } else if ($AddressBilling == 'sameBill_Ship') {
            $insertShippingQuery = "INSERT INTO `addresslist` (AddressID, OrderID, Type) VALUES ('$AddressShipping', '$OrderID', 'Bill');";
            $statement = $pdo->prepare($insertShippingQuery);
            $statement->execute();
        } else {
            $insertBillingQuery = "INSERT INTO `addresslist` (AddressID, OrderID, Type) VALUES ('$AddressBilling', '$OrderID', 'Bill');";
            $statement = $pdo->prepare($insertBillingQuery);
            $statement->execute();
        }


        // ในกรณีที่อยู่ส่ง ที่เลือกเหมือนซื้อหรือที่บิล
        if ($AddressShipping == 'sameShip_Buy') {
            $insertBuyQuery = "INSERT INTO `addresslist` (AddressID, OrderID, Type) VALUES ('$AddressBuy', '$OrderID', 'Ship');";
            $statement = $pdo->prepare($insertBuyQuery);
            $statement->execute();
        } else if ($AddressShipping == 'sameShip_Bill') {
            $insertShippingQuery = "INSERT INTO `addresslist` (AddressID, OrderID, Type) VALUES ('$AddressBilling', '$OrderID', 'Ship');";
            $statement = $pdo->prepare($insertShippingQuery);
            $statement->execute();
        } else {
            $insertBillingQuery = "INSERT INTO `addresslist` (AddressID, OrderID, Type) VALUES ('$AddressShipping', '$OrderID', 'Ship');";
            $statement = $pdo->prepare($insertBillingQuery);
            $statement->execute();
        }
        
        
        echo "Successfully";
        $newURL = 'E-receipt.php?OrderID=' . $OrderID;
        header('Location: ' . $newURL);
        exit;
    } else {
        echo "Some or all variables are missing!";
    }
?>