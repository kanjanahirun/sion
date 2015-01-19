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
        if ($result != 0) {
            $success = 0;
            $ID_Receivedetail = $lastID['ID_Receivedetail'];
            for ($i = 0; $i < count($ID_Orderdetail); $i++) {
                $ID_Receivedetail = generateIDbyFix($ID_Receivedetail, 2, "OD");

                $sqlReceiveDetail = "INSERT INTO `receive_detail` ( `ID_Receivedetail` , `ID_Receive` , `ID_Product` ,`Amount_Receive`, `Amount_NonRe`,`ID_Count`,`Cost_Price`,`Amount_balance`, `Product_Remand` ) VALUES ( '" . $ID_Receivedetail . "', '" . $ID_Receive . "', '" . $ID_Product[$i] . "','" . $Amount_Receive[$i] . "','" . $Amount_NonRe[$i] . "','" . $ID_Count[$i] . "','" . $Cost_Price[$i] . "','" . $Amount_balance[$i] . "', '" . $Product_Remand . "' );";
//            echo $sqlReceiveDetail."<br>";
                $RS = mysql_query($sqlReceiveDetail);
                if ($RS != 0) {
                    $success++;
                    $sqlIncrementProduct = "UPDATE `product` SET Amount_Product = Amount_Product + " . intval($Amount_Receive[$i]) . " WHERE ID_Product = '" . $ID_Product[$i] . "'";
                    $queryIncrementProduct = mysql_query($sqlIncrementProduct);
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
                            <form action="" method="post">
                                <div>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li Class = "active"><a href="./receive_receivedetail.php">จัดการข้อมูลการรับสินค้า</a></li>
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
                                <?php
                                $lastsql = "SELECT ID_receivedetail From receive_detail order by ID_receivedetail DESC LIMIT 1";
                                $result = mysql_query($lastsql);
                                $OldId = mysql_fetch_array($result);
                                $NewId = generateIDbyFix($OldId['ID_receivedetail'], 2, "OD");

                                $lastsql = "SELECT ID_Receive From receive order by ID_Receive DESC LIMIT 1";
                                $result = mysql_query($lastsql);
                                $OldId = mysql_fetch_array($result);

                                $OrId = generateIDbyFix($OldId['ID_Receive'], 2, "RD");
                                ?>
                                <input type="hidden" id='NewReceiveId' value="<?php echo $OrId; ?>">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table>
                                            <tr>
                                                <td>
                                                    <label>รหัสการสั่งสินค้า</label>
                                                </td>
                                                <td> 
                                                    <select name="ID_Order" id="ID_Order" class="idropdown" placeholder="เลือกรหัสการสั่งสินค้า" required="" >
                                                        <option value="" style="background: #C0F9BD">เลือกรหัสการสั่งสินค้า</option>
                                                        <?php
                                                        $sql = "SELECT o.ID_Order, o.Date_Order, r.ID_Receive, r.Date_Receive, r.ID_Order AS RID_Order, od.ID_Orderdetail, p.ID_Product, od.Amount_Product AS ODAmount_Product, od.Total_Price, c.Name_Company, p.Product_Name, p.Amount_Product AS PAmount_Product, p.Cost_Price, p.Sale_Price, p.Point_Purchase, e.FName_Emp, e.LName_Emp FROM orders o LEFT JOIN receive r ON o.ID_Order = r.ID_Order INNER JOIN order_detail od ON o.ID_Order = od.ID_Order INNER JOIN company c ON c.ID_Company = o.ID_Company INNER JOIN product p ON p.ID_Product = od.ID_Product INNER JOIN employees e ON e.ID_Emp = o.ID_Emp WHERE r.ID_Order IS NULL ORDER BY o.ID_Order DESC";
                                                        $result = mysql_query($sql);
                                                        // $orderDetail = mysql_fetch_array($cubrid_result(result, row));
                                                        // $sql = "SELECT * FROM orders ORDER BY ID_Order DESC";
                                                        // $query = mysql_query($sql);
                                                        while ($orderDetail = mysql_fetch_array($result)) {
                                                            ?>
                                                            <option value="<?= $orderDetail["ID_Order"]; ?>" style="background: #C0F9BD">
                                                            <?= $orderDetail["ID_Order"]; ?>
                                                            </option>
                                                                <?php
                                                            }
                                                            ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <table>
                                            <tr> 
                                                <td style="border: none;width: 25%;">
                                                    <label>รหัสการรับสินค้า : </label>
                                                </td>
                                                <td style="border: none;">
                                                    <span>&nbsp;<b id='receiveId'><?php echo $OrId; ?></b></span>
                                                    <input name="ID_Receive" id="ID_Receive" type="hidden" placeholder="รหัสการรับสินค้า" value="<?php echo $OrId; ?>">
                                                </td>
                                                <td style="border: none;width: 19%;">
                                                    <label>วันที่รับสินค้า</label>
                                                </td>
                                                <td style="border: none;">
                                                    <input class="form-control point" name="Date_Order" id="datetimepicker1" type="text" placeholder="คลิกเพื่อเลือกวันที่" style="width: 100%;" required="" readonly>
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
                                                                date = (date.getDate() + "/" + (parseInt(date.getMonth()) + 1) + "/" + date.getFullYear());
                                                            }
                                                            else
                                                            {
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
                                                    <input class="form-control point" type="text" placeholder="ชื่อพนักงาน" value="<?= $_SESSION['name'] ?>" readonly="" style="width: 60%;"><input type="hidden" name="ID_Emp" id="ID_Emp" value="<?= $_SESSION['id'] ?>">
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
                                <div class="row" style="margin-top: 40px;">
                                    <div class="col-md-12">
                                        <div align="center">
                                            <h4>______________________________________ รายละเอียดการรับสินค้า ____________________________________</h4>
                                        </div>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table>
                                            <tr>
                                                <th>รหัสรายละเอียด</th>
                                                <th>ชื่อสินค้า</th>
                                                <th>จำนวนที่สั่ง</th>
                                                <th>จำนวนที่รับ</th>
                                                <th>จำนวนค้างรับ</th>
                                                <th>หน่วยนับ</th>
                                                <th>หน่วยละ/บาท</th>
                                                <th>ยอดชำระ/บาท</th>
                                            </tr> 
                                            <tbody id="tbodydetail"></tbody>
                                        </table>
                                    </div>
                                    <div class="row" style="padding-bottom: 30px;">
                                        <div class="col-md-12">
                                            <center><br> 
                                                <div class="col-md-6" align="right"> 
                                                    <input type="hidden" name="save" value="รับสินค้า">
                                                    <button id="add" type="submit" name="submit" class="btn btn-primary">
                                                        <i class="glyphicon glyphicon-shopping-cart"></i> รับสินค้า
                                                    </button>
                                                </div>
                                                <div class="col-md-6" align="left">
                                                    <button id="cancle" type="reset" class="btn btn-default">
                                                        <i class="glyphicon glyphicon-remove-circle"></i> ยกเลิก
                                                    </button>
                                                </div>
                                                <script type="text/javascript">
                                                    $('#cancle').click(function () {
                                                        $('#add').show();
                                                    });
                                                </script>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php
                                    
                                    // compute pagination
                                    $sql = "SELECT * FROM `receive` order by ID_Receive DESC";
                                    $query = mysql_query($sql); 
                                    $total_results = 0;
                                    $receive = array();
                                    while ($receivez = mysql_fetch_assoc($query)) {
                                        $ID_Receive = $receivez['ID_Receive'];

                                        // check ว่ารับครบหรือยัง
                                        $check_receive = 0;
                                        $rsl = "SELECT r.ID_Receive, r.Date_Receive, r.ID_Emp, r.ID_Company, rd.ID_Receivedetail, rd.Amount_Receive, rd.Amount_NonRe, rd.Cost_Price, rd.Amount_balance, rd.ID_Product, rd.Product_Remand, rd.ID_Product, p.Amount_Product, p.Sale_Price, p.Point_Purchase, p.Product_Name, o.ID_Order, o.Date_Order, c.ID_Count, c.Name_Count, c.Amount_Unit FROM receive r INNER JOIN receive_detail rd ON r.ID_Receive = rd.ID_Receive INNER JOIN product p ON rd.ID_Product = p.ID_Product INNER JOIN orders o ON r.ID_Order = o.ID_Order INNER JOIN count c ON p.ID_Count = c.ID_Count WHERE r.ID_Receive = '$ID_Receive' ORDER BY rd.ID_Receivedetail DESC";
                                        $ss = mysql_query($rsl);
                                        while ($rw = mysql_fetch_assoc($ss)) {
                                            if ($rw['Amount_NonRe'] != 0) { 
                                                $check_receive++;
                                            }
                                        }
                                        if ($check_receive > 0) {
                                            $receive[$total_results] = $receivez;
                                            $total_results++; 
                                        }
                                    } 
                                    
                                    $Num_Rows = $total_results;  
                                    $limit = 7; 
                                    $Per_Page = 10;     // กำหนดจำนวนแถวที่ต้องการแสดง
                                    $limitlen = ceil($Num_Rows/$Per_Page);
                                    if($limitlen < $limit) $limit = $limitlen; 

                                    $Page =  1;
                                    if(!empty($_GET["page"])){
                                        $Page = (is_numeric($_GET["page"]) ? $_GET["page"]:1);
                                    }else{
                                        $Page=1;
                                    }
                                    $start = $Page;
                                    $Prev_Page = $Page-1;
                                    $Next_Page = $Page+1;

                                    $Page_Start = (($Per_Page*$Page)-$Per_Page); 
                                    if($Num_Rows<=$Per_Page){
                                            $Num_Pages =1;
                                    }else if(($Num_Rows % $Per_Page)==0){
                                            $Num_Pages =($Num_Rows/$Per_Page) ;
                                    }else{
                                        $Num_Pages =($Num_Rows/$Per_Page)+1;
                                        $Num_Pages = (int)$Num_Pages;
                                    }
                                    // end compute pagination
                                    
                                    $sql = "SELECT * FROM employees e, receive r, company c WHERE e.ID_Emp = r.ID_Emp AND r.ID_Company = c.ID_Company ORDER BY ID_Receive ASC";
                                    $query = mysql_query($sql);
                                    ?>
                                    <div class="bs-example">
                                        <div class="panel panel-default">
                                            <!-- Default panel contents -->
                                            <div class="panel-heading"><h4>แสดงข้อมูลการรับสินค้า</h4></div>
                                            <!-- Table -->
                                            <div class="mygrid-wrapper-div">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัสการรับสินค้า</th>
                                                            <th>ชื่อพนักงาน</th>
                                                            <th>ชื่อบริษัท</th>
                                                            <th>วันที่รับสินค้า</th>
                                                        </tr>
                                                    </thead> 
                                                        <?php
                                                        $sql = "SELECT * FROM `receive` order by ID_Receive DESC";
                                                        $query = mysql_query($sql);
                                                        $receivex = mysql_fetch_array($query);
                                                        $ID_Emp = $receivex['ID_Emp'];
                                                        $ID_Receive = $receivex['ID_Receive'];
                                                        $rql = "SELECT r.ID_Receive, r.Date_Receive, c.ID_Company ,c.Name_Company, e.ID_Emp,e.FName_Emp, e.LName_Emp FROM receive r INNER JOIN company c ON c.ID_Company = r.ID_Company INNER JOIN employees e ON e.ID_Emp = r.ID_Emp WHERE e.ID_Emp='$ID_Emp' AND r.ID_Receive='$ID_Receive' ORDER BY r.ID_Receive ASC";
                                                        $row_receive = mysql_fetch_assoc(mysql_query($rql));
                                                        $sql = "SELECT r.ID_Receive, r.Date_Receive, r.ID_Emp, r.ID_Company, rd.ID_Receivedetail, rd.Amount_Receive, rd.Amount_NonRe, rd.Cost_Price, rd.Amount_balance, rd.ID_Product, rd.Product_Remand, rd.ID_Product, p.Amount_Product, p.Sale_Price, p.Point_Purchase, p.Product_Name, o.ID_Order, o.Date_Order, c.ID_Count, c.Name_Count, c.Amount_Unit FROM receive r INNER JOIN receive_detail rd ON r.ID_Receive = rd.ID_Receive INNER JOIN product p ON rd.ID_Product = p.ID_Product INNER JOIN orders o ON r.ID_Order = o.ID_Order INNER JOIN count c ON p.ID_Count = c.ID_Count WHERE r.ID_Receive = '" . $row_receive['ID_Receive'] . "' ORDER BY rd.ID_Receivedetail DESC";
                                                        $result = mysql_query($sql);
                                                        $row = mysql_fetch_assoc($result);
//                                                        print_r($row);
                                                        if ($row['Amount_NonRe'] > 0) {
                                                            ?> 
                                                        <tbody>
                                                        <?php
                                                        //$sql = "SELECT r.ID_Receive, r.Date_Receive, c.ID_Company ,c.Name_Company, e.ID_Emp,e.FName_Emp, e.LName_Emp FROM receive r INNER JOIN company c ON c.ID_Company = r.ID_Company INNER JOIN employees e ON e.ID_Emp = r.ID_Emp ORDER BY r.ID_Receive ASC";
//                                                        $sql = "SELECT * FROM `receive` order by ID_Receive DESC";
//                                                        $query = mysql_query($sql);
//                                                        while ($receive = mysql_fetch_array($query)) {
                                                        
                                                        
                                                        
                                                        if($Num_Rows < $Per_Page){
                                                            $Per_Page = $Num_Rows;
                                                        } 
                                                        if($Page_Start <= $Per_Page){
                                                         
                                                        for($i = $Page_Start; $i < ($Per_Page+$Page_Start); $i++){ 
                                                            
//                                                            print_r($receive);
                                                            
                                                            $ID_Emp = $receive[$i]['ID_Emp'];
                                                            $ID_Receive = $receive[$i]['ID_Receive'];

                                                            // check ว่ารับครบหรือยัง
//                                                            $check_receive = 0;
//                                                            $rsl = "SELECT r.ID_Receive, r.Date_Receive, r.ID_Emp, r.ID_Company, rd.ID_Receivedetail, rd.Amount_Receive, rd.Amount_NonRe, rd.Cost_Price, rd.Amount_balance, rd.ID_Product, rd.Product_Remand, rd.ID_Product, p.Amount_Product, p.Sale_Price, p.Point_Purchase, p.Product_Name, o.ID_Order, o.Date_Order, c.ID_Count, c.Name_Count, c.Amount_Unit FROM receive r INNER JOIN receive_detail rd ON r.ID_Receive = rd.ID_Receive INNER JOIN product p ON rd.ID_Product = p.ID_Product INNER JOIN orders o ON r.ID_Order = o.ID_Order INNER JOIN count c ON p.ID_Count = c.ID_Count WHERE r.ID_Receive = '$ID_Receive' ORDER BY rd.ID_Receivedetail DESC";
//                                                            $ss = mysql_query($rsl);
//                                                            while ($rw = mysql_fetch_assoc($ss)) {
//                                                                if ($rw['Amount_NonRe'] != 0) {
//                                                                    $check_receive++;
//                                                                }
//                                                            }

//                                                            if ($check_receive > 0) {

                                                                if (strpos($ID_Emp, "E") !== false) {
                                                                    $rql = "SELECT r.ID_Receive, r.Date_Receive, c.ID_Company ,c.Name_Company, e.ID_Emp,e.FName_Emp, e.LName_Emp FROM receive r INNER JOIN company c ON c.ID_Company = r.ID_Company INNER JOIN employees e ON e.ID_Emp = r.ID_Emp WHERE e.ID_Emp='$ID_Emp' AND r.ID_Receive='$ID_Receive' ORDER BY r.ID_Receive ASC";
                                                                } else if (strpos($ID_Emp, "AD") !== false) {
                                                                    $rql = "SELECT r.ID_Receive, r.Date_Receive, c.ID_Company ,c.Name_Company, e.ID_Admin AS ID_Emp,e.Name_Admin AS FName_Emp, e.LName_Admin AS LName_Emp FROM receive r INNER JOIN company c ON c.ID_Company = r.ID_Company INNER JOIN admin e ON e.ID_Admin = r.ID_Emp WHERE e.ID_Admin='$ID_Emp' AND r.ID_Receive='$ID_Receive' ORDER BY r.ID_Receive ASC ";
                                                                }
                                                                $row_receive = mysql_fetch_assoc(mysql_query($rql));
                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <!-- <a id="<?= $row_receive['ID_Receive'] ?>" class="point">
                                                                            <?php echo $row_receive['ID_Receive']; ?>
                                                                            </a> -->

                                                                            <?php ?>
                                                                            <a class="popup-with-zoom-anim" HREF="#small<?= $row_receive['ID_Receive'] ?>"> <?php echo $row_receive['ID_Receive']; ?> </a>
                                                                            <?php $sql = "SELECT r.ID_Receive, r.Date_Receive, r.ID_Emp, r.ID_Company, rd.ID_Receivedetail, rd.Amount_Receive, rd.Amount_NonRe, rd.Cost_Price, rd.Amount_balance, rd.ID_Product, rd.Product_Remand, rd.ID_Product, p.Amount_Product, p.Sale_Price, p.Point_Purchase, p.Product_Name, o.ID_Order, o.Date_Order, c.ID_Count, c.Name_Count, c.Amount_Unit FROM receive r INNER JOIN receive_detail rd ON r.ID_Receive = rd.ID_Receive INNER JOIN product p ON rd.ID_Product = p.ID_Product INNER JOIN orders o ON r.ID_Order = o.ID_Order INNER JOIN count c ON p.ID_Count = c.ID_Count WHERE r.ID_Receive = '" . $row_receive['ID_Receive'] . "' ORDER BY rd.ID_Receivedetail DESC";
                                                                            $result = mysql_query($sql);
                                                                            ?>
                                                                            <div id="small<?= $row_receive['ID_Receive'] ?>" class="zoom-anim-dialog mfp-hide dialog open" style="margin-top: 22px;height: auto;">
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading"><h4>ข้อมูลรายละเอียดการรับสินค้า</h4></div>
                                                                                    <div class="mygrid-wrapper-div">
                                                                                        <table class="table"> 
                                                                                            <thead>
                                                                                            <th>#</th>
                                                                                            <th>ชื่อสินค้า</th>
                                                                                            <th><span style="float:right;">จำนวนที่สั่ง</span></th>
                                                                                            <th><span style="float:right;">จำนวนที่รับ</span></th>
                                                                                            <th><span style="float:right;">จำนวนค้างรับ</span></th>
                                                                                            <th>หน่วยนับ</th>
                                                                                            <th><span style="float:right;">หน่วยละ/บาท</span></th>
                                                                                            <th><span style="float:right;">ยอดชำระ/บาท</span></th>
                                                                                            <th>สถานะ</th>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                    <?php
                                                                                                    $inx = 0;
                                                                                                    while ($row = mysql_fetch_array($result)) {
                                                                                                        if ($row['Amount_NonRe'] != 0) {
                                                                                                            ?>
                                                                                                        <tr>
                                                                                                            <td><?php echo ++$inx; ?></td>
                                                                                                            <td><?php echo $row['Product_Name']; ?></td>
                                                                                                            <td>
                                                                                                                <?php
                                                                                                                $ID_Order = $row['ID_Order'];
                                                                                                                $ID_Product = $row['ID_Product'];
                                                                                                                $mql = "SELECT * FROM orders o INNER JOIN order_detail od ON o.ID_Order = od.ID_Order WHERE o.ID_Order = '$ID_Order' AND od.ID_Product = '$ID_Product'";
                                                                                                                $amount = mysql_fetch_assoc(mysql_query($mql));
                                                                                                                ?>
                                                                                                                <span style="float: right;"><?php echo $amount['Amount_Product']; ?> </span>
                                                                                                            </td>
                                                                                                            <td><span style="float: right;"><?php echo $row['Amount_Receive']; ?></span></td>
                                                                                                            <td><span style="float: right;"><?php echo $row['Amount_NonRe'] ?></span></td>
                                                                                                            <td>
                                                                                                                <?php
                                                                                                                $ID_Count = $amount['ID_Count'];
                                                                                                                $nql = "SELECT * FROM count WHERE ID_Count='$ID_Count'";
                                                                                                                $count = mysql_fetch_assoc(mysql_query($nql));
                                                                                                                ?>
                                                                                                                <?php echo $count['Name_Count']; ?>
                                                                                                            </td>
                                                                                                            <td><span style="float: right;"><?php echo $row['Cost_Price']; ?></span></td>
                                                                                                            <td><span style="float: right;"><?php echo $row['Amount_balance']; ?></span></td>
                                                                                                            <td>
                                                                                                                <?php
                                                                                                                if ($row['Amount_NonRe'] != 0) {
                                                                                                                    ?>
                                                                                                                    <a class="popup-with-zoom-anim btn btn-warning" HREF="#small<?= $row['ID_Receivedetail'] ?>">รับสินค้าที่เหลือ</a>
                                                                                                                    <div id="small<?= $row['ID_Receivedetail'] ?>" class="zoom-anim-dialog mfp-hide dialog">
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
                                                                                                                                                <th>หน่วยละ/บาท</th>
                                                                                                                                                <th>ยอดชำระ/บาท</th>
                                                                                                                                            </tr>
                                                                                                                                        </thead>
                                                                                                                                        <tbody>
                                                                                                                                            <tr>
                                                                                                                                                <?php $idx = $row['ID_Receivedetail']; ?>
                                                                                                                                                <td>
                                                                                                                                                    <input type="hidden" name="ID_Receive2" id="ID_Receive<?= $idx ?>" value="<?php echo $row['ID_Receive']; ?>" >
                                                                                                                                                    <input type="text" name="ID_Receivedetail2" value="<?php echo $row['ID_Receivedetail']; ?>" class="form-control" readonly="">
                                                                                                                                                </td>
                                                                                                                                                <td>
                                                                                                                                                    <input type="hidden" id="ID_Product<?= $idx ?>" name="ID_Product2" value="<?php echo $row['ID_Product']; ?>">
                                                                                                                                                    <input name="Product_NameS" id="Product_Name<?= $idx ?>" value="<?php echo $row['Product_Name']; ?>" maxlength="5" class="form-control" readonly="">
                                                                                                                                                </td>
                                                                                                                                                <td>
                                                                                                                                                    <input type="text" style="text-align:right" name="Amount_Product2" id="Amount_Product<?= $idx ?>" placeholder="จำนวนที่สั่ง" maxlength="10" class="form-control" required="" value="<?php echo $amount['Amount_Product']; ?>" readonly="">
                                                                                                                                                </td>
                                                                                                                                                <td>
                                                                                                                                                    <input type="text" style="text-align:right" name="No_Receive2" id="No_Receive<?= $idx ?>" placeholder="จำนวนค้างรับ" maxlength="10" class="form-control" required="" value="<?php echo $row['Amount_NonRe'] ?>" readonly="">
                                                                                                                                                </td>
                                                                                                                                                <td>
                                                                                                                                                    <input type="text" style="text-align:right" name="Number_Product2" id="Number_Product<?= $idx ?>" placeholder="จำนวนที่รับ" maxlength="10" class="form-control" required="" value="<?php echo $row['Amount_NonRe'] ?>">
                                                                                                                                                </td>
                                                                                                                                                
                                                                                                                                                <td>
                                                                                                                                                    <input type="hidden" name="ID_Count2" id="ID_Count<?= $idx ?>" value="<?php echo $amount['ID_Count'] ?>">
                                                                                                                                                    <input type="hidden" name="Amount_Unit2" id="Amount_Unit<?= $idx ?>" value="<?php echo $count['Amount_Unit'] ?>">
                                                                                                                                                    <input name="Name_Count2" id="Name_Count<?= $idx ?>" required="" placeholder="รหัสหน่วยนับ" maxlength="4" value="<?php echo $count['Name_Count'] ?>" class="form-control" readonly="">
                                                                                                                                                </td>
                                                                                                                                                <td>
                                                                                                                                                    <input type="text" style="text-align:right" name="Cost_Price2" id="Cost_Price<?= $idx ?>" required="" placeholder="ราคาทุน" maxlength="10" class="form-control" value="<?php echo $row['Cost_Price'] ?>" readonly="">
                                                                                                                                                </td>
                                                                                                                                                <td>
                                                                                                                                                    <input type="hidden" name="Total_PriceHide2" id="Total_PriceHide<?= $idx ?>" value="<?php echo $row['Amount_balance'] ?>">
                                                                                                                                                    <input type="text" style="text-align:right" name="Total_Price2" id="Total_Price<?= $idx ?>" placeholder="ราคารวม" maxlength="20" class="form-control" required="" value="<?php echo $row['Amount_balance']; ?>" readonly="">
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

                                                                                                                        $('#Number_Product<?= $idx ?>').change(function () {
                                                                                                                            var amountOr = parseFloat($('#Amount_Product<?= $idx ?>').val());
                                                                                                                            amountOr = isNaN(amountOr) ? 0 : amountOr;
                                                                                                                            var nonere = parseFloat($('#No_Receive<?= $idx ?>').val());
                                                                                                                            nonere = isNaN(nonere) ? 0 : nonere;

                                                                                                                            var amount_unit = parseFloat($('#Amount_Unit<?= $idx ?>').val());
                                                                                                                            var amount = parseFloat($('#Number_Product<?= $idx ?>').val());
                                                                                                                            var cost = parseFloat($('#Cost_Price<?= $idx ?>').val());
                                                                                                                            var total = $('#Total_PriceHide<?= $idx ?>').val();
                                                                                                                            total = total.replace(",", "");
                                                                                                                            var total_banlance = parseFloat(total);

                                                                                                                            console.log(total_banlance);
                                                                                                                            if (amount <= nonere) {
                                                                                                                                $('#No_Receive<?= $idx ?>').val(nonere - amount);
                                                                                                                                $('#Total_Price<?= $idx ?>').val((amount * amount_unit * cost) + total_banlance);
                                                                                                                                $('#Total_Price<?= $idx ?>').number(true, 2);
                                                                                                                            } else {
                                                                                                                                alert("กรุณากรอกจำนวนที่รับน้อยกว่าหรือเท่ากับ " + nonere);
                                                                                                                                $('#Number_Product<?= $idx ?>').val("");
                                                                                                                            }
                                                                                                                        });
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
                                                                                                        $("#<?= $row['ID_Receivedetail'] ?>").click(function () {
                                                                                                            $('#add').hide();
                                                                                                            $('#receiveId').text("<?= $row['ID_Receivedetail'] ?>");
                                                                                                            ID_Receivedetail.value = "<?= $row['ID_Receivedetail'] ?>";

                                                                                                            document.getElementById("ID_Product")[0].text = "<?= $row['Product_Name'] ?>";

                                                                                                            document.getElementById("Amount_Product")[0].value = "<?= $row['Amount_Product'] ?>";

                                                                                                            document.getElementById("Amount_Receive")[0].text = "<?= $row['Amount_Receive'] ?>";

                                                                                                            document.getElementById("Amount_NonRe")[0].value = "<?= $row['Amount_NonRe'] ?>";

                                                                                                            document.getElementById("ID_Count")[0].text = "<?= $row['Name_Count'] ?>";

                                                                                                            document.getElementById("Cost_Price")[0].value = "<?= $row['Cost_Price'] ?>";

                                                                                                            document.getElementById("Amount_balance")[0].value = "<?= $row['Amount_balance'] ?>";


                                                                                                        });
                                                                                                    </script>
                                                                                                    </tr>
                                                                                                        <?php }
                                                                                                    } ?>

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
                                                                        <td><?php echo $row_receive['FName_Emp']; ?></td>
                                                                        <td><?php echo $row_receive['Name_Company']; ?></td>
                                                                        <td><?php echo reverseDate($row_receive['Date_Receive']); ?></td>
                                                                    </tr>
                                                                <script type="text/javascript">
                                                                    $("#<?= $row_receive['ID_Receive'] ?>").click(function () {
                                                                        $('#add').hide();
                                                                        $('#receiveId').text("<?= $row_receive['ID_Receive'] ?>");
                                                                        ID_Receive.value = "<?= $row_receive['ID_Receive'] ?>";
                                                                        document.getElementById("ID_Emp")[0].text = "<?= $row_receive['FName_Emp'] ?>";
                                                                        document.getElementById("ID_Emp")[0].value = "<?= $row_receive['ID_Emp'] ?>";
                                                                        document.getElementById("ID_Company")[0].text = "<?= $row_receive['Name_Company'] ?>";
                                                                        document.getElementById("ID_Company")[0].value = "<?= $row_receive['ID_Company'] ?>";
                                                                        datetimepicker1.value = "<?= $row_receive['Date_Receive'] ?>";
                                                                    });
                                                                </script> 
                                                                <?php //}
                                                            } 
                                                        }
                                                        ?>
                                                        </tbody>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                            <!-- pagination -->
                                            <table style="float: right;">
                                            <tr>
                                              <td><span>Total <?php echo $Num_Rows;?> Record : <?php echo $Num_Pages;?> Pages</span></td>
                                              <td>
                                                  <ul class="pagination" style="margin: 0px;">  
                                                <?php
                                                if($Prev_Page){
                                                  echo '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?page='.$Prev_Page.'"><span>«Back</span></a></li>';
                                                }
                                                $endlimit = (($start+$limit) <= $Num_Pages) ? ($start+$limit) : $Num_Pages;
                                                $end = ($Num_Pages == 1) ? 1 :$endlimit;
                                                for($i = $start; $i <= $end; $i++){
                                                  if($i != $Page){
                                                    echo "<li><a href='$_SERVER[SCRIPT_NAME]?page=$i'>$i</a></li>";
                                                  }else{
                                                    echo "<li class='active'><a href='$_SERVER[SCRIPT_NAME]?page=$i'>$i</a></li>";
                                                  }
                                                } 
                                                if($Page!=$Num_Pages){
                                                  echo "<li><a href='".$_SERVER['SCRIPT_NAME']."?page=".$Next_Page."'><span>Next»</span></a></li>";
                                                } 
                                                ?>
                                                </ul>
                                              </td>
                                            </tr>
                                          </table> 
                                    </div> 
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div> 
                <script type="text/javascript">
                    $('#ID_Order').change(function () {
                        var receiveId = $('#ID_Order').val();
                        var json = {
                            'ID_Order': receiveId,
                            'status': '<?php echo!empty($_SESSION['ID_Status']) ? $_SESSION['ID_Status'] : ""; ?>'
                        };

                        $.post("./receive.controller.php", json, function (data, status) {
                            var orders = JSON.parse(data);
                            if (orders)
                                $('#ID_Company option[value=' + (orders.ID_Company) + ']').attr('selected', 'selected');
                        });

                        var notfound = '<tr><td colspan="8"><center><h2 style="color: rgb(237, 45, 45);">ไม่พบรายการที่ท่านเลือก!</h2></center></td></tr>';

                        $.post("./getorder.php", json, function (data, status) {
                            var orderdetail = JSON.parse(data);
                            if (orderdetail.length == 0) {
                                document.getElementById('tbodydetail').innerHTML = "";
                                $('#tbodydetail').append(notfound);
                            }

                            var Orderdetail, Product, AmountProduct, NumberProduct, NoReceive, Count, TotalPrice, CostPrice, templete, script;
                            for (var i = 0; i < orderdetail.length; i++) {
                                // remove tag
                                if (i == 0)
                                    document.getElementById('tbodydetail').innerHTML = "";
                                Orderdetail = '<input type="text" name="ID_Orderdetail[]" value="' + orderdetail[i].ID_Orderdetail + '" class="form-control" readonly>';
                                Product = '<input type="hidden" id="ID_Product" name="ID_Product[]" value="' + orderdetail[i].ID_Product + '"><input name="Product_Name[]" id="Product_Name" value="' + orderdetail[i].Product_Name + '" maxlength="5" class="form-control" readonly>';
                                AmountProduct = '<input style="text-align: right;" type="text" name="Amount_Product[]" id="Amount_Product' + i + '" placeholder="จำนวนที่สั่ง" maxlength="10" class="form-control" required="" value="' + orderdetail[i].Amount_Product + '" readonly>';
                                NumberProduct = '<input style="text-align: right;" type="text" name="Number_Product[]" id="Number_Product' + i + '" placeholder="จำนวนที่รับ" maxlength="10" class="form-control" required="" value="">';
                                NoReceive = '<input style="text-align: right;" type="text" name="No_Receive[]" id="No_Receive' + i + '" placeholder="จำนวนค้างรับ" maxlength="10" class="form-control" required="" value="0" readonly>';
                                Count = '<input type="hidden" name="ID_Count[]" id="ID_Count" value ="' + orderdetail[i].ID_Count + '"><input name="Name_Count[]" id="Name_Count" required="" placeholder="รหัสสินค้า" maxlength="4" value="' + orderdetail[i].Name_Count + '" class="form-control" required="" readonly>';
                                CostPrice = '<input style="text-align: right;" type="text" name="Cost_Price[]" id="Cost_Price' + i + '" required="" placeholder="ราคาทุน" maxlength="10" class="form-control" required="" value="' + orderdetail[i].Cost_Price + '" readonly>';
                                TotalPrice = '<input style="text-align: right;" type="text" name="Total_Price[]" id="Total_Price' + i + '" placeholder="ราคารวม" maxlength="20" class="form-control" required="" value="0" readonly>';

                                templete = '<tr><td>' + Orderdetail + '</td><td>' + Product + '</td><td>' + AmountProduct + '</td><td>' + NumberProduct + '</td><td>' + NoReceive + '</td><td>' + Count + '</td><td>' + CostPrice + '</td><td>' + TotalPrice + '</td></tr>';

                                // script = '<script>$("#Number_Product' + i + '").number(true,0); $("#Number_Product' + i + '").blur(function() {var number = parseInt($("#Number_Product' + i + '").val());var amount = parseInt(' + orderdetail[i].Amount_Product + ');if(number!=""&&number!=undefined&&amount>=number){$("#Total_Price' + i + '").val(number*parseFloat(' + orderdetail[i].Cost_Price + '));$("#No_Receive' + i + '").val(amount-number);$("#Total_Price' + i + '").number(true,2);}else if(amount<number){alert("กรุณากรอกให้น้อยกว่าหรือเท่ากับจำนวนที่สั่ง");$("#Number_Product' + i + '").val("")} else {$("#Total_Price' + i + '").val(0);$("#No_Receive' + i + '").val(0);}});<\/script>';
                                script = '<script>$("#Number_Product' + i + '").val(0);$("#Number_Product' + i + '").number(true,0); $("#Number_Product' + i + '").blur(function() {var number = parseInt($("#Number_Product' + i + '").val());var amount = parseInt(' + orderdetail[i].Amount_Product + ');if(number!=""&&number!=undefined&&amount>=number){$("#Total_Price' + i + '").val(number*parseFloat(' + orderdetail[i].Cost_Price + '));$("#No_Receive' + i + '").val(amount-number);$("#Total_Price' + i + '").number(true,2);}else if(amount<number){alert("กรุณากรอกให้น้อยกว่าหรือเท่ากับจำนวนที่สั่ง");$("#Number_Product' + i + '").val("")} else {$("#Total_Price' + i + '").val(0);$("#No_Receive' + i + '").val(0);} if(amount>=number && number == 0){$("#No_Receive' + i + '").val(amount);} });<\/script>';

                                $('#tbodydetail').append(templete + script);
                            }
                        });
                    });
                </script>
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