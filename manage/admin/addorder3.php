<?php
session_start();

include("../connect/connect.php");

if (empty($_SESSION['Username'])) {
    if (empty($_SESSION['Username']) || empty($_SESSION['status']) || empty($_SESSION['name'])) {
        echo alert('กรุณาเข้าสู่ระบบ Admin ก่อน');
        echo location("../login.php");
    }
} else {

    if (!empty($_POST['Button'])) {
        $button = $_POST['Button'];
        if ($button == 'ยืนยัน') {
            $ert = $_POST['ID_Order'];
            echo "<script type='text/javascript'> console.log('ID_Order');console.log($ert);</script>";

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
                    echo "<script>location='./addorder.php';</script>";
                }
            } else {
                echo "<script>alert('ไม่สามารถเพิ่มข้อมูลการสั่งซื้อสินค้าได้เนื่องจากข้อมูลไม่ถูกต้อง');</script>";
                echo "<script>location='./addorder.php';</script>";
            }
        }
    }

    // UPDATE

    if (!empty($_POST['update'])) {
        $ID_Order = $_POST['update']['ID_Order'];

        $PD = 'UPID_Orderdetail' . $ID_Order;
        $ID_Orderdetail = $_POST[$PD];
        $IP = 'UPID_Product' . $ID_Order;
        $ID_Product = $_POST[$IP];
        $AM = 'UPAmount' . $ID_Order;
        $Amount = $_POST[$AM];
        $CN = 'UPID_Count' . $ID_Order;
        $ID_Count = $_POST[$CN];
        $CP = 'UPCost_Price' . $ID_Order;
        $Cost_Price = $_POST[$CP];
        $TP = 'UPTotal_Price' . $ID_Order;
        $Total_Price = $_POST[$TP];

        $finish = 0;
        for ($i = 0; $i < count($ID_Orderdetail); $i++) {
            $sql = "UPDATE order_detail SET ID_Product='$ID_Product[$i]',Amount_Product='$Amount[$i]',ID_Count='$ID_Count[$i]', Total_Price='$Total_Price[$i]' WHERE ID_Orderdetail = '$ID_Orderdetail[$i]'";
            $rs = mysql_query($sql);
            if ($rs)
                $finish++;
        }

        if ($finish == count($ID_Orderdetail)) {
            echo "<script>alert('แก้ไขข้อมูลสั่งซื้อสินค้าเรียบร้อย');</script>";
        } else {
            echo "<script>alert('ไม่สามารถแก้ไขข้อมูลการสั่งซื้อสินค้าได้เนื่องจากข้อมูลไม่ถูกต้อง');</script>";
        }
    }

    // Delete 
    if (!empty($_POST['DELID_Order'])) {
        $ID_Order = $_POST['DELID_Order'];
        $sqla = "DELETE FROM orders WHERE ID_Order = '$ID_Order'";
        $sqlb = "DELETE FROM order_detail WHERE ID_Order = '$ID_Order' ";
        $ra = mysql_query($sqla)or die(mysql_error() . ":<br />" . $sql_select);
        $rb = mysql_query($sqlb)or die(mysql_error() . ":<br />" . $sql_select);
        if ($ra && $rb) {
            echo "<script type='text/javascript'>alert('ลบข้อมูลสำเร็จ')</script>";
        } else {
            echo "<script type='text/javascript'>alert('ลบข้อมูลผิดพลาด')</script>";
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

                                            <?php if (!empty($_GET['q'])) { ?>
                                                <?php
                                                $sql = "SELECT o.ID_Order, o.Date_Order, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, c.Name_Company, p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.FName_Emp, e.LName_Emp FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp WHERE o.ID_Order = '" . $_GET['q'] . "' ORDER BY o.ID_Order ASC";
                                                $result = mysql_query($sql);
                                                ?> 
                                                <div style="top: 342px; position: absolute; height: 1138px;" tabindex="-1" class="mfp-wrap mfp-close-btn-in mfp-auto-cursor my-mfp-zoom-in mfp-ready">
                                                    <div class="mfp-container mfp-inline-holder">
                                                        <div class="mfp-content"> 
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
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                $total_price = 0;
                                                                                while ($orderDetail = mysql_fetch_array($result)) {
                                                                                    $total_tmp = str_replace(",", "", $orderDetail['Total_Price']);
                                                                                    $total_price += $total_tmp;
                                                                                    ?>
                                                                                    <tr> 
                                                                                        <td>
                                                                                            <?php $getorder = $orderDetail['ID_Order'];  echo $orderDetail['ID_Order']; ?>
                                                                                        </td> 
                                                                                        <td>
                                                                                            <?php echo $orderDetail['ID_Orderdetail']; ?>
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
                                                                                <tr align="right">
                                                                                    <td colspan="7"> 
                                                                                        ราคารวม <b><?= number_format($total_price, 2) ?></b> บาท
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <a href="print_addorder.php" target="_blank" class="btn btn-primary" onClick="popWin('<?php echo $_GET['q'];?>')"; >พิมพ์ใบสั่งซื้อ</a>
                                                                <div style="text-align: right;"><a href="./addorder.php" class="btn btn-default">ปิด</a></div>
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
                                                                    <h3 class="table-add">เพิ่มข้อมูลการสั่งซื้อสินค้า</h3>
                                                                    <h3 style="display: block;"  class="table-edit">แก้ไขข้อมูลการสั่งซื้อสินค้า</h3>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4"style="border: none;">
                                                                    <table>
                                                                        <tr>
                                                                            <!-- <td style="border: none;padding: 8px;width: 46%;">
                                                                                <label>จำนวนรายการที่ต้องการสั่งซื้อ</label>
                                                                            </td>
                                                                            <td style="border: none;padding: 8px;width: 20%;">
                                                                                <input ng-model="numorders" only-digits type="text" value="" name="numrow" id="numorders" class="form-control point" style="background: #C0F9BD;text-align:right">
                                                                            </td>
                                                                            <td style="border: none;padding: 8px;">
                                                                                <input ng-click="numRows(numorders, 1)" id="add" type="submit" class="btn btn-primary" name="OK" value="ตกลง">
                                                                            </td> -->
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
                                                                <table class="table table-add">
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
                                                                            <select ng-model="ID_Company" ng-init="ID_Company = init('')" ng-change="selectCompany(ID_Company)" id="sID_Company"  style="width: 50%;" id="ID_Company" class="idropdown" placeholder="รหัสบริษัท" required="">
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
                                                                            <script>
                                                                                $( "#ssID_Company" ).change(function () {
                                                                                     location.reload();
                                                                                  })
                                                                                </script>
                                                                              
                                                                        </td>
                                                                    </tr> 
                                                                </table>
                                                                <div class="mygrid-wrapper-div" style="height: auto;">
                                                                    <table id="tab" class="table table-add">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width:1%"></th> 
                                                                                <th style="width: 22%;">ชื่อสินค้า</th>
                                                                                <th style="width: 5%;">จำนวน</th>
                                                                                <th style="width: 15%;">หน่วยนับ</th>
                                                                                <th>ราคาต่อหน่วย (บาท)</th> 
                                                                                <th>ราคารวม (บาท)</th>
                                                                                <th colspan="2"></th> 
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>    
                                                                            <tr ng-repeat="row in range(0, numrows - 1)" id="ng{{$index}}" ng-if="input[$index] != -1">
                                                                                <td style="vertical-align: middle"> 
                                                                                    <input type="hidden" ng-model="end">
                                                                                    <input type="hidden" ng-model="index[$index]" ng-init="index[$index] = $index + 1">
                                                                                    <!-- {{index[$index]}} -->
                                                                                </td> 
                                                                                <td>                                            
                                                                                    <input type="hidden" name="ID_Orderdetail[]" id="" value="{{generateIDbyFix(ID_Orderdetail, 2, 'OD', $index)}}">
                                                                                    <select ng-change="selectProduct($index)" ng-model="ID_Product[$index]" name="ID_Product[]" id="ID_Product" class="idropdown" placeholder="ชื่อสินค้า" required="">
                                                                                        <option value="" style="background: #C0F9BD;">เลือกสินค้า</option>
                                                                                        <option ng-repeat="data in product" value="{{data.ID_Product}}">{{data.Product_Name}}</option>
                                                                                    </select> 
                                                                                </td>
                                                                                <td>
                                                                                    <input ng-model="Amount_Product[$index]" ng-change="pressAmount(Amount_Product, $index)" ng-int="orders.Amount_Product[$index]=init('')" type="text" name="Amount_Product[]"  placeholder="จำนวนสินค้า" maxlength="10" style="background: #C0F9BD;text-align:right;" class="form-control Amount_Product" required="">
                                                                                    <script>$('.Amount_Product').number(true, 0);</script>
                                                                                </td> 
                                                                                <td>
                                                                                    <input type="hidden" ng-model="idc[$index]" readonly  class="form-control" name="ID_Count[]">
                                                                                    <input type="text" ng-model="idn[$index]" readonly  placeholder="หน่วยนับ" class="form-control">
                                                                                    
                                                                                    
                                                                                </td>
                                                                                <td style="width:17%">
                                                                                    <input ng-model="Cost_Price[$index]" ng-int="Cost_Price[$index]=init('')" value="{{Cost_Price[$index]}}" type="text" name="Cost_Price[]" placeholder="ราคา/หน่วย" maxlength="20" style="background: #C0F9BD;text-align:right" class="form-control Cost_Price" required="">
                                                                                    <input ng-model="Cost_Price_Product[$index]" ng-int="Cost_Price_Product[$index]=init('')" value="{{Cost_Price_Product[$index]}}" type="hidden" name="Cost_Price_Product" id="Cost_Price_Product" style="text-align:right;">
                                                                                    <script>$('.Cost_Price').number(true, 2);</script>
                                                                                </td>
                                                                                <td style="width:16%">
                                                                                    <input ng-model="Total_Price[$index]" ng-int="Total_Price[$index]=init('')" value="{{Total_Price[$index]}}" type="text" name="Total_Price[]" placeholder="ราคารวม" maxlength="20" style="background: #C0F9BD;text-align:right" class="form-control Total_Price" required="">
                                                                                    <script>$('.Total_Price').number(true, 2);</script>
                                                                                </td>  
                                                                                <td style="width:17%">
                                                                                    <div ng-if="$index >= 0 && $index == (row)" style="cursor: pointer;  margin-top: 8px;"> 
                                                                                        <a ng-click="deleteRow($index, 1)" style="color: rgb(211, 39, 39);" title="ลบแถว"><i class="glyphicon glyphicon-remove"></i></a>
                                                                                    </div>
                                                                                </td> 
                                                                            </tr> 
                                                                            <tr align="center">
                                                                                <td colspan="8"> 
                                                                                    <a ng-click="numRows(numrows, 2)" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i>เพิ่มข้อมูล</a>

                                                                                </td>
                                                                            </tr>
                                                                            <tr align="right">
                                                                                <td colspan="8">
                                                                                    <input id="add" type="submit" class="btn btn-primary" name="Button" value="ยืนยัน">
                                                                                    <a href="./addorder.php" class="btn btn-default">ยกเลิก</a>  
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <div id="table-edit">

                                                                    </div>
    <!--                                                                    <table class="table" >
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th> 
                                                                                <th style="width: 22%;">ชื่อสินค้า</th>
                                                                                <th style="width: 5%;">จำนวน</th>
                                                                                <th style="width: 15%;">หน่วยนับ</th>
                                                                                <th>ราคาต่อหน่วย (บาท)</th> 
                                                                                <th>ราคารวม (บาท)</th>
                                                                                <th colspan="2"></th> 
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>   
                                                                            
                                                                        </tbody>
                                                                    </table>-->
                                                                </div> 
                                                            </div> 
                                                        </div>
                                                       
                                                    </form> 
                                                    
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form action="./addorder.php?" method="get">
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
                                                </form>
                                                <div class="bs-example">
                                                    <div class="panel panel-default"> 
                                                        <div class="panel-heading"><h4>ข้อมูลการสั่งสินค้า</h4></div> 
                                                        <div class="mygrid-wrapper-div" style="height:65%;">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>รหัสการสั่งสินค้า</th>
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

                                                                    // compute pagination  
                                                                    $total_results = 0;
                                                                    $orderx = array();
                                                                    $orderd = array();

                                                                    while ($order = mysql_fetch_assoc($query)) {
                                                                        $ID_Emp = $order['ID_Emp'];
                                                                        $ID_Order = $order['ID_Order'];
                                                                        if (strpos($ID_Emp, "E") !== false) {
                                                                            $eql = "SELECT o.ID_Order, o.Date_Order, c.ID_Company,c.Name_Company,e.ID_Emp, e.FName_Emp, e.LName_Emp FROM orders o INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN employees e ON e.ID_Emp = o.ID_Emp WHERE e.ID_Emp='$ID_Emp' AND o.ID_Order='$ID_Order' ORDER BY o.ID_Order ASC ";
                                                                        } else if (strpos($ID_Emp, "AD") !== false) {
                                                                            $eql = "SELECT o.ID_Order, o.Date_Order, c.ID_Company,c.Name_Company,a.ID_Admin AS ID_Emp, a.Name_Admin AS FName_Emp, a.LName_Admin AS LName_Emp FROM orders o INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN admin a ON a.ID_Admin = o.ID_Emp WHERE a.ID_Admin='$ID_Emp' AND o.ID_Order='$ID_Order' ORDER BY o.ID_Order ASC";
                                                                        }
                                                                        $row_order = mysql_fetch_assoc(mysql_query($eql));

                                                                        $sql = "SELECT o.ID_Order, o.Date_Order, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, c.Name_Company, p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.FName_Emp, e.LName_Emp FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp WHERE o.ID_Order = '" . $row_order['ID_Order'] . "' ORDER BY o.ID_Order ASC";
                                                                        $result = mysql_query($sql);
                                                                        $orderDetail = mysql_fetch_assoc($result);

                                                                        if ($orderDetail['RID_Order'] == NULL) {
                                                                            $orderx[$total_results] = $row_order;
                                                                            $orderd[$total_results] = $order;
                                                                            $total_results++;
                                                                        }
                                                                    }

                                                                    $Num_Rows = $total_results;
                                                                    $limit = 7;
                                                                    $Per_Page = 10;     // กำหนดจำนวนแถวที่ต้องการแสดง
                                                                    $limitlen = ceil($Num_Rows / $Per_Page);
                                                                    if ($limitlen < $limit)
                                                                        $limit = $limitlen;

                                                                    $Page = 1;
                                                                    if (!empty($_GET["page"])) {
                                                                        $Page = (is_numeric($_GET["page"]) ? $_GET["page"] : 1);
                                                                    } else {
                                                                        $Page = 1;
                                                                    }
                                                                    $start = $Page;
                                                                    $Prev_Page = $Page - 1;
                                                                    $Next_Page = $Page + 1;

                                                                    $Page_Start = (($Per_Page * $Page) - $Per_Page);
                                                                    if ($Num_Rows <= $Per_Page) {
                                                                        $Num_Pages = 1;
                                                                    } else if (($Num_Rows % $Per_Page) == 0) {
                                                                        $Num_Pages = ($Num_Rows / $Per_Page);
                                                                    } else {
                                                                        $Num_Pages = ($Num_Rows / $Per_Page) + 1;
                                                                        $Num_Pages = (int) $Num_Pages;
                                                                    }
                                                                    // end compute pagination


                                                                    $inx = 0;
                                                                    if ($Num_Rows < $Per_Page) {
                                                                        $Per_Page = $Num_Rows;
                                                                    }
                                                                    if ($Page_Start <= $Per_Page) {

                                                                        for ($i = $Page_Start; $i < ($Per_Page + $Page_Start); $i++) {
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo ++$inx; ?></td>
                                                                                <td><a id="E<?php echo $orderx[$i]['ID_Order']; ?>" class="point"><?php echo $orderx[$i]['ID_Order']; ?></a></td> 
                                                                                <td><?php echo $orderx[$i]['FName_Emp']; ?></td>
                                                                                <td><?php echo $orderx[$i]['Name_Company']; ?></td>
                                                                                <td><?php echo reverseDate($orderx[$i]['Date_Order']); ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                    $sql = "SELECT o.ID_Order, o.Date_Order, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, c.Name_Company, p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.FName_Emp, e.LName_Emp FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp WHERE o.ID_Order = '" . $orderx[$i]['ID_Order'] . "' ORDER BY o.ID_Order ASC";
                                                                                    $result = mysql_query($sql);
                                                                                    ?>
                                                                                    <a class="popup-with-zoom-anim" HREF="#small<?= $orderx[$i]['ID_Order'] ?>"> รายละเอียด </a>
                                                                                    <div id="small<?= $orderx[$i]['ID_Order'] ?>" class="zoom-anim-dialog mfp-hide dialog">
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
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <?php
                                                                                                        $total_price = 0;
                                                                                                        while ($orderDetail = mysql_fetch_array($result)) {
                                                                                                            $total_tmp = str_replace(",", "", $orderDetail['Total_Price']);
                                                                                                            $total_price += $total_tmp;
                                                                                                            ?>
                                                                                                            <tr> 
                                                                                                                <td>
                                                                                                                    <?php $oid =$orderDetail['ID_Order']; echo $orderDetail['ID_Order']; ?>
                                                                                                                </td> 
                                                                                                                <td> 
                                                                                                                    <?php echo $orderDetail['ID_Orderdetail']; ?>
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
                                                                                                        <tr align="right">
                                                                                                            <td colspan="7"> 
                                                                                                                ราคารวม <b><?= number_format($total_price, 2) ?></b> บาท
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div><a href="print_addorder.php" target="_blank" class="btn btn-primary" onClick="popWin('<?php echo $oid;?>')";>พิมพ์ใบสั่งซื้ื้อ</a>
                                                                                        <div style="text-align: right;"><a href="./addorder.php" class="btn btn-default">ปิด</a></div>
                                                                                    </div> 

                                                                                </td>
                                                                                <td><a href="print_addorder.php" target="_blank" class="btn btn-primary" onClick="popWin('<?php echo $oid;?>')";>พิมพ์ใบสั่งซื้อ</a>
                                                                                    </td>
                                                                                <td>
                                                                                    <?php
                                                                                    $sql = "SELECT o.ID_Order, o.Date_Order, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.Cost_Price,p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, od.ID_Count,ic.Amount_Unit,c.ID_Company, c.Name_Company, p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.FName_Emp, e.LName_Emp FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp INNER JOIN count ic on od.ID_Count=ic.ID_Count WHERE o.ID_Order = '" . $orderx[$i]['ID_Order'] . "' ORDER BY o.ID_Order ASC";
                                                                                    $result = mysql_query($sql);
                                                                                    $orderDetail = mysql_fetch_array($result);

                                                                                    if ($orderDetail['RID_Order'] != NULL) {
                                                                                        
                                                                                    } else {
                                                                                        ?>
                                                                                        <!--
                                                                                        <a href="#updatex<?= $orderx[$i]['ID_Order'] ?>" class="popup-with-zoom-anim btn btn-warning" title="แก้ไขข้อมูล">
                                                                                            <i class="glyphicon glyphicon-pencil"></i> 
                                                                                        </a>
                                                                                        -->
                                                                                        <div id="updatex<?= $orderx[$i]['ID_Order'] ?>" class="zoom-anim-dialog mfp-hide dialog"> 
                                                                                            <div id="panel<?= $orderx[$i]['ID_Order'] ?>" class="panal-edit">
                                                                                                <form action="./addorder.php" method="post">
                                                                                                    <div class="panel panel-default" > 

                                                                                                        <div class="panel-heading"><h4>แก้ไขข้อมูลการสั่งสินค้า รหัส : <span style="color: #3399FF;"><?= $orderx[$i]['ID_Order'] ?></span></h4></div>

                                                                                                        <input type="hidden" name="update[ID_Order]" value="<?= $orderx[$i]['ID_Order'] ?>">
                                                                                                        <div class="mygrid-wrapper-div">
                                                                                                            <table class="table">
                                                                                                                <thead>
                                                                                                                <th style="width:22%">รหัสรายละเอียดการสั่งสินค้า</th> 
                                                                                                                <th style="width:22%">ชื่อสินค้า</th>
                                                                                                                <th style="width: 11%;"><span style="float: right;">จำนวนสินค้า</span></th>
                                                                                                                <!-- <th>หน่วยนับ</th> -->
                                                                                                                <th style="width: 16%;"><span style="float: right;">ราคาต่อหน่วย(บาท)</span></th>
                                                                                                                <th style="width: 13%;"><span style="float: right;">ราคารวม(บาท)</span></th> 
                                                                                                                </thead>
                                                                                                                <tbody>    
                                                                            <tr ng-repeat="row in range(0, numrows - 1)" id="ng{{$index}}" ng-if="input[$index] != -1">
                                                                                <td style="vertical-align: middle"> 
                                                                                    <input type="hidden" ng-model="end">
                                                                                    <input type="hidden" ng-model="index[$index]" ng-init="index[$index] = $index + 1">
                                                                                    <!-- {{index[$index]}} -->
                                                                                </td> 
                                                                                <td>                                            
                                                                                    <input type="hidden" name="ID_Orderdetail[]" id="" value="{{generateIDbyFix(ID_Orderdetail, 2, 'OD', $index)}}">
                                                                                    <select ng-change="selectProduct($index)" ng-model="ID_Product[$index]" name="ID_Product[]" id="ID_Product" class="idropdown" placeholder="ชื่อสินค้า" required="">
                                                                                        <option value="" style="background: #C0F9BD;">เลือกสินค้า</option>
                                                                                        <option ng-repeat="data in product" value="{{data.ID_Product}}">{{data.Product_Name}}</option>
                                                                                    </select> 
                                                                                </td>
                                                                                <td>
                                                                                    <input ng-model="Amount_Product[$index]" ng-change="pressAmount(Amount_Product, $index)" ng-int="orders.Amount_Product[$index]=init('')" type="text" name="Amount_Product[]"  placeholder="จำนวนสินค้า" maxlength="10" style="background: #C0F9BD;text-align:right;" class="form-control Amount_Product" required="">
                                                                                    <script>$('.Amount_Product').number(true, 0);</script>
                                                                                </td> 
                                                                                <td>
                                                                                    <input type="hidden" ng-model="idc[$index]" readonly  class="form-control" name="ID_Count[]">
                                                                                    <input type="text" ng-model="idn[$index]" readonly  placeholder="หน่วยนับ" class="form-control">
                                                                                    
                                                                                    
                                                                                </td>
                                                                                <td style="width:17%">
                                                                                    <input ng-model="Cost_Price[$index]" ng-int="Cost_Price[$index]=init('')" value="{{Cost_Price[$index]}}" type="text" name="Cost_Price[]" placeholder="ราคา/หน่วย" maxlength="20" style="background: #C0F9BD;text-align:right" class="form-control Cost_Price" required="">
                                                                                    <input ng-model="Cost_Price_Product[$index]" ng-int="Cost_Price_Product[$index]=init('')" value="{{Cost_Price_Product[$index]}}" type="hidden" name="Cost_Price_Product" id="Cost_Price_Product" style="text-align:right;">
                                                                                    <script>$('.Cost_Price').number(true, 2);</script>
                                                                                </td>
                                                                                <td style="width:16%">
                                                                                    <input ng-model="Total_Price[$index]" ng-int="Total_Price[$index]=init('')" value="{{Total_Price[$index]}}" type="text" name="Total_Price[]" placeholder="ราคารวม" maxlength="20" style="background: #C0F9BD;text-align:right" class="form-control Total_Price" required="">
                                                                                    <script>$('.Total_Price').number(true, 2);</script>
                                                                                </td>  
                                                                                <td style="width:17%">
                                                                                    <div ng-if="$index >= 0 && $index == (row)" style="cursor: pointer;  margin-top: 8px;"> 
                                                                                        <a ng-click="deleteRow($index, 1)" style="color: rgb(211, 39, 39);" title="ลบแถว"><i class="glyphicon glyphicon-remove"></i></a>
                                                                                    </div>
                                                                                </td> 
                                                                            </tr> 
                                                                            <tr align="center">
                                                                                <td colspan="8"> 
                                                                                    <a ng-click="numRows(numrows, 2)" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i>เพิ่มข้อมูล</a>

                                                                                </td>
                                                                            </tr>
                                                                            <tr align="right">
                                                                                <td colspan="8">
                                                                                    <input id="add" type="submit" class="btn btn-primary" name="Button" value="ยืนยัน">
                                                                                    <a href="./addorder.php" class="btn btn-default">ยกเลิก</a>  
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                                                            </table>
                                                                                                        </div> 
                                                                                                    </div> 
                                                                                                    <div style="text-align: right;">
                                                                                                        <div style="margin-right: 50%;">
                                                                                                            <input type="submit" value="แก้ไข" class="btn btn-warning" name="update[submit]">
                                                                                                            <a class="btn btn-default" id="close<?= $orderd[$i]['ID_Order'] ?>">ยกเลิก</a>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </form>
                                                                                                <div id="formDelete<?= $orderd[$i]['ID_Order'] ?>" style="width: 89%;margin-top: -20px;">
                                                                                                    <form action="./addorder.php" method="post" style="text-align: right;">
                                                                                                        <input type="hidden" name="DELID_Order" value="<?= $orderd[$i]['ID_Order'] ?>">
                                                                                                        <button type="submit" name="deleteOrder" onclick="return confirm('ยืนยันการลบข้อมูล');" title="ลบข้อมูล" class="btn btn-danger" style="margin-top: -28px;margin-left: 47px;"><i class="glyphicon glyphicon-remove"></i> ลบข้อมูล</button>
                                                                                                    </form> 
                                                                                                </div>
                                                                                            </div>
                                                                                        </div> 
                                                                                        <?php
                                                                                    }
                                                                                    ?> 
                                                                                </td> 
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
                                                                                    
                                                                                    $('#E<?php echo $orderDetail['ID_Order']; ?>').click(function () {
                                                                                        $('.table-add').hide();
                                                                                        $('.table-edit').show();
                                                                                        $('#panel<?= $orderx[$i]['ID_Order'] ?>').appendTo($('#table-edit')); 
                                                                                        console.log($( ".table-edit" ).length);
                                                                                        $('#panel<?= $orderx[$i]['ID_Order']; ?>').show();
                                                                                        $('.panal-edit').not('#panel<?= $orderx[$i]['ID_Order']; ?>').hide();
                                                                                    });
                                                                                    
                                                                                    $('#close<?= $orderd[$i]['ID_Order'] ?>').click(function(){
                                                                                        $('.table-add').show();
                                                                                        $('.table-edit').hide();
                                                                                        $('#pfrom').text("");
                                                                                        $('#table-edit').text("");
                                                                                    });
                                                                        </script>
                                                                        </tr>
                                                                        <script type="text/javascript">
                                                                                    $("#<?= $orderx[$i]['ID_Order'] ?>").click(function () {
                                                                                        $('#add').hide();
                                                                                        ID_Order.value = "<?= $orderx[$i]['ID_Order'] ?>";
                                                                                        document.getElementById("ID_Emp")[0].text = "<?= $orderx[$i]['FName_Emp'] ?>";
                                                                                        document.getElementById("ID_Emp")[0].value = "<?= $orderx[$i]['ID_Emp'] ?>";
                                                                                        document.getElementById("ID_Company")[0].text = "<?= $orderx[$i]['Name_Company'] ?>";
                                                                                        document.getElementById("ID_Company")[0].value = "<?= $orderx[$i]['ID_Company'] ?>";
                                                                                        datetimepicker1.value = "<?= reverseDate($orderx[$i]['Date_Order']) ?>";
                                                                                    });

                                                                        </script>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>

                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- pagination -->
                                                <table style="float: right;">
                                                    <tr>
                                                        <td><span>Total <?php echo $Num_Rows; ?> Record : <?php echo $Num_Pages; ?> Pages&nbsp;&nbsp;</span></td>
                                                        <td>
                                                            <ul class="pagination" style="margin: 0px;">  
                                                                <?php
                                                                if ($Prev_Page) {
                                                                    echo '<li><a href="' . $_SERVER['SCRIPT_NAME'] . '?page=' . $Prev_Page . '"><span>«Back</span></a></li>';
                                                                }
                                                                $endlimit = (($start + $limit) <= $Num_Pages) ? ($start + $limit) : $Num_Pages;
                                                                $end = ($Num_Pages == 1) ? 1 : $endlimit;
                                                                for ($i = $start; $i <= $end; $i++) {
                                                                    if ($i != $Page) {
                                                                        echo "<li><a href='$_SERVER[SCRIPT_NAME]?page=$i'>$i</a></li>";
                                                                    } else {
                                                                        echo "<li class='active'><a href='$_SERVER[SCRIPT_NAME]?page=$i'>$i</a></li>";
                                                                    }
                                                                }
                                                                if ($Page != $Num_Pages) {
                                                                    echo "<li><a href='" . $_SERVER['SCRIPT_NAME'] . "?page=" . $Next_Page . "'><span>Next»</span></a></li>";
                                                                }
                                                                ?>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </table> 
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
            <script>
            function popWin(oid){
                window.open('print_addorder.php?id='+oid+'' , 'mypopup' , 'nenuber=no,toorlbar=no,location=no,scrollbars=no, status=no,resizable=no,width=1000,height=500,top=120,left=350 ' );
                mypopup.focus();
            }
            function myFunction() {
                window.print();
            }
            </script>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('.table-edit').hide();
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