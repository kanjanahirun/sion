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
$button = '';
if(!empty($_POST['Button']))
	$button = $_POST['Button'];
$Flag = true;
if($button == 'เพิ่มข้อมูล')
{

	$strCount = "SELECT * FROM receive_detail ORDER BY ID_Receivedetail DESC LIMIT 1";
	$objQueryCount = mysql_query($strCount);
	$Count_prefix = mysql_fetch_array($objQueryCount);
	$NUMCount=substr($Count_prefix["ID_Receivedetail"],-1);
	$nextNum=$NUMCount+1;
	$Prefix_num=substr($nextNum["ID_Receivedetail"],0,3);

	//$strEmp_ID = "".($Prefix_num."".$nextNum);
			//echo "<script type='text/javascript'>alert('กรุณาเข้าสู่ระบบ Admin ก่อน')</script>";

			//$sql ="INSERT INTO prefix (ID_Prefix, Name_Prefix) VALUES ('$ID_Prefix', '$Name_Prefix')";
	$sql ="INSERT INTO receive_detail (ID_Receivedetail, ID_Receive, ID_Product, Amount_Product, Product_Remand) VALUES ('".$_POST["ID_Receivedetail"]."', '".$_POST["ID_Receive"]."','".$_POST["ID_Product"]."', '".$_POST["Amount_Product"]."', '".$_POST["Product_Remand"]."')";
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
	$sql = "UPDATE receive_detail SET ID_Receive = '".$_POST["ID_Receive"]."',ID_Product = '".$_POST["ID_Product"]."',Amount_Product = '".$_POST["Amount_Product"]."',Product_Remand = '".$_POST["Product_Remand"]."' WHERE ID_Receivedetail = '".$_POST["ID_Receivedetail"]."'";
	mysql_query($sql);
}


