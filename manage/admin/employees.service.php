<?php

include("../connect/connect.php");

// check คำซ้ำ
if(!empty($_POST['Name_TypeEmp'])){
    $Name_TypeEmp = $_POST['Name_TypeEmp'];
    $sql = "SELECT count(`ID_TypeEmp`) AS ID_TypeEmp FROM `typeemp` WHERE `Name_TypeEmp` LIKE '$Name_TypeEmp'";
    echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
}

// check คำที่ถูกใช้
if(!empty($_POST['ID_TypeEmp'])){
    $ID_TypeEmp = $_POST['ID_TypeEmp'];
    $sql = "SELECT count(`ID_TypeEmp`) AS ID_TypeEmp FROM employees WHERE `ID_TypeEmp`='$ID_TypeEmp'";
    echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
}

// check username ซ้ำ
if(!empty($_POST['username'])){
    $username = $_POST['username'];
    $sql = "SELECT count(`ID_member`) AS ID_Emp FROM `member` WHERE `username`='$username'";
    echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
}

// check คำที่ถูกใช้
if (!empty($_POST['ID_Emp'])) {
    $ID_Emp = $_POST['ID_Emp'];
    if ($_POST['table'] == "orders") {
        $sql = "SELECT count(`ID_Emp`) AS ID_Emp FROM orders WHERE `ID_Emp`='$ID_Emp'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    }
    elseif ($_POST['table'] == "receive") {
        $sql = "SELECT count(`ID_Emp`) AS ID_Emp FROM receive WHERE `ID_Emp`='$ID_Emp'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    }
}