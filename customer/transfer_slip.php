<?php
    require_once __DIR__ . '/db.php'; 
    include_once __DIR__ . '/navbar.php';

    $OrderID = $_GET['OrderID'];
?>

<center>
    <h1>ใส่ข้อมูลของลูกค้าที่ต้องการ</h1><br>
    <form method="POST" action="transfer_slip_save.php" enctype="multipart/form-data" style='text-align: start; padding:0px 30%;'>
        <input type="hidden" name="OrderID" value=<?= $OrderID ?>><br>
        Name &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="Name"><br>
        Upload Product Image
        <input type="file" id="imageUpload" name="imageUpload""><br>

        <input type="submit" value="ยืนยัน">
        <input type="reset" value="ยกเลิก">
    </form>
</center>