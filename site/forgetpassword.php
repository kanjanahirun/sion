<?php
session_start();

include("../manage/connect/connect.php");

if (!empty($_POST['Submit'])) {

    $username = $_POST['Username'];

    if(!empty($username))
    {
        $sqlGetUser = "SELECT * FROM customers WHERE username = '" . mysql_real_escape_string($username) . "' OR Email_Cus = '" . mysql_real_escape_string($username) . "'";

        $objQuery = mysql_query($sqlGetUser);
        $objResult = mysql_fetch_assoc($objQuery);

        if(!$objResult)
        {
            echo "<script type='text/javascript'>alert('ไม่พบ Username หรือ E-mail นี้ : ". $username ."')</script>";
        }
        else
        {
            // echo "Your password send successful.<br>Send to mail : ".$objResult["Email"];       

            $strTo = $objResult["Email_Cus"];

            $strSubject = "Your Account information username and password.";

            $strHeader = "Content-type: text/html; charset=UTF-8 \r\n"; // or UTF-8 //
            $strHeader .= " From: admin@sion-salonandspa.wc.lt \r\n Reply-To: admin@sion-salonandspa.wc.lt";
            $strMessage = "";
            // $strMessage .= "Welcome : ".$objResult["Name"]."<br>";
            $strMessage .= "Username : ".$objResult["username"]."<br>";
            $strMessage .= "Password : ". base64_decode($objResult["password"]) ."<br>";
            $strMessage .= "=================================<br>";
            $strMessage .= "Sion<br>";
            $flgSend = @mail($strTo,$strSubject,$strMessage,$strHeader);

            if($flgSend)
            {
                echo "<script type='text/javascript'>alert('Send E-mail Successful To E-mail : ". $strTo ."')</script>";
            }
            else
            {
                echo "<script type='text/javascript'>alert('Send E-mail Unsuccessful')</script>";
            }
            // echo "<script type='text/javascript'>alert('พบ Username หรือ E-mail นี้ : ". $username ."')</script>";
            //echo "<script>location='./login.php'</script>";
        }
        mysql_close();
    }
    else
    {
        echo "<script>alert('กรุณากรอก Username หรือ E-mail');</script>";   
    }
}
?>
<html>
    <head> 
        <title>Welcome to SiOn Salon</title>   
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
            }
            input[type=submit]:hover{
                background: rgb(242, 161, 12);
                border: 2px solid rgb(242, 161, 12);
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
                        </h1>  
                        <div class="slider-wrapper" style="background: transparent;">
                            <div class="slider" style="z-index: 1; overflow: hidden;">
                                <ul class="items">
                                    <li style="display: none;">
                                        <img src="./images/hair.jpg" alt="">
                                    </li>
                                    <li style="display: none;">
                                        <img src="./images/makeup.jpg" alt="">
                                    </li>
                                    <li style="display: none;">
                                        <img src="./images/spa.jpg" alt="">
                                    </li>
                                    <li style="display: none;">
                                        <img src="./images/map.jpg" alt="">
                                    </li>
                                </ul>
                                <div style="margin-top: 10%;">
                                    <center>
                                        <form name="form1" method="post" action="">  
                                            <table>
                                                <tr>
                                                    <td style="padding-top: 15px;">
                                                        <span style="color:#fff;font-size: 20px;font-family: cursive;">
                                                            Username or E-mail 
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="Username" placeholder="Username or E-mail">
                                                    </td>
                                                </tr>
                                                <!-- <tr>
                                                    <td style="padding-top: 15px;">
                                                        <span style="color:#fff;font-size: 20px;font-family: cursive;">
                                                            Password
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <input type="password"  class="form-control" name="Password" placeholder="Password">
                                                    </td>
                                                </tr> -->
                                                <tr>
                                                    <td colspan="2">
                                                        <input type="submit" class="btn btn-danger" name="Submit" value="ส่งรหัสผ่าน">
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
        <?php include './footer.php'; ?>
    </body>
</html>