elseif ($button == 'ลบข้อมูล')
{
	$sql ="DELETE FROM receive_detail WHERE ID_Receivedetail = '".$_POST["ID_Receivedetail"]."'";
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
							<li Class = "active"><a href="./base.php">รายละเอียดข้อมูลการรับสินค้า</a></li>
							<li role="presentation" class="dropdown" style="float: right;margin-right: -2px;">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" style="min-width: 160px;">
									<?php echo isset($_SESSION['name'])?$_SESSION['name']:"";?> <span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="../logout.php">ออกจากระบบ</a></li>
								</ul>
							</li>
						</ul>
					</div>
					<?php
					$lastsql="SELECT ID_Receivedetail From receive_detail order by ID_Receivedetail DESC LIMIT 1";
					$result=mysql_query($lastsql);
					$OldId =mysql_fetch_array($result);
				    		//P 099
					$NewId = generateID($OldId['ID_Receivedetail'],2);
				    		//generateID(ไอดีตัวสุดท้าย,จำนวนตัวอักษรที่อยู่ในไอดีนั้นๆ เช่น P099 ก็คือ มีแค่ 1 ตัว );

					?>
					<form name="form1" method="post" action="">
						<div class="row">
							<div class="padform">
								<div class="col-lg-6">
									<div class="input-group"style="width:60%;">
										<label>รหัสรายละเอียดข้อมูลการรับสินค้า</label>
										<input name="ID_Receivedetail" id="ID_Receivedetail" placeholder="รหัสรายละเอียดข้อมูลการรับสินค้า" value="<?php echo $NewId;?>" maxlength="5" style="background: #C0F9BD" class="form-control">
									</div>
									<div class="input-group" style="width:60%;">
										<label>รหัสการรับสินค้า</label><br>
										<select name="ID_Receive" id="ID_Receive" class="idropdown" placeholder="รหัสการรับสินค้า">
											<option value="" style="background: #C0F9BD">รหัสการรับสินค้า</option>
											<?php
											$sql = "SELECT * FROM receive ORDER BY ID_Receive ASC";
											$query = mysql_query($sql);
											while($objResult = mysql_fetch_array($query))
											{
												?>
												<option value="<?=$objResult["ID_Receive"];?>" style="background: #C0F9BD"><?=$objResult["ID_Receive"];?></option>
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
									<div class="input-group" style="width:75%;">
										<div><label>จำนวนสินค้าที่รับ</label></div>
										<div>
											<input type="text" name="Amount_Product" id="Amount_Product" placeholder="จำนวนสินค้าที่รับ" maxlength="20" style="background: #C0F9BD;width: 48%;" class="form-control">
										</div>
										<div style="padding: 7px 0px 0px 84px;">
											<label style="padding-left: 3%;">ชิ้น</label></div>
										</div>


										<div class="input-group" style="width:75%;">
											<div><label>จำนวนสินค้าที่ส่งคืน</label></div>
											<div>
												<input type="text" name="Product_Remand" id="Product_Remand" placeholder="(กรณีที่สินค้าชำรุด)" maxlength="20" style="background: #C0F9BD;width: 48%;" class="form-control">
											</div>
											<div style="padding: 7px 0px 0px 84px;">
												<label style="padding-left: 3%;">ชิ้น</label></div>
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
								//$('#Product_Remand').number( true, 2 );
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
					$sql = "SELECT * FROM receive r, receive_detail d, product p WHERE r.ID_Receive = d.ID_Receive 
					AND d.ID_Product = p.ID_Product ORDER BY ID_Receivedetail ASC";
					$query = mysql_query($sql);
								//$objResult = mysql_fetch_array($objQuery);

					?>
					<div class="bs-example">
						<div class="panel panel-default">
							<!-- Default panel contents -->
							<div class="panel-heading"><h4>ข้อมูลรายละเอียดการรับสินค้า</h4></div>
							<!-- Table -->
							<div class="mygrid-wrapper-div">
								<table class="table">
									<thead>
										<tr>
											<th>รหัสรายละเอียดข้อมูลการรับสินค้า</th>
											<th>รหัสการรับสินค้า</th>
											<th>ชื่อสินค้า</th>
											<th>จำนวนสินค้าที่รับ</th>
											<th>จำนวนสินค้าที่ส่งคืน</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql = "SELECT * FROM receive r, receive_detail d, product p WHERE r.ID_Receive = d.ID_Receive AND d.ID_Product = p.ID_Product ORDER BY ID_Receivedetail ASC";
										$query = mysql_query($sql);
								//$objResult = mysql_fetch_array($objQuery);

										?>
										<?php while($row_Receivedetail = mysql_fetch_array($query)) { ?>
										<tr>
											<td>
												<a id="<?=$row_Receivedetail['ID_Receivedetail']?>" class="point">
													<?php echo $row_Receivedetail['ID_Receivedetail']; ?>
												</a>
											</td>
											<td><?php echo $row_Receivedetail['ID_Receive']; ?></td>
											<td><?php echo $row_Receivedetail['Product_Name']; ?></td>
											<td align="center"><?php echo $row_Receivedetail['Amount_Product']; ?></td>
											<td align="center"><span id="center"><?php echo $row_Receivedetail['Product_Remand']; ?></span></td>
										</tr>
										<script type="text/javascript">
											$("#<?=$row_Receivedetail['ID_Receivedetail']?>").click(function(){
												$('#add').hide();
												ID_Receivedetail.value = "<?=$row_Receivedetail['ID_Receivedetail']?>";
												ID_Receive.value = "<?=$row_Receivedetail['ID_Receive']?>";
												document.getElementById("ID_Product")[0].text ="<?=$row_Receivedetail['Product_Name']?>";
												document.getElementById("ID_Product")[0].value ="<?=$row_Receivedetail['ID_Product']?>";
												Amount_Product.value = "<?=$row_Receivedetail[7]?>";
												Product_Remand.value = "<?=$row_Receivedetail['Product_Remand']?>";
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
			$('#receive').addClass('active');
			$('#sub2').show();
			$('#receivelist').css({background: "transparent"});
			$('#receivedetail').css({background: "#e8e8e8"});
		});
	</script>
	<?php include("../fragments/footer.php");?>
</footer>
</body>
</html>
<?php } ?>