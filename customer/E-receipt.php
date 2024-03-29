<?php 
    require_once __DIR__ . '/db.php'; 
    require ("../libraries/fpdf/fpdf.php");
  
  
    $OrderID = $_GET['OrderID'];
    $AddressQuery = "SELECT Name , Country , Province , Postal , Type
    FROM address a, addresslist al
    WHERE a.AddressID = al.AddressID AND al.OrderID = '$OrderID'";
    $statement = $pdo->prepare($AddressQuery);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $addressLists = $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    $ProductQuery = "SELECT ProductName , pl.Qty , PricePerUnit 
    FROM product p, productlist pl
    WHERE p.ProductID = pl.ProductID AND pl.OrderID = '$OrderID'";
    $statement = $pdo->prepare($ProductQuery);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $productLists = $statement->fetchAll(PDO::FETCH_ASSOC);
    }

  //customer and invoice details
$infoBuy = [];
$infoBill = [];
$infoShipping = [];

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
        $infoShipping = [
            "Name" => $row['Name'],
            "Province" => $row['Province'], 
            "Country" => $row['Country'], 
            "Postal" => $row['Postal']
        ];

    }
}


  
//invoice Products
$products_info = [];
foreach ($productLists as $list) {
    $price = $list['Qty'] * $list['PricePerUnit'];
    $products_info[] = [
        "name" => $list['ProductName'],
        "price" => number_format($list['PricePerUnit'], 2), // Format เป็นทศนิยมสองตำแหน่ง
        "qty" => $list['Qty'],
        "total" => $price
    ];

}
  
  class PDF extends FPDF
  {
    private $OrderIDD;
    function setOrderID($OrderID) {
      $this->OrderIDD = $OrderID;
  }

    function Header(){
        $this->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $this->AddFont('THSarabunNew', 'B', 'THSarabunNew_b.php');
        
        //Display Company Info
        $this->SetFont('THSarabunNew', 'B', 14); // กำหนดเป็นตัวหนา
        $this->Cell(50, 10, iconv('UTF-8', 'cp874', 'Admin'), 0, 1, 'L');
        
        $this->SetFont('THSarabunNew', '', 14); // เปลี่ยนกลับเป็นปกติ
        $this->Cell(50, 7, iconv('UTF-8', 'cp874', 'bangkok'), 0, 1);
        $this->Cell(50, 7, iconv('UTF-8', 'cp874', 'Thailand 15240'), 0, 1);
        $this->Cell(50, 7, "tel.16161166", 0, 1);
        
      
      //Display INVOICE text
      $this->SetY(15);
      $this->SetX(-40);
      $this->SetFont('THSarabunNew','',14);
      $this->Cell(50,10,iconv('UTF-8', 'cp874', 'OrderID: ' . $this->OrderIDD), 0, 1);      
      //Display Horizontal line
      $this->Line(0,48,210,48);
    }
    
    function body($infoBill,$infoBuy,$infoShipping,$products_info){
      $this->AddFont('THSarabunNew','','THSarabunNew.php');

      // Buyer
    $this->SetY(55);
    $this->SetX(10);
    $this->SetFont('THSarabunNew', '', 12);
    $this->Cell(7, 7, iconv('UTF-8', 'cp874', 'ผู้ซื้อ:'), 0, 0);
    $this->Cell(15, 7, $infoBuy["Name"], 0, 1,'L');
    $this->SetX(17);
    $this->Cell(15, 7, $infoBuy["Province"], 0, 1,'L');
    $this->SetX(17);
    $this->Cell(15, 7, $infoBuy["Country"], 0, 0,'L');
    $this->Cell(15, 7, $infoBuy["Postal"], 0, 1,'L');

    //Bill
    $this->SetY(55);
    $this->SetX(80);
    $this->SetFont('THSarabunNew','',12);
    $this->Cell(15, 7, iconv('UTF-8', 'cp874', 'bill to:'), 0, 0);
    $this->Cell(15, 7, $infoBill["Name"], 0, 1,'L');
    $this->SetX(95); // ปรับตำแหน่ง X ใหม่
    $this->Cell(15, 7, $infoBill["Province"], 0, 1,'L');
    $this->SetX(95); // ปรับตำแหน่ง X ใหม่
    $this->Cell(15, 7, $infoBill["Country"], 0, 0,'L');
    $this->Cell(15, 7, $infoBill["Postal"], 0, 1,'L');

    // Shiping
    $this->SetY(55);
    $this->SetX(150);
    $this->SetFont('THSarabunNew','',12);
    $this->Cell(15, 7, iconv('UTF-8', 'cp874', 'Ship to:'), 0, 0);
    $this->Cell(15, 7, $infoShipping["Name"], 0, 1,'L');
    $this->SetX(165);
    $this->Cell(15, 7, $infoShipping["Province"], 0, 1,'L');
    $this->SetX(165);
    $this->Cell(15, 7, $infoShipping["Country"], 0, 0,'L');
    $this->Cell(15, 7, $infoShipping["Postal"], 0, 1,'L');

      
      
      //Display Invoice no
      $this->SetY(55);
      $this->SetX(-60);
      //$this->Cell(50,7,"Invoice No : ".$info["Province"]);
      
      //Display Invoice date
      $this->SetY(63);
      $this->SetX(-60);
      //$this->Cell(50,7,"Invoice Date : ".$info["Province"]);
      
      //Display Table headings
      $this->SetY(95);
      $this->SetX(10);
      $this->SetFont('THSarabunNew','',12);
      $this->Cell(80,9,"NAME",1,0);
      $this->Cell(40,9,"PRICE",1,0,"C");
      $this->Cell(30,9,"QTY",1,0,"C");
      $this->Cell(40,9,"TOTAL",1,1,"C");
      $this->SetFont('THSarabunNew','',12);
      
      //Display table product rows
      $allPrice = 0.00;
      foreach($products_info as $row){
        $this->Cell(80,9,$row["name"],"LR",0);
        $this->Cell(40,9,$row["price"],"R",0,"R");
        $this->Cell(30,9,$row["qty"],"R",0,"C");
        $this->Cell(40,9,$row["total"],"R",1,"R");
        $allPrice += $row["total"];
      }
      //Display table empty rows
      for($i=0;$i<12-count($products_info);$i++)
      {
        $this->Cell(80,9,"","LR",0);
        $this->Cell(40,9,"","R",0,"R");
        $this->Cell(30,9,"","R",0,"C");
        $this->Cell(40,9,"","R",1,"R");
      }
      //Display table total row
      $VAT = ($allPrice * 0.07);
      $this->SetFont('THSarabunNew','',12);
      $this->Cell(150, 9, "SUBTOTAL", 'LTR', 0, 'R');
      $this->Cell(40, 9, $allPrice, 'TR', 1, 'R');
      $this->Cell(150, 9, "VAT 7 %", "LR", 0, 'R');
      $this->Cell(40, 9, $VAT, "R", 1, 'R');
      $this->SetFont('THSarabunNew','B',12);
      $this->Cell(150, 9, "TOTAL", 'LR', 0, 'R');
      $this->Cell(40, 9, $allPrice + $VAT, 'R', 1, 'R');
      $this->Cell(190, 0, '', 1, 1);
      
      
      //Display amount in words
      $this->SetY(225);
      $this->SetX(10);
      $this->SetFont('THSarabunNew','',12);
      //$this->Cell(0,9,"Amount in Words ",0,1);
      //$this->SetFont('THSarabunNew','',12);
      //$this->Cell(0,9,$info["words"],0,1);
      
    }
    function Footer(){
      $this->AddFont('THSarabunNew','','THSarabunNew.php');
      //set footer position
      $this->SetY(-50);
      $this->SetFont('THSarabunNew','',12);
      //$this->Cell(0,10,"for ABC COMPUTERS",0,1,"R");
      $this->Ln(15);
      $this->SetFont('THSarabunNew','',12);
      //$this->Cell(0,10,"Authorized Signature",0,1,"R");
      $this->SetFont('THSarabunNew','',10);
      
      //Display Footer Text
      //$this->Cell(0,10,"This is a computer generated invoice",0,1,"C");
      
    }
    
  }
  //Create A4 Page with Portrait 
  $pdf=new PDF("P","mm","A4");
  $pdf->setOrderID($OrderID);
  $pdf->AddPage();
  $pdf->body($infoBill,$infoBuy,$infoShipping,$products_info);
  $pdf->Output();
?>