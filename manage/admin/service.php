<?php
session_start();
include("../connect/connect.php");

if (empty($_SESSION['Username'])) {
    if (empty($_SESSION['Username']) || empty($_SESSION['status']) || empty($_SESSION['name'])) {
        echo alert('กรุณาเข้าสู่ระบบ Admin ก่อน');
        echo location("../login.php");
    }
}else {
    if($_SESSION['ID_Status'] == "s002"){
        echo location("./addorder.php");
    }else{
//$strSQL = "SELECT * FROM sale_promotion WHERE username = '" . $_SESSION['Username'] . "' ";
//$objQuery = mysql_query($strSQL);
//$objResult = mysql_fetch_array($objQuery);

//echo $nextNum;
if (!empty($_POST['Button'])) {
    $button = $_POST['Button'];
    //$Flag = true;
    if ($button == 'เพิ่มข้อมูล') {

        $strCount = "SELECT * FROM sale_promotion ORDER BY ID_SalePro DESC LIMIT 1";
        $objQueryCount = mysql_query($strCount);
        $Count_prefix = mysql_fetch_array($objQueryCount);
        $NUMCount = substr($Count_prefix["ID_SalePro"], -1);
        $nextNum = $NUMCount + 1;
        $Prefix_num = substr($Count_prefix["ID_SalePro"], 0, 3);

        $strEmp_ID = "" . ($Prefix_num . "" . $nextNum);
        //echo "<script type='text/javascript'>alert('กรุณาเข้าสู่ระบบ Admin ก่อน')</script>"; 
        //$sql ="INSERT INTO prefix (ID_Prefix, Name_Prefix) VALUES ('$ID_Prefix', '$Name_Prefix')";
        $sql = "INSERT INTO sale_promotion (ID_SalePro, Promotion_Name, Discount, Start_Date, End_Date) VALUES ('" . $_POST["ID_SalePro"] . "', '" . $_POST["Promotion_Name"] . "', '" . $_POST["Discount"] . "', '" . $_POST["Start_Date"] . "', '" . $_POST["End_Date"] . "')";
        //บัคที่เพิ่ม ID ซ้ำกันแล้ว ไม่มี Error*********************************************************************
        mysql_query($sql);
        if ($Flag) {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลสำเร็จ')</script>";
        } else {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลผิดพลาด')</script>";
        }
    } elseif ($button == 'แก้ไขข้อมูล') {
        $sql = "UPDATE sale_promotion SET ID_SalePro = '" . $_POST["ID_SalePro"] . "' ,Promotion_Name = '" . $_POST["Promotion_Name"] . "',Discount = '" . $_POST["Discount"] . "',Start_Date = '" . $_POST["Start_Date"] . "',End_Date = '" . $_POST["End_Date"] . "',personal_ID = '" . $_POST["personal_ID"] . "' WHERE ID_SalePro = '" . $_POST["ID_SalePro"] . "'";
        mysql_query($sql);
    } else {
        $sql = "DELETE FROM sale_promotion WHERE ID_SalePro = '" . $_POST["ID_SalePro"] . "'";
        mysql_query($sql);
    }
}
?>
<!DOCTYP html>
<html>
    <head>
        <title> ร้านศรีอ้น แฮร์ & สปาร์ </title>

<?php include("../fragments/libmanage.php"); ?>

    </head>

    <body id="bg">
        <nav>
<?php include("../fragments/header.php"); ?>
        </nav>
        <article>
            <div class="container">  
                <div class="row">
                    <div class="col-md-3">
        <?php include("../fragments/sidebar.php"); ?>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="active"><a href="./base.php">ข้อมูลการให้บริการ</a></li>
                                    <li role="presentation" class="dropdown" style="float: right;margin-right: -2px;">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" style="min-width: 160px;">
<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ""; ?> <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="../logout.php">ออกจากระบบ</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <form name="form1" method="post" action="">
                                <div class="row"> 
                                    <div class="padform"> 
                                        <div class="col-lg-6">
                                            <div class="input-group"style="width:65%;">
                                                <label>รหัสการให้บริการ *</label>
                                                <input name="ID_SalePro" id="ID_SalePro" placeholder="รหัสการให้บริการ" maxlength="4" style="background: #C0F9BD" class="form-control">
                                            </div> 
                                            <div class="input-group"style="width:65%;">
                                                <label>ชื่อการให้บริการ</label>
                                                <input name="ID_SalePro" id="ID_SalePro" placeholder="ชื่อการให้บริการ" maxlength="4" style="background: #C0F9BD" class="form-control">
                                            </div>
                                            <div class="input-group"style="width:65%;">
                                                <label>ราคา</label>
                                                <input name="Discount" id="Discount" placeholder="ราคา" maxlength="4" style="background: #C0F9BD" class="form-control">
                                            </div>  

                                            <div class="input-group" style="width:40%;">
                                                <label>วันที่ให้บริการ</label><br>
                                                <select name="Discount" id="Discount" class="idropdown">
                                                    <option value="D0">วัน</option>
                                                    <option value="D1">01</option>
                                                    <option value="D2">02</option>	
                                                    <option value="D3">03</option>
                                                    <option value="D4">04</option>
                                                    <option value="D5">05</option>	
                                                    <option value="D6">06</option>
                                                    <option value="D7">07</option>
                                                    <option value="D8">08</option>	
                                                    <option value="D9">09</option>
                                                    <option value="D10">10</option>
                                                    <option value="D11">11</option>	
                                                    <option value="D12">12</option>
                                                    <option value="D13">13</option>
                                                    <option value="D14">14</option>	
                                                    <option value="D15">15</option>
                                                    <option value="D16">16</option>
                                                    <option value="D17">17</option>	
                                                    <option value="D18">18</option>
                                                    <option value="D19">19</option>
                                                    <option value="D20">20</option>	
                                                    <option value="D21">21</option>
                                                    <option value="D22">22</option>
                                                    <option value="D23">23</option>	
                                                    <option value="D24">24</option>
                                                    <option value="D25">25</option>
                                                    <option value="D26">26</option>	
                                                    <option value="D27">27</option>
                                                    <option value="D28">28</option>
                                                    <option value="D29">29</option>	
                                                    <option value="D30">30</option>
                                                    <option value="D31">31</option>
                                                </select>

                                                <select name="ID_Prefix" id="ID_Prefix" class="idropdown">
                                                    <option value="M0">เดือน</option>
                                                    <option value="M1">มกราคม</option>
                                                    <option value="M2">กุมภาพันธ์</option>
                                                    <option value="M3">มีนาคม</option>
                                                    <option value="M4">เมษายน</option>
                                                    <option value="M5">พฤษภาคม</option>
                                                    <option value="M6">มิถุนายน</option>
                                                    <option value="M7">กรกฎาคม</option>
                                                    <option value="M8">สิงหาคม</option>
                                                    <option value="M9">กันยายน</option>
                                                    <option value="M10">ตุลาคม</option>
                                                    <option value="M11">พฤศจิกายน</option>
                                                    <option value="M12">ธันวาคม</option>
                                                </select>

                                                <select name="ID_Prefix" id="ID_Prefix" class="idropdown">
                                                    <option value="Y0">ปี</option>
                                                    <option value="Y1">2014</option>
                                                    <option value="Y2">2013</option>
                                                    <option value="Y3">2012</option>
                                                    <option value="Y4">2011</option>
                                                    <option value="Y5">2010</option>
                                                    <option value="Y6">2009</option>
                                                    <option value="Y7">2008</option>
                                                    <option value="Y8">2007</option>
                                                    <option value="Y9">2006</option>
                                                    <option value="Y10">2005</option>
                                                    <option value="Y11">2004</option>
                                                    <option value="Y12">2003</option>
                                                    <option value="Y13">2002</option>
                                                    <option value="Y14">2001</option>
                                                    <option value="Y15">2000</option>
                                                    <option value="Y16">1999</option>
                                                    <option value="Y17">1998</option>
                                                    <option value="Y18">1997</option>
                                                    <option value="Y19">1996</option>
                                                    <option value="Y20">1995</option>
                                                    <option value="Y21">1994</option>
                                                    <option value="Y22">1993</option>
                                                    <option value="Y23">1992</option>
                                                    <option value="Y24">1991</option>
                                                    <option value="Y25">1990</option>
                                                </select>

                                            </div>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <center>
                                            <input type="submit" class="btn btn-primary" name="Button" value="เพิ่มข้อมูล">
                                            <input type="submit" class="btn btn-warning" name="Button" value="แก้ไขข้อมูล">
                                            <input type="submit" class="btn btn-danger" name="Button" value="ลบข้อมูล">
                                        </center>
                                    </div>
                                </div>
                            </form>
                            <div class="row"> 
                                <div class="col-md-12"> 
<?php
$sql = "SELECT * FROM employees e, prefix p, typeemp t WHERE e.ID_Prefix = p.ID_Prefix AND t.ID_TypeEmp = e.ID_TypeEmp ORDER BY e.ID_Emp ASC";
$query = mysql_query($sql);
//$objResult = mysql_fetch_array($objQuery);
?>
                                    <div class="bs-example">
                                        <div class="panel panel-default">
                                            <!-- Default panel contents -->
                                            <div class="panel-heading"><h4>ข้อมูลโปรโมชันการขาย</h4></div> 
                                            <!-- Table -->
                                            <div class="mygrid-wrapper-div">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัสพนักงาน</th>
                                                            <th>คำนำหน้าชื่อ</th>
                                                            <th>ชื่อพนักงาน</th>
                                                            <th>นามสกุล</th>
                                                            <th>เบอร์ติดต่อ</th>
                                                            <th>รหัสประจำตัวประชาชน</th>
                                                            <th>รหัสประเภทพนักงาน</th>
                                                            <th>อัตราค่าจ้าง</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
<?php while ($row_prefix = mysql_fetch_array($query)) { ?>
                                                            <tr>
                                                                <td>
                                                                    <a id="<?= $row_prefix['ID_SalePro'] ?>" class="point">
    <?php echo $row_prefix['ID_SalePro']; ?>
                                                                    </a>
                                                                </td>
                                                                <td><?php echo $row_prefix['ID_Prefix']; ?></td>
                                                                <td><?php echo $row_prefix['FName_Emp']; ?></td>
                                                                <td><?php echo $row_prefix['LName_Emp']; ?></td>
                                                                <td><?php echo $row_prefix['Tel_Emp']; ?></td>
                                                                <td><?php echo $row_prefix['personal_ID']; ?></td>
                                                                <td><?php echo $row_prefix['ID_TypeEmp']; ?></td>
                                                                <td><?php echo $row_prefix['Salary']; ?></td>
                                                            </tr>
                                                        <script type="text/javascript">
                                                            $("#<?= $row_prefix['ID_SalePro'] ?>").click(function () {
                                                                ID_SalePro.value = "<?= $row_prefix['ID_SalePro'] ?>";
                                                                ID_Prefix.value = "<?= $row_prefix['ID_Prefix'] ?>";
                                                                FName_Emp.value = "<?= $row_prefix['FName_Emp'] ?>";
                                                                LName_Emp.value = "<?= $row_prefix['LName_Emp'] ?>";
                                                                Tel_Emp.value = "<?= $row_prefix['Tel_Emp'] ?>";
                                                                personal_ID.value = "<?= $row_prefix['personal_ID'] ?>";
                                                                ID_TypeEmp.value = "<?= $row_prefix['ID_TypeEmp'] ?>";
                                                                Salary.value = "<?= $row_prefix['Salary'] ?>";
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
                            $(document).ready(function () {
                                $('#service').addClass('active');
                            });
                        </script>
<?php include("../fragments/footer.php"); ?>
                    </footer>
                    </body>
                    </html>
<?php }} ?>