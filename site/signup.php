<?php
session_start();

include("../manage/connect/connect.php");
?>
<html>
    <head> 
        <title>Sign up</title>   
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/reset.css" type="text/css" media="screen">
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
        <link rel="stylesheet" href="css/grid.css" type="text/css" media="screen"> 
        <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>  
        <script src="js/jquery-1.6.3.min.js" type="text/javascript"></script>
        <script src="js/cufon-yui.js" type="text/javascript"></script>
        <script src="js/cufon-replace.js" type="text/javascript"></script>
        <script src="js/PT_Sans_400.font.js" type="text/javascript"></script>
        <script src="js/PT_Sans_italic_400.font.js" type="text/javascript"></script> 
        <script src="js/Satisfy_400.font.js" type="text/javascript"></script>
        <script src="js/NewsGoth_400.font.js" type="text/javascript"></script>
        <script src="js/FF-cash.js" type="text/javascript"></script> 
        <script src="js/script.js" type="text/javascript"></script>  
        <script src="js/tms-0.3.js" type="text/javascript"></script>
        <script src="js/tms_presets.js" type="text/javascript"></script>
        <script src="js/jquery.easing.1.3.js" type="text/javascript"></script>	 
        <script src="js/easyTooltip.js" type="text/javascript"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style> 
            input[type=text],input[type=password],input[type=email]{
                height: 40px;
                width: 99%;
                font-size: 15px;
                border: 1px solid rgb(247, 247, 247);
                border-radius: 4px;
                padding: 10px;
                margin: 5px;
                background: rgba(0, 0, 0, 0);
                color: rgb(255, 255, 255);
            }
            input[type=submit]{
                font-size: 15px;
                height: 40px;
                width: 240px;
                float: right;
                background: rgb(255, 165, 0);
                color: rgb(255, 255, 255);
                border: 2px solid rgb(255, 165, 0);
                border-radius: 4px;
                font-weight: 300;
                font-size: 16px;
                margin: 5px;
                cursor: pointer;
                margin-right: 8px;
            }
            input[type=submit]:hover{
                background: rgb(242, 161, 12);
                font-size: 16px;
                border: 2px solid rgb(242, 161, 12);
                color: black;
            } 
            .idropdown{
                height: 40px;
                cursor: pointer;
                margin-top: 5px;
                padding-left: 5px;
                width: 99%;
                border-radius: 4px;
                border: 1px solid #D4D0D0;
                font-size: 16px;
                margin-left: 5px;
                background: transparent;
                color: gray;
            } 
        </style>
    </head> 
    <body id="page1">
        <div  class="extra">
            <header> 
                <div class="header-row"><div class="ic"></div>
                    <div class="main">
                        <h1 class="margin-bot">
                            <a href="./index.php">Sion</a>
                            <em><cufon class="cufon cufon-canvas" alt="Keep " style="width: 41px; height: 20px;"><canvas width="61" height="21" style="width: 61px; height: 21px; top: 0px; left: -2px;"></canvas><cufontext>Keep </cufontext></cufon><cufon class="cufon cufon-canvas" alt="Your " style="width: 37px; height: 20px;"><canvas width="57" height="21" style="width: 57px; height: 21px; top: 0px; left: -2px;"></canvas><cufontext>Your </cufontext></cufon><cufon class="cufon cufon-canvas" alt="Perfect " style="width: 54px; height: 20px;"><canvas width="75" height="21" style="width: 75px; height: 21px; top: 0px; left: -2px;"></canvas><cufontext>Perfect </cufontext></cufon><cufon class="cufon cufon-canvas" alt="Look" style="width: 35px; height: 20px;"><canvas width="52" height="21" style="width: 52px; height: 21px; top: 0px; left: -2px;"></canvas><cufontext>Look</cufontext></cufon></em>
                            <?php
                            if (empty($_SESSION['Username'])) {
                                echo '<em id="login" style="float:right;cursor: pointer;color: #15B715;">Login</em>';
                                echo '<em id="signup" style="float:right;cursor: pointer;margin-right: 1em;color: white;">Sign up</em>';
                            } else {
                                echo '<em id="logout" style="float:right;cursor: pointer;">Logout</em>';
                                echo '<em id="username" style="float:right;color:orange;cursor: pointer;margin-right: 1em;">' . $_SESSION['Username'] . '</em>';
                            }
                            ?> 
                        </h1>  
                        <script type="text/javascript">
                            $('#login').click(function () { $(location).attr('href', './login.php'); });
                            $('#signup').click(function () { $(location).attr('href', './signup.php'); });
                            $('#logout').click(function () { $(location).attr('href', './logout.php'); });
                            $('#username').click(function () { $(location).attr('href', './profile.php'); });
                        </script>
                        <div style="background: transparent;">
                            <div> 
                                <div>  
                                    <center>
                                        <form name="form1" method="post" action="">  
                                            <table style="width: 70%;">
                                                <tr>
                                                    <td style="padding: 10px;">
                                                        <span style="color:#fff;font-size: 20px;font-family: cursive;">รหัสสมาชิก</span><br>
                                                        <div style="color: #fff;margin-top: 16px;font-size: 20px;margin-left: 5px;">C001</div>
                                                        <input type="hidden" name="ID_Customer" id="ID_Customer" value="">
                                                    </td>
                                                    <td style="padding: 10px;">
                                                        <span style="color:#fff;font-size: 20px;font-family: cursive;">คำนำหน้าชื่อ</span><br>
                                                        <?php
                                                        $sql = "SELECT * FROM prefix order by Name_Prefix";
                                                        $strResult = mysql_query($sql);
                                                        ?>
                                                        <select name="ID_Prefix" id="ID_Prefix" class="idropdown" required="">
                                                            <option value="">คำนำหน้าชื่อ</option>
                                                            <?php
                                                            while ($row = mysql_fetch_assoc($strResult)) {
                                                                ?>
                                                                <option value="<?= $row['ID_Prefix'] ?>"><?= $row['Name_Prefix'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 10px;">
                                                        <span style="color:#fff;font-size: 20px;font-family: cursive;">ฃื่อสมาชิก</span><br>
                                                        <input type="text" class="form-control" id="FName_Cus" name="FName_Cus" placeholder="ฃื่อสมาชิก" required="">
                                                    </td>
                                                    <td style="padding: 10px;">
                                                        <span style="color:#fff;font-size: 20px;font-family: cursive;">นามสกุลสมาชิก</span><br>
                                                        <input type="text" class="form-control" id="LName_Cus" name="LName_Cus" placeholder="นามสกุลสมาชิก" required="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 10px;">
                                                        <span style="color:#fff;font-size: 20px;font-family: cursive;">เบอร์โทรศัพท์</span><br>
                                                        <input type="text" class="form-control" id="Tel_Cus" name="Tel_Cus" maxlength="10" placeholder="เบอร์โทรศัพท์" required="">
                                                    </td>
                                                    <td style="padding: 10px;">
                                                        <span style="color:#fff;font-size: 20px;font-family: cursive;">E-mail</span><br>
                                                        <input type="email" class="form-control" id="Email_Cus" name="Email_Cus" placeholder="E-mail" required="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 10px;">
                                                        <span style="color:#fff;font-size: 20px;font-family: cursive;">ประเภทสมาชิก</span><br>
                                                        <?php
                                                        $sql = "SELECT * FROM custype order by Name_CusType";
                                                        $strResult = mysql_query($sql);
                                                        ?>
                                                        <select name="ID_CusType" id="ID_CusType" class="idropdown" required="">
                                                            <option value="">ประเภทสมาชิก</option>  
                                                            <?php
                                                            while ($row = mysql_fetch_assoc($strResult)) {
                                                                ?>
                                                                <option value="<?= $row['ID_CusType'] ?>"><?= $row['Name_CusType'] ?></option>
                                                                <?php
                                                            }
                                                            ?>	 
                                                    </td>
                                                    <td style="padding: 10px;">
                                                        <span style="color:#fff;font-size: 20px;font-family: cursive;">ชื่อผู้ใช้งาน</span><br>
                                                        <input type="text" class="form-control" id="User_name" name="User_name" placeholder="ชื่อผู้ใช้งาน" required="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 10px;">
                                                        <span style="color:#fff;font-size: 20px;font-family: cursive;">รหัสผ่าน</span><br>
                                                        <input type="password" class="form-control" id="password" name="password" placeholder="รหัสผ่าน" required="">
                                                    </td>
                                                    <td style="padding: 10px;">
                                                        <span style="color:#fff;font-size: 20px;font-family: cursive;">ยืนยันรหัสผ่าน</span><br>
                                                        <input type="password" class="form-control" id="repassword" name="repassword" placeholder="ยืนยันรหัสผ่าน" required="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <input type="submit" class="btn btn-danger" name="Submit" value="สมัครสมาชิก">
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </center> 
                                </div>
                            </div> 
                        </div> 			   
                    </div>
                </div> 
            </header> 
        </div> 
    </body>
</html>



