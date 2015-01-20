<?php
session_start();

include("../connect/connect.php");

if (empty($_SESSION['Username'])) {
    if (empty($_SESSION['Username']) || empty($_SESSION['status']) || empty($_SESSION['name'])) {
        echo alert('กรุณาเข้าสู่ระบบ Admin ก่อน');
        echo location("../login.php");
    }
} else {  ?>

<html>
<head>
    <title> ร้านศรีอ้น แฮร์ & สปาร์ </title>

    <?php include("../fragments/libmanage.php"); ?>

</head>
<body id="bg">
    <h4 style="margin-left: 15%; margin-top: 10% ; font-size: 16"> เลขที่สั่งซื้อ : </h3>
    <center><table style="margin-top: 5%" width="100%"> 
        <tr>
            <td style="padding: 5px;font-size: 23px"><center><u>
                แบบฟอร์มการส่ังซื้อสินค้า
            </center></td>
        </tr>
        <tr>
            <th style="font-size: 20"><center style="margin-top: 2%;">ร้านศรีอ้น แฮร์&สปา</center></th>
            
        </tr>
        <tr>
            <td style="padding: 10px;font-size: 15"><center>เลขที่ 134 ม.5 ต.เนินหอม อ.เมือง จ.ปราจีนบุรี 25230</center></td>
        </tr>
        <tr>
            <td style="padding: 3px;font-size: 17" ><center>
            

             <div id="local_time" style="padding: 0px;font-size: 15">&nbsp;</div>
             <script language="JavaScript1.2">
             <!--
             function local_date(now_time) {
                current_local_time = new Date();

                var thday = new Array ("อาทิตย์","จันทร์",
                    "อังคาร","พุธ","พฤหัส","ศุกร์","เสาร์"); 
                var thmonth = new Array ("มกราคม","กุมภาพันธ์","มีนาคม",
                    "เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน",
                    "ตุลาคม","พฤศจิกายน","ธันวาคม");
                
                var hours = current_local_time.getHours().toString();
                hours = hours.length == 1 ? "0"+hours : hours;
                var minus = current_local_time.getMinutes().toString();
                minus = minus.length == 1 ? "0"+minus : minus;
                var second = current_local_time.getSeconds().toString();
                second = second.length == 1 ? "0"+second : second;
                local_time.innerHTML = "ออก ณ วัน" + thday[current_local_time.getDay()]+ "ที่ "+ current_local_time.getDate() + " " + thmonth[current_local_time.getMonth()] + "  " + (0+current_local_time.getYear()+2443) + "  " + hours + ":" + minus + ":" + second;

                setTimeout("local_date()",1000);
            }

            setTimeout("local_date()",1000);

            </script>     

            </center></td>
        </tr>
        <tr>
            <td>



            </td>
        </tr>
    </table></center>
</body>

</html>


<?php } ?>