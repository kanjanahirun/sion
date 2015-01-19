<?php
session_start();
include("../connect/connect.php");

if (empty($_SESSION['Username'])) {
    if (empty($_SESSION['Username']) || empty($_SESSION['status']) || empty($_SESSION['name'])) {
        echo alert('กรุณาเข้าสู่ระบบ Admin ก่อน');
        echo location("../login.php");
    }
} else {

    if (!empty($_POST['Button'])) {
        $button = $_POST['Button'];
        $Flag = true;

        $ID_Admin = $_POST['ID_Admin'];
        $Name_Admin = $_POST['Name_Admin'];
        $LName_Admin = $_POST['LName_Admin'];
        $Email = $_POST['Email'];
        $username = $_POST['username'];
        $password = base64_encode($_POST['password']);
        $ID_Status = "s001"; // Employees

        if ($button == 'เพิ่มข้อมูล') {

            $strCount = "SELECT * FROM employees ORDER BY ID_Emp DESC LIMIT 1";
            $objQueryCount = mysql_query($strCount);
            $Count_prefix = mysql_fetch_array($objQueryCount);
            $NUMCount = substr($Count_prefix["ID_Emp"], -1);
            $nextNum = $NUMCount + 1;
            $Prefix_num = substr($Count_prefix["ID_Emp"], 0, 3);
            $strEmp_ID = "" . ($Prefix_num . "" . $nextNum);

            // member gen PK
            $mql = "SELECT ID_member FROM member order by ID_member desc limit 1";
            $xrs = mysql_fetch_assoc(mysql_query($mql));
            $ID_member = (count($xrs) != 0) ? generateIDbyFix($xrs['ID_member'], 2, "m") : "m001";

            $mql = "INSERT INTO `member` (ID_member, username, password, ID_Status, personal_ID,Email) VALUES ('$ID_member', '$username', '$password', '$ID_Status', '','$Email')";
            $mrs = mysql_query($mql);

            $eql = "INSERT INTO `admin` (`ID_Admin`, `Name_Admin`, `LName_Admin`, `personal_ID`, `ID_member`) VALUES ('$ID_Admin', '$Name_Admin', '$LName_Admin', '', '$ID_member')";
            $Flag = mysql_query($eql);
            if ($Flag)
                echo alert('เพิ่มข้อมูลสำเร็จ');
            else
                echo alert('เพิ่มข้อมูลผิดพลาด');
        } elseif ($button == 'แก้ไขข้อมูล') {

            $ID_member = $_POST['ID_member'];
            $sql = "UPDATE admin SET Name_Admin = '$Name_Admin',LName_Admin = '$LName_Admin',personal_ID = '',ID_member='$ID_member' WHERE ID_Admin = '$ID_Admin'";
            $ers = mysql_query($sql);
            $mql = "UPDATE `member` SET username='$username',password='$password',ID_Status='$ID_Status',personal_ID='',Email='$Email' WHERE ID_member='$ID_member'";
            $mrs = mysql_query($mql);
            if ($ers && $mrs)
                echo alert('แก้ไขข้อมูลสำเร็จ');
            else
                echo alert('แก้ไขข้อมูลผิดพลาด');
        }
        elseif ($button == 'ลบข้อมูล') {
            $ID_member = $_POST['ID_member'];
            $sql = "SELECT count(ID_Admin) AS ID_Admin FROM admin";
            $rs = mysql_fetch_assoc(mysql_query($sql));
            if ($rs['ID_Admin'] > 1) {
                if (!empty($ID_member)) {
                    $sql = "DELETE FROM admin WHERE ID_Admin = '$ID_Admin'";
                    $ers = mysql_query($sql);
                    $mql = "DELETE FROM member WHERE ID_member = '$ID_member'";
                    $mrs = mysql_query($mql);
                    if ($ers && $mrs) {
                        echo alert('ลบข้อมูลสำเร็จ');
                        if ($_SESSION['id'] == $ID_Admin) {
                            echo location("../logout.php");
                        }
                    } else
                        echo alert('ลบข้อมูลผิดพลาด');
                } else {
                    echo alert("กรุณาเลือกข้อมูลที่จะจะลบก่อน");
                }
            } else {
                echo alert("ไม่สามารถลบข้อมูลผู้ดูแลระบบได้");
            }
        }
    }
    ?>
    <!DOCTYP html>
    <html>
        <head>
            <title> ร้านศรีอ้น แฮร์ & สปาร์ </title> 
            <?php include("../fragments/libmanage.php"); ?>  
            <style>
                .input-group{ padding-bottom: 5px; }
            </style>
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
                                    <!-- <li Class = "active"><a href="./base.php">จัดการข้อมูลผู้ดูแลระบบ</a></li> -->
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
                            <?php
                            $lastsql = "SELECT ID_Admin From admin order by cast(substr(ID_Admin,3) AS UNSIGNED) DESC LIMIT 1";
                            $result = mysql_query($lastsql);
                            $OldId = mysql_fetch_assoc($result);
                            $NewId = (count($OldId) != 0) ? generateIDbyFix4($OldId['ID_Admin'], 2, "AD") : "AD01";
                            ?>
                            <form name="form1" method="post" action="">
                                <div class="row">
                                    <div class="padform">
                                        <div class="col-lg-6">
                                            <div class="input-group"style="width:60%;">
                                                <label>รหัสผู้ดูแลระบบ</label>
                                                <input name="ID_Admin" id="ID_Admin" placeholder="รหัสผู้ดูแลระบบ" value="<?php echo $NewId; ?>" maxlength="4" style="background: #C0F9BD" class="form-control" required="">
                                            </div>
                                            <div class="input-group"style="width:60%;">
                                                <label>ฃื่อผู้ดูแลระบบ</label> <font color="red">*</font>
                                                <input type="text" name="Name_Admin" id="Name_Admin" maxlength="40" placeholder="ชื่อผู้ดูแลระบบ" style="background: #C0F9BD" class="form-control" required="">
                                            </div>
                                            <div class="input-group"style="width:60%;">
                                                <label>นามสกุล</label> <font color="red">*</font>
                                                <input type="text" name="LName_Admin" id="LName_Admin" placeholder="นามสกุล" maxlength="50" style="background: #C0F9BD" class="form-control" required="">
                                            </div> 
                                            <div class="input-group"style="width:60%;">
                                                <label>Email</label> <font color="red">*</font>
                                                <input type="email" name="Email" id="Email" value="" placeholder="Email" style="background: #C0F9BD;" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">  
                                            <div class="input-group"style="width:60%;">
                                                <label>ชื่อผู้ใช้งาน</label> <font color="red">*</font>
                                                <span id="ituse" style="margin-left: 30px;color: blue;font-weight: 500;">สามารถใช้ชื่อนี้ได้</span> 
                                                <span id="onuse" style="margin-left: 30px;color: red;font-weight: 500;">ไม่สามารถใช้ชื่อนี้ได้</span> 
                                                <input type="hidden" name="ID_member" id="ID_member" value="">
                                                <input type="text" name="username" id="username" required placeholder="ชื่อผู้ใช้งาน" maxlength="40" style="background: #C0F9BD" class="form-control" required="">
                                            </div> 
                                            <div class="input-group"style="width:60%;">
                                                <label>รหัสผ่าน</label> <font color="red">*</font>
                                                <span id="ans" style="margin-left: 30px;font-weight: 500;"></span>
                                                <!-- <input type="Password" name="Password" id="Password" placeholder="Password" maxlength="40" style="background: #C0F9BD" class="form-control"> -->
                                                <input type="password" onkeypress="checkPassword()" name="password" id="password" onchange="validatepassword()" required placeholder="รหัสผ่าน" maxlength="40" style="background: #C0F9BD" class="form-control" required=""><br />
                                            </div> 
                                            <div class="input-group"style="width:60%;">
                                                <label>ยืนยันรหัสผ่าน</label> <font color="red">*</font>
                                                <!-- <input type="Password" name="Password" id="Password" placeholder="Password" maxlength="40" style="background: #C0F9BD" class="form-control"> -->
                                                <input type="password" name="confirmpassword" onchange="validatepassword()" id="repassword" required placeholder="ยืนยันรหัสผ่าน" maxlength="40" style="background: #C0F9BD" class="form-control" required=""><br /> 
                                                <!--<br><br><input type="submit" onclick="return validatepassword();" class="btn btn-info" name="Button" value="ตรวจสอบรหัสผ่าน" />-->
                                                <label id="success" for="" style="margin-left: 20px;color: blue;">รหัสผ่านตรงกัน</label>
                                                <label id="error" for="" style="margin-left: 20px;color: red;">รหัสผ่านไม่ตรงกัน</label>
                                            </div> 
                                            <script type="text/javascript">
                                                $('#success').hide();
                                                $('#error').hide();
                                                function validatepassword() {
                                                    var password = $('#password').val();
                                                    var repassword = $('#repassword').val();
                                                    console.log(password, repassword);
                                                    if (password != repassword) {
                                                        $('#success').hide();
                                                        $('#error').show();
                                                    }
                                                    if (password == repassword) {
                                                        $('#success').show();
                                                        $('#error').hide();
                                                    }
                                                }

                                                var n = 0, a = 0, AI = 0, A0 = 0, L = 0;
                                                function checkPassword() {
                                                    var p = $('#password').val();
                                                    if (p.match('[0-9]{1,}'))
                                                        n++;
                                                    if (p.match('[a-z]{1,}'))
                                                        a++;
                                                    if (p.match('[A-Z]{1,}'))
                                                        AI++;
                                                    if (p.match('[0-9]{1,}') && p.match('[a-z]{1,}') && p.match('[A-Z]{1,}') && p.length > 5)
                                                        A0++;
                                                    else if (p.length > 9)
                                                        L++;
                                                    analysis(n, a, AI, A0, L);
                                                }

                                                function analysis(n, a, AI, A0, L) {
                                                    var ans = n + a + AI + A0 + L;
                                                    var p = $('#password').val();
                                                    if (p.length <= 8)
                                                        ans = p.length;
                                                    else if (p.length <= 16)
                                                        ans = p.length;
                                                    else if (p.length >= 17)
                                                        ans = p.length;
                                                    if (ans <= 8) {
                                                        $('#ans').css("color", "red");
                                                        $('#ans').text("คาดเดาได้ง่าย");
                                                    } else if (ans <= 16) {
                                                        $('#ans').css("color", "orange");
                                                        $('#ans').text("คาดเดาได้ปานกลาง");
                                                    } else if (ans >= 17) {
                                                        $('#ans').css("color", "blue");
                                                        $('#ans').text("คาดเดาได้ยาก");
                                                    }
                                                }
                                            </script> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <center><br>
                                            <input id="add" type="submit" class="btn btn-primary" name="Button" value="เพิ่มข้อมูล">
                                            <input id="update"type="submit" class="btn btn-warning" name="Button" value="แก้ไขข้อมูล">
                                            <?php
                                            $sql = "SELECT count(ID_Admin) AS ID_Admin FROM admin";
                                            $rs = mysql_fetch_assoc(mysql_query($sql));
                                            if ($rs['ID_Admin'] > 1) {
                                                echo '<input id="delete"type="submit" onclick="return confirm(\'ยืนยันการลบข้อมูล\');"  class="btn btn-danger" name="Button" value="ลบข้อมูล">';
                                            }
                                            ?> 
                                            <input id="cancle" type="reset" class="btn btn-default" name="Button" value="ยกเลิก">
                                            <script type="text/javascript">
                                                $('#cancle').click(function () {
                                                    $('#add').show();
                                                });
                                                $('#ituse').hide();
                                                $('#onuse').hide();
                                                $('#username').change(function () {
                                                    var username = $('#username').val();
                                                    var json = {'username': username};
                                                    $.post("./employees.service.php", json).done(function (data) {
                                                        var emp = JSON.parse(data);
                                                        if (emp.ID_Emp > 0) {
                                                            $('#ituse').hide();
                                                            $('#onuse').show();
                                                            alert("ชื่อผู้ใช้นี้ถูกใช้งานแล้ว");
                                                            $('#username').val("");
                                                        } else {
                                                            $('#ituse').show();
                                                            $('#onuse').hide();
                                                        }
                                                    });
                                                });

                                                $('#Email').change(function () {
                                                    var Email = $('#Email').val();
                                                    var json = {'Email': Email, 'table': "member"}; 
                                                    $.post("./customer.service.php", json).done(function (data) { 
                                                        var email = JSON.parse(data); 
                                                        var json2 = {'Email': Email, 'table': "customers"};
                                                        $.post("./customer.service.php", json2).done(function (datax) { 
                                                            var email2 = JSON.parse(datax);
                                                            if (email.Email > 0 || email2.Email > 0) {
                                                                alert("ไม่สามารถใช้ Email นี้ได้");
                                                                $('#Email').val("");
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>
                                        </center>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    $sql = "SELECT * FROM admin e, member m WHERE m.ID_member=e.ID_member ORDER BY e.Name_Admin ASC";
                                    $query = mysql_query($sql);
                                    ?>
                                    <div class="bs-example">
                                        <div class="panel panel-default">
                                            <!-- Default panel contents -->
                                            <div class="panel-heading"><h4>ข้อมูลผู้ดูแลระบบ</h4></div>
                                            <!-- Table -->
                                            <div class="mygrid-wrapper-div" style="height: 50%;">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัสผู้ดูแลระบบ</th> 
                                                            <th>ชื่อผู้ดูแลระบบ</th>
                                                            <th>นามสกุล</th>
                                                            <th>Email</th>   
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php while ($admin = mysql_fetch_assoc($query)) { ?> 
                                                            <tr>
                                                                <td>
                                                                    <a class="point" id="ID<?= $admin['ID_Admin'] ?>"><?= $admin['ID_Admin'] ?></a>
                                                                </td> 
                                                                <td><?php echo $admin['Name_Admin']; ?></td>
                                                                <td><?php echo $admin['LName_Admin']; ?></td>
                                                                <td><?php echo $admin['Email']; ?></td>   
                                                            </tr>
                                                        <script type="text/javascript">
                                                            $("#ID<?= $admin['ID_Admin'] ?>").click(function () {
                                                                $('#add').hide();
                                                                $('#ID_Admin').val("<?= $admin['ID_Admin'] ?>");
                                                                $('#Name_Admin').val("<?= $admin['Name_Admin'] ?>");
                                                                $('#LName_Admin').val("<?= $admin['LName_Admin'] ?>");
                                                                $('#Email').val("<?= $admin['Email'] ?>");
                                                                $('#ID_member').val("<?= $admin['ID_member'] ?>");
                                                                $('#username').val("<?= $admin['username'] ?>");
                                                                $('#password').val("<?= base64_decode($admin['password']) ?>");
                                                                $('#repassword').val("<?= base64_decode($admin['password']) ?>");
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
                        $('#admin').addClass('active');
                    });
                </script>
                <?php include("../fragments/footer.php"); ?>
            </footer>
        </body>
    </html>
<?php } ?>