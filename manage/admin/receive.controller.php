<?php 
	include("../connect/connect.php"); 


	if(!empty($_POST['ID_Order'])){
		$ID = $_POST['ID_Order'];
		$sql = "SELECT * FROM orders o INNER JOIN company c ON o.ID_Company = c.ID_Company WHERE o.ID_Order =  '$ID'";
		echo json_encode(mysql_fetch_assoc(mysql_query($sql)));
	}
	
 ?>