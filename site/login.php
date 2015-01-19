<?php
session_start();

include("../manage/connect/connect.php");

if (!empty($_POST['Submit'])) {

    $strSQL = "SELECT * FROM customers c inner join custype t on c.ID_CusType=t.ID_CusType WHERE c.username = '" . mysql_real_escape_string($_POST['Username']) . "' and c.password='" . mysql_real_escape_string($_POST['Password']) . "'";
    ;
    $objQuery = mysql_query($strSQL);
    $objResult = mysql_fetch_assoc($objQuery);

    if (!$objResult) {
        echo "<script type='text/javascript'>alert('Username หรือ Password ไม่ถูกต้อง')</script>";
    } else {
        $_SESSION['CUsername'] = $_POST['Username'];
        $_SESSION['Cname'] = $objResult['FName_Cus'] . " " . $objResult['LName_Cus'];
        $_SESSION['Cstatus'] = "customer";
        $_SESSION['custype'] = $objResult['Name_CusType'];
        session_write_close();
        header("Location:index.php");
    }
}
?>
<html>
    <head> 
        <title>Login</title>   
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
            input[type=text],input[type=password]{
                height: 45px;
                width: 240px;
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
                height: 45px;
                width: 240px;
                float: right;
                background: rgb(255, 165, 0);
                color: rgb(255, 255, 255);
                border: 2px solid rgb(255, 165, 0);
                border-radius: 4px;
                font-weight: 300;
                margin: 5px;
                cursor: pointer;
                font-size: 16px;
            }
            input[type=submit]:hover{
                background: rgb(242, 161, 12);
                border: 2px solid rgb(242, 161, 12);
                font-size: 16px;
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
                        <div class="slider-wrapper" style="background: transparent;">
                            <div class="slider" style="z-index: 1; overflow: hidden;"> 
                                <div style="margin-top: 10%;">
                                    <center>
                                        <form name="form1" method="post" action="">  
                                            <table>
                                                <tr>
                                                    <td style="padding-top: 15px;">
                                                        <span style="color:#fff;font-size: 20px;font-family: cursive;">
                                                            Username
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="Username" placeholder="Username">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 15px;">
                                                        <span style="color:#fff;font-size: 20px;font-family: cursive;">
                                                            Password
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <input type="password"  class="form-control" name="Password" placeholder="Password">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <input type="submit" class="btn btn-danger" name="Submit" value="เข้าสู่ระบบ">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <a style="margin-left: 7em;" href="./forgetpassword.php" class="btn btn-danger" name="Forget">ลืมรหัสผ่าน</a> 
                                                    </td>
                                                </tr>
                                            </table 
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


