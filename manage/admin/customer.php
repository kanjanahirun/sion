<?php
session_start();
include("../connect/connect.php");

if (empty($_SESSION['Username'])) {
    if (empty($_SESSION['Username']) || empty($_SESSION['status']) || empty($_SESSION['name'])) {
        echo alert('กรุณาเข้าสู่ระบบ Admin ก่อน');
        echo location("../login.php");
    }
} else {
    if($_SESSION['ID_Status'] == "s002"){
        echo location("./addorder.php");
    }else{
    if (!empty($_POST['Button'])) {

        $button = $_POST['Button']; 
        //$Flag = true;
        $ID_Cus = $_POST['ID_Cus'];
        $ID_Prefix = $_POST['ID_Prefix'];
        $FName_Cus = $_POST['FName_Cus'];
        $LName_Cus = $_POST['LName_Cus'];
        $Email_Cus = $_POST['Email_Cus'];
        $username = $_POST['username'];
        $password = base64_encode($_POST['password']);
        $Tel_Cus = $_POST['Tel_Cus'];
        $ID_CusType = "CT01" ;
        $ID_Status2 = "s003";
        
        if ($button == 'เพิ่มข้อมูล') {
            $mql = "SELECT ID_member FROM member order by ID_member desc limit 1";
            $xrs = mysql_fetch_assoc(mysql_query($mql));
            $ID_member = generateIDbyFix($xrs['ID_member'], 2, "m");
            //echo "<script type='text/javascript'>alert('กรุณาเข้าสู่ระบบ Admin ก่อน')</script>"; 
            //$sql ="INSERT INTO prefix (ID_Prefix, Name_Prefix) VALUES ('$ID_Prefix', '$Name_Prefix')";
            $mql = "INSERT INTO member (ID_member, username, password, ID_Status, personal_ID, Email) VALUES ('$ID_member', '$username', '$password', '$ID_Status2', '', '$Email_Cus')";
            $mrs = mysql_query($mql)or die(mysql_error().":<br />".$sql_select);

            $sql = "INSERT INTO customers (ID_Cus, ID_Prefix, FName_Cus, LName_Cus, username, password , Tel_Cus, Email_Cus, ID_CusType) VALUES ('$ID_Cus', '$ID_Prefix', '$FName_Cus', '$LName_Cus', '$username', '$password', '$Tel_Cus', '$Email_Cus', '$ID_CusType')";
            //บัคที่เพิ่ม ID ซ้ำกันแล้ว ไม่มี Error*********************************************************************
            $Flag = mysql_query($sql)or die(mysql_error().":<br />".$sql_select);
            if ($Flag) {
                echo "<script type='text/javascript'>alert('เพิ่มข้อมูลสำเร็จ')</script>";
            } else {
                echo "<script type='text/javascript'>alert('เพิ่มข้อมูลผิดพลาด')</script>";
            }
        } elseif ($button == 'แก้ไขข้อมูล') {

            //$sql = "UPDATE Employees SET ID_Prefix, FName_Emp, LName_Emp, Tel_Emp, Salary, ID_TypeEmp, personal_ID = '".$_POST["ID_Prefix"]."', '".$_POST["FName_Emp"]."', '".$_POST["LName_Emp"]."', '".$_POST["Tel_Emp"]."', '".$_POST["Salary"]."', '".$_POST["ID_TypeEmp"]."', '".$_POST["personal_ID"]."'";
            $sql = "UPDATE customers SET ID_Prefix = '" . $_POST["ID_Prefix"] . "',FName_Cus = '" . $_POST["FName_Cus"] . "',LName_Cus = '" . $_POST["LName_Cus"] . "',username = '" . $_POST["username"] . "',password = '" . $_POST["password"] . "',Tel_Cus = '" . $_POST["Tel_Cus"] . "',Email_Cus = '" . $_POST["Email_Cus"] . "', ID_CusType = '" . $_POST["ID_CusType"] . "'  WHERE ID_Cus = '" . $_POST["ID_Cus"] . "'";
            $Flag = mysql_query($sql);
            if ($Flag) {
                echo "<script type='text/javascript'>alert('แก้ไขข้อมู,สำเร็จ')</script>";
            } else {
                echo "<script type='text/javascript'>alert('แก้ไขข้อมู,ผิดพลาด')</script>";
            }
        } elseif ($button == 'ลบข้อมูล') {
            $ID_Cus = $_POST['ID_Cus'];
            if (!empty($ID_Cus)) {
                $sql = "DELETE FROM customers WHERE ID_Cus = '$ID_Cus'";
                $ers = mysql_query($sql);

                $mql = "DELETE FROM member WHERE username = '$username'";
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
            $ID_Cus = $_POST["ID_Cus"];
            if($ID_Cus != "C000"){
                $sql = "DELETE FROM customers WHERE ID_Cus = '$ID_Cus'";
                mysql_query($sql);
            }else{
                echo alert("ไม่สารถลบข้อมูลนี้ได้");
            }
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
                                    <li Class = "active"><a href="./base.php">จัดการข้อมูลสมาชิก</a></li>
                                    <li role="presentation" class="dropdown" style="float: right;margin-right: -2px;">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" style="min-width: 160px;">
                                            <?php echo!empty($_SESSION['name']) ? $_SESSION['name'] : ""; ?> <span class="caret" style="float: right;margin-top: 10px;"></span>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="../logout.php">ออกจากระบบ</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            <tr>
                                                                <td style="border: none;width: 15%;">
                                                                    <h3>จัดการข้อมูลสมาชิก</h3>
                                                                </td>
                                                            </tr>


                      
                                            <?php if (!empty($_GET['q'])) { ?>
                                            <?php
                                            $sql = "SELECT * FROM customers c inner join prefix p on c.ID_Prefix=p.ID_Prefix WHERE c.FName_Cus LIKE '%" . $_GET['q'] . "%' OR c.LName_Cus LIKE '%" . $_GET['q'] . "%' ";
                                            // $sql = "SELECT * FROM product p, count c, company cm WHERE p.ID_Product = '" . $_GET['q'] . "' AND p.ID_Count = c.ID_Count AND p.ID_Company=cm.ID_Company ";
                                            // $sql = "SELECT * FROM product p, count c, company cm WHERE  p.ID_Count = c.ID_Count AND p.ID_Company=cm.ID_Company p.ID_Product = '" . $_GET['q'] . "'";
                                            // $sql = "SELECT * FROM product WHERE ID_Product = '" . $_GET['q'] . "'";
                                            // $sql = "SELECT o.ID_Order, o.Date_Order, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, c.Name_Company, p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.FName_Emp, e.LName_Emp FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp WHERE o.ID_Order = '" . $_GET['q'] . "' ORDER BY o.ID_Order ASC";
                                            $result = mysql_query($sql)or die(mysql_error().":<br />".$sql_select);
                                            ?>
                                            <!--<div class="mfp-bg my-mfp-zoom-in mfp-ready"></div>-->
                                            <div style="top: 342px; position: absolute; height: 1138px;" tabindex="-1" class="mfp-wrap mfp-close-btn-in mfp-auto-cursor my-mfp-zoom-in mfp-ready">
                                                <div class="mfp-container mfp-inline-holder">
                                                    <div class="mfp-content">
                                                        <!--<a class="popup-with-zoom-anim" HREF="#smallResult"> รายละเอียด </a>-->
                                                        <div id="smallResult" class="zoom-anim-dialog mfp-hide dialog open" style="margin-top: 226px;height: auto;"> 
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading"><h4>ข้อมูลลูกค้า</h4></div>
                                                                <div class="mygrid-wrapper-div">
                                                                    <table class="table" style="height: 100%;"> 
                                                                        <thead>
                                                                            <th>รหัสลูกค้า</th>
                                                                            <th>ชื่อ</th>
                                                                            <th>นามสกุล</th>
                                                                            <th>เบอร์โทร</th>
                                                                            <th>E-mail</th>
                                                                            <th>Username</th>
                                                                            
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php while ($row_customer = mysql_fetch_array($result)) { ?>
                                                                            <tr> 
                                                                                <td><a id="<?= $row_customer['ID_Cus'] ?>" class="point"><?php echo $row_customer['ID_Cus']; ?></a></td>
                                                                                <td><?php echo $row_customer['FName_Cus']; ?></td>
                                                                                <td><?php echo $row_customer['LName_Cus']; ?></td>
                                                                                <td><?php echo $row_customer['Tel_Cus']; ?></td>
                                                                                <td><?php echo $row_customer['Email_Cus']; ?></td>
                                                                                <td><?php echo $row_customer['username']; ?></td>
                                                                                
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div style="text-align: right;"><a href="./customer.php" class="btn btn-default">ปิด</a></div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            jQuery(window).load(function () {
                                                $('.mfp-close').hide();
                                            });
                                            jQuery.magnificPopup.open({items: {src: '#smallResult'},
                                                type: 'inline',
                                                mainClass: 'my-mfp-zoom-in',
                                                fixedContentPos: false,
                                                overflowY: 'auto'
                                            }, 0);
                                        </script>

                                        <?php
                                    } else {

                                    }
                                    ?>


                            <?php
                            $lastsql = "SELECT ID_Cus From customers order by ID_Cus DESC LIMIT 1";
                            $result = mysql_query($lastsql);
                            $OldId = mysql_fetch_array($result);
                            $new_id = mysql_result(mysql_query("Select Max(substr(ID_Cus,-3))+1 as MaxID from customers"), 0, "MaxID");
                            if ($new_id == '') {
                                $NewId = "C001";
                            } else {
                                $NewId = "C" . sprintf("%03d", $new_id);
                            }
                            ?>
                            <form name="form1" method="post" action="">
                                <div class="row"> 
                                    <div class="padform"> 
                                        <div class="col-lg-6">
                                            <div class="input-group"style="width:60%;">
                                                <label>รหัสสมาชิก</label>
                                                <input name="ID_Cus" id="ID_Cus" required placeholder="รหัสสมาชิก" maxlength="4" value="<?php echo $NewId; ?>" style="background: #C0F9BD" class="form-control" readonly>
                                            </div>  
                                            <div class="input-group" style="width:60%;">
                                                <label>คำนำหน้าชื่อ</label> <font color="red">*</font><br> 
                                                <?php
                                                $sql = "SELECT * FROM prefix order by Name_Prefix";
                                                $strResult = mysql_query($sql);
                                                ?>
                                                <select name="ID_Prefix" id="ID_Prefix" class="idropdown">
                                                    <option value="">คำนำหน้าชื่อ</option>
                                                    <?php
                                                    while ($row = mysql_fetch_array($strResult)) {
                                                        ?>
                                                        <option value="<?= $row['ID_Prefix'] ?>"><?= $row['Name_Prefix'] ?></option>
                                                        <?php
                                                    }
                                                    ?>  
                                                </select> 
                                            </div>
                                            <div class="input-group"style="width:60%;">
                                                <label>ฃื่อสมาชิก</label> <font color="red">*</font>
                                                <input type="text" name="FName_Cus" id="FName_Cus" required placeholder="ฃื่อลูกค้า" style="background: #C0F9BD" class="form-control">
                                            </div>
                                            <div class="input-group"style="width:60%;">
                                                <label>นามสกุลสมาชิก</label> <font color="red">*</font>
                                                <input type="text" name="LName_Cus" id="LName_Cus" required placeholder="นามสกุลลูกค้า" style="background: #C0F9BD" class="form-control">
                                            </div> 
                                            <div class="input-group"style="width:60%;">
                                                <label>เบอร์โทรศัพท์</label> <font color="red">*</font>
                                                <input type="tel" name="Tel_Cus" id="Tel_Cus" required placeholder="เบอร์โทรศัพท์" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="10" style="background: #C0F9BD" class="form-control"> 
                                            </div> 
                                            <div class="input-group"style="width:60%;">
                                                <label>E-mail</label> <font color="red">*</font>
                                                <input type="email" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" name="Email_Cus" id="Email_Cus" required  placeholder="Email" maxlength="50" style="background: #C0F9BD" class="form-control">
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
                                                
                                                <label>ประเภทสมาชิก</label> <font color="red">*</font>
                                                <input type="text" name="ID_CusTypes" id="ID_CusTypes" required placeholder="ลูกค้าสมาชิก" value="ลูกค้าสมาชิก" maxlength="10" style="background: #C0F9BD" class="form-control" readonly> 
                                            </div> 
                                            <!-- <div class="input-group"style="width:60%;"> -->
                                                <!-- <label>ประเภทสมาชิก</label> <font color="red">*</font> -->

                                                <!-- <select name="ID_CusType" id="ID_CusType" class="idropdown"> -->
                                                    <!-- <option value="">ประเภทสมาชิก</option> -->
                                                    <!-- <option selected="" value="CT01" >ลูกค้าสมาชิก</option> -->

                                                    <?php
                                                    /*

                                                    while ($row = mysql_fetch_array($strResult)) {
                                                        // if ($objResult["ID_CusType"] == "CT01") {
                                                        ?>
                                                        <option selected="" value="<?= $row['ID_CusType'] ?>" ><?= $row['Name_CusType'] ?></option>
                                                        <!-- <option selected="" value="<?= $objResult["ID_TypeEmp"] ?>" style="background: #C0F9BD"><?= $objResult["Name_TypeEmp"]; ?></option> -->
                                                        <?php
                                                    // }
                                                    }
                                                    */
                                                    ?>        
                                                <!-- </select>  -->
                                            <!-- </div>  -->
                                        </div> 
                                        <div class="col-lg-6">
                                            <div class="input-group"style="width:60%;">
                                                <label>ชื่อผู้ใช้งาน</label> <font color="red">*</font>
                                                <span id="ituse" style="margin-left: 30px;color: blue;font-weight: 500;">สามารถใช้ชื่อนี้ได้</span> 
                                                <span id="onuse" style="margin-left: 30px;color: red;font-weight: 500;">ไม่สามารถใช้ชื่อนี้ได้</span>
                                                <input type="text" name="username" id="username" required placeholder="ชื่อผู้ใช้งาน" maxlength="40" style="background: #C0F9BD" class="form-control">
                                            </div> 
                                            <div class="input-group"style="width:60%;">
                                                <label>รหัสผ่าน</label> <font color="red">*</font>
                                                <span id="ans" style="margin-left: 30px;font-weight: 500;"></span>
                                                <!-- <input type="Password" name="Password" id="Password" placeholder="Password" maxlength="40" style="background: #C0F9BD" class="form-control"> -->
                                                <input type="password" name="password" onkeypress="checkPassword()" onchange="validatepassword()" id="password" required placeholder="รหัสผ่าน" maxlength="40" style="background: #C0F9BD" class="form-control" /><br />
                                            </div> 
                                            <div class="input-group"style="width:60%;">
                                                <label>ยืนยันรหัสผ่าน</label> <font color="red">*</font>
                                                <!-- <input type="Password" name="Password" id="Password" placeholder="Password" maxlength="40" style="background: #C0F9BD" class="form-control"> -->
                                                <input type="password" name="confirmpassword" onchange="validatepassword()" id="repassword" required placeholder="ยืนยันรหัสผ่าน" maxlength="40" style="background: #C0F9BD" class="form-control" /><br /> 
                                                <!--<br><br><input type="submit" onclick="return validatepassword();"  class="btn btn-info" name="Button" value="ตรวจสอบรหัสผ่าน" />-->
                                                <label id="success" for="" style="margin-left: 20px;color: blue;">รหัสผ่านตรงกัน</label>
                                                <label id="error" for="" style="margin-left: 20px;color: red;">รหัสผ่านไม่ตรงกัน</label>
                                            </div> 
                                            <script type="text/javascript">
                                                $('#success').hide();
                                                $('#error').hide();
                                                function validatepassword() {
                                                    var password = $('#password').val();
                                                    var repassword = $('#repassword').val();
                                                    if (password != repassword) {
                                                        $('#success').hide();
                                                        $('#error').show();
                                                        $('#repassword').val("");
                                                    } else {
                                                        $('#success').show();
                                                        $('#error').hide();
                                                    }
                                                    return false;
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
                                        <center>
                                            <br>
                                            <input id="add" type="submit" class="btn btn-primary" name="Button" value="เพิ่มข้อมูล">
                                            <input id="update"type="submit" onclick="return confirm('ยืนยันการแก้ไขข้อมูล');" class="btn btn-warning" name="Button" value="แก้ไขข้อมูล"> 
                                            <input id="delete" onclick="return confirm('ยืนยันการลบข้อมูล');" type="submit" class="btn btn-danger" name="Button" value="ลบข้อมูล"> 
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
                                                    //console.log(json);
                                                    $.post("./customer.service.php", json).done(function (data) {
                                                        var cus = JSON.parse(data);
                                                        console.log(data);
                                                        if (cus.ID_Cus > 0) {
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
                                                $('#Email_Cus').change(function () {
                                                    var Email = $('#Email_Cus').val();
                                                    var json = {'Email': Email, 'table': "member"}; 
                                                    $.post("./customer.service.php", json).done(function (data) { 
                                                        var email = JSON.parse(data); 
                                                        var json2 = {'Email': Email, 'table': "customers"};
                                                        $.post("./customer.service.php", json2).done(function (datax) { 
                                                            var email2 = JSON.parse(datax);
                                                            if (email.Email > 0 || email2.Email > 0) {
                                                                alert("ไม่สามารถใช้ Email นี้ได้");
                                                                $('#Email_Cus').val("");
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>
                                        </center>
                                    </div>
                                </div>
                            </form>

                            <div class="customer">
                                    <div class="row">
                                        <div class="padform">
                                            <form action="./customer.php" method="get">
                                            <table class="table">
                                                            <tr>
                                                                <td style="border: none;width: 15%;">
                                                                    <h3>ค้นหาข้อมูลสมาชิก</h3>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4"style="border: none;">
                                                                    <table>
                                                                        <tr>
                                                                            <td style="border: none;padding: 8px;width: 46%;">
                                                                                <label>ชื่อ หรือ นามสุกล</label>
                                                                            </td>
                                                                            <td style="border: none;padding: 8px;width: 40%;">
                                                                                <input name="q" id="q" type="text" placeholder="ชื่อ หรือ นามสกุล" style="background: #C0F9BD;width:100% " class="form-control point" value=""> 
                                                                            </td>
                                                                            <td style="border: none;padding: 8px;">
                                                                                <input type="submit" class="btn btn-primary" value="ค้นหา">
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                
                                                <!-- <input type="text" name="q" value=""> -->
                                                
                                            </form>

                            <div class="row"> 
                                <div class="col-md-12"> 
                                    <?php
                                    $sql = "SELECT * FROM customers c, prefix p, CusType t, member m WHERE c.ID_Prefix = p.ID_Prefix AND t.ID_CusType = c.ID_CusType AND c.username = m.username ORDER BY c.ID_Cus ASC";
                                    $query = mysql_query($sql);
                                    ?>
                                    <div class="bs-example">
                                        <div class="panel panel-default"> 
                                            <div class="panel-heading"><h4>ข้อมูลสมาชิก</h4></div>  
                                            <div class="mygrid-wrapper-div">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัสสมาชิก</th>
                                                            <th>คำนำหน้าชื่อ</th>
                                                            <th>ชื่อสมาชิก</th>
                                                            <th>นามสกุลสมาชิก</th>
                                                            <th>เบอร์โทรศัพท์</th>
                                                            <th><center>Email</center></th>
                                                            <th>ประเภทสมาชิก</th>
                                                    <!-- <th>รหัสประจำตัวประชาชน</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php while ($row_customer = mysql_fetch_array($query)) { ?>
                                                            <tr>
                                                                <td>
                                                                    <a id="<?= $row_customer['ID_Cus'] ?>" class="point">
                                                                        <?php echo $row_customer['ID_Cus']; ?>
                                                                    </a>
                                                                </td>
                                                                <td><?php echo $row_customer['Name_Prefix']; ?></td>
                                                                <td><?php echo $row_customer['FName_Cus']; ?></td>
                                                                <td><?php echo $row_customer['LName_Cus']; ?></td>
                                                                <td><?php echo $row_customer['Tel_Cus']; ?></td>
                                                                <td><?php echo $row_customer['Email_Cus']; ?></td>
                                                                <td><span id="center"><?php echo $row_customer['Name_CusType']; ?></span></td>
                                                                <!-- <td><span id="center"><?php //echo $row_customer['personal_ID']; ?></span></td> -->
                                                            </tr> 
                                                        <script type="text/javascript"> 
                                                            $("#<?= $row_customer['ID_Cus'] ?>").click(function () {
                                                                <?php echo ($row_customer['ID_Cus'] == "C000")? "$('#delete').hide();":"$('#delete').show();"; ?>
                                                                $('#add').hide();
                                                                ID_Cus.value = "<?= $row_customer['ID_Cus'] ?>";
                                                                ID_Prefix.value = "<?= $row_customer['ID_Prefix'] ?>";
                                                                FName_Cus.value = "<?= $row_customer['FName_Cus'] ?>";
                                                                LName_Cus.value = "<?= $row_customer['LName_Cus'] ?>";
                                                                Tel_Cus.value = "<?= $row_customer['Tel_Cus'] ?>";
                                                                Email_Cus.value = "<?= $row_customer['Email_Cus'] ?>";
                                                                //ID_CusTypes.value = "<?= $row_customer['ID_CusType'] ?>";
                                                                username.value = "<?= $row_customer['username'] ?>";
                                                                password.value = "<?= base64_decode($row_customer['password']) ?>";
                                                                repassword.value = "<?= base64_decode($row_customer['password']) ?>";
                                                                // personal_ID.value = "<?php //$row_customer['personal_ID']  ?>";
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
                        $('#customer').addClass('active');
                    });
                </script>
                <?php include("../fragments/footer.php"); ?>
            </footer>
        </body>
    </html>
<?php } }?>