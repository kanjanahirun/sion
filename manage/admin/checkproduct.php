<?php
session_start();
include("../connect/connect.php");

if (empty($_SESSION['Username'])) {
    if (empty($_SESSION['Username']) || empty($_SESSION['status']) || empty($_SESSION['name'])) {
        echo alert('กรุณาเข้าสู่ระบบ Admin ก่อน');
        echo location("../login.php");
    }
} else {
    

    ?>
    <!DOCTYPE html>
    <html lang="th">
        <head>
            <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
            <script type="text/javascript" src="../assets/js/bootstrap.js"></script>
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
                               
                            
                                
                               <div class="product">
                                    <div class="row">
                                        <div class="padform">
                                            <form action="./checkproduct.php" method="get">
                                            <table class="table">
                                                            <tr>
                                                                <td style="border: none;width: 15%;">
                                                                    <!-- <h3>ค้นหาข้อมูลสินค้า</h3> -->
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
                                                            <td><?php echo $row_product['ID_Product']; ?></td>
                                                            <td><?php echo $row_product['Product_Name']; ?></td>
                                                            <td><span style="float: right;" id="middle"><?php echo number_format(str_replace(",", "", $row_product['Amount_Product'])); ?></span></td>
                                                            <td><span id="center"><?php echo $row_product['Name_Count']; ?></span></td>
                                                            <td><span style="float: right;" id="middle"><?php echo number_format(str_replace(",", "", $row_product['Cost_Price']), 2); ?></span></td>
                                                            <td><span style="float: right;" id="middle"><?php echo number_format(str_replace(",", "", $row_product['Sale_Price']), 2); ?></span></td>
                                                            <td align = "center"><span style="float: right;" id=""><?php echo number_format(str_replace(",", "", $row_product['Point_Purchase'])); ?></span></td>
                                                            <td><span id="middle"><?php echo $row_product['Name_Company']; ?></span></td>
                                                        </tr>
                                                   
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

            <?php if (!empty($_GET['q'])) { ?>
                                            <?php
                                            $sql = "SELECT * FROM product p INNER JOIN count c INNER JOIN company cm ON p.ID_Count = c.ID_Count AND p.ID_Company=cm.ID_Company WHERE p.ID_Product LIKE '" . $_GET['q'] . "' OR p.Product_Name LIKE '%" . $_GET['q'] . "%' OR cm.Name_Company LIKE '%" . $_GET['q'] . "%' ORDER BY p.ID_Product ASC ";
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
                                                                <div class="mygrid-wrapper-div"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

        </body>
    </html>
<?php } ?>