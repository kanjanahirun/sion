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

    $button = $_POST['Button'];
    $Flag = true;
    if ($button == 'เพิ่มข้อมูล') {

        // $strCount = "SELECT * FROM order_detail ORDER BY ID_Orderdetail DESC LIMIT 1";
        // $objQueryCount = mysql_query($strCount);
        // $Count_prefix = mysql_fetch_array($objQueryCount);
        // $NUMCount=substr($Count_prefix["ID_Orderdetail"],-1);
        // $nextNum=$NUMCount+1;
        // $Prefix_num=substr($nextNum["ID_Orderdetail"],0,3);



        $date = tranformDate($_POST["Date_Order"]);

        //$sql ="INSERT INTO prefix (ID_Prefix, Name_Prefix) VALUES ('$ID_Prefix', '$Name_Prefix')";
        $sqlOrder = "INSERT INTO orders VALUES ('" . $_POST["ID_Order"] . "', '" . $date . "', '" . $_POST["ID_Emp"] . "', '" . $_POST["ID_Company"] . "')";
        //echo $sqlOrder.'<br>';


        $sqlOrderdetail = "INSERT INTO order_detail VALUES ('" . $_POST["ID_Orderdetail"] . "', '" . $_POST["ID_Order"] . "','" . $_POST["ID_Product"] . "', '" . $_POST["Amount_Product"] . "', '" . $_POST["Total_Price"] . "')";
        // echo $sqlOrderdetail.'<br>';
        //บัคที่เพิ่ม ID ซ้ำกันแล้ว ไม่มี Error*********************************************************************
        $result = mysql_query($sqlOrder);
        if ($result) {
            mysql_query($sqlOrderdetail);
        } else
            $Flag = false;


        if ($Flag) {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลสำเร็จ')</script>";
        } else {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลผิดพลาด')</script>";
        }
    } elseif ($button == 'แก้ไขข้อมูล') {
        $date = tranformDate($_POST["Date_Order"]);
        $sqlOrder = "UPDATE orders SET Date_Order = '" . $date . "',ID_Emp = '" . $_POST["ID_Emp"] . "',ID_Company = '" . $_POST["ID_Company"] . "' WHERE ID_Order = '" . $_POST["ID_Order"] . "'";

        $sqlOrderdetail = "UPDATE order_detail SET ID_Order = '" . $_POST["ID_Order"] . "',ID_Product = '" . $_POST["ID_Product"] . "',Amount_Product = '" . $_POST["Amount_Product"] . "',Total_Price = '" . $_POST["Total_Price"] . "' WHERE ID_Orderdetail = '" . $_POST["ID_Orderdetail"] . "'";

        $result = mysql_query($sqlOrder);
        if ($result) {
            mysql_query($sqlOrderdetail);
        } else
            $Flag = false;

        if ($Flag) {
            echo "<script type='text/javascript'>alert('แก้ไขข้อมูลสำเร็จ')</script>";
        } else {
            echo "<script type='text/javascript'>alert('แก้ไขข้อมูลผิดพลาด')</script>";
        }
    } elseif ($button == 'ลบข้อมูล') {
        $sqlOrder = "DELETE FROM orders WHERE ID_Order = '" . $_POST["ID_Order"] . "'";
        $sqlOrderdetail = "DELETE FROM order_detail WHERE ID_Orderdetail = '" . $_POST["ID_Orderdetail"] . "'";

        $result = mysql_query($sqlOrder);
        if ($result) {
            mysql_query($sqlOrderdetail);
        } else
            $Flag = false;

        if ($Flag) {
            echo "<script type='text/javascript'>alert('ลบข้อมูลสำเร็จ')</script>";
        } else {
            echo "<script type='text/javascript'>alert('ลบข้อมูลผิดพลาด')</script>";
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="th">
        <head>
            <meta charset="UTF-8">
            <title> ร้านศรีอ้น แฮร์ & สปาร์ </title>

    <?php include("../fragments/libmanage.php"); ?>
        </head>
        <body id="bg">
            <nav>
    <?php include("../fragments/header.php"); ?>
            </nav>
            <article>
                <div id="container">
                    <div class="row">
                        <form action="" method="post">
                            <div class="col-md-2">
    <?php include("../fragments/sidebar.php"); ?>
                            </div>
                            <div class="col-md-5">
                                <div>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li Class = "active"><a href="./base.php">จัดการข้อมูลการสั่งสินค้า</a></li>
                                    </ul>
                                </div>
    <?php
    $lastsql = "SELECT ID_Orderdetail From order_detail order by ID_Orderdetail DESC LIMIT 1";
    $result = mysql_query($lastsql);
    $OldId = mysql_fetch_array($result);
    //P 099
    //$NewId = generateID2($OldId['ID_Orderdetail'],2);
    //generateID(ไอดีตัวสุดท้าย,จำนวนตัวอักษรที่อยู่ในไอดีนั้นๆ เช่น P099 ก็คือ มีแค่ 1 ตัว );

    $lastsql = "SELECT ID_Order From orders order by ID_Order DESC LIMIT 1";
    $result = mysql_query($lastsql);
    $OldId = mysql_fetch_array($result);

    //P 099
    //$OrId = generateID($OldId['ID_Order'],2);
    $new_id = mysql_result(mysql_query("Select Max(substr(ID_Order,-3))+1 as MaxID from orders"), 0, "MaxID"); //เลือกเอาค่า id ที่มากที่สุดในฐานข้อมูลและบวก 1 เข้าไปด้วยเลย
    if ($new_id == '') { // ถ้าได้เป็นค่าว่าง หรือ null ก็แสดงว่ายังไม่มีข้อมูลในฐานข้อมูล
        $OrId = "OR001";
    } else {
        $OrId = "OR" . sprintf("%03d", $new_id); //ถ้าไม่ใช่ค่าว่าง
    }
    ?>
                                <input type="hidden" id='NewOrderId' value="<?php echo $OrId; ?>">
                                <div class="row">

                                    <div class="table-responsive">

                                        <table class="table">
                                            <tr>
                                            <br>
                                            <td style="border: none;width: 25%;">
                                                <label>รหัสการสั่งสินค้า : </label>
                                            </td>
                                            <td style="border: none;">
                                                <span>&nbsp;<b id='orderId'><?php echo $OrId; ?></b></span>
                                                <input name="ID_Order" id="ID_Order" type="hidden" placeholder="รหัสการสั่งสินค้า" value="<?php echo $OrId; ?>">
                                            </td>
                                            <td style="border: none;width: 19%;">
                                                <label>วันที่สั่งสินค้า</label>
                                            </td>
                                            <td style="border: none;">
                                                <input class="form-control point" name="Date_Order" id="datetimepicker1" type="text" placeholder="คลิกเพื่อเลือกวันที่" style="width: 100%;" required="">
                                                <script type="text/javascript">
                                                    jQuery('#datetimepicker1').datetimepicker({
                                                        lang: 'th',
                                                        i18n: {
                                                            th: {
                                                                months: [
                                                                    'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน',
                                                                    'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม',
                                                                    'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม',
                                                                ],
                                                                dayOfWeek: [
                                                                    "So.", "Mo", "Di", "Mi",
                                                                    "Do", "Fr", "Sa.",
                                                                ]
                                                            }
                                                        },
                                                        timepicker: false,
                                                        format: 'd/m/Y'
                                                    });
                                                    $(document).ready(function () {
                                                        var date = new Date();

                                                        if (date.getDate() < 10)
                                                        {
                                                            //date = "0"+date.getDate()+"/"+(date.getMonth()+"/"+date.getFullYear();
                                                            date = (date.getDate() + "/" + (parseInt(date.getMonth()) + 1) + "/" + date.getFullYear());
                                                        }
                                                        else
                                                        {
                                                            //date = date.getDate()+"/"+date.getMonth()+"/"+date.getFullYear();
                                                            date = (date.getDate() + "/" + (parseInt(date.getMonth()) + 1) + "/" + date.getFullYear());
                                                        }
                                                        jQuery('#datetimepicker1').val(date);

                                                    });

                                                </script>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;width: 19%;">
                                                    <label>ชื่อพนักงาน</label>
                                                </td>
                                                <td style="border: none;">
                                                    <?// echo$_SESSION['Username'] ?>
                                                    <select name="ID_Emp" style="width: 100%;" id="ID_Emp" class="idropdown" placeholder="รหัสพนักงาน" required="">
                                                        <option value="" style="background: #C0F9BD">ชื่อพนักงาน</option>
    <?php
    $sql = "SELECT * FROM employees ORDER BY ID_Emp ASC";
    $query = mysql_query($sql);
    while ($objResult = mysql_fetch_array($query)) {
        ?>
                                                            <option value="<?= $objResult["ID_Emp"]; ?>" style="background: #C0F9BD">
        <?= $objResult["FName_Emp"]; ?>
                                                            </option>
        <?php
    }
    ?>
                                                    </select>
                                                </td>
                                                <td style="border: none;">
                                                    <label>ชื่อบริษัท</label>
                                                </td>
                                                <td style="border: none;">
                                                    <select name="ID_Company"  style="width: 100%;" id="ID_Company" class="idropdown" placeholder="รหัสบริษัท" required="">
                                                        <option value="" style="background: #C0F9BD">ชื่อบริษัท</option>
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
                                    </div>
                                </div>
                                <div align="center"><b>______________________ รายละเอียดการสั่งสินค้า ______________________<b></div>
                                            <br>
                                            <div class="row">

                                                <div class="col-lg-6">
                                                        <?php
                                                        $new_id = mysql_result(mysql_query("Select Max(substr(ID_Orderdetail,-3))+1 as MaxID from order_detail"), 0, "MaxID"); //เลือกเอาค่า id ที่มากที่สุดในฐานข้อมูลและบวก 1 เข้าไปด้วยเลย
                                                        if ($new_id == '') { // ถ้าได้เป็นค่าว่าง หรือ null ก็แสดงว่ายังไม่มีข้อมูลในฐานข้อมูล
                                                            $RTId = "RT001";
                                                        } else {
                                                            $RTId = "RT" . sprintf("%03d", $new_id); //ถ้าไม่ใช่ค่าว่าง
                                                        }
                                                        ?>

                                                    <div class="input-group"style="width:100%;">
                                                        <label>รหัสรายละเอียดข้อมูลการสั่งสินค้า</label>
                                                        <!-- <input type="text" name="OrderdetailId" value="<?php //echo $NewId; ?>"> -->

                                                        <h5><b><?php echo $RTId; ?></b></h5>
                                                        <input type="hidden" name="ID_Orderdetail" id="ID_Orderdetail"  value="<?php echo $RTId; ?>">
                                                    </div>
                                                    <div class="input-group" style="width:100%;">
                                                    <?php
                                                    $sql = "SELECT * FROM product p, count c	WHERE p.ID_Count = c.ID_Count ORDER BY ID_Product ASC";
                                                    $query = mysql_query($sql);
                                                    echo "<script>var product = " . json_encode(fetchArray($query)) . ";</script>";
                                                    ?>
                                                        <label>ชื่อสินค้า</label><br>
                                                        <select name="ID_Product" id="SID_Product" class="idropdown" placeholder="ชื่อสินค้า">
                                                            <option value="" style="background: #C0F9BD">ชื่อสินค้า</option>
                                                    <?php
                                                    $query = mysql_query($sql);
                                                    while ($objResult = mysql_fetch_array($query)) {
                                                        ?>
                                                                <option  value="<?= $objResult["ID_Product"]; ?>" style="background: #C0F9BD">
        <?= $objResult["Product_Name"]; ?> 

                                                                </option>
        <?php
    }
    ?>
                                                        </select>
                                                    </div>
                                                    <div class="input-group" style="width:100%;">
                                                        <div><label>จำนวนสินค้า</label></div>
                                                        <div>
                                                            <input type="text" name="Amount_Product" id="Amount_Product" onchange="amount()"  placeholder="กรุณากรอกจำนวนสินค้า" maxlength="10" style="background: #C0F9BD" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="input-group" style="width:100%;">
                                                        <div style="width: 82%;">
                                                            <label>ราคา/หน่วย</label>
                                                            <input type="text" name="Cost_Price" disabled="" id="Cost_Price" required="" placeholder="ราคาทุน" maxlength="10"  class="form-control">
                                                        </div>

                                                        <div style="padding: 7px 0px 0px 86%;">บาท</div>
                                                    </div>

                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="input-group"style="width:100%;">
                                                        <label>รหัสการสั่งสินค้า</label>
                                                        <input name="ID_Order" id="DeID_Order" disabled="" placeholder="รหัสการสั่งสินค้า" value="<?php echo $OrId; ?>" maxlength="5"  class="form-control">
                                                    </div>
                                                    <div class="input-group"style="width:100%;">
                                                        <label>รหัสสินค้า</label>
                                                        <input name="ID_Product" id="ID2_Product" disabled="" required placeholder="รหัสสินค้า" maxlength="4" value=""  class="form-control">
                                                    </div>

                                                    <!-- <div class="input-group"style="width:100%;">
                                                            <label>หน่วยนับ</label>
                                                            <input type="text" class="form-control" name="ID_Count" id="ID_Count" required placeholder="รหัสหน่วยนับ" value="<?php echo $OrId; ?>" maxlength="4"> 
                                                    </div> -->
                                                    <div class="input-group" style="width:100%;">
                                                        <label>หน่วยนับ</label><br>
                                                        <input name="ID_Count" id="ID2_Count" disabled="" required="" placeholder="หน่วยนับ" maxlength="4" value="" class="form-control">
                                                    </div>
                                                    <div class="input-group" style="width:100%;">
                                                        <div style="width: 82%;">
                                                            <div><label>ราคารวม</label></div>
                                                            <div>
                                                                <input type="text" name="Total_Price"  id="iTotal_Price" placeholder="ราคารวม" value="" class="form-control" >
                                                            </div>
                                                        </div>
                                                        <div style="padding: 7px 0px 0px 86%;">บาท</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <center><br>
                                                        <input id="add" type="submit" class="btn btn-primary" name="Button" value="เพิ่มข้อมูล">
                                                        <input id="update"type="submit" class="btn btn-warning" name="Button" value="แก้ไขข้อมูล">
                                                        <input id="delete"type="submit" class="btn btn-danger" name="Button" value="ลบข้อมูล">
                                                        <input id="cancle" type="reset" class="btn btn-default" name="Button" value="ยกเลิก">


                                                        <script type="text/javascript">
                                                            $('#Cost_Price').number(true, 2);
                                                            $('#Total_Price').number(true, 2);
                                                            $('#cancle').click(function () {
                                                                $('#add').show();
                                                            });



                                                        </script>
                                                    </center>
                                                    <br>
                                                </div>

                                                <div align="right">
                                                    <a class="btn btn-success" href="./addorder.php">
                                                        <i class="glyphicon glyphicon-print"></i> พิมพ์ใบสั่งสินค้า
                                                    </a>
                                                </div>

                                            </div>
                                            </div>
                                            <script type="text/javascript">

                                                var Cost_Price = 0;

                                                $('#SID_Product').change(function () {
                                                    var productId = $('#SID_Product').val();
                                                    $('#ID2_Product').val(productId);
                                                    // document.getElementById("ID_Count")[0].text ="<?= $row_Orderdetail['Name_Count'] ?>";
                                                    // document.getElementById("ID_Count")[0].value ="<?= $row_Orderdetail['ID_Count'] ?>"; 

                                                    var count = searchCount(product, productId);
                                                    console.log(count);
                                                    if (count != undefined) {
                                                        console.log(count['ID_Count']);
                                                        $('#ID2_Count').val(count['Name_Count']);
                                                        $('#Cost_Price').val(count['Cost_Price']);
                                                        Cost_Price = parseFloat(count['Cost_Price']);
                                                    }
                                                });

                                                function searchCount(product, productId) {
                                                    var size = product.length;
                                                    var found = 0;
                                                    for (var index = 0; index < size; index++) {
                                                        if (product[index].ID_Product == productId) {
                                                            found = index;
                                                            break;
                                                        }
                                                    }
                                                    return product[found];
                                                }

                                                function amount() {
                                                    var amount = parseFloat($('#Amount_Product').val());
                                                    amount = isNaN(amount) ? 0 : amount;
                                                    if (Cost_Price > 0) {
                                                        console.log(Cost_Price, amount);
                                                        var total = parseFloat(Cost_Price) * parseFloat(amount);
                                                        // document.getElementById('Total_Price').value = total;
                                                        // Total_Price.value = total;
                                                        $('#iTotal_Price').val(total);
                                                    }
                                                }

                                            </script>
                                            <div class="col-md-5">
                                                <div>
                                                    <ul class="nav nav-tabs" role="tablist">
                                                        <li Class = "active"><a href="./base.php">ข้อมูลการสั่งสินค้า</a></li>
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
                                                    <div class="col-md-12">
                                                        <?
                                                        $strSQL = "SELECT * FROM employees e, orders o ,company c WHERE e.ID_Emp = o.ID_Emp AND o.ID_Company = c.ID_Company ORDER BY ID_Order ASC";
                                                        $objQuery = mysql_query($strSQL);
                                                        ?>


                                                        <div class="bs-example">
                                                            <div class="panel panel-default">
                                                                <!-- Default panel contents -->
                                                                <div class="panel-heading"><h4>การสั่งสินค้า</h4></div>
                                                                <!-- Table -->
                                                                <div class="mygrid-wrapper-div">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>รหัสการสั่งสินค้า</th>
                                                                                <th>ชื่อพนักงาน</th>
                                                                                <th>ชื่อบริษัท</th>
                                                                                <th>วันที่สั่งสินค้า</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?
                                                                            //$strSQL = "";

                                                                            $strSQL = "SELECT o.ID_Order, o.Date_Order, c.Name_Company, e.FName_Emp, e.LName_Emp FROM orders o INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN employees e ON e.ID_Emp = o.ID_Emp ORDER BY o.ID_Order ASC";
                                                                            $objQuery = mysql_query($strSQL);
                                                                            ?>
    <?php while ($row_order = mysql_fetch_array($query)) { ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <a id="<?= $row_order['ID_Order'] ?>" class="point">
        <?php echo $row_order['ID_Order']; ?>
                                                                                        </a>
                                                                                    </td>
                                                                                    <td><?php echo $row_order['FName_Emp']; ?></td>
                                                                                    <td><?php echo $row_order['Name_Company']; ?></td>
                                                                                    <td><?php echo $row_order['Date_Order']; ?></td>
                                                                                </tr>
                                                                            <script type="text/javascript">
                                                                                $("#<?= $row_order['ID_Order'] ?>").click(function () {
                                                                                    $('#add').hide();
                                                                                    $('#orderId').text("<?= $row_order['ID_Order'] ?>");
                                                                                    ID_Order.value = "<?= $row_order['ID_Order'] ?>";
                                                                                    document.getElementById("ID_Emp")[0].text = "<?= $row_order['FName_Emp'] ?>";
                                                                                    document.getElementById("ID_Emp")[0].value = "<?= $row_order['ID_Emp'] ?>";
                                                                                    document.getElementById("ID_Company")[0].text = "<?= $row_order['Name_Company'] ?>";
                                                                                    document.getElementById("ID_Company")[0].value = "<?= $row_order['ID_Company'] ?>";
                                                                                    datetimepicker1.value = "<?= $row_order['Date_Order'] ?>";
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
    <?php
    $sql = "SELECT o.ID_Order, o.Date_Order, o.ID_Emp, o.ID_Company, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, c.Name_Company, p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.ID_Prefix, e.FName_Emp, e.LName_Emp, ct.ID_Count, ct.Name_Count FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp INNER JOIN count ct ON ct.ID_Count = p.ID_Count ORDER BY ID_Orderdetail ASC";
    $query = mysql_query($sql);
    //$objResult = mysql_fetch_array($objQuery);
    ?>

                                                        <div class="bs-example">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading"><h4>รายการสินค้าที่ต้องการสั่งซื้อ</h4></div>
                                                                <div class="mygrid-wrapper-div">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>รหัสรายละเอียด</th>
                                                                                <th>รหัสการสั่งสินค้า</th>
                                                                                <th>รหัสสินค้า</th>
                                                                                <th>ชื่อสินค้า</th>
                                                                                <th>จำนวน</th>
                                                                                <th>หน่วยนับ</th>
                                                                                <th>ราคา/หน่วย</th>
                                                                                <th>ราคารวม</th>
                                                                                <th>สถานะ</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                        <?php
                                                        $sql = "SELECT o.ID_Order, o.Date_Order, o.ID_Emp, o.ID_Company, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, c.Name_Company, p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.ID_Prefix, e.FName_Emp, e.LName_Emp, ct.ID_Count, ct.Name_Count FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp INNER JOIN count ct ON ct.ID_Count = p.ID_Count ORDER BY ID_Orderdetail ASC";
                                                        $query = mysql_query($sql);
                                                        ?>
    <?php while ($row_Orderdetail = mysql_fetch_array($query)) { ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <a id="<?= $row_Orderdetail['ID_Orderdetail'] ?>" class="point">
        <?php echo $row_Orderdetail['ID_Orderdetail']; ?>
                                                                                        </a>
                                                                                        <a id="<?= $row_order['ID_Order'] ?>" class="point">
        <?php echo $row_order['ID_Order']; ?>
                                                                                        </a>
                                                                                    </td>
                                                                                    <td><?php echo $row_Orderdetail['ID_Order']; ?></td>
                                                                                    <td><?php echo $row_Orderdetail['ID_Product']; ?></td>
                                                                                    <td><?php echo $row_Orderdetail['Product_Name']; ?></td>
                                                                                    <td align = "right"><?php echo $row_Orderdetail['ODAmount_Product']; ?></td>
                                                                                    <td><?php echo $row_Orderdetail['Name_Count']; ?></td>
                                                                                    <td><?php echo $row_Orderdetail['Cost_Price']; ?>
                                                                                    <td><span id="right"><?php echo $row_Orderdetail['Total_Price']; ?></span></td>
                                                                                    <td> 
                                                                                <?php
                                                                                //echo ($row_Orderdetail['ID_Order'] == $row_Orderdetail['RID_Order']) ? '<span class="label label-success">รับแล้วนะจ๊ะ สุดหล่อ</span>':'<span class="label label-danger">ยังไม่รับจ๊ะ สุดหล่อ</span>';
                                                                                if ($row_Orderdetail['ID_Order'] == $row_Orderdetail['RID_Order']) {
                                                                                    echo '<span class="label label-success">รับสินค้าเรียบร้อย</span>';
                                                                                } else {
                                                                                    echo '<span class="label label-danger">ยังไม่ได้รับสินค้า</span>';
                                                                                }
                                                                                ?> 
                                                                                    </td>
                                                                                </tr>
                                                                            <script type="text/javascript">
                                                                                $("#<?= $row_Orderdetail['ID_Orderdetail'] ?>").click(function () {
                                                                                    $('#add').hide();
                                                                                    $('#ID_Orderdetail').val("<?= $row_Orderdetail['ID_Orderdetail'] ?>");
                                                                                    $('#DeID_Order').val("<?= $row_Orderdetail['ID_Order'] ?>");
                                                                                    $('#ID_Order').val("<?= $row_Orderdetail['ID_Order'] ?>");
                                                                                    $('#orderId').text("<?= $row_Orderdetail['ID_Order'] ?>");

                                                                                    $('#ID_Orderdetail').text("<?= $row_Orderdetail['ID_Orderdetail'] ?>");
                                                                                    ID_Orderdetail.value = "<?= $row_Orderdetail['ID_Orderdetail'] ?>";


                                                                                    // ID_Order.value = "<?= $row_Orderdetail['ID_Order'] ?>";
                                                                                    $('#ID2_Product').val("<?= $row_Orderdetail['ID_Product'] ?>");
                                                                                    document.getElementById("SID_Product")[0].text = "<?= $row_Orderdetail['Product_Name'] ?>";
                                                                                    document.getElementById("SID_Product")[0].value = "<?= $row_Orderdetail['ID_Product'] ?>";
                                                                                    $('#Amount_Product').val("<?= $row_Orderdetail['ODAmount_Product'] ?>");
                                                                                    // document.getElementById("ID_Count")[0].text ="<?= $row_Orderdetail['Name_Count'] ?>";
                                                                                    // document.getElementById("ID_Count")[0].value ="<?= $row_Orderdetail['ID_Count'] ?>";
                                                                                    // ;Total_Price.value = "<?= $row_Orderdetail['Total_Price'] ?>";
                                                                                    $('#ID2_Count').val("<?= $row_Orderdetail['Name_Count'] ?>");
                                                                                    $('#Total_Price').val("<?= $row_Orderdetail['Total_Price'] ?>");
                                                                                    $('#Cost_Price').val("<?= $row_Orderdetail['Cost_Price'] ?>");
                                                                                    document.getElementById("ID_Order").value = "<?= $row_Orderdetail['ID_Order'] ?>";
                                                                                    document.getElementById("ID_Emp")[0].text = "<?= $row_Orderdetail['FName_Emp'] ?>";
                                                                                    document.getElementById("ID_Emp")[0].value = "<?= $row_Orderdetail['ID_Emp'] ?>";
                                                                                    document.getElementById("ID_Company")[0].text = "<?= $row_Orderdetail['Name_Company'] ?>";
                                                                                    document.getElementById("ID_Company")[0].value = "<?= $row_Orderdetail['ID_Company'] ?>";
                                                                                    document.getElementById("datetimepicker1").value = "<?= $row_Orderdetail['Date_Order'] ?>";

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
                                                </form>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                            </article>
                                            <footer>
                                                <script type="text/javascript">
                                                    $(document).ready(function () {
                                                        $('#order').addClass('active');
                                                    });
                                                </script>
    <?php include("../fragments/footer.php"); ?>
                                            </footer>
                                            </body>
                                            </html>
<?php } ?>