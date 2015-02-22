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
    <style type="text/css">
    table.one
    {
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
    }
    </style>
    <title> ร้านศรีอ้น แฮร์ & สปาร์ </title>

    <?php include("../fragments/libmanage.php"); ?>

</head>
<body > <!-- onload="window.print()" -->   
<?php 
    $ID_oOrder = $_GET['id'];
?> 
    <table border="1.5" width="95%" height="950px" style="margin-left: auto;margin-right: auto;margin-top: 4%;">
        <tbody><tr height="10%">
            <td style="width:70%" colspan="2">
                <table border="0" height="20%" style="margin-top: 7;margin-left: auto;margin-right: auto;">
                    <tr>
                        <th style="font-size: 20"><center style="margin-top: 2%;">ร้านศรีอ้น แฮร์&สปา</center></th>
                    </tr>
                    <tr>
                        <td style="font-size: 10"><center style="margin-top: 2%;">เลขที่ 134 ม.5 ต.เนินหอม อ.เมือง จ.ปราจีนบุรี 25230</center></td>
                    </tr>
                    <tr>
                        <td style="font-size: 10"><center style="margin-top: 2%;">โทร 099-999-9999</center></td>
                    </tr>
                    <tr>
                        <td style="font-size: 17"><center style="margin-top: 2%;"><u>ใบสั่งซื้อสินค้า</u></center></td>
                    </tr>
                    
                </table>
                <table class="one" border="1" style="margin-top: -10;margin-left: auto;margin-right: 45;" width="20%">
                    <tr>
                        <td style="font-size: 15 ;" >รหัสสั่งซื้อ</td>
                        <td><?php echo $ID_oOrder; ?></td>
                    </tr>
                    <tr>
                        <td style="font-size: 15 ;">วันที่ออก</td>
                        <td><div id="clockbox" style="font-size:15"></div></td>
                    </tr>
                </table>
            </td>
            
        </tr>
        <tr height="100px">
            <?php
                $sql = "SELECT o.ID_Order, o.Date_Order, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.Cost_Price,p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, od.ID_Count,ic.Amount_Unit,c.ID_Company, c.Name_Company, c.Address , c.Tel , p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.FName_Emp, e.LName_Emp FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp INNER JOIN count ic on od.ID_Count=ic.ID_Count WHERE o.ID_Order = '" . $ID_oOrder . "' ORDER BY o.ID_Order ASC";
                $result = mysql_query($sql);
                $orderDetail = mysql_fetch_array($result);
            ?>
            <td width="50%" ><center>
                <table border="1" width="95%">
                    <tr>
                        <td width="30%">
                            ชื่อบริษัท
                        </td>
                        <td>
                            <!-- coding --><?php echo $orderDetail['Name_Company']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">
                            ที่อยู่
                        </td>
                        <td>
                            <!-- coding --><?php echo $orderDetail['Address']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">
                            เบอร์ติดต่อ
                        </td>
                        <td>
                            <!-- coding --><?php echo $orderDetail['Tel']; ?>
                        </td>
                    </tr>
                </table>
            </center></td>
            <td width="50%"><center>
                <table border="1" width="95%">
                    <?php
                $sql = "SELECT o.ID_Order, o.ID_Emp, o.Date_Order, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.Cost_Price,p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, od.ID_Count,ic.Amount_Unit,c.ID_Company, c.Name_Company, c.Address , c.Tel , p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.FName_Emp, e.LName_Emp,e.Tel_Emp FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp INNER JOIN count ic on od.ID_Count=ic.ID_Count WHERE o.ID_Order = '" . $ID_oOrder . "' ORDER BY o.ID_Order ASC";
                $result = mysql_query($sql);
                $orderDetail = mysql_fetch_array($result);
            ?>
                    <tr>
                        <td width="30%">
                            รหัสผู้สั่ง 
                            <?php
                                // $num1 = 2;
                                // $num2 = 5; 
                                // $sum = $num1*$num2;
                                // echo $sum;
                             ?>
                        </td>
                        <td>
                            <!-- coding --><?php echo $orderDetail['ID_Emp']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">
                            ชื่อ-สกุล
                        </td>
                        <td>
                            <!-- coding --><?php echo $orderDetail['FName_Emp']; ?>             <?php echo $orderDetail['LName_Emp']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">
                            เบอร์ติดต่อ
                        </td>
                        <td>
                            <!-- coding --><?php echo $orderDetail['Tel_Emp']; ?>
                        </td>
                    </tr>
                </table>
            </center></td>
        </tr>
        <tr>
            <td  colspan="2"><center>
                <table border="1" style="margin-bottom:550;margin-right:auto;margin-left:auto;" width="90%" >
                    <tr>
                        <td colspan="6"><center>
                            รายการสินค้า
                        </center></td>
                    </tr>
                    <tr>
                        <td width="12%"><center>รหัสสินค้า</center></td>
                        <td width=""><center>ชื่อสินค้า</center></td>
                        <td width=""><center>จำนวนสินค้า</center></td>
                        <td widht=""><center>หน่วยนับ</center></td>
                        <td width=""><center>ราคาต่อหน่วย(บาท)</center></td>
                        <td width=""><center>ราคารวม(บาท)</center></td>
                    </tr>
                    <tbody><?php
                            $sql = "SELECT o.ID_Order, o.ID_Emp, o.Date_Order, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.Cost_Price,p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, od.ID_Count,ic.Name_Count,ic.Amount_Unit,c.ID_Company, c.Name_Company, c.Address , c.Tel , p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.FName_Emp, e.LName_Emp,e.Tel_Emp FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp INNER JOIN count ic on od.ID_Count=ic.ID_Count WHERE o.ID_Order = '" . $ID_oOrder . "' ORDER BY o.ID_Order ASC";
                            $result = mysql_query($sql);
                            
                            ?>
                                <?php
                                $total_prices = 0;
                                while ($orderDetail = mysql_fetch_array($result)) {
                                    $total_tmp = str_replace(",", "", $orderDetail['Total_Price']);
                                    $total_prices += $total_tmp;
                                    ?>
                                    <tr> 
                                        <td>
                                            <?php echo $orderDetail['ID_Product']; ?>
                                        </td> 
                                        <td>
                                            <?php echo $orderDetail['Product_Name']; ?>
                                        </td>   
                                        <td><span style="float: right;"><?php echo $orderDetail['ODAmount_Product']; ?></span></td>
                                        <td><center><?php echo $orderDetail['Name_Count']; ?></center></td>  
                                        <td><span style="float: right;"><?php echo $orderDetail['Cost_Price']; ?></span></td>  
                                        <td><span style="float: right;"><?php echo $orderDetail['Total_Price']; ?></span></td> 

                                    </tr>
                                    <?php
                                }
                                ?>
                                
                            </tbody>
                    <tr>
                        <td colspan="5" align="right">
                            ราคารวม(บาท)
                        </td>
                        <td align="right">
                            <b><?= number_format($total_prices, 2) ?></b> 
                        </td>
                    </tr>
                </table>
            </center></td>
        </tr>
    </tbody></table>
    <script type="text/javascript">
    function GetClock(){
        var d=new Date();
        var nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear();
        if(nyear<1000) nyear+=1900;

        document.getElementById('clockbox').innerHTML=""+ndate+"/"+(nmonth+1)+"/"+nyear+"";
    }

    window.onload=function(){
        GetClock();
        setInterval(GetClock,1000);
        window.print();
    }
    </script> 
</body>

</html>


<?php } ?>