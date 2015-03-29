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
if (!empty($_POST['Button'])) {
    $button = $_POST['Button'];
    $Flag = true;
    if ($button == 'เพิ่มข้อมูล') {
        $sql = "INSERT INTO Count (ID_Count, Name_Count, Amount_Unit) VALUES ('" . $_POST["ID_Count"] . "', '" . $_POST["Name_Count"] . "'," . $_POST["Amount_Unit"] . ")";

        $Flag = mysql_query($sql);
        if ($Flag) {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลสำเร็จ')</script>";
        } else {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลผิดพลาด')</script>";
        }
    } elseif ($button == 'แก้ไขข้อมูล') {
        $sql = "UPDATE Count SET Name_Count = '" . $_POST["Name_Count"] . "',Amount_Unit = " . $_POST["Amount_Unit"] . " WHERE ID_Count = '" . $_POST["ID_Count"] . "'";
        mysql_query($sql);
    } else {
        $sql = "DELETE FROM Count WHERE ID_Count = '" . $_POST["ID_Count"] . "'";
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
                                <li><a href="./base.php">ข้อมูลคำนำหน้าชื่อ</a></li>
                                <li><a href="./employeetype.php">ข้อมูลประเภทพนักงาน</a></li>
                                <li class="active"><a href="./unitcount.php">ข้อมูลหน่วยนับ</a></li>
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
                                <div class="col-md-12" style="width: 58%;">
                                    <?php
                                    $lastsql = "SELECT ID_Count From Count order by ID_Count DESC LIMIT 1";
                                    $result = mysql_query($lastsql);
                                    $OldId = mysql_fetch_array($result);
                                    //P 099
                                    $NewId = generateID($OldId['ID_Count'], 1);
                                    //generateID(ไอดีตัวสุดท้าย,จำนวนตัวอักษรที่อยู่ในไอดีนั้นๆ เช่น P099 ก็คือ มีแค่ 1 ตัว );
                                    ?>
                                    <form name="form1" method="post" action="" >
                                        รหัสหน่วยนับ
                                        <br>
                                        <input type="text" class="form-control" name="ID_Count" id="ID_Count" required placeholder="รหัสหน่วยนับ" value="<?php echo $NewId; ?>" maxlength="4" style="background: #C0F9BD"> 
                                        <br>
                                        ชื่อหน่วยนับ <font color="red">*</font>
                                        <br>
                                        <input type="text" class="form-control" name="Name_Count" id="Name_Count" required placeholder="ชื่อหน่วยนับ" value="" style="background: #C0F9BD"> 
                                        <br>
                                        <!-- จำนวน/หน่วย <font color="red">*</font> -->
                                        <br>
                                        <input type="hidden" class="form-control" name="Amount_Unit" id="Amount_Unit" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required placeholder="จำนวน/หน่วย" value="1" style="background: #C0F9BD"> 
                                        <br>

                                        <input onclick="return checkUnitCount();" id="add" type="submit" class="btn btn-primary" name="Button" value="เพิ่มข้อมูล">
                                        <input id="update"type="submit" class="btn btn-warning" name="Button" value="แก้ไขข้อมูล">
                                        <input onclick="return checkIDUnitCount();" id="delete" type="submit" class="btn btn-danger" name="Button" value="ลบข้อมูล">
                                        <input id="cancle" type="reset" class="btn btn-default" name="Button" value="ยกเลิก">

                                    </form>
                                    <script type="text/javascript">
                                        $('#cancle').click(function () {
                                            $('#add').show();
                                        });

                                        // check คำซ้ำ
                                        var result = false;
                                        $('#Name_Count').change(function () {
                                            var Name_Count = $('#Name_Count').val();
                                            var json = {'Name_Count': Name_Count};
                                            $.post("./unitcount.service.php", json).done(function (data) {
                                                var unitcount = JSON.parse(data);
                                                if (unitcount.ID_Count > 0) {
                                                    result = false;
                                                } else {
                                                    result = true;
                                                }
                                            });
                                        });
                                        function checkUnitCount() {
                                            if (!result) {
                                                alert("หน่วยนับนี้ได้มีการเพิ่มข้อมูลเข้าไปในระบบแล้ว");
                                            }
                                            return result;
                                        }
                                            var rsId = false;
                                            var text = "คำนำหน้าชื่อนี้ถูกใช้อยู่ไม่สามารถลบได้"; 
                                            function checkIDUnitCount() {
                                                if (!rsId) {
                                                alert(text);
                                            }
                                            return rsId;
                                        }

                                        // รอ.... เช็ค ห้ามลบ

                                    </script>
                                </div>  
                            </div>
                        </div>
                        <div class="row" align="center" style="margin-left: -13%;"> 
                            <div class="padded">
                                <div class="col-md-12" style="width:80%;"> 
                                    <?php
                                    $sql = "SELECT * FROM Count ";
                                    $query = mysql_query($sql);
                                    ?>
                                    <div class="bs-example">
                                        <div class="panel panel-default">
                                            <!-- Default panel contents -->
                                            <div class="panel-heading"><h4>ข้อมูลหน่วยนับ</h4></div> 
                                            <!-- Table -->
                                            <div class="mygrid-wrapper-div" style="height: 45%;">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัสหน่วยนับ</th>
                                                            <th>ชื่อหน่วยนับ</th>
                                                            <!-- <th>จำนวน/หน่วย</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php while ($row_prefix = mysql_fetch_assoc($query)) { ?>
                                                            <tr>
                                                                <td>
                                                                    <a id="<?= $row_prefix['ID_Count'] ?>" class="point">
                                                                        <?php echo $row_prefix['ID_Count']; ?>
                                                                    </a>
                                                                </td>
                                                                <td><?php echo $row_prefix['Name_Count']; ?></td>
                                                                <!-- <td> -->
                                                                    <?php 
                                                                // echo $row_prefix['Amount_Unit']; 
                                                                ?>
                                                            <!-- </td> -->
                                                            </tr>
                                                        <script type="text/javascript">
                                                            $("#<?= $row_prefix['ID_Count'] ?>").click(function () {
                                                                $('#add').hide();
                                                                ID_Count.value = "<?= $row_prefix['ID_Count'] ?>";
                                                                Name_Count.value = "<?= $row_prefix['Name_Count'] ?>";
                                                                Amount_Unit.value = "<?= $row_prefix['Amount_Unit'] ?>";
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
<?php }} ?>