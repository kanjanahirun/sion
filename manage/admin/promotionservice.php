<?php
session_start();
include("../connect/connect.php");

if (empty($_SESSION['Username'])) {
    if (empty($_SESSION['Username']) || empty($_SESSION['status']) || empty($_SESSION['name'])) {
        echo alert('กรุณาเข้าสู่ระบบ Admin ก่อน');
        echo location("../login.php");
    }
}

//echo $nextNum;
if (!empty($_POST['Button'])) {
    $button = $_POST['Button'];
    //$Flag = true;
    if ($button == 'เพิ่มข้อมูล') {

        $strCount = "SELECT * FROM service_promotion ORDER BY ID_SerPro DESC LIMIT 1";
        $objQueryCount = mysql_query($strCount);
        $Count_prefix = mysql_fetch_array($objQueryCount);
        $NUMCount = substr($Count_prefix["ID_SerPro"], -1);
        $nextNum = $NUMCount + 1;
        $Prefix_num = substr($Count_prefix["ID_SerPro"], 0, 3);

        $strEmp_ID = "" . ($Prefix_num . "" . $nextNum);
        //echo "<script type='text/javascript'>alert('กรุณาเข้าสู่ระบบ Admin ก่อน')</script>"; 
        //$sql ="INSERT INTO prefix (ID_Prefix, Name_Prefix) VALUES ('$ID_Prefix', '$Name_Prefix')";
        $sql = "INSERT INTO service_promotion (ID_SerPro, Promotion_Name, Discount, Start_Date, End_Date) VALUES ('" . $_POST["ID_SalePro"] . "', '" . $_POST["Promotion_Name"] . "', '" . $_POST["Discount"] . "', '" . $_POST["Start_Date"] . "', '" . $_POST["End_Date"] . "')";
        //บัคที่เพิ่ม ID ซ้ำกันแล้ว ไม่มี Error*********************************************************************
        mysql_query($sql);
        if ($Flag) {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลสำเร็จ')</script>";
        } else {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลผิดพลาด')</script>";
        }
    } elseif ($button == 'แก้ไขข้อมูล') {
        //$sql = "UPDATE Employees SET ID_Prefix, FName_Emp, LName_Emp, Tel_Emp, Salary, ID_TypeEmp, personal_ID = '".$_POST["ID_Prefix"]."', '".$_POST["FName_Emp"]."', '".$_POST["LName_Emp"]."', '".$_POST["Tel_Emp"]."', '".$_POST["Salary"]."', '".$_POST["ID_TypeEmp"]."', '".$_POST["personal_ID"]."'";
        $sql = "UPDATE service_promotion SET ID_SerPro = '" . $_POST["ID_SerPro"] . "',Promotion_Name = '" . $_POST["Promotion_Name"] . "',Discount = '" . $_POST["Discount"] . "',Start_Date = '" . $_POST["Start_Date"] . "',End_Date = '" . $_POST["End_Date"] . "' WHERE ID_SerPro = '" . $_POST["ID_SerPro"] . "'";
        mysql_query($sql);
    } else {
        $sql = "DELETE FROM service_promotion WHERE ID_SerPro = '" . $_POST["ID_SerPro"] . "'";
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
                                    <li><a href="./promotionsale.php">โปรโมชันการขาย</a></li>
                                    <li class="active dropdown">
                                        <a class="point dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;">
                                            โปรโมชันการให้บริการ <span class="caret"></span>
                                        </a>
                                    </li> 
                                </ul>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="./promotionservice.php">รายละเอียดโปรโมชันการให้บริการ</a></li>
                                    </li>
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
                            <div class="promotionservice">
<?php
$lastsql = "SELECT ID_SalePro From sale_promotion order by ID_SalePro DESC LIMIT 1";
$result = mysql_query($lastsql);
$OldId = mysql_fetch_array($result);
//P 099
$NewId = generateID($OldId['ID_SalePro'], 2);
//generateID(ไอดีตัวสุดท้าย,จำนวนตัวอักษรที่อยู่ในไอดีนั้นๆ เช่น P099 ก็คือ มีแค่ 1 ตัว );
?>
                                <form name="form1" method="post" action="">
                                    <div class="row"> 
                                        <div class="padform"> 
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="input-group"style="width:65%;">
                                                            <label>รหัสโปรโมชันการขาย *</label>
                                                            <input name="ID_SalePro" id="ID_SalePro" placeholder="รหัสโปรโมชันการขาย" maxlength="5" value="<?php echo $NewId; ?>" style="background: #C0F9BD" class="form-control">
                                                        </div> 

                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>วันที่เริ่ม</label><br>
                                                        <input class="form-control point" name="Start_Date" id="datetimepicker1" type="text" placeholder="คลิกเพื่อเลือกวันที่" style="width: 67%;">
                                                        <script type="text/javascript">
                                                            jQuery('#datetimepicker1').datetimepicker({
                                                                lang: 'th',
                                                                i18n: {
                                                                    th: {
                                                                        months: [
                                                                            'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน',
                                                                            'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม',
                                                                            'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม',
                                                                        ],
                                                                        dayOfWeek: [
                                                                            "So.", "Mo", "Di", "Mi",
                                                                            "Do", "Fr", "Sa.",
                                                                        ]
                                                                    }
                                                                },
                                                                timepicker: false,
                                                                format: 'd/m/Y'
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="input-group"style="width:65%;">
                                                            <label>ชื่อโปรโมชันการขาย</label>
                                                            <input name="Promotion_Name" id="Promotion_Name" placeholder="ชื่อโปรโมชันการขาย" maxlength="20" style="background: #C0F9BD" class="form-control">
                                                        </div>
                                                        <div class="input-group"style="width:65%;">
                                                            <label>อัตราส่วนลด (%)</label>
                                                            <input name="Discount" id="Discount" placeholder="อัตราส่วนลด (%)" maxlength="6" style="background: #C0F9BD" class="form-control">
                                                        </div>  
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>วันที่สิ้นสุด</label><br>
                                                        <input class="form-control point" name="End_Date" id="datetimepicker2" type="text" placeholder="คลิกเพื่อเลือกวันที่" style="width: 67%;">
                                                        <script type="text/javascript">
                                                            jQuery('#datetimepicker2').datetimepicker({
                                                                lang: 'th',
                                                                i18n: {
                                                                    th: {
                                                                        months: [
                                                                            'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน',
                                                                            'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม',
                                                                            'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม',
                                                                        ],
                                                                        dayOfWeek: [
                                                                            "So.", "Mo", "Di", "Mi",
                                                                            "Do", "Fr", "Sa.",
                                                                        ]
                                                                    }
                                                                },
                                                                timepicker: false,
                                                                format: 'd/m/Y'
                                                            });
                                                        </script>
                                                    </div>
                                                </div>

                                            </div> 
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <center>
                                                <br>
                                                <input id="add" type="submit" class="btn btn-primary" name="Button" value="เพิ่มข้อมูล">
                                                <input id="update"type="submit" class="btn btn-warning" name="Button" value="แก้ไขข้อมูล">
                                                <input id="delete"type="submit" class="btn btn-danger" name="Button" value="ลบข้อมูล">
                                                <input id="cancle" type="reset" class="btn btn-default" name="Button" value="ยกเลิก">
                                                <script type="text/javascript">
                                                    $('#cancle').click(function () {
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
$sql = "SELECT * FROM sale_promotion ";
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
                                                                <th>รหัสโปรโมชันการขาย</th>
                                                                <th>ชื่อโปรโมชัน</th>
                                                                <th>อัตราส่วนลด (%)</th>
                                                                <th>วันที่เริ่ม</th>
                                                                <th>วันที่สิ้นสุด</th>
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
                                                                    <td><?php echo $row_prefix['Promotion_Name']; ?></td>
                                                                    <td><?php echo $row_prefix['Discount']; ?></td>
                                                                    <td><?php echo $row_prefix['Start_Date']; ?></td>
                                                                    <td><?php echo $row_prefix['End_Date']; ?></td>
                                                                </tr>
                                                            <script type="text/javascript">
                                                                $("#<?= $row_prefix['ID_SalePro'] ?>").click(function () {
                                                                    $('#add').hide();
                                                                    ID_SalePro.value = "<?= $row_prefix['ID_SalePro'] ?>";
                                                                    Promotion_Name.value = "<?= $row_prefix['Promotion_Name'] ?>";
                                                                    Discount.value = "<?= $row_prefix['Discount'] ?>";
                                                                    Start_Date.value = "<?= $row_prefix['Start_Date'] ?>";
                                                                    End_Date.value = "<?= $row_prefix['End_Date'] ?>";
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
                    </div>
                    </article>
                    <footer>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#promotionsale').addClass('active');
                            });
                        </script>
<?php include("../fragments/footer.php"); ?>
                    </footer>
                    </body>
                    </html>
