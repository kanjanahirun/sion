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
    if (!empty($_POST['Button'])) {
        $button = $_POST['Button'];
        //$Flag = true;
        if ($button == 'เพิ่มข้อมูล') {

            $strCount = "SELECT * FROM orders ORDER BY ID_Order DESC LIMIT 1";
            $objQueryCount = mysql_query($strCount);
            $Count_prefix = mysql_fetch_array($objQueryCount);
            $NUMCount = substr($Count_prefix["ID_Order"], -1);
            $nextNum = $NUMCount + 1;
            $Prefix_num = substr($Count_prefix["ID_Order"], 0, 3);

            $strEmp_ID = "" . ($Prefix_num . "" . $nextNum);

            if (!empty($_POST['ID_Order']) && !empty($_POST['Date_Order']) && !empty($_POST['ID_Emp']) && !empty($_POST['ID_Company']) && !empty($_POST['ID_Orderdetail']) && !empty($_POST['ID_Product']) && !empty($_POST['Amount_Product']) && !empty($_POST['ID_Count']) && !empty($_POST['Cost_Price']) && !empty($_POST['Total_Price'])) {

                $date = format_date($_POST["Date_Order"]);
                $sql = "INSERT INTO orders VALUES ('" . $_POST["ID_Order"] . "', '" . $date . "', '" . $_SESSION['id'] . "', '" . $_POST["ID_Company"] . "')";

                $ID_Count = $_POST['ID_Count'];
                $ID_Orderdetail = $_POST['ID_Orderdetail'];
                $ID_Product = $_POST['ID_Product'];
                $Amount_Product = $_POST['Amount_Product'];
                $Total_Price = $_POST['Total_Price'];

                $result = mysql_query($sql);
                if ($result == 1) {
                    for ($i = 0; $i < count($ID_Orderdetail); $i++) {
                        $sql = "INSERT INTO order_detail (`ID_Orderdetail`, `ID_Order`, `ID_Product`, `Amount_Product`, `Total_Price`,`ID_Count`) VALUES ('" . $ID_Orderdetail[$i] . "', '" . $_POST["ID_Order"] . "', '" . $ID_Product[$i] . "', '" . $Amount_Product[$i] . "', '" . $Total_Price[$i] . "','" . $ID_Count[$i] . "')";
                        mysql_query($sql);
                    }
                    echo "<script>alert('เพิ่มข้อมูลสั่งซื้อสินค้าเรียบร้อย');</script>";
                    echo "<script>location='./order.php';</script>";
                }
            } else {
                echo "<script>alert('ไม่สามารถเพิ่มข้อมูลการสั่งซื้อสินค้าได้เนื่องจากข้อมูลไม่๔ุกต้อง');</script>";
                echo "<script>location='./addorder.php';</script>";
            }
        } elseif ($button == 'แก้ไขข้อมูล') {
            //$sql = "UPDATE Employees SET ID_Prefix, FName_Emp, LName_Emp, Tel_Emp, Salary, ID_TypeEmp, personal_ID = '".$_POST["ID_Prefix"]."', '".$_POST["FName_Emp"]."', '".$_POST["LName_Emp"]."', '".$_POST["Tel_Emp"]."', '".$_POST["Salary"]."', '".$_POST["ID_TypeEmp"]."', '".$_POST["personal_ID"]."'";
            $date = tranformDate($_POST["Date_Order"]);
            $sql = "UPDATE orders SET Date_Order = '" . $date . "',ID_Emp = '" . $_POST["ID_Emp"] . "',ID_Company = '" . $_POST["ID_Company"] . "' WHERE ID_Order = '" . $_POST["ID_Order"] . "'";

            mysql_query($sql);
        } elseif ($button == 'ลบข้อมูล') {
            $sql = "DELETE FROM orders WHERE ID_Order = '" . $_POST["ID_Order"] . "'";
            mysql_query($sql);
        }
    }
    ?>
    <!DOCTYP html>
    <html ng-app="sion">
        <head>
            <title> ร้านศรีอ้น แฮร์ & สปาร์ </title> 
            <?php include("../fragments/libmanage.php"); ?>
            <script type="text/javascript" src="../assets/js/angular.min.js"></script>
            <script type="text/javascript" src="../assets/js/addorder.controller.js"></script>
        </head>
        <body id="bg" ng-controller="addorderController">
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
                            <div class="col-md-12">
                                <div>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="active point" style="width: 17%;">
                                            <a href="./addorder.php">จัดการข้อมูลการสั่งสินค้า</a>
                                        </li> 
                                        <li role="presentation" class="dropdown" style="float: right;margin-right: -2px;">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" style="min-width: 160px;">
                                                <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ""; ?> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="../logout.php">ออกจากระบบ</a></li>
                                            </ul>
                                    </ul>
                                </div> 
                                <div class="orderdetail">
                                    <div class="row">
                                        <div class="padform">
                                            <form action="./addorder2.php" method="get">
                                            <table class="table">
                                                            <tr>
                                                                <td style="border: none;width: 15%;">
                                                                    <h3>ค้นหาข้อมูลการสั่งสินค้า</h3>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4"style="border: none;">
                                                                    <table>
                                                                        <tr>
                                                                            <td style="border: none;padding: 8px;width: 46%;">
                                                                                <label>รหัสการสั่งสินค้า</label>
                                                                            </td>
                                                                            <td style="border: none;padding: 8px;width: 40%;">
                                                                                <input name="q" id="q" type="text" placeholder="รหัสการสั่งสินค้า" style="background: #C0F9BD;width:100% " class="form-control point" value=""> 
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
                                            <?php if (!empty($_GET['q'])) { ?>
                                            <?php
                                            $sql = "SELECT o.ID_Order, o.Date_Order, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, c.Name_Company, p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.FName_Emp, e.LName_Emp FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp WHERE o.ID_Order = '" . $_GET['q'] . "' ORDER BY o.ID_Order ASC";
                                            $result = mysql_query($sql);
                                            ?>
                                            <!--<div class="mfp-bg my-mfp-zoom-in mfp-ready"></div>-->
                                            <div style="top: 342px; position: absolute; height: 1138px;" tabindex="-1" class="mfp-wrap mfp-close-btn-in mfp-auto-cursor my-mfp-zoom-in mfp-ready">
                                                <div class="mfp-container mfp-inline-holder">
                                                    <div class="mfp-content">
                                                        <!--<a class="popup-with-zoom-anim" HREF="#smallResult"> รายละเอียด </a>-->
                                                        <div id="smallResult" class="zoom-anim-dialog mfp-hide dialog open" style="margin-top: 226px;height: auto;"> 
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading"><h4>ข้อมูลรายละเอียดการสั่งสินค้า</h4></div>
                                                                <div class="mygrid-wrapper-div">
                                                                    <table class="table" style="height: 100%;"> 
                                                                        <thead>
                                                                            <th>รหัสการสั่งสินค้า</th>
                                                                            <th>รหัสรายละเอียดการสั่งสินค้า</th> 
                                                                            <th>ชื่อสินค้า</th>
                                                                            <th><span style="float: right;">จำนวนสินค้า</span></th>
                                                                            <th><span style="float: right;">ราคารวม(บาท)</span></th>
                                                                            <!-- <th>สถานะ</th>  -->
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php while ($orderDetail = mysql_fetch_array($result)) { ?>
                                                                            <tr> 
                                                                                <td>
                                                                                    <?php echo $orderDetail['ID_Order']; ?>
                                                                                </td> 
                                                                                <td>
                                                                                    <a readonly id="<?php echo $orderDetail['ID_Orderdetail']; ?>" class="point"><?php echo $orderDetail['ID_Orderdetail']; ?></a>
                                                                                </td>   
                                                                                <td><?php echo $orderDetail['Product_Name']; ?></td>  
                                                                                <td><span style="float: right;"><?php echo $orderDetail['ODAmount_Product']; ?></span></td>  
                                                                                <td><span style="float: right;"><?php echo $orderDetail['Total_Price']; ?></span></td> 
                                                                                <td> 

                                                                                </td> 
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div style="text-align: right;"><a href="./addorder2.php" class="btn btn-default">ปิด</a></div>
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
                                            $lastsql = "SELECT ID_Order From orders order by ID_Order DESC LIMIT 1";
                                            $result = mysql_query($lastsql);
                                            $OldId = mysql_fetch_array($result);
                                            $NewId = generateIDbyFix($OldId['ID_Order'], 2, "OR");
                                            ?>
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <form> 
                                                        <table class="table">
                                                            <tr>
                                                                <td style="border: none;width: 15%;">
                                                                    <h3>เพิ่มข้อมูลการสั่งซื้อสินค้า</h3>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4"style="border: none;">
                                                                    <table>
                                                                        <tr>
                                                                            <td style="border: none;padding: 8px;width: 46%;">
                                                                                <label>จำนวนรายการที่ต้องการสั่งซื้อ</label>
                                                                            </td>
                                                                            <td style="border: none;padding: 8px;width: 20%;">
                                                                                <input ng-model="numorders" only-digits type="text" value="" name="numrow" id="numorders" class="form-control point" style="background: #C0F9BD;text-align:right">
                                                                            </td>
                                                                            <td style="border: none;padding: 8px;">
                                                                                <input ng-click="numRows(numorders)" id="add" type="submit" class="btn btn-primary" name="OK" value="ตกลง">
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </form>
                                                    <script>$('#numorders').val("");</script>  
                                                    <form method="post" action="./addorder.php"> 
                                                        <div ng-if="numrows > 0" >
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <tr>
                                                                        <td style="border: none;width: 15%;">
                                                                            <label>รหัสการสั่งสินค้า : </label>
                                                                        </td>
                                                                        <td style="border: none;">
                                                                            <span>&nbsp;<b><?php echo $NewId; ?></b></span>
                                                                            <input name="ID_Order" id="ID_Order" type="hidden" placeholder="รหัสการสั่งสินค้า" value="<?php echo $NewId; ?>">
                                                                        </td>
                                                                        <td style="border: none;width: 11%;">
                                                                            <label>วันที่สั่งสินค้า</label>
                                                                        </td>
                                                                        <td style="border: none;">
                                                                            <input class="form-control point" name="Date_Order" id="datetimepicker1" type="text" placeholder="คลิกเพื่อเลือกวันที่" style="width: 50%;" required="" readonly="">
                                                                            <script type="text/javascript">
                                                                                        var date = new Date();
                                                                                        if (date.getDate() < 10) {
                                                                                            date = (date.getDate() + "/" + (parseInt(date.getMonth()) + 1) + "/" + date.getFullYear());
                                                                                        } else {
                                                                                            date = (date.getDate() + "/" + (parseInt(date.getMonth()) + 1) + "/" + date.getFullYear());
                                                                                        }
                                                                                        jQuery('#datetimepicker1').val(date);

                                                                            </script>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="border: none;">
                                                                            <label>ชื่อพนักงาน</label>
                                                                        </td>
                                                                        <td style="border: none;">
                                                                            <input class="form-control point" type="text" name="ID_Emp" id="ID_Emp" type="hidden" placeholder="ชื่อพนักงาน" value="<?= $_SESSION['name'] ?>" readonly="" style="width: 30%;">
                                                                        </td>
                                                                        <td style="border: none;">
                                                                            <label>ชื่อบริษัท</label>
                                                                        </td>
                                                                        <td style="border: none;">
                                                                            <select ng-model="ID_Company" ng-init="ID_Company = init('')" ng-change="selectCompany(ID_Company)" name="ID_Company"  style="width: 50%;" id="ID_Company" class="idropdown" placeholder="รหัสบริษัท" required="">
                                                                                <option value="" style="background: #C0F9BD">เลือกบริษัท</option> 
                                                                                <?php
                                                                                $sql = "SELECT * FROM company ORDER BY ID_Company ASC";
                                                                                $query = mysql_query($sql);
                                                                                while ($objResult = mysql_fetch_array($query)) {
                                                                                    ?>
                                                                                    <option value="<?= $objResult["ID_Company"]; ?>" style="background: #C0F9BD">
                                                                                    <?= $objResult["Name_Company"]; ?>
                                                                                    </option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                    </tr> 
                                                                </table>
                                                                <div class="mygrid-wrapper-div" style="height: auto;">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <!--<th style="width: 20%;">รหัสรายละเอียดการสั่งซื้อ</th>-->
                                                                                <th style="width: 22%;">ชื่อสินค้า</th>
                                                                                <th style="width: 5%;">จำนวน</th>
                                                                                <th style="width: 15%;">หน่วยนับ</th>
                                                                                <th>ราคาต่อหน่วย (บาท)</th> 
                                                                                <th>ราคารวม (บาท)</th>
                                                                                <!-- <th>รายการที่เลือก</th> -->
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>  
                                                                            <tr ng-repeat="row in []| range:numrows" >
                                                                                <td> {{$index + 1}} </td>
    <!--                                                                            <td> 
                                                                                    <label>{{generateIDbyFix(ID_Orderdetail, 2, 'OD', $index)}}</label>
                                                                                    <input type="hidden" name="ID_Orderdetail[]" id="" value="{{generateIDbyFix(ID_Orderdetail, 2, 'OD', $index)}}">
                                                                                </td>-->
                                                                                <td>                                            
                                                                                    <input type="hidden" name="ID_Orderdetail[]" id="" value="{{generateIDbyFix(ID_Orderdetail, 2, 'OD', $index)}}">
                                                                                    <select ng-change="selectProduct($index)" ng-model="ID_Product[$index]" name="ID_Product[]" id="ID_Product" class="idropdown" placeholder="ชื่อสินค้า" required="">
                                                                                        <option value="" style="background: #C0F9BD;">เลือกสินค้า</option>
                                                                                        <option ng-repeat="data in product" value="{{data.ID_Product}}">{{data.Product_Name}}</option>
                                                                                    </select> 
                                                                                </td>
                                                                                <td>
                                                                                    <input ng-model="Amount_Product[$index]" ng-change="pressAmount(Amount_Product, $index)" ng-int="orders.Amount_Product[$index]=init('')" type="text" name="Amount_Product[]"  placeholder="จำนวนสินค้า" maxlength="10" style="background: #C0F9BD;text-align:right" class="form-control Amount_Product" required="">
                                                                                    <script>$('.Amount_Product').number(true, 0);</script>
                                                                                </td> 
                                                                                <td>
                                                                                    <select ng-change="selectCount($index)" ng-model="ID_Count[$index]" ng-init="ID_Count[$index] = init('')" name="ID_Count[]" id="ID_Count" class="idropdown" required="">
                                                                                        <option value="" style="background: #C0F9BD">เลือกหน่วยนับ</option>
                                                                                        <?php
                                                                                        $sql = "SELECT * FROM `count` ORDER BY ID_Count ASC";
                                                                                        $query = mysql_query($sql);
                                                                                        while ($objResult = mysql_fetch_array($query)) {
                                                                                            ?>
                                                                                            <option value="<?= $objResult["ID_Count"]; ?>" style="background: #C0F9BD">
                                                                                            <?= $objResult["Name_Count"]; ?>
                                                                                            </option>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input ng-model="Cost_Price[$index]" ng-int="Cost_Price[$index]=init('')" value="{{Cost_Price[$index]}}" type="text" name="Cost_Price[]" placeholder="ราคา/หน่วย" maxlength="20" style="background: #C0F9BD;text-align:right" class="form-control Cost_Price" required="">
                                                                                    <input ng-model="Cost_Price_Product[$index]" ng-int="Cost_Price_Product[$index]=init('')" value="{{Cost_Price_Product[$index]}}" type="hidden" name="Cost_Price_Product" id="Cost_Price_Product" style="text-align:right;">
                                                                                    <script>$('.Cost_Price').number(true, 2);</script>
                                                                                </td>
                                                                                <td>
                                                                                    <input ng-model="Total_Price[$index]" ng-int="Total_Price[$index]=init('')" value="{{Total_Price[$index]}}" type="text" name="Total_Price[]" placeholder="ราคารวม" maxlength="20" style="background: #C0F9BD;text-align:right" class="form-control Total_Price" required="">
                                                                                    <script>$('.Total_Price').number(true, 2);</script>
                                                                                </td> 

                                                                                <td>
                                                                                    <!-- ลบรายการ -->
                                                                                    <!-- <center> <input type="checkbox" class="css_data_item" name="select" value="select"> </center>-->
                                                                                    <!-- <span ng-click="Del(row.$$hashKey)">x</span> -->


                                                                                </td> 

                                                                            </tr>
                                                                            <tr align="center">
                                                                                <td colspan="7"> 
                                                                                    <input id="add" type="submit" class="btn btn-primary" name="Button" value="เพิ่มข้อมูล">
                                                                                    <!-- <input onclick="return checkIdPrefix();" id="delete" type="submit" class="btn btn-danger" name="Button" value="ลบแถว">  -->
                                                                                    <a href="./addorder.php" class="btn btn-default">ยกเลิก</a>  
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div> 
                                                            </div> 
                                                        </div>
                                                    </form> 
                                                </div>	
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="bs-example">
                                                    <div class="panel panel-default">
                                                        <!-- Default panel contents -->
                                                        <div class="panel-heading"><h4>ข้อมูลการสั่งสินค้า</h4></div>
                                                        <!-- Table -->
                                                        <div class="mygrid-wrapper-div" style="height:65%;">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <!--<th>รหัสการสั่งสินค้า</th>-->
                                                                        <th>#</th>
                                                                        <th>ชื่อพนักงาน</th>
                                                                        <th>ชื่อบริษัท</th>
                                                                        <th>วันที่สั่งสินค้า</th>
                                                                        <th>รายละเอียดการสั่งซื้อ</th>
                                                                        <th>จัดการข้อมูล</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <?php
                                                                    $sql = "SELECT * FROM `orders` ORDER BY ID_Order DESC";
                                                                    $query = mysql_query($sql);
                                                                    $inx = 0;
                                                                    while ($order = mysql_fetch_assoc($query)) {
                                                                        $ID_Emp = $order['ID_Emp'];
                                                                        $ID_Order = $order['ID_Order'];
                                                                        if (strpos($ID_Emp, "E") !== false) {
                                                                            $eql = "SELECT o.ID_Order, o.Date_Order, c.ID_Company,c.Name_Company,e.ID_Emp, e.FName_Emp, e.LName_Emp FROM orders o INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN employees e ON e.ID_Emp = o.ID_Emp WHERE e.ID_Emp='$ID_Emp' AND o.ID_Order='$ID_Order' ORDER BY o.ID_Order ASC ";
                                                                        } else if (strpos($ID_Emp, "AD") !== false) {
                                                                            $eql = "SELECT o.ID_Order, o.Date_Order, c.ID_Company,c.Name_Company,a.ID_Admin AS ID_Emp, a.Name_Admin AS FName_Emp, a.LName_Admin AS LName_Emp FROM orders o INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN admin a ON a.ID_Admin = o.ID_Emp WHERE a.ID_Admin='$ID_Emp' AND o.ID_Order='$ID_Order' ORDER BY o.ID_Order ASC";
                                                                        }
                                                                        $row_order = mysql_fetch_assoc(mysql_query($eql));
                                                                        ?>
                                                                        <tr>

                                                                            <?php
                                                                            $sql = "SELECT o.ID_Order, o.Date_Order, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, c.Name_Company, p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.FName_Emp, e.LName_Emp FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp WHERE o.ID_Order = '" . $row_order['ID_Order'] . "' ORDER BY o.ID_Order ASC";
                                                                            $result = mysql_query($sql);
                                                                            $orderDetail = mysql_fetch_array($result);

                                                                            if ($orderDetail['RID_Order'] != NULL) {
                                                                                ?>
        <?php } else {
            ?>
                                                                                                    <!--                                                            <td>
                                                                                                                                                                        <input type="hidden" id="ID_Order" name="ID_Order" value="">
                                                                                                                                                                        <a id="<?php //echo $row_order['ID_Order'];           ?>" class="point"><?php //echo $row_order['ID_Order'];          ?></a>
                                                                                                                                                                    </td>-->
                                                                                <td><?php echo ++$inx; ?></td>
                                                                                <td><?php echo $row_order['FName_Emp']; ?></td>
                                                                                <td><?php echo $row_order['Name_Company']; ?></td>
                                                                                <td><?php echo reverseDate($row_order['Date_Order']); ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                    $sql = "SELECT o.ID_Order, o.Date_Order, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, c.Name_Company, p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.FName_Emp, e.LName_Emp FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp WHERE o.ID_Order = '" . $row_order['ID_Order'] . "' ORDER BY o.ID_Order ASC";
                                                                                    $result = mysql_query($sql);
                                                                                    ?>
                                                                                    <a class="popup-with-zoom-anim" HREF="#small<?= $row_order['ID_Order'] ?>"> รายละเอียด </a>
                                                                                    <div id="small<?= $row_order['ID_Order'] ?>" class="zoom-anim-dialog mfp-hide dialog">
                                                                                        <div class="panel panel-default">
                                                                                            <div class="panel-heading"><h4>ข้อมูลรายละเอียดการสั่งสินค้า</h4></div>
                                                                                            <div class="mygrid-wrapper-div">
                                                                                                <table class="table"> 
                                                                                                    <thead>
                                                                                                    <th>รหัสการสั่งสินค้า</th>
                                                                                                    <th>รหัสรายละเอียดการสั่งสินค้า</th> 
                                                                                                    <th>ชื่อสินค้า</th>
                                                                                                    <th><span style="float: right;">จำนวนสินค้า</span></th>
                                                                                                    <th><span style="float: right;">ราคารวม(บาท)</span></th>
                                                                                                    <!-- <th>สถานะ</th>  -->
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                                <?php while ($orderDetail = mysql_fetch_array($result)) { ?>
                                                                                                            <tr> 
                                                                                                                <td>
                <?php echo $orderDetail['ID_Order']; ?>
                                                                                                                </td> 
                                                                                                                <td>
                                                                                                                    <a readonly id="<?php echo $orderDetail['ID_Orderdetail']; ?>" class="point"><?php echo $orderDetail['ID_Orderdetail']; ?></a>
                                                                                                                </td>   
                                                                                                                <td><?php echo $orderDetail['Product_Name']; ?></td>  
                                                                                                                <td><span style="float: right;"><?php echo $orderDetail['ODAmount_Product']; ?></span></td>  
                                                                                                                <td><span style="float: right;"><?php echo $orderDetail['Total_Price']; ?></span></td> 
                                                                                                                <td> 

                                                                                                                </td> 
                                                                                                            </tr>
                                                                                                            <?php
                                                                                                        }
                                                                                                        ?>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
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
                                                                                        </script>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                    $sql = "SELECT o.ID_Order, o.Date_Order, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, c.Name_Company, p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.FName_Emp, e.LName_Emp FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp WHERE o.ID_Order = '" . $row_order['ID_Order'] . "' ORDER BY o.ID_Order ASC";
                                                                                    $result = mysql_query($sql);
                                                                                    $orderDetail = mysql_fetch_array($result);

                                                                                    if ($orderDetail['RID_Order'] != NULL) {
                                                                                        
                                                                                    } else {
                                                                                        ?>
                                                                                        <a href="#" class="btn btn-warning" title="แก้ไขข้อมูล">
                                                                                            <i class="glyphicon glyphicon-pencil"></i> 
                                                                                        </a>
                                                                                        <a href="#" class="btn btn-danger" title="ลบข้อมูล">
                                                                                            <i class="glyphicon glyphicon-remove"></i> 
                                                                                        </a>
                                                                                        <?php
                                                                                    }
                                                                                    ?> 
                                                                                </td>
        <?php } ?>
                                                                        </tr>
                                                                    <script type="text/javascript">
                                                                                $("#<?= $row_order['ID_Order'] ?>").click(function () {
                                                                                    $('#add').hide();
                                                                                    ID_Order.value = "<?= $row_order['ID_Order'] ?>";
                                                                                    document.getElementById("ID_Emp")[0].text = "<?= $row_order['FName_Emp'] ?>";
                                                                                    document.getElementById("ID_Emp")[0].value = "<?= $row_order['ID_Emp'] ?>";
                                                                                    document.getElementById("ID_Company")[0].text = "<?= $row_order['Name_Company'] ?>";
                                                                                    document.getElementById("ID_Company")[0].value = "<?= $row_order['ID_Company'] ?>";
                                                                                    datetimepicker1.value = "<?= reverseDate($row_order['Date_Order']) ?>";
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
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-12"> 

                                                </div>
                                            </div>
                                        </div>
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
                    $('#order').addClass('active');
                    $('#sub1').show();
                    $('#orderlist').css({background: "#e8e8e8"});
                    $('#orderdetail').css({background: "transparent"});
                });
            </script>
    <?php include("../fragments/footer.php"); ?>
        </footer>
    </body>
    </html>
<?php } ?>