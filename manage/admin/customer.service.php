<?php

include("../connect/connect.php");

//// check คำซ้ำ
//if(!empty($_POST['Name_TypeEmp'])){
//    $Name_TypeEmp = $_POST['Name_TypeEmp'];
//    $sql = "SELECT count(`ID_TypeEmp`) AS ID_TypeEmp FROM `typeemp` WHERE `Name_TypeEmp` LIKE '$Name_TypeEmp'";
//    echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
//}
//
//// check คำที่ถูกใช้
//if(!empty($_POST['ID_TypeEmp'])){
//    $ID_TypeEmp = $_POST['ID_TypeEmp'];
//    $sql = "SELECT count(`ID_TypeEmp`) AS ID_TypeEmp FROM employees WHERE `ID_TypeEmp`='$ID_TypeEmp'";
//    echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
//}

// check email ซ้ำ
if (!empty($_POST['Email'])) {
    $Email = $_POST['Email'];
    $table = $_POST['table'];
    if ($table == "customers") {
        $sql = "SELECT count(`Email_Cus`) AS Email FROM `customers` WHERE `Email_Cus`='$Email'"; 
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    } elseif ($table == "member") {
        $sql = "SELECT count(`Email`) AS Email FROM `member` WHERE `Email`='$Email'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql))); 
    }
}

// check username ซ้ำ
if (!empty($_POST['username'])) {
    $username = $_POST['username'];
    $sql = "SELECT count(`ID_member`) AS ID_Cus FROM `member` WHERE `username`='$username'";
    echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
}
