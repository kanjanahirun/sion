<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<?php 
	include("../connect/connect.php"); 

	if(!empty($_POST['ID_Order']) && !empty($_POST['Date_Order']) && !empty($_POST['ID_Emp']) && !empty($_POST['ID_Company']) && !empty($_POST['ID_Orderdetail']) && !empty($_POST['ID_Product']) && !empty($_POST['Amount_Product']) && !empty($_POST['ID_Count']) && !empty($_POST['Cost_Price']) && !empty($_POST['Total_Price'])){
		$ID_Order = $_POST['ID_Order'];
		$Date_Order = format_date($_POST['Date_Order']);
		$ID_Emp = $_POST['ID_Emp'];
		$ID_Company = $_POST['ID_Company'];
		$ID_Product = $_POST['ID_Product'];
		$Amount_Product = $_POST['Amount_Product'];
		$Total_Price = $_POST['Total_Price']; 
		$ID_Orderdetail = $_POST['ID_Orderdetail']; 
		$ID_Count = $_POST['ID_Count'];
		$Cost_Price = $_POST['Cost_Price']; 


		echo $ID_Order."<br>";
		echo $Date_Order."<br>";
		echo $ID_Emp."<br>";
		echo $ID_Company."<br>";
		echo "<pre>";
		print_r($ID_Product);
		print_r($Amount_Product);
		print_r($Total_Price);
		print_r($ID_Orderdetail);
		print_r($ID_Count);
		print_r($Cost_Price);


		$order_ql = "INSERT INTO orders VALUES ('$ID_Order','$Date_Order','$ID_Emp','$ID_Company')";

		$order_detail_ql = "";



}


?>
</body>
</html>