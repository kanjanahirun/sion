<?php
session_start();
include("../connect/connect.php");
// $ID_Count = "C001";

if (empty($_SESSION['Username'])) {
    if (empty($_SESSION['Username']) || empty($_SESSION['status']) || empty($_SESSION['name'])) {
        echo alert('กรุณาเข้าสู่ระบบ Admin ก่อน');
        echo location("../login.php");
    }
}else{
    if($_SESSION['ID_Status'] == "s002"){
        echo location("./addorder.php");
    }else{

if (!empty($_POST['Button'])) {
    $button = $_POST['Button'];
    //$Flag = true;
    if ($button == 'เพิ่มข้อมูล') {
        $sql = "INSERT INTO product (ID_Product, Product_Name, Amount_Product, ID_Count, Cost_Price, Sale_Price, Point_Purchase,ID_Company) VALUES ('" . $_POST["ID_Product"] . "', '" . $_POST["Product_Name"] . "', '" . $_POST["Amount_Product"] . "', 'C001', '" . $_POST["Cost_Price"] . "', '" . $_POST["Sale_Price"] . "', '" . $_POST["Point_Purchase"] . "','".$_POST["ID_Company"]."')";
        $Flag = mysql_query($sql);

        if ($Flag) {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลสำเร็จ')</script>";
        } else {
            echo "<script type='text/javascript'>alert('เพิ่มข้อมูลผิดพลาด')</script>";
        }
    } elseif ($button == 'แก้ไขข้อมูล') {
        //$sql = "UPDATE Employees SET ID_Prefix, FName_Emp, LName_Emp, Tel_Emp, Salary, ID_TypeEmp, personal_ID = '".$_POST["ID_Prefix"]."', '".$_POST["FName_Emp"]."', '".$_POST["LName_Emp"]."', '".$_POST["Tel_Emp"]."', '".$_POST["Salary"]."', '".$_POST["ID_TypeEmp"]."', '".$_POST["personal_ID"]."'";
        $sql = "UPDATE product SET ID_Product = '" . $_POST["ID_Product"] . "',Product_Name = '" . $_POST["Product_Name"] . "',Amount_Product = '" . $_POST["Amount_Product"] . "',ID_Count = 'C001',Cost_Price = '" . $_POST["Cost_Price"] . "',Sale_Price = '" . $_POST["Sale_Price"] . "',Point_Purchase = '" . $_POST["Point_Purchase"] . "',ID_Company='".$_POST["ID_Company"]."' WHERE ID_Product = '" . $_POST["ID_Product"] . "'";
        $Flag = mysql_query($sql);
        if ($Flag) {
            echo alert('แก้ไขข้อมูลสำเร็จ');
        } else {
            echo alert('แก้ไขข้อมูลผิดพลาด');
        }
    } elseif ($button == "ลบข้อมูล") {
        $sql = "DELETE FROM product WHERE ID_Product = '" . $_POST["ID_Product"] . "'";
        $Flag = mysql_query($sql);
        if ($Flag) {
            echo alert('ลบข้อมูลสำเร็จ');
        } else {
            echo alert('ลบข้อมูลผิดพลาด');
        }
    }
}
?>
<!DOCTYP html>
<html>
    <head>
        <title> ร้านศรีอ้น แฮร์ & สปาร์ </title>

        <?php include("../fragments/libmanage.php"); ?>
        <style>
            .input-group{
                padding-bottom: 5px;
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
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li Class = "active"><a href="./base.php">จัดการข้อมูลสินค้า</a></li>
                                <li role="presentation" class="dropdown" style="float: right;margin-right: -2px;">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" style="min-width: 160px;">
                                        <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ""; ?> <span class="caret" style="float: right;margin-top: 10px;"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="../logout.php">ออกจากระบบ</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                                            <?php if (!empty($_GET['q'])) { ?>
                                            <?php
                                            $sql = "SELECT * FROM product p INNER JOIN count c INNER JOIN company cm ON p.ID_Count = c.ID_Count AND p.ID_Company=cm.ID_Company WHERE p.ID_Product LIKE '" . $_GET['q'] . "' OR p.Product_Name LIKE '%" . $_GET['q'] . "%' OR cm.Name_Company LIKE '" . $_GET['q'] . "' ORDER BY p.ID_Product ";
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
                                                        <div style="text-align: right;"><a href="./product.php" class="btn btn-default">ปิด</a></div>
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
                        $lastsql = "SELECT ID_Product From product order by ID_Product DESC LIMIT 1";
                        $result = mysql_query($lastsql);
                        $IdPro = mysql_fetch_array($result);
                        $ProId = generateIDbyFix($IdPro['ID_Product'], 1, "P");
                        ?>
                         <tr>
                                                                <td style="border: none;width: 15%;">
                                                                    <h3>จัดการข้อมูลสินค้า</h3>
                                                                </td>
                                                            </tr>
                        <form name="form1" method="post" action=""> 
                            <div class="row">
                                <div class="padform">
                                    <div class="col-lg-6">

                                        <div class="input-group"style="width:60%;">
                                            <label>รหัสสินค้า</label>
                                            <input name="ID_Product" id="ID_Product" required="" placeholder="รหัสสินค้า" maxlength="4" value="<?php echo $ProId; ?>" style="background: #C0F9BD" class="form-control" readonly>
                                        </div>
                                        <div class="input-group"style="width:60%;">
                                            <label>ชื่อสินค้า</label> <font color="red">*</font>
                                            <input type="text" name="Product_Name" id="Product_Name" placeholder="ชื่อสินค้า" style="background: #C0F9BD" class="form-control" required="">
                                        </div>

                                        <div class="input-group" style="width:60%;">
                                            <div><label>จำนวนสินค้า</label> <font color="red">*</font></div> 
                                            <div>
                                                <input type="text" name="Amount_Product" id="Amount_Product" placeholder="จำนวนสินค้า" maxlength="10" style="background: #C0F9BD;text-align:right" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="input-group"style="width:60%;">
                                            <label>หน่วยนับ</label> <font color="red">*</font>

                                            <input type="text" name="tt" id="tt" required placeholder="ชิ้น" value="ชิ้น" maxlength="10" style="background: #C0F9BD" class="form-control" readonly> 
                                        </div> 
                                    </div> 
                                    <div class="col-lg-6">
                                        <div class="input-group" style="width:60%;">
                                            <div style="width: 82%;">
                                                <label>ราคาทุน</label> <font color="red">*</font>
                                                <input type="text" name="Cost_Price" id="Cost_Price" required="" placeholder="ราคาทุน" maxlength="10" style="background: #C0F9BD;text-align:right" class="form-control">
                                            </div>

                                            <div style="padding: 7px 0px 0px 84%;">บาท</div>
                                        </div>
                                        <div class="input-group"style="width:60%;">
                                            <div style="width: 82%;">
                                                <label>ราคาขาย</label> <font color="red">*</font>
                                                <input type="text" name="Sale_Price" id="Sale_Price" required="" placeholder="ราคาขาย" maxlength="40" style="background: #C0F9BD;text-align:right" class="form-control">
                                            </div>
                                            <div style="padding: 7px 0px 0px 84%;">บาท</div>
                                        </div>
                                        <div class="input-group"style="width:60%;">
                                            <div style="width: 82%;">
                                                <label>จุดสั่งซื้อสินค้า</label> <font color="red">*</font>
                                                <input type="text" name="Point_Purchase" onchange="checkPoint(1)" id="Point_Purchase" required=""  placeholder="จุดสั่งซื้อสินค้า" maxlength="50" style="background: #C0F9BD;text-align:right" class="form-control">
                                            </div>
                                        </div>
                                        <div class="input-group"style="width:60%;">
                                            <label>บริษัท</label>  <font color="red">*</font>
                                            <br>
                                            <select style="width: 82%;" name="ID_Company" id="ID_Company" class="idropdown" placeholder="หน่วยนับ" required="">
                                                <option value="" style="background: #C0F9BD">เลือกบริษัท</option>
                                                <?php
                                                $sql = "SELECT * FROM company ORDER BY ID_Company ASC";
                                                $query = mysql_query($sql);
                                                while ($objResult = mysql_fetch_assoc($query)) {
                                                    ?>
                                                    <option value="<?= $objResult["ID_Company"]; ?>" style="background: #C0F9BD">
                                                        <?= $objResult["Name_Company"]; ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select> 
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <input onclick="return checkProduct();" id="add" type="submit" class="btn btn-primary" name="Button" value="เพิ่มข้อมูล">
                                        <input id="update" onclick="return confirm('ยืนยันการแก้ไขข้อมูล');" type="submit" class="btn btn-warning" name="Button" value="แก้ไขข้อมูล"> 
                                        <!-- <input id="delete" onclick="return confirm('ยืนยันการลบข้อมูล');" type="submit" class="btn btn-danger" name="Button" value="ลบข้อมูล"> -->
                                        <input onclick="return (confirm('ยืนยันการลบ'))?checkIDProduct():false;" id="delete"type="submit" class="btn btn-danger" name="Button" value="ลบข้อมูล">
                                        <input id="cancle" type="reset" class="btn btn-default" name="Button" value="ยกเลิก">
                                    </center>
                                    <script type="text/javascript">
                                        var point = false;
                                        function checkPoint(limit){
                                            var Point_Purchase = $('#Point_Purchase').val();
                                            if(Point_Purchase >= limit){
                                                point = true;
                                            }else{
                                                $('#Point_Purchase').val(1);
                                                point = false;
                                                alert("จุดสั่งซื้อสินค้าต้องมากกว่าหรือเท่ากับ 1");
                                            }
                                        }
                                        var result = false;
                                        $('#Product_Name,#ID_Company').change(function () {
                                            var Product_Name = $('#Product_Name').val();
                                            var ID_Company = $('#ID_Company').val();
                                            if (Product_Name != "" && Product_Name != undefined && ID_Company != "" && ID_Company != undefined) {
                                                var json = {'Product_Name': Product_Name,'ID_Company':ID_Company};
                                                $.post("./product.controller.php", json).done(function (data) {
                                                    var product = JSON.parse(data);
                                                    if (product.ID_Product > 0) { 
                                                        result = false;
                                                    } else {
                                                        result = true;
                                                    }
                                                });
                                            }
                                        });

                                        function checkProduct() {
                                            var check = false;
                                            if (!result) {
                                                check = false;
                                                $('#ID_Company option[value=""]').attr('selected', 'selected');
                                                alert("ชื่อสินค้าของบริษัทนี้ได้มีการเพิ่มข้อมูลเข้าไปในระบบแล้ว");
                                            }else{
                                                check = true;
                                            }
                                            if(!point){ 
                                                check = false;
                                                $('#Point_Purchase').val(1);
                                                alert("จุดสั่งซื้อสินค้าต้องมากกว่าหรือเท่ากับ 1");
                                            }else{
                                                check = true;
                                            }
                                            return check;
                                        }

                                        // check ข้อมูลที่ใช้อยู่
                                        var useResult = false;
                                        function checkIDProduct() {
                                            if (!useResult)
                                                alert("สินค้านี้ถูกใช้อยู่ไม่สามารถลบได้");
                                            return useResult;
                                        }
                                    </script>
                                    <script type="text/javascript">
                                        $('#Cost_Price').number(true, 2);
                                        $('#Sale_Price').number(true, 2);
                                        $('#Amount_Product').number(true, 0);
                                        $('#Point_Purchase').number(true, 0);
                                        $('#Sale_Price').blur(function () {
                                            if (parseFloat($('#Sale_Price').val()) < parseFloat($('#Cost_Price').val())) {
                                                alert("ราคาขายต้องมากกว่าราคาทุน กรุณาใส่ค่าใหม่ !");
                                            }
                                        });
                                        $('#Cost_Price').blur(function () {
                                            if (parseFloat($('#Sale_Price').val()) < parseFloat($('#Cost_Price').val())) {
                                                alert("ราคาขายต้องมากกว่าราคาทุน กรุณาใส่ค่าใหม่ !");
                                            }
                                        });
                                        $('#cancle').click(function () {
                                            $('#add').show();
                                        });
                                    </script>
                                </div>
                            </div>
                        </form>


                        <div class="product">
                                    <div class="row">
                                        <div class="padform">
                                            <form action="./product.php" method="get">
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
                                                                                <label>รหัส/ชื่อ/บริษัท</label>
                                                                            </td>
                                                                            <td style="border: none;padding: 8px;width: 40%;">
                                                                                <input name="q" id="q" type="text" placeholder="รหัสสินค้า ชื่อสินค้า หรือ บริษัทคู่ค้า" style="background: #C0F9BD;width:100% " class="form-control point" value=""> 
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
                    </div>
                </div>
        </article>
        <footer>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#product').addClass('active');
                });
            </script>
            <?php include("../fragments/footer.php"); ?>
        </footer>
    </body>
</html>
<?php } } ?>