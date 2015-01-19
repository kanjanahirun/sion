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
    //$button = $_REQUEST['Button'];
    $Flag = true;
    if ($button == 'เพิ่มข้อมูล') {
        //echo "<script type='text/javascript'>alert('กรุณาเข้าสู่ระบบ Admin ก่อน')</script>"; 
        //$sql ="INSERT INTO prefix (ID_Prefix, Name_Prefix) VALUES ('$ID_Prefix', '$Name_Prefix')";
        $sql = "INSERT INTO TypeSer (ID_TypeSer, Name_TypeSer) VALUES ('" . $_POST["ID_TypeSer"] . "', '" . $_POST["Name_TypeSer"] . "')";
        //บัคที่เพิ่ม ID ซ้ำกันแล้ว ไม่มี Error*********************************************************************
        mysql_query($sql);
        if ($Flag) {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลสำเร็จ')</script>";
        } else {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลผิดพลาด')</script>";
        }
    } elseif ($button == 'แก้ไขข้อมูล') {
        $sql = "UPDATE TypeSer SET Name_TypeSer = '" . $_POST["Name_TypeSer"] . "' WHERE ID_TypeSer = '" . $_POST["ID_TypeSer"] . "'";
        mysql_query($sql);
    } else {
        $sql = "DELETE FROM TypeSer WHERE ID_TypeSer = '" . $_POST["ID_TypeSer"] . "'";
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
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li><a href="./base.php">ข้อมูลคำนำหน้าชื่อ</a></li>
                                <li><a href="./employeetype.php">ข้อมูลประเภทพนักงาน</a></li>
                                <li><a href="./unitcount.php">ข้อมูลหน่วยนับ</a></li>
                                <li class="active"><a href="./servicetype.php">ข้อมูลประเภทการให้บริการ</a></li>
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
                        <div class="row" style="margin-left: 0%;">
                            <div class="padded">
                                <?php
                                $lastsql = "SELECT ID_TypeSer From TypeSer order by ID_TypeSer DESC LIMIT 1";
                                $result = mysql_query($lastsql);
                                $OldId = mysql_fetch_array($result);
                                //TS 001
                                $NewId = generateID($OldId['ID_TypeSer'], 2);
                                //generateID(ไอดีตัวสุดท้าย,จำนวนตัวอักษรที่อยู่ในไอดีนั้นๆ เช่น P099 ก็คือ มีแค่ 1 ตัว );
                                ?>
                                <div class="col-md-12" style="width:50%;">
                                    <form name="form1" method="post" action="" style="width: 121%;">
                                        รหัสประเภทการให้บริการ
                                        <br>
                                        <input type="text" class="form-control" name="ID_TypeSer" id="ID_TypeSer" required placeholder="รหัสประเภทการให้บริการ" value="<?php echo $NewId; ?>" maxlength="5" style="background: #C0F9BD"> 
                                        <br>
                                        ชื่อประเภทการให้บริการ <font color="red">*</font>
                                        <br>
                                        <input type="text" class="form-control" name="Name_TypeSer" id="Name_TypeSer" required placeholder="ชื่อประเภทการให้บริการ" value="" style="background: #C0F9BD"> 
                                        <br>
                                        <input onclick="return checkTypeSer();" id="add" type="submit" class="btn btn-primary" name="Button" value="เพิ่มข้อมูล">
                                        <input id="update"type="submit" class="btn btn-warning" name="Button" value="แก้ไขข้อมูล">
                                        <input onclick="return checkIdTypeEmp();" id="delete"type="submit" class="btn btn-danger" name="Button" value="ลบข้อมูล">
                                        <input id="cancle" type="reset" class="btn btn-default" name="Button" value="ยกเลิก">
                                        </center>

                                        <script type="text/javascript">
                                            $('#cancle').click(function () {
                                                $('#add').show();
                                            });
                                            // check คำซ้ำ
                                            var result = false;
                                            $('#Name_TypeSer').change(function () {
                                                var Name_TypeSer = $('#Name_TypeSer').val();
                                                var json = {'Name_TypeSer': Name_TypeSer};
                                                $.post("./service.service.php", json).done(function (data) {
                                                    var typeSer = JSON.parse(data);
                                                    if (typeSer.ID_TypeSer > 0) {
                                                        alert("ประเภทการให้บริการนี้ได้มีการเพิ่มข้อมูลเข้าไปในระบบแล้ว");
                                                        result = false;
                                                    } else {
                                                        result = true;
                                                    }
                                                });
                                            });
                                            function checkTypeSer() {
                                                if (!result) {
                                                    alert("ประเภทการให้บริการนี้ได้มีการเพิ่มข้อมูลเข้าไปในระบบแล้ว");
                                                }
                                                return result;
                                            }

                                            // check คำที่ใช้จะลบไม่ได้
                                            var rsId = false;
                                            var text = "ประเภทการให้บริการนี้ถูกใช้อยู่ไม่สามารถลบได้";
                                            function checkIdTypeEmp() {
                                                if (!rsId) {
                                                    alert(text);
                                                }
                                                return rsId;
                                            }


                                        </script>
                                    </form>
                                </div>  
                            </div>
                        </div>
                        <div class="row" style="margin-left: 19%;"> 
                            <div class="col-md-12" style="width: 60%;"> 
                                <?php
                                $sql = "SELECT * FROM TypeSer ";
                                $query = mysql_query($sql);
//$objResult = mysql_fetch_array($objQuery);
                                ?>
                                <div class="bs-example">
                                    <div class="panel panel-default">
                                        <!-- Default panel contents -->
                                        <div class="panel-heading"><h4>ข้อมูลประเภทการให้บริการ</h4></div> 
                                        <!-- Table -->
                                        <div class="mygrid-wrapper-div" style="height:45%;">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>รหัสประเภทการให้บริการ</th>
                                                        <th>ชื่อประเภทการให้บริการ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row_prefix = mysql_fetch_array($query)) { ?>
                                                        <tr>
                                                            <td>
                                                                <a id="<?= $row_prefix['ID_TypeSer'] ?>" class="point">
                                                                    <?php echo $row_prefix['ID_TypeSer']; ?>
                                                                </a>
                                                            </td>
                                                            <td><?php echo $row_prefix['Name_TypeSer']; ?></td>
                                                        </tr>
                                                    <script type="text/javascript">
                                                        $("#<?= $row_prefix['ID_TypeSer'] ?>").click(function () {
                                                            $('#add').hide();
                                                            ID_TypeSer.value = "<?= $row_prefix['ID_TypeSer'] ?>";
                                                            Name_TypeSer.value = "<?= $row_prefix['Name_TypeSer'] ?>";
                                                            
                                                            // check คำที่ใช้จะลบไม่ได้
                                                            var json = {'ID_TypeSer': "<?= $row_prefix['ID_TypeSer'] ?>"};
                                                            $.post("./service.service.php", json).done(function (data) {
                                                                var typeSer = JSON.parse(data); 
                                                                if (typeSer.ID_TypeSer > 0) { 
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