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
        if ($button == 'เพิ่มข้อมูล') {

            $strCount = "SELECT * FROM orders ORDER BY ID_Order DESC LIMIT 1";
            $objQueryCount = mysql_query($strCount);
            $Count_prefix = mysql_fetch_array($objQueryCount);
            $NUMCount = substr($Count_prefix["ID_Order"], -1);
            $nextNum = $NUMCount + 1;
            $Prefix_num = substr($Count_prefix["ID_Order"], 0, 3);
            $strEmp_ID = "" . ($Prefix_num . "" . $nextNum);
            $date = format_date($_POST["Date_Order"]);

            $sql = "INSERT INTO orders VALUES ('" . $_POST["ID_Order"] . "', '" . $date . "', '" . $_POST["ID_Emp"] . "', '" . $_POST["ID_Company"] . "')";

            $Flag = mysql_query($sql);
            if ($Flag) {
                echo alert('เพิ่มข้อมูลสำเร็จ');
            } else {
                echo alert('เพิ่มข้อมูลผิดพลาด');
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
    <html>
        <head>
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
                        <div class="col-md-2">
                            <?php include("../fragments/sidebar.php"); ?>
                        </div>
                        <div class="col-md-10">
                            <div class="col-md-12">
                                <div>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="active" style="width: 17%;">
                                            <a href="./order.php">
                                                จัดการข้อมูลการสั่งสินค้า 
                                            </a>
                                        </li> 
                                    </ul>
                                </div> 
                                <div class="orderdetail.php">
                                    <div class="row">
                                        <div>
                                            <div style="float: right;margin: 18px;margin-right: 30px;">
                                                <a class="btn btn-primary" href="./addorder.php">
                                                    <i class="glyphicon glyphicon-plus"></i> เพิ่มใบสั่งซื้อ
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-12">

                                                <?php
                                                $sql = "SELECT * FROM employees e, orders o ,company c WHERE e.ID_Emp = o.ID_Emp AND o.ID_Company = c.ID_Company ORDER BY ID_Order ASC";
                                                $query = mysql_query($sql);
                                                ?> 
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
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    <?php
                                                                     $sql = "SELECT * FROM `orders` ORDER BY ID_Order";
                                                                    $query = mysql_query($sql);
                                                                    $inx = 0;
                                                                    ?>
                                                                    <?php while ($order = mysql_fetch_assoc($query)) { ?>
                                                                        <?php
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
            <!--                                                            <td>
                                                                                <input type="hidden" id="ID_Order" name="ID_Order" value="">
                                                                                <a id="<?php //echo $row_order['ID_Order'];   ?>" class="point"><?php //echo $row_order['ID_Order'];  ?></a>
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
                                                                                                <th>จำนวนสินค้า</th>
                                                                                                <th>ราคารวม</th>
                                                                                                <th>สถานะ</th> 
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <?php while ($orderDetail = mysql_fetch_array($result)) { ?>
                                                                                                        <tr> 
                                                                                                            <td>
                                                                                                                <?php echo $orderDetail['ID_Order']; ?>
                                                                                                            </td> 
                                                                                                            <td>
                                                                                                                <a id="<?php echo $orderDetail['ID_Orderdetail']; ?>" class="point"><?php echo $orderDetail['ID_Orderdetail']; ?></a>
                                                                                                            </td>   
                                                                                                            <td><?php echo $orderDetail['Product_Name']; ?></td>  
                                                                                                            <td><?php echo $orderDetail['ODAmount_Product']; ?></td>  
                                                                                                            <td><?php echo $orderDetail['Total_Price']; ?></td> 
                                                                                                            <td> 
                                                                                                                <?php
                                                                                                                if ($orderDetail['RID_Order'] != NULL) {
                                                                                                                    echo '<span class="label label-success">รับสินค้าเรียบร้อย</span>';
                                                                                                                } else {
                                                                                                                    echo '<span class="label label-danger">ยังไม่ได้รับสินค้า</span>';
                                                                                                                }
                                                                                                                ?> 
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
                                                                                <a href="#" class="btn btn-warning" title="แก้ไขข้อมูล">
                                                                                    <i class="glyphicon glyphicon-pencil"></i> 
                                                                                </a>
                                                                                <a href="#" class="btn btn-danger" title="ลบข้อมูล">
                                                                                    <i class="glyphicon glyphicon-remove"></i> 
                                                                                </a>
                                                                            </td>
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