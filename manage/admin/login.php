<?php
session_start();

include("../connect/connect.php");

if (!empty($_POST['Submit'])) {
    $button = $_POST['Submit'];
    
    if ($button == 'เข้าสู่ระบบ') { // ถ้ากดปุ่ม แล้วปุ่ม = Login
        $sql = "SELECT * FROM member m inner join status s on s.ID_status = m.ID_status inner join admin a  on a.ID_member = m.ID_member WHERE username = '" . mysql_real_escape_string($_POST['Username']) . "' and password='" . mysql_real_escape_string($_POST['Password']) . "'";
        $query = mysql_query($sql);
        $objResult = mysql_fetch_array($query);

        if (!$objResult) {
            echo "<script type='text/javascript'>alert('Username หรือ Password ไม่ถูกต้อง')</script>";
        } else {
            $_SESSION['Username'] = $_POST['Username'];
            $_SESSION['ID_Status'] = $objResult['ID_Status'];

            if ($objResult['ID_Status'] == "s001") {
                $_SESSION['status'] = $objResult['Name_status'];
                $_SESSION['name'] = $objResult['Name_Admin'];
                header("location:manage/admin/base.php");
            } elseif ($objResult['ID_Status'] == "s002") {
                $_SESSION['status'] = $objResult['Name_status'];
                header("location:manage/emp/emp_page.php");
            } else {
                $_SESSION['status'] = $objResult['Name_status'];
                header("location:site/cus_page.php");
            }
            session_write_close();
        }
    }
}
?>
<html>
    <head> 
        <title>Welcome to SiOn Salon</title>
        <?php include("../fragments/libmanage.php"); ?>
        <style>
            #pad{
                padding:7px;
            }
            #mar{
                margin-top: 25%;
            }
            #pad-left{
                padding:7px;
                margin-left: 32%;
            }
            #btn-width{
                width: 234%;
            }
        </style>
    </head> 
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="mar">
                    <form name="form1" method="post" action="">  
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="input-group" id="pad">
                                    <span class="input-group-addon">Username</span>
                                    <input type="text" class="form-control" name="Username" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="input-group" id="pad">
                                    <span class="input-group-addon">Password</span>
                                    <input type="password"  class="form-control" name="Password" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <div class="input-group" id="pad-left">
                                    <input type="submit" class="btn btn-danger" name="Submit" value="เข้าสู่ระบบ" id="btn-width">
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

