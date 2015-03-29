<?php

include("../connect/connect.php");

// find priduct by id
if (!empty($_POST['productId'])) {
    $id = $_POST['productId'];
    $sql = "SELECT *  FROM product p, count c WHERE p.ID_Product='" . $id . "' AND c.ID_Count=p.ID_Count";
    echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
}


if (!empty($_POST['ID_Count'])) {
    $cid = $_POST['ID_Count'];
    $sql = "SELECT * FROM count WHERE ID_Count='" . $cid . "'";
    echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
}

// ดึง PK ตัวสุดท้าย
if(!empty($_POST['getlastodetail'])){ 
    $sql = "SELECT ID_Orderdetail From order_detail order by cast(substr(ID_Orderdetail,3) AS UNSIGNED) DESC LIMIT 1";
    echo json_encode(mysql_fetch_assoc(mysql_query($sql))); 
}

// แสดง สินค้าตามบริษัท
if(!empty($_POST['ID_Company'])){
    $ID_Company = $_POST['ID_Company'];
    $sql = "SELECT * FROM `product` WHERE `ID_Company`='$ID_Company' order by `Product_Name` asc";
    echo json_encode(fetchArray(mysql_query($sql)));
}

