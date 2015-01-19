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
if (!empty($_POST['Button'])) {
    $button = $_POST['Button'];
    //$Flag = true;
    if ($button == 'เพิ่มข้อมูล') {

        $strCount = "SELECT * FROM receive ORDER BY ID_Receive DESC LIMIT 1";
        $objQueryCount = mysql_query($strCount);
        $Count_prefix = mysql_fetch_array($objQueryCount);
        $NUMCount = substr($Count_prefix["ID_Receive"], -1);
        $nextNum = $NUMCount + 1;
        $Prefix_num = substr($Count_prefix["ID_Receive"], 0, 3);

        $strEmp_ID = "" . ($Prefix_num . "" . $nextNum);
        //echo "<script type='text/javascript'>alert('กรุณาเข้าสู่ระบบ Admin ก่อน')</script>";

        $date = tranformDate($_POST["Date_Receive"]);

        //$sql ="INSERT INTO prefix (ID_Prefix, Name_Prefix) VALUES ('$ID_Prefix', '$Name_Prefix')";
        $sql = "INSERT INTO receive VALUES ('" . $_POST["ID_Receive"] . "', '" . $date . "', '" . $_POST["ID_Emp"] . "', '" . $_POST["ID_Company"] . "', '" . $_POST["ID_Order"] . "')";

        //บัคที่เพิ่ม ID ซ้ำกันแล้ว ไม่มี Error*********************************************************************
        mysql_query($sql);
        if ($Flag) {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลสำเร็จ')</script>";
        }
        // else
        // {
        // 	echo "<script type='text/javascript'>alert('เพิ่มข้อมูลผิดพลาด')</script>";
        // }
    } elseif ($button == 'แก้ไขข้อมูล') {
        //$sql = "UPDATE Employees SET ID_Prefix, FName_Emp, LName_Emp, Tel_Emp, Salary, ID_TypeEmp, personal_ID = '".$_POST["ID_Prefix"]."', '".$_POST["FName_Emp"]."', '".$_POST["LName_Emp"]."', '".$_POST["Tel_Emp"]."', '".$_POST["Salary"]."', '".$_POST["ID_TypeEmp"]."', '".$_POST["personal_ID"]."'";
        $date = tranformDate($_POST["Date_Receive"]);
        $sql = "UPDATE receive SET Date_Receive = '" . $date . "',ID_Emp = '" . $_POST["ID_Emp"] . "',ID_Company = '" . $_POST["ID_Company"] . "',ID_Order = '" . $_POST["ID_Order"] . "' WHERE ID_Receive = '" . $_POST["ID_Receive"] . "'";

        mysql_query($sql);
    } elseif ($button == 'ลบข้อมูล') {
        $sql = "DELETE FROM receive WHERE ID_Receive = '" . $_POST["ID_Receive"] . "'";
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
            <div id="container">
                <div class="row">
                    <div class="col-md-2">
<?php include("../fragments/sidebar.php"); ?>
                    </div>
                    <div class="col-md-10">
                        <div class="col-md-12">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="active">
                                        <a>
                                            จัดการข้อมูลการรับสินค้า 
                                        </a>
                                        </div>

                                        <div class="receivedetail.php">
                                            <form name="form1" method="post" action="">
                                                <div class="row">
                                                    <div class="padform">
<?php
$lastsql = "SELECT ID_Receive From receive order by ID_Receive DESC LIMIT 1";
$result = mysql_query($lastsql);
$OldId2 = mysql_fetch_array($result);

$NewId2 = generateID2($OldId2['ID_Receive'], 2);
//$NewId = generateIDbyFix($OldId['ID_Order'],2,'OR');
//generateID(ไอดีตัวสุดท้าย,จำนวนตัวอักษรที่อยู่ในไอดีนั้นๆ เช่น P099 ก็คือ มีแค่ 1 ตัว );
?>
                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="input-group"style="width:65%;">
                                                                        <label>รหัสการรับสินค้า</label><input name="ID_Receive" id="ID_Receive" placeholder="รหัสการรับสินค้า" value="<?php echo $NewId2; ?>"length="5" style="background: #C0F9BD" class="form-control">
                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-group"style="width:65%;">
                                                                        <label>รหัสการสั่งสินค้า</label>

                                                                        <select name="ID_Order" id="ID_Order" class="idropdown" placeholder="รหัสการสั่งสินค้า">
                                                                            <option value="" style="background: #C0F9BD">รหัสการสั่งสินค้า</option>
<?php
$sql = "SELECT * FROM orders ORDER BY ID_Order ASC";
$query = mysql_query($sql);
while ($objResult = mysql_fetch_array($query)) {
    ?>
                                                                                <option value="<?= $objResult["ID_Order"]; ?>" style="background: #C0F9BD">
    <?= $objResult["ID_Order"]; ?>
                                                                                </option>
    <?php
}
?>
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class = "row">
                                                                <div class="col-lg-6">
                                                                    <div class="input-group"style="width:64%;">
                                                                        <label>ชื่อบริษัท</label>

                                                                        <select name="ID_Company" id="ID_Company" class="idropdown" placeholder="ชื่อบริษัท">
                                                                            <option value="" style="background: #C0F9BD">ชื่อบริษัท</option>
<?php
$sql = "SELECT * FROM company ORDER BY ID_Company ASC";
$query = mysql_query($sql);
while ($objResult = mysql_fetch_array($query)) {
    ?>
                                                                                <option value="<?= $objResult["ID_Company"]; ?>" style="background: #C0F9BD">
    <?= $objResult["Name_Company"]; ?>
                                                                                </option>
    <?php
}
?>
                                                                        </select>

                                                                    </div>

                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label>วันทีรับสินค้า</label><br>
                                                                    <input class="form-control point" name="Date_Receive" id="datetimepicker1" type="text" placeholder="คลิกเพื่อเลือกวันที่" style="width: 67%;">
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
                                                                        <label>ชื่อพนักงาน</label>

                                                                        <select name="ID_Emp" id="ID_Emp" class="idropdown" placeholder="รหัสพนักงาน">
                                                                            <option value="" style="background: #C0F9BD">ชื่อพนักงาน</option>
<?php
$sql = "SELECT * FROM employees ORDER BY ID_Emp ASC";
$query = mysql_query($sql);
while ($objResult = mysql_fetch_array($query)) {
    ?>
                                                                                <option value="<?= $objResult["ID_Emp"]; ?>" style="background: #C0F9BD">
    <?= $objResult["FName_Emp"]; ?>
                                                                                </option>
    <?php
}
?>
                                                                        </select>

                                                                    </div>

                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <center STYLE="margin-top: -6%; margin-bottom: 2%;">
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
                                                    <div class="col-md-12">

                                                        <?
                                                        $strSQL = "SELECT * FROM employees e, orders o, receive r,company c WHERE e.ID_Emp = r.ID_Emp AND r.ID_Company = o.ID_Company AND o.ID_Company = c.ID_Company AND r.ID_Company = c.ID_Company ORDER BY r.ID_Receive ASC";
                                                        $objQuery = mysql_query($strSQL);
                                                        ?>

                                                        <div class="bs-example">
                                                            <div class="panel panel-default">
                                                                <!-- Default panel contents -->
                                                                <div class="panel-heading"><h4>ข้อมูลการรับสินค้า</h4></div>
                                                                <!-- Table -->
                                                                <div class="mygrid-wrapper-div">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>รหัสการรับสินค้า</th>
                                                                                <th>รหัสการสั่งสินค้า</th>
                                                                                <th>ชื่อพนักงาน</th>
                                                                                <th>ชื่อบริษัท</th>
                                                                                <th>วันที่รับสินค้า</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            <?
                                                                            $strSQL = "SELECT * FROM employees e, orders o, receive r,company c WHERE e.ID_Emp = r.ID_Emp AND r.ID_Company = o.ID_Company AND o.ID_Company = c.ID_Company AND r.ID_Company = c.ID_Company ORDER BY r.ID_Receive ASC";
                                                                            $objQuery = mysql_query($strSQL);
                                                                            ?>
<?php while ($row_receive = mysql_fetch_array($query)) { ?>

                                                                                <tr>
                                                                                    <td>
                                                                                        <a id="<?= $row_receive['ID_Receive'] ?>" class="point">
    <?php echo $row_receive['ID_Receive']; ?>
                                                                                        </a>
                                                                                    </td>
                                                                                    <td><?php echo $row_receive['ID_Order']; ?></td>
                                                                                    <td><?php echo $row_receive['FName_Emp']; ?></td>
                                                                                    <td><?php echo $row_receive['Name_Company']; ?></td>
                                                                                    <td><?php echo reverseDate($row_receive['Date_Receive']); ?></td>
                                                                                </tr>


                                                                            <script type="text/javascript">
                                                                                $("#<?= $row_receive['ID_Receive'] ?>").click(function () {
                                                                                    $('#add').hide();
                                                                                    ID_Receive.value = "<?= $row_receive['ID_Receive'] ?>";
                                                                                    ID_Order.value = "<?= $row_receive['ID_Order'] ?>";
                                                                                    document.getElementById("ID_Emp")[0].text = "<?= $row_receive['FName_Emp'] ?>";
                                                                                    document.getElementById("ID_Emp")[0].value = "<?= $row_receive['ID_Emp'] ?>";
                                                                                    document.getElementById("ID_Company")[0].text = "<?= $row_receive['Name_Company'] ?>";
                                                                                    document.getElementById("ID_Company")[0].value = "<?= $row_receive['ID_Company'] ?>";
                                                                                    datetimepicker1.value = "<?= reverseDate($row_receive['Date_Receive']) ?>";
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
                                                    $('#receive').addClass('active');
                                                    $('#sub2').show();
                                                    $('#receivelist').css({background: "#e8e8e8"});
                                                    $('#receivedetail').css({background: "transparent"});
                                                });
                                            </script>
<?php include("../fragments/footer.php"); ?>
                                        </footer>
                                        </body>
                                        </html>
<?php } ?>