<?php

 include("../connect/connect.php");

// check คำซ้ำ
if(!empty($_POST['Name_Count'])){
    $Name_Count = $_POST['Name_Count'];
    $sql = "SELECT count(`ID_Count`) AS ID_Count FROM `count` WHERE `Name_Count` LIKE '$Name_Count'";
    echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
}

// check คำที่ถูกใช้
if(!empty($_POST['ID_Count'])){
    $ID_Count = $_POST['ID_Count'];
    $sql = "SELECT count(`ID_Count`) AS ID_Count FROM %%%%%%% WHERE `ID_Count`='$ID_Count'";
    echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
}