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
        $sql = "INSERT INTO TypeEmp (ID_TypeEmp, Name_TypeEmp) VALUES ('" . $_POST["ID_TypeEmp"] . "', '" . $_POST["Name_TypeEmp"] . "')";
        mysql_query($sql);
        if ($Flag) {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลสำเร็จ')</script>";
        } else {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลผิดพลาด')</script>";
        }
    } elseif ($button == 'แก้ไขข้อมูล') {
        $sql = "UPDATE TypeEmp SET Name_TypeEmp = '" . $_POST["Name_TypeEmp"] . "' WHERE ID_TypeEmp = '" . $_POST["ID_TypeEmp"] . "'";
        mysql_query($sql);
    } else {
        $sql = "DELETE FROM TypeEmp WHERE ID_TypeEmp = '" . $_POST["ID_TypeEmp"] . "'";
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
                                <li class="active"><a href="./employeetype.php">ข้อมูลประเภทพนักงาน</a></li>
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
                                    $lastsql = "SELECT ID_TypeEmp From TypeEmp order by ID_TypeEmp DESC LIMIT 1";
                                    $result = mysql_query($lastsql);
                                    $OldId = mysql_fetch_array($result);
//TE 01
                                    $NewId = generateID($OldId['ID_TypeEmp'], 2);
//generateID(ไอดีตัวสุดท้าย,จำนวนตัวอักษรที่อยู่ในไอดีนั้นๆ เช่น P099 ก็คือ มีแค่ 1 ตัว );
                                    ?>
                                    <form name="form1" method="post" action="">
                                        <table style="width: 250px;margin: 20px 0 20px 35px;">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        รหัสประเภทพนักงาน
                                                        <br>
                                                        <input type="text" class="form-control" name="ID_TypeEmp" id="ID_TypeEmp" required placeholder="รหัสประเภทพนักงาน"  value="<?php echo $NewId; ?>" maxlength="5" style="background: #C0F9BD">
                                                        <br>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        ชื่อประเภทพนักงาน
                                                        <input type="text" class="form-control" name="Name_TypeEmp" id="Name_TypeEmp" required placeholder="ชื่อประเภทพนักงาน" value="" style="background: #C0F9BD"> 
                                                        <br>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input onclick="return checkTypeEmp();" id="add" type="submit" class="btn btn-primary" name="Button" value="เพิ่มข้อมูล">
                                        <input id="update"type="submit" class="btn btn-warning" name="Button" value="แก้ไขข้อมูล">
                                        <input onclick="return checkIdTypeEmp();" id="delete" type="submit" class="btn btn-danger" name="Button" value="ลบข้อมูล">
                                        <input id="cancle" type="reset" class="btn btn-default" name="Button" value="ยกเลิก">
                                    </form>
                                    <script type="text/javascript">
                                        $('#cancle').click(function () {
                                            $('#add').show();
                                        });

                                        // check คำซ้ำ
                                        var result = false;
                                        $('#Name_TypeEmp').change(function () {
                                            var Name_TypeEmp = $('#Name_TypeEmp').val();
                                            var json = {'Name_TypeEmp': Name_TypeEmp};
                                            console.log(json);
                                            $.post("./employees.service.php", json).done(function (data) {
                                                var emptype = JSON.parse(data);
                                                console.log(emptype);
                                                if (emptype.ID_TypeEmp > 0) {
                                                    alert("ประเภทพนักงานนี้ได้มีการเพิ่มข้อมูลเข้าไปในระบบแล้ว");
                                                    result = false;
                                                } else {
                                                    result = true;
                                                }
                                            });
                                        });
                                        function checkTypeEmp() {
                                            if (!result) {
                                                alert("ประเภทพนักงานนี้ได้มีการเพิ่มข้อมูลเข้าไปในระบบแล้ว");
                                            }
                                            return result;
                                        }

                                        // check คำที่ใช้จะลบไม่ได้
                                        var rsId = false;
                                        var text = "ประเภทพนักงานนี้ถูกใช้อยู่ไม่สามารถลบได้";
                                        function checkIdTypeEmp() {
                                            if (!rsId) {
                                                alert(text);
                                            }
                                            return rsId;
                                        } 
                                    </script>
                                </div>  
                            </div>
                        </div>
                        <div class="row" > 
                            <div class="col-md-12"> 
                                <?php
                                $sql = "SELECT * FROM TypeEmp ";
                                $query = mysql_query($sql); 
                                ?>

                                <div class="bs-example">
                                    <div class="panel panel-default"  style="width: 35%;margin-left: 262px;">
                                        <!-- Default panel contents -->
                                        <div class="panel-heading"><h4>ข้อมูลประเภทพนักงาน</h4></div> 
                                        <!-- Table -->
                                        <div class="mygrid-wrapper-div" style="height: 45%;">
                                            <table class="table" >
                                                <thead>
                                                    <tr>
                                                        <th>รหัสประเภทพนักงาน</th>
                                                        <th>ชื่อประเภทพนักงาน</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row_prefix = mysql_fetch_array($query)) { ?>
                                                        <tr>
                                                            <td>
                                                                <a id="<?= $row_prefix['ID_TypeEmp'] ?>" class="point">
                                                                    <?php echo $row_prefix['ID_TypeEmp']; ?>
                                                                </a>
                                                            </td>
                                                            <td><?php echo $row_prefix['Name_TypeEmp']; ?></td>
                                                        </tr>
                                                    <script type="text/javascript" >
                                                        $("#<?= $row_prefix['ID_TypeEmp'] ?>").click(function () {
                                                            $('#add').hide();
                                                            ID_TypeEmp.value = "<?= $row_prefix['ID_TypeEmp'] ?>";
                                                            Name_TypeEmp.value = "<?= $row_prefix['Name_TypeEmp'] ?>";

                                                            // check คำที่ใช้จะลบไม่ได้
                                                            var json = {'ID_TypeEmp': "<?= $row_prefix['ID_TypeEmp'] ?>"};
                                                            $.post("./employees.service.php", json).done(function (data) {
                                                                var employees = JSON.parse(data); 
                                                                if (employees.ID_TypeEmp > 0) { 
                                                                    rsId = false;
                                                                } else {
                                                                    rsId = true;
                                                                }
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
<?php }} ?>