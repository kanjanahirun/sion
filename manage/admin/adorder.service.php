<?php

include("../connect/connect.php");


if (!empty($_POST['ID_Order'])) {
    $ID_Order = $_POST['ID_OrderID_Order'];
    if ($_POST['table'] == "receive") {
        $sql = "SELECT count(`ID_Order`) AS ID_Order FROM receive WHERE `ID_Order`='$ID_Order'";
        echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
    }
}