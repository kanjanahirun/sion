<?php

include("../connect/connect.php");

// check คำที่มีแล้ว
if (!empty($_POST['Product_Name'])) {
    $name = $_POST['Product_Name'];
    $ID_Company = $_POST['ID_Company'];
    $sql = "SELECT count(`ID_Product`) AS ID_Product FROM `product` WHERE Product_Name like '$name' AND ID_Company='$ID_Company'";
    echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
}

// check คำที่ใช้อยู่จะลบไม่ได้
if (!empty($_POST['ID_Product'])) {
    $ID_Product = $_POST['ID_Product'];
    if ($_POST['table'] == "sale_detail") {
        $sql = "SELECT count(`ID_Product`) AS ID_Product FROM `sale_detail` WHERE `ID_Product`='$ID_Product'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    } elseif ($_POST['table'] == "order_detail") {
        $sql = "SELECT count(`ID_Product`) AS ID_Product FROM `order_detail` WHERE `ID_Product`='$ID_Product'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    } elseif ($_POST['table'] == "receive_detail") {
        $sql = "SELECT count(`ID_Product`) AS ID_Product FROM `receive_detail` WHERE `ID_Product`='$ID_Product'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    } elseif ($_POST['table'] == "disproduct_detail") {
        $sql = "SELECT count(`Product_ID`) AS ID_Product FROM `disproduct_detail` WHERE `Product_ID`='$ID_Product'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    } elseif ($_POST['table'] == "disburse_product") {
        $sql = "SELECT count(`ID_Product`) AS ID_Product FROM `disburse product` WHERE `ID_Product`='$ID_Product'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    }  elseif ($_POST['table'] == "prosale_detail") {
        $sql = "SELECT count(`ID_Product`) AS ID_Product FROM `prosale_detail` WHERE `ID_Product`='$ID_Product'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    } elseif ($_POST['table'] == "sales") {
        $sql = "SELECT count(`ID_Product`) AS ID_Product FROM `sales` WHERE `ID_Product`='$ID_Product'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    }
}
