<?php
session_start();
include("../connect/connect.php");



if (empty($_SESSION['Username'])) {
    if (empty($_SESSION['Username']) || empty($_SESSION['status']) || empty($_SESSION['name'])) {
        echo alert('กรุณาเข้าสู่ระบบ Admin ก่อน');
        echo location("../login.php");
    }
}else{

if (!empty($_POST['Button'])) {
    $button = $_POST['Button'];
    $Flag = true;

    $ID_Emp = $_POST['ID_Emp'];
    $ID_Prefix = $_POST['ID_Prefix'];
    $FName_Emp = $_POST['FName_Emp'];
    $LName_Emp = $_POST['LName_Emp'];
    $Email = $_POST['Email'];
    $username = $_POST['username'];
    $password = base64_encode($_POST['password']);
    $Tel_Emp = $_POST['Tel_Emp'];
    $Salary = str_replace(",", "", $_POST['Salary']);
    $ID_TypeEmp = $_POST['ID_TypeEmp'];
    
    $ID_Status2 = "";
    if ($ID_TypeEmp =='TE001'){
        $ID_Status2 = "s001"; // Admin}
    }
    elseif ($ID_TypeEmp =='TE002') {
       $ID_Status2 = "s002"; // Employees
    }
    

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
        $ID_member = generateIDbyFix($xrs['ID_member'], 2, "m");

        $mql = "INSERT INTO `member` (ID_member, username, password, ID_Status, personal_ID,Email) VALUES ('$ID_member', '$username', '$password', '$ID_Status2', '','$Email')";
        $mrs = mysql_query($mql);

        $eql = "INSERT INTO `employees` (`ID_Emp`, `ID_Prefix`, `FName_Emp`, `LName_Emp`, `username`, `password`, `Tel_Emp`,`Email`, `Salary`, `ID_TypeEmp`) VALUES ('$ID_Emp', '$ID_Prefix', '$FName_Emp', '$LName_Emp', '$username', '', '$Tel_Emp','$Email', '$Salary', '$ID_TypeEmp')";
        $Flag = mysql_query($eql);
        if ($Flag)
            echo alert('เพิ่มข้อมูลสำเร็จ');
        else
            echo alert('เพิ่มข้อมูลผิดพลาด');
    } elseif ($button == 'แก้ไขข้อมูล') {

        $ID_member = $_POST['ID_member'];
        $sql = "UPDATE Employees SET ID_Prefix = '$ID_Prefix',FName_Emp = '$FName_Emp',LName_Emp = '$LName_Emp',username='$username' ,Tel_Emp = '$Tel_Emp',Email='$Email',Salary = '$Salary', ID_TypeEmp='$ID_TypeEmp' WHERE ID_Emp = '$ID_Emp'";
        $ers = mysql_query($sql);
        $mql = "UPDATE `member` SET username='$username',password='$password',ID_Status='$ID_Status2',personal_ID='',Email='$Email' WHERE ID_member='$ID_member'";
        $mrs = mysql_query($mql);
        if ($ers && $mrs)
            echo alert('แก้ไขข้อมูลสำเร็จ');
        else
            echo alert('แก้ไขข้อมูลผิดพลาด');
    } elseif ($button == 'ลบข้อมูล') {
        $ID_member = $_POST['ID_member'];
        if (!empty($ID_member)) {
            $sql = "DELETE FROM Employees WHERE ID_Emp = '$ID_Emp'";
            $ers = mysql_query($sql);

            $mql = "DELETE FROM member WHERE ID_member = '$ID_member'";
            $mrs = mysql_query($mql);
            if ($ers && $mrs) {
                echo alert('ลบข้อมูลสำเร็จ');
                if ($_SESSION['id'] == $ID_Emp) {
                    echo location("../logout.php");
                }
            } else
                echo alert('ลบข้อมูลผิดพลาด');
        } else {
            echo alert("กรุณาเลือกข้อมูลที่จะจะลบก่อน");
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
            .input-group{
                padding-bottom: 5px;
            }
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
                                <!--    <li Class = "active"><a href="./base.php">จัดการข้อมูลพนักงาน</a></li> -->
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
                        <tr>
                                                                <td style="border: none;width: 15%;">
                                                                    <h3>จัดการข้อมูลพนักงาน</h3>
                                                                </td>
                                                            </tr>
                        <?php
                        $lastsql = "SELECT ID_Emp From employees order by ID_Emp DESC LIMIT 1";
                        $result = mysql_query($lastsql);
                        $OldId = mysql_fetch_assoc($result);
                        $new_id = mysql_result(mysql_query("Select Max(substr(ID_Emp,-3))+1 as MaxID from employees"), 0, "MaxID");
                        if ($new_id == '') {
                            $NewId = "E001";
                        } else {
                            $NewId = "E" . sprintf("%03d", $new_id); //ถ้าไม่ใช่ค่าว่าง
                        }
                        ?>
                        <form name="form1" method="post" action="">
                            <div class="row">
                                <div class="padform">
                                    <div class="col-lg-6">
                                        <div class="input-group"style="width:60%;">
                                            <label>รหัสพนักงาน</label>
                                            <input name="ID_Emp" id="ID_Emp" placeholder="รหัสพนักงาน" value="<?php echo $NewId; ?>" maxlength="4" style="background: #C0F9BD" class="form-control" required="" readonly>
                                        </div>
                                        <div class="input-group"style="width:60%;">
                                            <label>คำนำหน้าชื่อ</label> <font color="red">*</font>
                                            <select name="ID_Prefix" id="ID_Prefix" class="idropdown" required="">
                                                <option value="" style="background: #C0F9BD">คำนำหน้าชื่อ</option>
                                                <?php
                                                $sql = "SELECT * FROM prefix ORDER BY ID_Prefix ASC";
                                                $query = mysql_query($sql);
                                                while ($objResult = mysql_fetch_array($query)) {
                                                    ?>
                                                    <option value="<?= $objResult["ID_Prefix"]; ?>" style="background: #C0F9BD">
                                                        <?= $objResult["Name_Prefix"]; ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select> 
                                        </div>
                                        <div class="input-group"style="width:60%;">
                                            <label>ฃื่อพนักงาน</label> <font color="red">*</font>
                                            <input type="text" name="FName_Emp" id="FName_Emp" maxlength="40" placeholder="ชื่อพนักงาน" style="background: #C0F9BD" class="form-control" required="">
                                        </div>
                                        <div class="input-group"style="width:60%;">
                                            <label>นามสกุล</label> <font color="red">*</font>
                                            <input type="text" name="LName_Emp" id="LName_Emp" placeholder="นามสกุล" maxlength="50" style="background: #C0F9BD" class="form-control" required="">
                                        </div>
                                        <div class="input-group"style="width:60%;">
                                            <label>เบอร์ติดต่อ</label> <font color="red">*</font>
                                            <input type="text" name="Tel_Emp" id="Tel_Emp" placeholder="เบอร์ติดต่อ" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="10" style="background: #C0F9BD" class="form-control" required="">
                                        </div>
                                        <div class="input-group" style="width:60%;">
                                            <!--<div><label>อัตราค่าจ้าง</label></div>-->
                                            <div>
                                                <input type="hidden" name="Salary" id="Salary" placeholder="อัตราจ้าง" maxlength="10" style="background: #C0F9BD;width: 87%;" class="form-control" required=""> 
                                                <script>$('#Salary').val(300);</script>
                                            </div>
                                            <!--<div style="padding: 7px 0px 2px 262px;"><label>บาท</label></div>-->
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group"style="width:60%;">
                                            <label>ประเภทพนักงาน</label> 
                                            <select name="ID_TypeEmp" id="ID_TypeEmp" class="idropdown" placeholder="ประเภทพนักงาน" required=""> 
                                                <?php
                                                $sql = "SELECT * FROM typeemp ORDER BY ID_TypeEmp ASC";
                                                $query = mysql_query($sql);
                                                while ($objResult = mysql_fetch_array($query)) {
                                                    // if ($objResult["ID_TypeEmp"] == "TE001") {
                                                        ?>
                                                        <option selected="" value="<?= $objResult["ID_TypeEmp"] ?>" style="background: #C0F9BD"><?= $objResult["Name_TypeEmp"]; ?></option>
                                                        <?php
                                                    // }
                                                }
                                                ?>
                                            </select> 
                                        </div> 
                                        <div class="input-group"style="width:60%;">
                                            <label>Email</label>
                                            <input type="email" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" name="Email" id="Email" required  placeholder="Email" maxlength="50" style="background: #C0F9BD" class="form-control">
                                                <script>
                                                function InvalidMsg(textbox) {
                                                    if (textbox.value == '') {
                                                        textbox.setCustomValidity('กรุณากรอก Email');
                                                    } else if(textbox.validity.typeMismatch){
                                                        textbox.setCustomValidity('กรุณากรอก Email ให้ถูกต้อง!');
                                                    } else {
                                                        textbox.setCustomValidity('');
                                                    }
                                                    return true;
                                                }
                                            </script>
                                        </div>
                                        <div class="input-group"style="width:60%;">
                                            <label>ชื่อผู้ใช้งาน</label>
                                            <span id="ituse" style="margin-left: 30px;color: blue;font-weight: 500;">สามารถใช้ชื่อนี้ได้</span> 
                                            <span id="onuse" style="margin-left: 30px;color: red;font-weight: 500;">ไม่สามารถใช้ชื่อนี้ได้</span> 
                                            <input type="hidden" name="ID_member" id="ID_member" value="">
                                            <input type="text" name="username" id="username" placeholder="ชื่อผู้ใช้งาน" maxlength="40" style="background: #C0F9BD" class="form-control">
                                        </div> 
                                        <div class="input-group"style="width:60%;">
                                            <label>รหัสผ่าน</label>
                                            <span id="ans" style="margin-left: 30px;font-weight: 500;"></span>
                                            <!-- <input type="Password" name="Password" id="Password" placeholder="Password" maxlength="40" style="background: #C0F9BD" class="form-control"> -->
                                            <input type="password" onkeypress="checkPassword()" name="password" id="password" onchange="validatepassword()" placeholder="รหัสผ่าน" maxlength="40" style="background: #C0F9BD" class="form-control"><br />
                                        </div> 
                                        <div class="input-group"style="width:60%;">
                                            <label>ยืนยันรหัสผ่าน</label>
                                            <!-- <input type="Password" name="Password" id="Password" placeholder="Password" maxlength="40" style="background: #C0F9BD" class="form-control"> -->
                                            <input type="password" name="confirmpassword" onchange="validatepassword()" id="repassword" placeholder="ยืนยันรหัสผ่าน" maxlength="40" style="background: #C0F9BD" class="form-control"><br /> 
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
                                                    $('#ans').css("color", "green");
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
                                        <input onclick="return checkID_Emp();" id="delete"type="submit" class="btn btn-danger" name="Button" value="ลบข้อมูล">
                                        <input id="cancle" type="reset" class="btn btn-default" name="Button" value="ยกเลิก">
                                        <!-- <input onclick="reset()" id="cancle" type="reset" class="btn btn-default" name="Button" value="ยกเลิก"> -->
                                        <script type="text/javascript">
                                            $('#Salary').number(true, 2);
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
                                                // check คำที่ใช้จะลบไม่ได้

                                                var rsId = false;
                                                var text = "พนักงานชื่อนี้ถูกใช้อยู่ไม่สามารถลบได้"; 
                                                function checkID_Emp() {
                                                    if (!rsId) {
                                                        alert(text);
                                                    }
                                                    return rsId;
                                                }

                                                

                                            </script>
                                    </center>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                $sql = "SELECT * FROM employees e, prefix p, typeemp t,member m WHERE e.ID_Prefix = p.ID_Prefix AND t.ID_TypeEmp = e.ID_TypeEmp AND m.username=e.username ORDER BY e.ID_Emp ASC";
                                $query = mysql_query($sql);
                                ?>
                                <div class="bs-example">
                                    <div class="panel panel-default">
                                        <!-- Default panel contents -->
                                        <div class="panel-heading"><h4>ข้อมูลพนักงาน</h4></div>
                                        <!-- Table -->
                                        <div class="mygrid-wrapper-div" style="height: 50%;">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>รหัสพนักงาน</th>
                                                        <th>คำนำหน้าชื่อ</th>
                                                        <th>ชื่อพนักงาน</th>
                                                        <th>นามสกุล</th>
                                                        <th>Email</th>
                                                        <th>เบอร์ติดต่อ</th> 
                                                        <th>ประเภทพนักงาน</th>
                                                        <!--<th>อัตราค่าจ้าง (บาท)</th>-->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($admin = mysql_fetch_assoc($query)) { ?>
                                                        <tr>
                                                            <td>
                                                                <a id="<?= $admin['ID_Emp'] ?>" class="point">
                                                                    <?php echo $admin['ID_Emp']; ?>
                                                                </a>
                                                            </td>
                                                            <td><?php echo $admin['Name_Prefix']; ?></td>
                                                            <td><?php echo $admin['FName_Emp']; ?></td>
                                                            <td><?php echo $admin['LName_Emp']; ?></td>
                                                            <td><?php echo $admin['Email']; ?></td>
                                                            <td><?php echo $admin['Tel_Emp']; ?></td> 
                                                            <td><?php echo $admin['Name_TypeEmp']; ?></td>
                                                            <!--<td><span id="right"><?php // echo number_format($admin['Salary'], 2);       ?></span></td>-->
                                                        </tr>
                                                    <script type="text/javascript">
                                                        $("#<?= $admin['ID_Emp'] ?>").click(function () {
                                                            $('#add').hide();
                                                            $('#ID_Emp').val("<?= $admin['ID_Emp'] ?>");
                                                            $('#ID_Prefix option[value="<?= $admin['ID_Prefix'] ?>"]').attr('selected', 'selected');
                                                            $('#FName_Emp').val("<?= $admin['FName_Emp'] ?>");
                                                            $('#LName_Emp').val("<?= $admin['LName_Emp'] ?>");
                                                            $('#Email').val("<?= $admin['Email'] ?>");
                                                            $('#Tel_Emp').val("<?= $admin['Tel_Emp'] ?>");
                                                            $('#ID_TypeEmp option[value="<?= $admin['ID_TypeEmp'] ?>"]').attr('selected', 'selected');
                                                            $('#Salary').val("<?= $admin['Salary'] ?>");
                                                            $('#ID_member').val("<?= $admin['ID_member'] ?>");
                                                            $('#username').val("<?= $admin['username'] ?>");
                                                            // $('#password').val("<?= base64_decode($admin['password']) ?>");
                                                            // $('#repassword').val("<?= base64_decode($admin['password']) ?>");

                                                            
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
                    $('#employee').addClass('active');
                });
            </script>
            <?php include("../fragments/footer.php"); ?>
        </footer>
    </body>
</html>
<?php } ?>