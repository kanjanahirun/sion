<?php
session_start(); 

include("../connect/connect.php");

if (empty($_SESSION['Username'])) {
    if (empty($_SESSION['Username']) || empty($_SESSION['status']) || empty($_SESSION['name'])) {
        echo alert('กรุณาเข้าสู่ระบบ Admin ก่อน');
        echo location("../login.php");
    }
}else{
    if($_SESSION['ID_Status'] == "s002"){
        echo location("./addorder.php");
    }else{

if (!empty($_POST['Button'])) {
    $button = $_POST['Button'];
    $Flag = true;

    if ($button == 'เพิ่มข้อมูล') {
        $strCount = "SELECT * FROM prefix ORDER BY ID_Prefix DESC LIMIT 1";
        $objQueryCount = mysql_query($strCount);
        $Count_prefix = mysql_fetch_array($objQueryCount);
        $NUMCount = substr($Count_prefix["ID_Prefix"], -1);
        $nextNum = $NUMCount + 1;
        $Prefix_num = substr($Count_prefix["ID_Prefix"], 0, 3);

        $strEmp_ID = "" . ($Prefix_num . "" . $nextNum);
        //echo "<script type='text/javascript'>alert('กรุณาเข้าสู่ระบบ Admin ก่อน')</script>"; 
        //$sql ="INSERT INTO prefix (ID_Prefix, Name_Prefix) VALUES ('$ID_Prefix', '$Name_Prefix')";
        $sql = "INSERT INTO prefix (ID_Prefix, Name_Prefix) VALUES ('" . $_POST["ID_Prefix"] . "', '" . $_POST["Name_Prefix"] . "')";
        //บัคที่เพิ่ม ID ซ้ำกันแล้ว ไม่มี Error*********************************************************************
        mysql_query($sql);
        if ($Flag) {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลสำเร็จ')</script>";
        } else {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลผิดพลาด')</script>";
        }
    } elseif ($button == 'แก้ไขข้อมูล') {
        $sql = "UPDATE prefix SET Name_Prefix = '" . $_POST["Name_Prefix"] . "' WHERE ID_Prefix = '" . $_POST["ID_Prefix"] . "'";
        mysql_query($sql);
    } else {
        $sql = "DELETE FROM prefix WHERE ID_Prefix = '" . $_POST["ID_Prefix"] . "'";
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
            <div id ="container">  
                <div class="row">
                    <div class="col-md-2">
                        <?php include("../fragments/sidebar.php"); ?>
                    </div>
                    <div class="col-md-10">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="./base.php">ข้อมูลคำนำหน้าชื่อ</a></li>
                                <li><a href="./employeetype.php">ข้อมูลประเภทพนักงาน</a></li>
                                <li><a href="./unitcount.php">ข้อมูลหน่วยนับ</a></li>
                                <li><a href="./servicetype.php">ข้อมูลประเภทการให้บริการ</a></li>
                                <li role="presentation" class="dropdown" style="float: right;margin-right: -2px;">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" style="min-width: 160px;">
                                        <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ""; ?> <span class="caret" style="float: right;margin-top: 10px;"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="../logout.php">ออกจากระบบ</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="row"> 
                            <div class="padded">
                                <div class="col-md-12">
                                    <?php
                                    $lastsql = "SELECT ID_Prefix From prefix order by ID_Prefix DESC LIMIT 1";
                                    $result = mysql_query($lastsql);
                                    $OldId = mysql_fetch_array($result);
                                    //P 099
                                    //$NewId = generateID($OldId['ID_Prefix'],1); 
                                    //generateID(ไอดีตัวสุดท้าย,จำนวนตัวอักษรที่อยู่ในไอดีนั้นๆ เช่น P099 ก็คือ มีแค่ 1 ตัว );
                                    $new_id = mysql_result(mysql_query("Select Max(substr(ID_Prefix,-3))+1 as MaxID from prefix"), 0, "MaxID");
                                    if ($new_id == '') { // ถ้าได้เป็นค่าว่าง หรือ null ก็แสดงว่ายังไม่มีข้อมูลในฐานข้อมูล
                                        $NID_Prefix = "P001";
                                    } else {
                                        $NID_Prefix = "P" . sprintf("%03d", $new_id); //ถ้าไม่ใช่ค่าว่าง
                                    }
                                    ?>
                                    <form name="form1" method="post" action="" style="width:84%;">
                                        <center>
                                            <label style="margin-left: -70px;">รหัสคำนำหน้า</label>
                                            <br>
                                            <input style="background: #C0F9BD;width: 25%;" type="text" class="form-control" name="ID_Prefix" id="ID_Prefix" required placeholder="รหัสคำนำหน้า" value="<?php echo $NID_Prefix; ?>" maxlength="20"> 
                                            <br>
                                            <label style="margin-left: -100px;">คำนำหน้าชื่อ</label><font color="red">*</font>
                                            <br>
                                            <input style="background: #C0F9BD;width: 25%;" type="text" class="form-control" name="Name_Prefix" id="Name_Prefix" required placeholder="ชื่อคำนำหน้า" value="" > 
                                            <br>

                                            <input onclick="return checkPrefix();" id="add" type="submit" class="btn btn-primary" name="Button" value="เพิ่มข้อมูล">
                                            <input id="update" type="submit" class="btn btn-warning" name="Button" value="แก้ไขข้อมูล"> 
                                            <input onclick="return checkIdPrefix();" id="delete" type="submit" class="btn btn-danger" name="Button" value="ลบข้อมูล">
                                            <input id="cancle" type="reset" class="btn btn-default" name="Button" value="ยกเลิก">
                                        </center> 
                                    </form>
                                    <script type="text/javascript">
                                        $('#cancle').click(function () {
                                            $('#add').show();
                                        });

                                        // check คำนำนหน้าที่มีแล้ว
                                        var result = false;
                                        $('#Name_Prefix').change(function () {
                                            var Name_Prefix = $('#Name_Prefix').val();
                                            var json = {'Name_Prefix': Name_Prefix};
                                            $.post("./base.service.php", json).done(function (data) {
                                                var prefix = JSON.parse(data);
                                                if (prefix.ID_Prefix > 0) {
                                                    alert("คำนำหน้าชื่อนี้ได้มีการเพิ่มข้อมูลเข้าไปในระบบแล้ว");
                                                    result = false;
                                                } else {
                                                    result = true;
                                                }
                                            });
                                        });
                                        function checkPrefix() {
                                            if (!result) {
                                                alert("คำนำหน้าชื่อนี้ได้มีการเพิ่มข้อมูลเข้าไปในระบบแล้ว");
                                            }
                                            return result;
                                        }

                                        // check คำที่ใช้จะลบไม่ได้
                                        var rsId = false;
                                        var text = "คำนำหน้าชื่อนี้ถูกใช้อยู่ไม่สามารถลบได้"; 
                                        function checkIdPrefix() {
                                            if (!rsId) {
                                                alert(text);
                                            }
                                            return rsId;
                                        }
                                    </script>
                                </div>  
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-md-12" align="center"> 
                                <?php
                                $sql = "SELECT * FROM prefix ";
                                $query = mysql_query($sql);
                                //$objResult = mysql_fetch_array($objQuery);
                                ?>
                                <div class="bs-example">
                                    <div class="panel panel-default" style="width:35%";>
                                        <!-- Default panel contents -->
                                        <div class="panel-heading"><h4>ข้อมูลคำนำหน้าชื่อ</h4></div> 
                                        <!-- Table -->
                                        <div class="mygrid-wrapper-div" style="height: 40%;">
                                            <table class="table" align="center">
                                                <thead>
                                                    <tr>
                                                        <th><center>รหัสคำนำหน้า</center></th>
                                                <th><center>คำนำหน้าชื่อ</center></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row_prefix = mysql_fetch_array($query)) { ?>
                                                        <tr>
                                                            <td  style="text-align:center;">
                                                                <a id="<?= $row_prefix['ID_Prefix'] ?>" class="point">
                                                                    <?php echo $row_prefix['ID_Prefix']; ?>
                                                                </a>
                                                            </td>
                                                            <td style="text-align:center;"><?php echo $row_prefix['Name_Prefix']; ?></td>
                                                        </tr>
                                                    <script type="text/javascript">
                                                        $("#<?= $row_prefix['ID_Prefix'] ?>").click(function () {
                                                            $('#add').hide();
                                                            ID_Prefix.value = "<?= $row_prefix['ID_Prefix'] ?>";
                                                            Name_Prefix.value = "<?= $row_prefix['Name_Prefix'] ?>";
                                                            
                                                            // check คำที่ใช้จะลบไม่ได้
                                                            var json = {'ID_Prefix': "<?= $row_prefix['ID_Prefix'] ?>", 'table': "customers"};
                                                            $.post("./base.service.php", json).done(function (data) {
                                                                var customers = JSON.parse(data);
                                                                var jsoni = {'ID_Prefix': "<?= $row_prefix['ID_Prefix'] ?>", 'table': "employees"};
                                                                $.post("./base.service.php", jsoni).done(function (data) {
                                                                    var employees = JSON.parse(data);
                                                                    if (customers.ID_Prefix > 0 || employees.ID_Prefix > 0) { 
                                                                        rsId = false;
                                                                    } else {
                                                                        rsId = true;
                                                                    }
                                                                }); 
                                                            });
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
                    $('#base').addClass('active');
                });
            </script>
            <?php include("../fragments/footer.php"); ?>
        </footer>
    </body>
</html>
<?php } } ?>