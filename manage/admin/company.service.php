<?php

include("../connect/connect.php");

// check คำซ้ำ
if (!empty($_POST['Name_Company'])) {
    $Name_Company = $_POST['Name_Company'];
    $sql = "SELECT count(`ID_Company`) AS ID_Company FROM company WHERE `Name_Company` LIKE '$Name_Company'";
    echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
}

// check คำที่ถูกใช้
if (!empty($_POST['ID_Company'])) {
    $ID_Company = $_POST['ID_Company'];
    if ($_POST['table'] == "product") {
        $sql = "SELECT count(`ID_Company`) AS ID_Company FROM product WHERE `ID_Company`='$ID_Company'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    }elseif($_POST['table'] == "orders"){
        $sql = "SELECT count(`ID_Company`) AS ID_Company FROM orders WHERE `ID_Company`='$ID_Company'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    }elseif($_POST['table'] == "receive"){
        $sql = "SELECT count(`ID_Company`) AS ID_Company FROM receive WHERE `ID_Company`='$ID_Company'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    }
}