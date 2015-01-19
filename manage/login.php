<?php
session_start();
include("./connect/connect.php");


//if (!empty($_POST['Username']) && !empty($_POST['Password'])) {
//    $strSQL = "SELECT * FROM member WHERE username = '" . mysql_real_escape_string($_POST['Username']) . "'and Password = '" . mysql_real_escape_string($_POST['Password']) . "'";
//    $objQuery = mysql_query($strSQL);
//    $objResult = mysql_fetch_array($objQuery);
////รับค่าจากฟอร์ม
//    $button = $_POST['Submit'];
//
//    if ($button == 'Login') { // ถ้ากดปุ่ม แล้วปุ่ม = Login
//        if (!$objResult) {
//            echo "<script type='text/javascript'>alert('Username or Password incorrect')</script>";
//        } else {
//            $_SESSION['Username'] = $_POST['Username'];
//            $_SESSION['ID_Status'] = $objResult['ID_Status'];
//
//            if ($objResult['ID_Status'] == "s001") {
//                header("location:admin/base.php");
//            } elseif ($objResult['ID_Status'] == "s002") {
//                header("location:emp_page.php");
//            } else {
//                header("location:cus_page.php");
//            }
//            session_write_close();
//        }
//    }
//}
 

if (!empty($_POST['Submit'])) {
    //$strSQL = "SELECT * FROM member m inner join status s on s.ID_status = m.ID_status inner join admin a  on a.ID_member = m.ID_member WHERE username = '" . mysql_real_escape_string($_POST['Username']) . "' and password='" . mysql_real_escape_string($_POST['Password']) . "'";
    $sql = "SELECT * FROM member WHERE username = '" . mysql_real_escape_string($_POST['Username']) . "'and Password = '" . base64_encode(mysql_real_escape_string($_POST['Password'])) . "'";
    $query = mysql_query($sql);
    $objResult = mysql_fetch_assoc($query);

    if (!$objResult) {
        echo "<script type='text/javascript'>alert('Username or Password incorrect')</script>";
    } else {
        $_SESSION['Username'] = $_POST['Username'];
        $username = $_POST['Username'];
        $ID_member = $objResult['ID_member'];
        $ID_status = $objResult['ID_Status'];
        $_SESSION['ID_Status'] = $objResult['ID_Status'];
        if ($objResult['ID_Status'] == "s001") {        // admin
            // $sql = "SELECT * FROM member m inner join admin a on m.ID_member=a.ID_member inner join status s on m.ID_status=s.ID_status WHERE a.ID_member='$ID_member' AND m.ID_status='$ID_status'";
            $sql = "SELECT * FROM member m inner join employees e on m.username=e.username inner join status s on m.ID_status=s.ID_status WHERE m.username='$username' AND m.ID_status='$ID_status'";
            $rs = mysql_fetch_assoc(mysql_query($sql));
            $_SESSION['status'] = $rs['Name_status'];
            $_SESSION['id'] = $rs['ID_Emp'];
            $_SESSION['name'] = $rs['FName_Emp'];
            $_SESSION['surname'] = $rs2['LName_Emp'];
//            echo $_SESSION['status']."<br>";
//            echo $_SESSION['id']."<br>";
//            echo $_SESSION['name']."<br>";  
            header("location:admin/base.php");
        } elseif ($objResult['ID_Status'] == "s002") {  // employee
            $sql = "SELECT * FROM member m inner join employees e on m.username=e.username inner join status s on m.ID_status=s.ID_status WHERE m.username='$username' AND m.ID_status='$ID_status'";
            $rs2 = mysql_fetch_assoc(mysql_query($sql));
            $_SESSION['status'] = $rs2['Name_status'];
            $_SESSION['id'] = $rs2['ID_Emp'];
            $_SESSION['name'] = $rs2['FName_Emp'];
            $_SESSION['surname'] = $rs2['LName_Emp'];
//            echo $_SESSION['status']."<br>";
//            echo $_SESSION['id']."<br>";
//            echo $_SESSION['name']."<br>";
//            echo $_SESSION['surname']."<br>";
            header("location:admin/addorder.php");
        }
//        else {                                        // member
//            $_SESSION['status'] = $objResult['Name_status'];
//            header("location:site/cus_page.php");
//        }
        session_write_close();
    }
}

if (!empty($_SESSION['Username']) && !empty($_SESSION['status'])) {
    if ($_SESSION['status'] == "admin") {
        echo "<script>location='./admin/base.php'</script>";
    } elseif ($_SESSION['status'] == "employee") {
        echo "<script>location='./admin/addorder.php'</script>";
    } 
    elseif ($_SESSION['status'] == "customer") {
        echo "<script>location='../site/index.php'</script>";
    } elseif ($_SESSION['status'] == "member") {
        echo "<script>location='../site/index.php'</script>";
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
                width: 9%;
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
                    <span class="color">Username</span> 
                    <input type="text" name="Username" id="Username" placeholder="Username"> <br>
                    <span class="color">Password</span>
                    <input type="password" name="Password" id="Password" placeholder="Password"><br><br>
                    <input type="submit" class="btn btn-danger" name="Submit" value="Login"> 
                    <a href="./forgetpassword.php" class="btn btn-danger" name="Forget">ลืมรหัสผ่าน</a> 
                </center>
            </form>
        </div>
    </body>
</html>

