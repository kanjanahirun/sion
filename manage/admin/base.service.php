<?php

include("../connect/connect.php");

// check คำนำหน้าซ้ำ
if (!empty($_POST['Name_Prefix'])) {
    $name = $_POST['Name_Prefix'];
    $sql = "SELECT count(`ID_Prefix`) AS ID_Prefix FROM `prefix` WHERE Name_Prefix like '$name' limit 1";
    echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
}

// check คำนำหน้าที่ถูกใช้
if (!empty($_POST['ID_Prefix']) && !empty($_POST['table'])) {
    if ($_POST['table'] == "customers") {
        $ID_Prefix = $_POST['ID_Prefix'];
        $sql = "SELECT count(`ID_Prefix`) AS `ID_Prefix` FROM `customers` WHERE `ID_Prefix`='$ID_Prefix'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    } elseif ($_POST['table'] == "employees") {
        $ID_Prefix = $_POST['ID_Prefix'];
        $sql = "SELECT count(`ID_Prefix`) AS `ID_Prefix` FROM `employees` WHERE `ID_Prefix`='$ID_Prefix'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    }
}

