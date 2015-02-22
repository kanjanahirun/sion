<?php
session_start();
include("../connect/connect.php");

if (empty($_SESSION['Username'])) {
    if (empty($_SESSION['Username']) || empty($_SESSION['status']) || empty($_SESSION['name'])) {
        echo alert('กรุณาเข้าสู่ระบบ Admin ก่อน');
        echo location("../login.php");
    }
} else {

//echo $nextNum;
//if (!empty($_POST['Button'])) {

    if (!empty($_POST['save'])) {

        $ID_Order = $_POST['ID_Order'];
        $ID_Receive = $_POST['ID_Receive'];
        $Date_Order = format_date($_POST["Date_Order"]);
        $ID_Emp = $_POST['ID_Emp'];
        $ID_Company = $_POST['ID_Company'];
        $ID_Orderdetail = $_POST['ID_Orderdetail'];
        $ID_Product = $_POST['ID_Product'];
        $Amount_Product = $_POST['Amount_Product'];
        $Amount_Receive = $_POST['Number_Product'];
        $Amount_NonRe = $_POST['No_Receive'];
        $Product_Remand = 0; //เดี๋ยวกลับมาแก้ให้นะจ๊ะเด็กดี
        $Amount_balance = $_POST['Total_Price'];

        $ID_Count = $_POST['ID_Count'];
        $Cost_Price = $_POST['Cost_Price'];

        // ไม่แน่ใจว่าจะทำให้เกิด ปัญหา PK ซ้ำมั้ย
        $sqlRD = "SELECT `ID_Receivedetail` FROM `receive_detail` order by substr(`ID_Receivedetail`,3) desc limit 1";
        $lastID = mysql_fetch_assoc(mysql_query($sqlRD));

        // echo '<pre>';
        // print_r($Amount_Product);
        // print_r($Number_Product);
        // print_r($No_Receive);
        // print_r($ID_Orderdetail);
        // print_r($ID_Product);
        //if (!empty($ID_Order)&&!empty($ID_Receive)&&!empty($Date_Order)&&!empty($ID_Emp)&&!empty($ID_Company)&&!empty($ID_Orderdetail)&&!empty($ID_Product)&&!empty($Amount_Product)&&!empty($Number_Product)&&!empty($No_Receive)) {

        $sqlReceive = "INSERT INTO `receive` ( `ID_Receive` , `Date_Receive` , `ID_Emp` , `ID_Company` , `ID_Order` ) VALUES ( '" . $ID_Receive . "', '" . $Date_Order . "', '" . $ID_Emp . "', '" . $ID_Company . "', '" . $ID_Order . "' )";
//    echo $sqlReceive."<br>";
        $result = mysql_query($sqlReceive); 
//        $result = 1;
        if ($result) {
            $success = 0;
            $ID_Receivedetail = $lastID['ID_Receivedetail'];
            for ($i = 0; $i < count($ID_Orderdetail); $i++) {
                $ID_Receivedetail = generateIDbyFix($ID_Receivedetail, 2, "OD");

                $sqlReceiveDetail = "INSERT INTO `receive_detail` ( `ID_Receivedetail` , `ID_Receive` , `ID_Product` ,`Amount_Receive`, `Amount_NonRe`,`ID_Count`,`Cost_Price`,`Amount_balance`, `Product_Remand` ) VALUES ( '" . $ID_Receivedetail . "', '" . $ID_Receive . "', '" . $ID_Product[$i] . "','" . $Amount_Receive[$i] . "','" . $Amount_NonRe[$i] . "','" . $ID_Count[$i] . "','" . $Cost_Price[$i] . "','" . $Amount_balance[$i] . "', '" . $Product_Remand . "' )";
//                echo $sqlReceiveDetail."<br>";
                $RS = mysql_query($sqlReceiveDetail);
//                $RS = 1;
                if ($RS) {
                    $success++;
                    $sqlIncrementProduct = "UPDATE `product` SET Amount_Product = Amount_Product + " . intval($Amount_Receive[$i]) . " WHERE ID_Product = '" . $ID_Product[$i] . "'";
                    $queryIncrementProduct = mysql_query($sqlIncrementProduct);
                     //echo $sqlIncrementProduct."<br>";
                }
            }
            if ($success == count($ID_Orderdetail)) {
                echo "<script type='text/javascript'>alert('รับสินค้าเรียบร้อย')</script>";
            } else {
                echo "<script type='text/javascript'>alert('มีข้อผิดพลาดในการรับสินค้า')</script>";
            }
        }
    }
//}
// เรับสินค้าเพิ่มเติม
    if (!empty($_POST['Number_Product2'])) {

        $ID_Receive = $_POST['ID_Receive2'];
        $ID_Product2 = $_POST['ID_Product2'];
        $Amount_Product2 = $_POST['Amount_Product2'];
        $Number_Product2 = $_POST['Number_Product2'];
        $No_Receive2 = $_POST['No_Receive2'];
        $ID_Count2 = $_POST['ID_Count2'];
        $Cost_Price2 = $_POST['Cost_Price2'];
        $Total_Price2 = $_POST['Total_Price2'];
        $Product_Remand = 0; //เดี๋ยวกลับมาแก้ให้นะจ๊ะเด็กดี
        // insert
        // $lastsql="SELECT ID_receivedetail From receive_detail order by ID_receivedetail DESC LIMIT 1";
        // $result=mysql_query($lastsql);
        // $OldId =mysql_fetch_array($result); 
        // $ID_Receivedetail2 = generateIDbyFix($OldId['ID_receivedetail'],2,"RC");
        //$sqlReceiveDetail = "INSERT INTO `receive_detail` ( `ID_Receivedetail` , `ID_Receive` , `ID_Product`,`Amount_Receive`, `Amount_NonRe`,`ID_Count`,`Cost_Price`,`Amount_balance`, `Product_Remand` ) VALUES ( '".$ID_Receivedetail2."', '".$ID_Receive."', '".$ID_Product2."','".$Number_Product2."','".$No_Receive2."','".$ID_Count2."','".$Cost_Price2."','".$Total_Price2."', '".$Product_Remand."' )";
        // update
        $ID_Receivedetail2 = $_POST['ID_Receivedetail2'];
        $sqlReceiveDetail = "UPDATE receive_detail SET ID_Receive='" . $ID_Receive . "' , ID_Product='" . $ID_Product2 . "',Amount_Receive= Amount_Receive + '" . $Number_Product2 . "', Amount_NonRe='" . $No_Receive2 . "',ID_Count='" . $ID_Count2 . "',Cost_Price='" . $Cost_Price2 . "',Amount_balance='" . $Total_Price2 . "', Product_Remand='" . $Product_Remand . "'  WHERE ID_Receivedetail='" . $ID_Receivedetail2 . "'";


        // echo $sqlReceiveDetail;
        $RS = mysql_query($sqlReceiveDetail);
        if ($RS) {
            $sqlIncrementProduct = "UPDATE `product` SET Amount_Product = Amount_Product + " . intval($Number_Product2) . " WHERE ID_Product = '" . $ID_Product2 . "'";
            $queryIncrementProduct = mysql_query($sqlIncrementProduct);
            echo "<script type='text/javascript'>alert('รับสินค้าเรียบร้อย')</script>";
        } else {
            echo "<script type='text/javascript'>alert('มีข้อผิดพลาดในการรับสินค้า')</script>";
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="th">
        <head>
            <meta charset="UTF-8">
            <title> ร้านศรีอ้น แฮร์ & สปาร์ </title>

            <?php include("../fragments/libmanage.php"); ?>
            <style type="text/css">
                td,th{
                    padding: 10px;
                }
            </style>
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
                             <?php if (!empty($_GET['q'])) { ?>
                                                <?php
                                                $asql = "SELECT * FROM receive_detail rd, product p ,receive r WHERE rd.ID_Receive = '" . $_GET['q'] . "' AND rd.ID_Product = p.ID_Product AND rd.ID_Receive = r.ID_Receive";
                                                // $asql = "SELECT * FROM orders o RIGHT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN receive_detail rd ON r.ID_Receive = rd.ID_Receive INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp  WHERE r.ID_Receive LIKE '" . $_GET['q'] . "' ORDER BY r.ID_Receive ASC";
                                                $result = mysql_query($asql)or die(mysql_error() . ":<br />" . $sql_select);;
                                                ?> 
                                                <div style="top: 342px; position: absolute; height: 1138px;" tabindex="-1" class="mfp-wrap mfp-close-btn-in mfp-auto-cursor my-mfp-zoom-in mfp-ready">
                                                    <div class="mfp-container mfp-inline-holder">
                                                        <div class="mfp-content"> 
                                                            <div id="smallResult" class="zoom-anim-dialog mfp-hide dialog open" style="margin-top: 226px;height: auto;"> 
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading"><h4>ข้อมูลรายละเอียดการรับสินค้า <?php echo $_GET['q']; ?></h4></div>
                                                                    <div class="mygrid-wrapper-div">
                                                                        <table class="table" style="height: 100%;"> 
                                                                            <thead>
                                                                            <th>#</th>
                                                                            <th>ชื่อสินค้า</th>
                                                                            <th><span style="float:right;">จำนวนที่สั่ง</span></th>
                                                                            <th><span style="float:right;">จำนวนที่รับ</span></th>
                                                                            <th><span style="float:right;">จำนวนค้างรับ</span></th>
                                                                            <th>หน่วยนับ</th>
                                                                            <th><span style="float:right;">หน่วย(บาท)</span></th>
                                                                            <th><span style="float:right;">ยอดรวม(บาท)</span></th>
                                                                            <th>สถานะ</th>
                                                                        </thead>
                                                                        <tbody>
                                                                                                    <?php
                                                                                                    $inx = 0;
                                                                                                    while ($receive_detail = mysql_fetch_array($result)) { ;
                                                                                                        
                                                                                                            ?>
                                                                                                        <tr>
                                                                                                            <td><?php echo ++$inx; ?></td>
                                                                                                            <td><?php echo $receive_detail['Product_Name']; ?></td>
                                                                                                            <td>
                                                                                                                <?php
                                                                                                                $ID_Order = $receive_detail['ID_Order'];
                                                                                                                $ID_Product = $receive_detail['ID_Product'];
                                                                                                                $mql = "SELECT * FROM orders o INNER JOIN order_detail od ON o.ID_Order = od.ID_Order WHERE o.ID_Order = '$ID_Order' AND od.ID_Product = '$ID_Product'";
                                                                                                                $amount = mysql_fetch_assoc(mysql_query($mql));
                                                                                                                ?>
                                                                                                                <span style="float: right;"><?php echo $amount['Amount_Product']; ?> </span>
                                                                                                            </td>
                                                                                                            <td><span style="float: right;"><?php echo $receive_detail['Amount_Receive']; ?></span></td>
                                                                                                            <td><span style="float: right;"><?php echo $receive_detail['Amount_NonRe'] ?></span></td>
                                                                                                            <td>
                                                                                                                <?php
                                                                                                                $ID_Count = $amount['ID_Count'];
                                                                                                                $nql = "SELECT * FROM count WHERE ID_Count='$ID_Count'";
                                                                                                                $count = mysql_fetch_assoc(mysql_query($nql));
                                                                                                                ?>
                                                                                                                <?php echo $count['Name_Count']; ?>
                                                                                                            </td>
                                                                                                            <td><span style="float: right;"><?php echo $receive_detail['Cost_Price']; ?></span></td>
                                                                                                            <td><span style="float: right;"><?php echo $receive_detail['Amount_balance']; ?></span></td>
                                                                                                            <td>
                                                                                                                <?php
                                                                                                                if ($receive_detail['Amount_NonRe'] != 0) {
                                                                                                                    ?>
                                                                                                                    <a class="popup-with-zoom-anim btn btn-warning" HREF="#small<?= $receive_detail['ID_Receivedetail'] ?>">รับสินค้าที่เหลือ</a>
                                                                                                                    <div id="small<?= $receive_detail['ID_Receivedetail'] ?>" class="zoom-anim-dialog mfp-hide dialog" style="top: 342px; position: absolute;">
                                                                                                                        <form action="" method="post">
                                                                                                                            <div class="panel panel-default">
                                                                                                                                <div class="panel-heading"><h4>ข้อมูลรายละเอียดการสั่งสินค้า</h4></div>
                                                                                                                                <div class="mygrid-wrapper-div"> 
                                                                                                                                    <table class="table"> 
                                                                                                                                        <thead>
                                                                                                                                            <tr>
                                                                                                                                                <th>รหัสรายละเอียด</th>
                                                                                                                                                <th>ชื่อสินค้า</th>
                                                                                                                                                <th>จำนวนที่สั่ง</th>
                                                                                                                                                <th>จำนวนค้างรับ</th>
                                                                                                                                                <th>จำนวนที่รับ</th>
                                                                                                                                                
                                                                                                                                                <th>หน่วยนับ</th>
                                                                                                                                                <th>หน่วยละ(บาท)</th>
                                                                                                                                                <th>ยอดรวม(บาท)</th>
                                                                                                                                            </tr>
                                                                                                                                        </thead>
                                                                                                                                        <tbody>
                                                                                                                                            <tr>
                                                                                                                                                <?php $idx = $receive_detail['ID_Receivedetail']; ?>
                                                                                                                                                <td>
                                                                                                                                                    <input type="hidden" name="ID_Receive2" id="ID_Receive<?= $idx ?>" value="<?php echo $receive_detail['ID_Receive']; ?>" >
                                                                                                                                                    <input type="text" name="ID_Receivedetail2" value="<?php echo $receive_detail['ID_Receivedetail']; ?>" class="form-control" readonly="">
                                                                                                                                                </td>
                                                                                                                                                <td>
                                                                                                                                                    <input type="hidden" id="ID_Product<?= $idx ?>" name="ID_Product2" value="<?php echo $receive_detail['ID_Product']; ?>">
                                                                                                                                                    <input name="Product_NameS" id="Product_Name<?= $idx ?>" value="<?php echo $receive_detail['Product_Name']; ?>" maxlength="5" class="form-control" readonly="">
                                                                                                                                                </td>
                                                                                                                                                <td>
                                                                                                                                                    <input type="text" style="text-align:right" name="Amount_Product2" id="Amount_Product<?= $idx ?>" placeholder="จำนวนที่สั่ง" maxlength="10" class="form-control" required="" value="<?php echo $amount['Amount_Product']; ?>" readonly="">
                                                                                                                                                </td>
                                                                                                                                                <td>
                                                                                                                                                    <input type="text" style="text-align:right" name="No_Receive2" id="No_Receive<?= $idx ?>" placeholder="จำนวนค้างรับ" maxlength="10" class="form-control" required="" value="<?php echo $receive_detail['Amount_NonRe'] ?>" readonly="">
                                                                                                                                                </td>
                                                                                                                                                <td>
                                                                                                                                                    <input type="text" style="text-align:right" name="Number_Product2" id="Number_Product<?= $idx ?>" placeholder="จำนวนที่รับ" maxlength="10" class="form-control" required="" value="<?php echo $receive_detail['Amount_NonRe'] ?>">
                                                                                                                                                    <input type="hidden" style="text-align:right" name="Number_t2" id="Number_Product22<?= $idx ?>" placeholder="จำนวนที่รับ" maxlength="10" class="form-control" required="" value="<?php echo $receive_detail['Amount_NonRe'] ?>">
                                                                                                                                                </td>
                                                                                                                                                
                                                                                                                                                <td>
                                                                                                                                                    <input type="hidden" name="ID_Count2" id="ID_Count<?= $idx ?>" value="<?php echo $amount['ID_Count'] ?>">
                                                                                                                                                    <input type="hidden" name="Amount_Unit2" id="Amount_Unit<?= $idx ?>" value="<?php echo $count['Amount_Unit'] ?>">
                                                                                                                                                    <input name="Name_Count2" id="Name_Count<?= $idx ?>" required="" placeholder="รหัสหน่วยนับ" maxlength="4" value="<?php echo $count['Name_Count'] ?>" class="form-control" readonly="">
                                                                                                                                                </td>
                                                                                                                                                <td>
                                                                                                                                                    <input type="text" style="text-align:right" name="Cost_Price2" id="Cost_Price<?= $idx ?>" required="" placeholder="ราคาทุน" maxlength="10" class="form-control" value="<?php echo $receive_detail['Cost_Price'] ?>" readonly="">
                                                                                                                                                </td>
                                                                                                                                                <td>
                                                                                                                                                    <input type="hidden" name="Total_PriceHide2" id="Total_PriceHide<?= $idx ?>" value="<?php echo $receive_detail['Amount_balance'] ?>">
                                                                                                                                                    <input type="text" style="text-align:right" name="Total_Price2" id="Total_Price<?= $idx ?>" placeholder="ราคารวม" maxlength="20" class="form-control" required="" value="<?php echo $receive_detail['Amount_balance']; ?>" readonly="">
                                                                                                                                                </td> 
                                                                                                                                            </tr>
                                                                                                                                            <tr>
                                                                                                                                                <td colspan="8">
                                                                                                                                                    <table align="center">
                                                                                                                                                        <tr>
                                                                                                                                                            <td>
                                                                                                                                                                <button id="add2" type="submit" name="submitUp" class="btn btn-primary">
                                                                                                                                                                    <i class="glyphicon glyphicon-shopping-cart"></i> รับสินค้า
                                                                                                                                                                </button> 
                                                                                                                                                            </td>
                                                                                                                                                            <td>
                                                                                                                                                                <button onclick="$.magnificPopup.close();" type="button" class="btn btn-default">ยกเลิก</button>
                                                                                                                                                            </td>
                                                                                                                                                        </tr>
                                                                                                                                                    </table>
                                                                                                                                                </td> 
                                                                                                                                            </tr>
                                                                                                                                        </tbody>
                                                                                                                                    </table> 
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </form>
                                                                                                                    </div>
                                                                                                                    <script type="text/javascript">
                                                                                                                        $(".popup-with-zoom-anim").magnificPopup({
                                                                                                                            type: 'inline',
                                                                                                                            fixedContentPos: false,
                                                                                                                            fixedBgPos: true,
                                                                                                                            overflowY: 'auto',
                                                                                                                            closeBtnInside: true,
                                                                                                                            preloader: false,
                                                                                                                            midClick: true,
                                                                                                                            removalDelay: 300,
                                                                                                                            mainClass: 'my-mfp-zoom-in'
                                                                                                                        });

                                                                                                                        $("#Number_Product<?= $idx ?>").number(true, 0);

                                                                                                                        // $('#Number_Product<?= $idx ?>').change(function () {
                                                                                                                        //     var amountOr = parseFloat($('#Amount_Product<?= $idx ?>').val());
                                                                                                                        //     amountOr = isNaN(amountOr) ? 0 : amountOr;
                                                                                                                        //     var nonere = parseFloat($('#No_Receive<?= $idx ?>').val());
                                                                                                                        //     nonere = isNaN(nonere) ? 0 : nonere;

                                                                                                                        //     var amount_unit = parseFloat($('#Amount_Unit<?= $idx ?>').val());
                                                                                                                        //     var amount = parseFloat($('#Number_Product<?= $idx ?>').val());
                                                                                                                        //     var cost = parseFloat($('#Cost_Price<?= $idx ?>').val());
                                                                                                                        //     var total = $('#Total_PriceHide<?= $idx ?>').val();
                                                                                                                        //     total = total.replace(",", "");
                                                                                                                        //     var total_banlance = parseFloat(total);

                                                                                                                        //     // console.log(total_banlance);
                                                                                                                        //     if (amount <= nonere) {
                                                                                                                        //         $('#No_Receive<?= $idx ?>').val(nonere - amount);
                                                                                                                        //         $('#Total_Price<?= $idx ?>').val((amount * amount_unit * cost) + total_banlance);
                                                                                                                        //         $('#Total_Price<?= $idx ?>').number(true, 2);
                                                                                                                        //     } else {
                                                                                                                        //         alert("กรุณากรอกจำนวนที่รับน้อยกว่าหรือเท่ากับ " + nonere);
                                                                                                                        //         $('#Number_Product<?= $idx ?>').val("");
                                                                                                                        //     }
                                                                                                                        // }
                                                                                                                        );
                                                                                                                    </script>
                                                                                                                        <?php
                                                                                                                    } else {
                                                                                                                        ?>
                                                                                                                    <label type="button" style="cursor:text;color: rgb(4, 166, 12);">รับสินค้าครบแล้ว</label>
                                                                                                                    <?php
                                                                                                                }
                                                                                                                ?> 
                                                                                                            </td>
                                                                                                    <script type="text/javascript">
                                                                                                        $("#<?= $receive_detail['ID_Receivedetail'] ?>").click(function () {
                                                                                                            $('#add').hide();
                                                                                                            $('#receiveId').text("<?= $receive_detail['ID_Receivedetail'] ?>");
                                                                                                            ID_Receivedetail.value = "<?= $receive_detail['ID_Receivedetail'] ?>";

                                                                                                            document.getElementById("ID_Product")[0].text = "<?= $receive_detail['Product_Name'] ?>";

                                                                                                            document.getElementById("Amount_Product")[0].value = "<?= $receive_detail['Amount_Product'] ?>";

                                                                                                            document.getElementById("Amount_Receive")[0].text = "<?= $receive_detail['Amount_Receive'] ?>";

                                                                                                            document.getElementById("Amount_NonRe")[0].value = "<?= $receive_detail['Amount_NonRe'] ?>";

                                                                                                            document.getElementById("ID_Count")[0].text = "<?= $receive_detail['Name_Count'] ?>";

                                                                                                            document.getElementById("Cost_Price")[0].value = "<?= $receive_detail['Cost_Price'] ?>";

                                                                                                            document.getElementById("Amount_balance")[0].value = "<?= $receive_detail['Amount_balance'] ?>";


                                                                                                        });
                                                                                                    </script>
                                                                                                    </tr>
                                                                                                        <?php 
                                                                                                    } ?>

                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <!-- <a href="print_addorder.php" target="_blank" class="btn btn-primary" onClick="popWin()"; >พิมพ์ใบสั่งซื้อ</a> -->
                                                                <div style="text-align: right;"><a href="./receive_receivedetail.php" class="btn btn-default">ปิด</a></div>
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
                            <form action="" method="post">
                                <div>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li ><a href="./receive_receivedetail.php">จัดการข้อมูลการรับสินค้า</a></li>
                                        <li Class = "active"><a href="./checkproduct.php">ตรวจสอบข้อมูลสินค้า</a></li>
                                        <li role="presentation" class="dropdown" style="float: right;margin-right: -2px;">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" style="min-width: 160px;">
                                                <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ""; ?> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="../logout.php">ออกจากระบบ</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>  
                               
                            
                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3 class="table-add">ตรวจสอบข้อมูลสินค้า</h3>
                                        <?php if (!empty($_GET['q'])) { ?>
                                            <?php
                                            $sql = "SELECT * FROM product p INNER JOIN count c INNER JOIN company cm ON p.ID_Count = c.ID_Count AND p.ID_Company=cm.ID_Company WHERE p.ID_Product LIKE '" . $_GET['q'] . "' OR p.Product_Name LIKE '%" . $_GET['q'] . "%' OR cm.Name_Company LIKE '" . $_GET['q'] . "' ORDER BY p.ID_Product ASC ";
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
                                                                <div class="panel-heading"><h4>ข้อมูลสินค้า</h4></div>
                                                                <div class="mygrid-wrapper-div">
                                                                    <table class="table" style="height: 100%;"> 
                                                                        <thead>
                                                                            <th>รหัสสินค้า</th>
                                                                            <th>ชื่อสินค้า</th>
                                                                            <th><span style="float:right;">จำนวนสินค้า</span></th>
                                                                            <th>หน่วยนับ</th>
                                                                            <th><span style="float:right;">ราคาทุน(บาท)</span></th>
                                                                            <th><span style="float:right;">ราคาขาย(บาท)</span></th>
                                                                            <th><span style="float:right;">จุดสั่งซื้อสินค้า(ชิ้น)</span></th>
                                                                            <th>บริษัท</th>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php while ($row_product = mysql_fetch_array($result)) { ?>
                                                                            <tr> 
                                                                                <td><a id="<?= $row_product['ID_Product'] ?>" class="point"><?php echo $row_product['ID_Product']; ?></a></td>
                                                                                <td><?php echo $row_product['Product_Name']; ?></td>
                                                                                <td><span style="float: right;" id="middle"><?php echo number_format(str_replace(",", "", $row_product['Amount_Product'])); ?></span></td>
                                                                                <td><span id="center"><?php echo $row_product['Name_Count']; ?></span></td>
                                                                                <td><span style="float: right;" id="middle"><?php echo number_format(str_replace(",", "", $row_product['Cost_Price']), 2); ?></span></td>
                                                                                <td><span style="float: right;" id="middle"><?php echo number_format(str_replace(",", "", $row_product['Sale_Price']), 2); ?></span></td>
                                                                                <td align = "center"><span style="float: right;" id=""><?php echo number_format(str_replace(",", "", $row_product['Point_Purchase'])); ?></span></td>
                                                                                <td><span id="middle"><?php echo $row_product['Name_Company']; ?></span></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div style="text-align: right;"><a href="./checkproduct.php" class="btn btn-default">ปิด</a></div>
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
                                    <form action="./checkproduct.php" method="get">
                                            <table class="table">
                                                            <tr>
                                                                <td style="border: none;width: 15%;">
                                                                    <h3>ค้นหาข้อมูลสินค้า</h3>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4"style="border: none;">
                                                                    <table>
                                                                        <tr>
                                                                            <td style="border: none;padding: 8px;width: 46%;">
                                                                                <label>ข้อมูลสินค้า</label>
                                                                            </td>
                                                                            <td style="border: none;padding: 8px;width: 40%;">
                                                                                <input name="q" id="q" type="text" placeholder="ข้อมูลสินค้า" style="background: #C0F9BD;width:100% " class="form-control point" value=""> 
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
                                $sql = "SELECT * FROM product p, count c, company cm WHERE p.ID_Count = c.ID_Count AND p.ID_Company=cm.ID_Company order by p.ID_Product asc";
                                $query = mysql_query($sql);
                                ?>
                                <div class="bs-example">
                                    <div class="panel panel-default">
                                        <!-- Default panel contents -->
                                        <div class="panel-heading"><h4>ข้อมูลสินค้า</h4></div>
                                        <!-- Table -->
                                        <div class="mygrid-wrapper-div" style="height: 45%;">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>รหัสสินค้า</th>
                                                        <th>ชื่อสินค้า</th>
                                                        <th><span style="float:right;">จำนวนสินค้า</span></th>
                                                        <th>หน่วยนับ</th>
                                                        <th><span style="float:right;">ราคาทุน(บาท)</span></th>
                                                        <th><span style="float:right;">ราคาขาย(บาท)</span></th>
                                                        <th><span style="float:right;">จุดสั่งซื้อสินค้า(ชิ้น)</span></th>
                                                        <th>บริษัท</th>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row_product = mysql_fetch_assoc($query)) { ?>
                                                        <tr>
                                                            <td><a id="<?= $row_product['ID_Product'] ?>" class="point"><?php echo $row_product['ID_Product']; ?></a></td>
                                                            <td><?php echo $row_product['Product_Name']; ?></td>
                                                            <td><span style="float: right;" id="middle"><?php echo number_format(str_replace(",", "", $row_product['Amount_Product'])); ?></span></td>
                                                            <td><span id="center"><?php echo $row_product['Name_Count']; ?></span></td>
                                                            <td><span style="float: right;" id="middle"><?php echo number_format(str_replace(",", "", $row_product['Cost_Price']), 2); ?></span></td>
                                                            <td><span style="float: right;" id="middle"><?php echo number_format(str_replace(",", "", $row_product['Sale_Price']), 2); ?></span></td>
                                                            <td align = "center"><span style="float: right;" id=""><?php echo number_format(str_replace(",", "", $row_product['Point_Purchase'])); ?></span></td>
                                                            <td><span id="middle"><?php echo $row_product['Name_Company']; ?></span></td>
                                                        </tr>
                                                    <script type="text/javascript">
                                                        $("#<?= $row_product['ID_Product'] ?>").click(function () {
                                                            $('#add').hide();
                                                            ID_Product.value = "<?= $row_product['ID_Product'] ?>";
                                                            Product_Name.value = "<?= $row_product['Product_Name'] ?>";
                                                            Amount_Product.value = "<?= $row_product['Amount_Product'] ?>";
                                                            $('#ID_Count option[value="<?= $row_product['ID_Count'] ?>"]').attr('selected', 'selected');
                                                            $('#ID_Company option[value="<?= $row_product['ID_Company'] ?>"]').attr('selected', 'selected');
                                                            document.getElementById("Cost_Price").value = "<?= $row_product['Cost_Price'] ?>";
                                                            $('#Sale_Price').val("<?= $row_product['Sale_Price'] ?>");
                                                            Point_Purchase.value = "<?= $row_product['Point_Purchase'] ?>";

                                                            // check คำที่ใช้จะลบไม่ได้
                                                            var json = {'ID_Product': "<?= $row_product['ID_Product'] ?>", 'table': "sale_detail"};
                                                            $.post("./product.controller.php", json).done(function (data) {
                                                                var sale_detail = JSON.parse(data);
                                                                var json2 = {'ID_Product': "<?= $row_product['ID_Product'] ?>", 'table': "order_detail"};
                                                                $.post("./product.controller.php", json2).done(function (data) {
                                                                    var order_detail = JSON.parse(data);
                                                                    var json3 = {'ID_Product': "<?= $row_product['ID_Product'] ?>", 'table': "receive_detail"};
                                                                    $.post("./product.controller.php", json3).done(function (data) {
                                                                        var receive_detail = JSON.parse(data);
                                                                        var json4 = {'ID_Product': "<?= $row_product['ID_Product'] ?>", 'table': "disproduct_detail"};
                                                                        $.post("./product.controller.php", json4).done(function (data) {
                                                                            var disproduct_detail = JSON.parse(data);
                                                                            var json5 = {'ID_Product': "<?= $row_product['ID_Product'] ?>", 'table': "disburse_product"};
                                                                            $.post("./product.controller.php", json5).done(function (data) {
                                                                                var disburse_product = JSON.parse(data);
                                                                                var json6 = {'ID_Product': "<?= $row_product['ID_Product'] ?>", 'table': "prosale_detail"};
                                                                                $.post("./product.controller.php", json6).done(function (data) {
                                                                                    var prosale_detail = JSON.parse(data);
                                                                                    var json7 = {'ID_Product': "<?= $row_product['ID_Product'] ?>", 'table': "sales"};
                                                                                    $.post("./product.controller.php", json7).done(function (data) {
                                                                                        var sales = JSON.parse(data);
                                                                                        if (sale_detail.ID_Product > 0 || order_detail.ID_Product > 0 || receive_detail.ID_Product > 0 || disproduct_detail.ID_Product > 0 || disburse_product.ID_Product > 0 || disburse_product.ID_Product > 0 || prosale_detail.ID_Product > 0 || sales.ID_Product > 0) {
                                                                                            useResult = false;
                                                                                        } else {
                                                                                            useResult = true;
                                                                                        }
                                                                                    });
                                                                                });
                                                                            });
                                                                        });
                                                                    });
                                                                });
                                                            });
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
                                        
            </article>
            <footer>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#receive').addClass('active');
                    });
                </script>
                <?php include("../fragments/footer.php"); ?>
            </footer>
        </body>
    </html>
<?php } ?>