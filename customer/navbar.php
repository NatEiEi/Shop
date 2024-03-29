<?php
    session_start();

    if(isset($_SESSION['Username'])) {
        include __DIR__ . '/navbar_login.php';
    }else {
        include __DIR__ . '/navbar_guest.php';
    }
?>