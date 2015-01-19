<?php

session_start();
include("../connect/connect.php");

if (empty($_SESSION['Username'])) {
    if (empty($_SESSION['Username']) || empty($_SESSION['status']) || empty($_SESSION['name'])) {
        echo alert('กรุณาเข้าสู่ระบบ Admin ก่อน');
        echo location("../login.php");
    }
}else{



	//echo $nextNum;

$button = $_POST['Button'];
$Flag = true;
if($button == 'เพิ่มข้อมูล')
{

	$strCount = "SELECT * FROM order_detail ORDER BY ID_Orderdetail DESC LIMIT 1";
	$objQueryCount = mysql_query($strCount);
	$Count_prefix = mysql_fetch_array($objQueryCount);
	$NUMCount=substr($Count_prefix["ID_Orderdetail"],-1);
	$nextNum=$NUMCount+1;
	$Prefix_num=substr($nextNum["ID_Orderdetail"],0,3);

	//$strEmp_ID = "".($Prefix_num."".$nextNum);
			//echo "<script type='text/javascript'>alert('กรุณาเข้าสู่ระบบ Admin ก่อน')</script>";

			//$sql ="INSERT INTO prefix (ID_Prefix, Name_Prefix) VALUES ('$ID_Prefix', '$Name_Prefix')";
	$sql ="INSERT INTO order_detail (ID_Orderdetail, ID_Order, ID_Product, Amount_Product, Total_Price) VALUES ('".$_POST["ID_Orderdetail"]."', '".$_POST["ID_Order"]."','".$_POST["ID_Product"]."', '".$_POST["Amount_Product"]."', '".$_POST["Total_Price"]."')";
			//บัคที่เพิ่ม ID ซ้ำกันแล้ว ไม่มี Error*********************************************************************
	mysql_query($sql);
	if($Flag)
	{
		echo "<script type='text/javascript'>alert('เพิ่มข้อมูลสำเร็จ')</script>";
	}
	else
	{
		echo "<script type='text/javascript'>alert('เพิ่มข้อมูลผิดพลาด')</script>";
	}
}
elseif($button == 'แก้ไขข้อมูล')
{
			//$sql = "UPDATE Employees SET ID_Prefix, FName_Emp, LName_Emp, Tel_Emp, Salary, ID_TypeEmp, personal_ID = '".$_POST["ID_Prefix"]."', '".$_POST["FName_Emp"]."', '".$_POST["LName_Emp"]."', '".$_POST["Tel_Emp"]."', '".$_POST["Salary"]."', '".$_POST["ID_TypeEmp"]."', '".$_POST["personal_ID"]."'";
	$sql = "UPDATE order_detail SET ID_Order = '".$_POST["ID_Order"]."',ID_Product = '".$_POST["ID_Product"]."',Amount_Product = '".$_POST["Amount_Product"]."',Total_Price = '".$_POST["Total_Price"]."' WHERE ID_Orderdetail = '".$_POST["ID_Orderdetail"]."'";
	mysql_query($sql);
}


elseif ($button == 'ลบข้อมูล')
{
	$sql ="DELETE FROM order_detail WHERE ID_Orderdetail = '".$_POST["ID_Orderdetail"]."'";
	mysql_query($sql);
}
?>
<!DOCTYP html>
<html>
<head>
	<title> ร้านศรีอ้น แฮร์ & สปาร์ </title>

	<?php include("../fragments/libmanage.php");?>



</head>

<body id="bg">
	<nav>
		<?php include("../fragments/header.php");?>
	</nav>
	<article>
		<div id="container">
			<div class="row">
				<div class="col-md-2">
					<?php include("../fragments/sidebar.php"); ?>
				</div>
				<div class="col-md-10">
					<div>
						<ul class="nav nav-tabs" role="tablist">
							<li Class = "active"><a href="./base.php">รายละเอียดข้อมูลการสั่งสินค้า</a></li>
						</ul>
					</div>
					<?php
					$lastsql="SELECT ID_Orderdetail From order_detail order by ID_Orderdetail DESC LIMIT 1";
					$result=mysql_query($lastsql);
					$OldId =mysql_fetch_array($result);
				    		//P 099
					$NewId = generateID($OldId['ID_Orderdetail'],2);
				    		//generateID(ไอดีตัวสุดท้าย,จำนวนตัวอักษรที่อยู่ในไอดีนั้นๆ เช่น P099 ก็คือ มีแค่ 1 ตัว );

					?>
					<form name="form1" method="post" action="">
						<div class="row">
							<div class="padform">
								<div class="col-lg-6">
									<div class="input-group"style="width:60%;">
										<label>รหัสรายละเอียดข้อมูลการสั่งสินค้า</label>
										<input name="ID_Orderdetail" id="ID_Orderdetail" placeholder="รหัสรายละเอียดข้อมูลการสั่งสินค้า" value="<?php echo $NewId;?>" maxlength="5" style="background: #C0F9BD" class="form-control">
									</div>
									<div class="input-group" style="width:60%;">
										<label>รหัสการสั่งสินค้า</label><br>
										<select name="ID_Order" id="ID_Order" class="idropdown" placeholder="รหัสการสั่งสินค้า">
											<option value="" style="background: #C0F9BD">รหัสการสั่งสินค้า</option>
											<?php
											$sql = "SELECT * FROM orders ORDER BY ID_Order ASC";
											$query = mysql_query($sql);
											while($objResult = mysql_fetch_array($query))
											{
												?>
												<option value="<?=$objResult["ID_Order"];?>" style="background: #C0F9BD"><?=$objResult["ID_Order"];?></option>
												<?php
											}
											?>
										</select>
									</div>
									<div class="input-group" style="width:60%;">
										<label>ชื่อสินค้า</label><br>
										<select name="ID_Product" id="ID_Product" class="idropdown" placeholder="ชื่อสินค้า">
											<option value="" style="background: #C0F9BD">ชื่อสินค้า</option>
											<?php
											$sql = "SELECT * FROM product ORDER BY ID_Product ASC";
											$query = mysql_query($sql);
											while($objResult = mysql_fetch_array($query))
											{
												?>
												<option value="<?=$objResult["ID_Product"];?>" style="background: #C0F9BD">
													<?=$objResult["Product_Name"];?>
												</option>
												<?php
											}
											?>
										</select>
									</div>
									
								</div>
								<div class="col-lg-6">
									<div class="input-group" style="width:60%;">
										<div><label>จำนวนสินค้า</label></div>
										<div>
											<input type="text" name="Amount_Product" id="Amount_Product" placeholder="จำนวนสินค้า" maxlength="10" style="background: #C0F9BD;width: 48%;" class="form-control">
										</div>
										<div style="padding: 5px 0px 0px 120px;">
											<label>ชิ้น</label></div>
										</div>


										<div class="input-group" style="width:60%;">
											<div><label>ราคารวม</label></div>
											<div>
												<input type="text" name="Total_Price" id="Total_Price" placeholder="ราคารวม" maxlength="20" style="background: #C0F9BD;width: 48%;" class="form-control">
											</div>
											<div style="padding: 5px 0px 0px 120px;">
												<label>บาท</label></div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<center><br>
											<input id="add" type="submit" class="btn btn-primary" name="Button" value="เพิ่มข้อมูล">
											<input id="update"type="submit" class="btn btn-warning" name="Button" value="แก้ไขข้อมูล">
											<input id="delete"type="submit" class="btn btn-danger" name="Button" value="ลบข้อมูล">
											<input id="cancle" type="reset" class="btn btn-default" name="Button" value="ยกเลิก">

											<script type="text/javascript">
												$('#Total_Price').number( true, 2 );
												$('#cancle').click(function(){
													$('#add').show();
												});
											</script>
										</center>
									</div>
								</div>
							</form>
							<div class="row">
								<div class="col-md-12">
									<?php
									$sql = "SELECT * FROM orders o, order_detail d, product p WHERE o.ID_Order = d.ID_Order 
									AND d.ID_Product = p.ID_Product ORDER BY ID_Orderdetail ASC";
									$query = mysql_query($sql);
								//$objResult = mysql_fetch_array($objQuery);

									?>
									<div class="bs-example">
										<div class="panel panel-default">
											<!-- Default panel contents -->
											<div class="panel-heading"><h4>ข้อมูลรายละเอียดการสั่งสินค้า</h4></div>
											<!-- Table -->
											<div class="mygrid-wrapper-div">
												<table class="table">
													<thead>
														<tr>
															<th>รหัสรายละเอียดการสั่งสินค้า</th>
															<th>รหัสการสั่งสินค้า</th>
															<th>ชื่อสินค้า</th>
															<th>จำนวนสินค้า</th>
															<th>ราคารวม</th>
															<th>สถานะ</th>
														</tr>
													</thead>
													<tbody>
														<?php
											//$strSQL = "SELECT * FROM orders o, order_detail d, product p WHERE o.ID_Order = d.ID_Order AND d.ID_Product = p.ID_Product ORDER BY ID_Orderdetail ASC";
											//$sql = "SELECT * FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp";
														$sql = "SELECT o.ID_Order, o.Date_Order, o.ID_Emp, o.ID_Company, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, c.Name_Company, p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.ID_Prefix, e.FName_Emp, e.LName_Emp FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp ORDER BY ID_Orderdetail ASC";
														$query = mysql_query($sql);
														?>
														<?php while($row_Orderdetail = mysql_fetch_array($query)) { ?>
														<tr>
															<td>
																<a id="<?=$row_Orderdetail['ID_Orderdetail']?>" class="point">
																	<?php echo $row_Orderdetail['ID_Orderdetail']; ?>
																</a>
															</td>
															<td><?php echo $row_Orderdetail['ID_Order']; ?></td>
															<td><?php echo $row_Orderdetail['Product_Name']; ?></td>
															<td align = "right"><?php echo $row_Orderdetail['ODAmount_Product']; ?></td>
															<td><span id="right"><?php echo $row_Orderdetail['Total_Price']; ?></span></td>
															<td> 
																<?php 
													//echo ($row_Orderdetail['ID_Order'] == $row_Orderdetail['RID_Order']) ? '<span class="label label-success">รับแล้วนะจ๊ะ สุดหล่อ</span>':'<span class="label label-danger">ยังไม่รับจ๊ะ สุดหล่อ</span>';
																if($row_Orderdetail['ID_Order'] == $row_Orderdetail['RID_Order']){
																	echo '<span class="label label-success">รับสินค้าเรียบร้อย</span>';
																}
																else{
																	echo '<span class="label label-danger">ยังไม่ได้รับสินค้า</span>';
																}
																?> 
															</td>
														</tr>
														<script type="text/javascript">
															$("#<?=$row_Orderdetail['ID_Orderdetail']?>").click(function(){
																$('#add').hide();
																ID_Orderdetail.value = "<?=$row_Orderdetail['ID_Orderdetail']?>";
																ID_Order.value = "<?=$row_Orderdetail['ID_Order']?>";
																document.getElementById("ID_Product")[0].text ="<?=$row_Orderdetail['Product_Name']?>";
																document.getElementById("ID_Product")[0].value ="<?=$row_Orderdetail['ID_Product']?>";
																Amount_Product.value = "<?=$row_Orderdetail[7]?>";
																Total_Price.value = "<?=$row_Orderdetail['Total_Price']?>";
															});
														</script>
														<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</article>
				<footer>
					<script type="text/javascript">
						$(document).ready(function(){
							$('#order').addClass('active');
							$('#sub1').show();
							$('#orderlist').css({background: "transparent"});
							$('#orderdetail').css({background: "#e8e8e8"});

						});
					</script>
					<?php include("../fragments/footer.php");?>
				</footer>
			</body>
			</html>
<?php } ?>