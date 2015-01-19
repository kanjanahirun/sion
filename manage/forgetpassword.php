<?php
include("./connect/connect.php");

if (!empty($_POST['Submit'])) 
{
    $username = $_POST['Username'];
    if(!empty($username))
    {
        $sqlGetUser = "SELECT * FROM member WHERE Email = '" . mysql_real_escape_string($username) . "'";

        $objQuery = mysql_query($sqlGetUser);
        $objResult = mysql_fetch_assoc($objQuery);

        if(!$objResult)
        {
            echo "<script type='text/javascript'>alert('ไม่พบ E-mail นี้ : ". $username ."')</script>";
        }
        else
        {
            // echo "Your password send successful.<br>Send to mail : ".$objResult["Email"];       

            $strTo = $objResult["Email"];

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
        echo "<script>alert('กรุณากรอก E-mail');</script>";   
    }
}

?>
<html>
    <head> 
        <title>Welcome to SiOn Salon</title>
        <?php include("./fragments/libindex.php"); ?>
        <style type="text/css">
            input[type="text"],input[type="password"]{
                background: rgba(0, 0, 0, 0);
                color: rgb(255, 255, 255);
                padding: 10px;
                border: 1px solid rgb(247, 247, 247);
                height: 40px;
                width: 17em;
                border-radius: 4px;
                margin: 15px 15px 0px;
            }
            input[type="submit"]{
                width: 15%;
                margin-left: 5em;
            }
        </style>
    </head> 
    <body class="login">
        <div class="container">
            <br><br><br>
            <center>
                <img src="./assets/image/SiOn2.jpg" width="30%"> 
            </center>

            <br><br><br><br>

            <form name="form1" method="post" action="">  
                <center>  
                    <span class="color">กรุณากรอก E-mail</span> 
                    <input type="email" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" name="Username" id="Username" placeholder="Username or E-mail"> <br><br>
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

                    <input type="submit" class="btn btn-danger" name="Submit" value="Send Password"> 
                </center>
            </form>
        </div>
    </body>
</html>

