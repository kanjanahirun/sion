<?php

include("../connect/connect.php");

// check คำซ้ำ
if(!empty($_POST['Name_TypeSer'])){
    $Name_TypeSer = $_POST['Name_TypeSer'];
    $sql = "SELECT count(`ID_TypeSer`) AS ID_TypeSer FROM `TypeSer` WHERE `Name_TypeSer` LIKE '$Name_TypeSer'";
    echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
}

// check คำที่ถูกใช้
if(!empty($_POST['ID_TypeSer'])){
    $ID_TypeSer = $_POST['ID_TypeSer'];
    $sql = "SELECT count(`ID_TypeSer`) AS ID_TypeSer FROM service WHERE `ID_TypeSer`='$ID_TypeSer'";
    echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
}
