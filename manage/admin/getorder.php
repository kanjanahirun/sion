<?php

include("../connect/connect.php");

if (!empty($_POST['ID_Order'])) {
    $orderId = $_POST['ID_Order'];
//    if (validOrderId($orderId)) { 
    if ($_POST['status'] == "s001") {
        $sql = "SELECT od.ID_Orderdetail, o.ID_Order, p.ID_Product, p.Product_Name, od.Amount_Product, od.Total_Price, p.Cost_Price, c.ID_Count, c.Name_Count, a.ID_Admin AS ID_Emp, a.Name_Admin AS FName_Emp,a.LName_Admin AS LName_Emp, cp.ID_Company, cp.Name_Company FROM orders o INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN count c ON c.ID_Count = od.ID_Count INNER JOIN admin a ON a.ID_Admin = o.ID_Emp INNER JOIN company cp ON cp.ID_Company = o.ID_Company where o.ID_Order='$orderId' ORDER BY od.ID_Orderdetail ASC";
        echo json_encode(fetchArray(mysql_query($sql)));
    } elseif ($_POST['status'] == "s002") {
        $sql = "SELECT od.ID_Orderdetail, o.ID_Order, p.ID_Product, p.Product_Name, od.Amount_Product, od.Total_Price, p.Cost_Price, c.ID_Count, c.Name_Count, e.ID_Emp, e.FName_Emp,e.LName_Emp, cp.ID_Company, cp.Name_Company FROM orders o INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN count c ON c.ID_Count = od.ID_Count INNER JOIN employees e ON e.ID_Emp = o.ID_Emp INNER JOIN company cp ON cp.ID_Company = o.ID_Company where o.ID_Order='$orderId' ORDER BY od.ID_Orderdetail ASC";
        echo json_encode(fetchArray(mysql_query($sql)));
    }
//    echo '[{"sql":"'.$sql.'"}]';
//    } else {
//        echo "{error:500}";
//    }
} else {
    echo '<script>location="./";</script>';
}

// OR001
function validOrderId($id) {
    $str = substr($id, 0, 2);
    $valid = false;
    if ($str == "OR")
        $valid = true;
    return $valid;
}

// if(!empty($_POST['num'])){
// 	$lastsql="SELECT ID_receivedetail From receive_detail order by ID_receivedetail DESC LIMIT 1";
// 	$result=mysql_query($lastsql);
// 	$OldId =mysql_fetch_array($result); 
// 	$ID_Receivedetail = array();
// 	$id = $OldId['ID_receivedetail'];
// 	for($i = 0; i < $_POST['num']; $i++){
// 		$ID_Receivedetail[$i]['ID_Receivedetail'] = generateIDbyFix($id,2,"RC");
// 		$id = $ID_Receivedetail[$i]['ID_Receivedetail'];
// 	} 
// 	echo json_encode($ID_Receivedetail);
// } 