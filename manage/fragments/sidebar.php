<div class="list-group">
     
    <?php
    if (!empty($_SESSION['ID_Status'])) {
         if ($_SESSION['ID_Status'] == "s001") {
            echo '<a id="base" href="./base.php" class="list-group-item">ข้อมูลพื้นฐาน</a>';
            // echo '<a id="admin" href="./admin.php" class="list-group-item">ข้อมูลผู้ดูแลระบบ</a>';
            echo '<a id="employee" href="./employee.php" class="list-group-item">ข้อมูลพนักงาน</a>';
            echo '<a id="customer" href="./customer.php" class="list-group-item">ข้อมูลสมาชิก</a>';
            echo '<a id="product" href="./product.php" class="list-group-item">ข้อมูลสินค้า</a>';
            echo '<a id="company" href="./company.php" class="list-group-item">ข้อมูลบริษัทคู่ค้า</a>';
            echo '<a id="service" href="./service.php" class="list-group-item">ข้อมูลการให้บริการ</a>';
            echo '<a id="promotionsale" href="./promotionsale.php" class="list-group-item">ข้อมูลโปรโมชัน</a>';
            echo '<a id="report" href="./report.php" class="list-group-item">การออกรายงาน</a>';
            echo '<a id="manageSite" href="./site.php" class="list-group-item">จัดการข้อมูลหน้าเว็บ</a>';

         }
         else  {
            echo '<a id="order" href="./addorder.php" class="list-group-item">ข้อมูลการสั่งสินค้า</a>';
            echo '<a id="receive" href="./receive_receivedetail.php" class="list-group-item">ข้อมูลการรับสินค้า</a>';
            echo '<a id="load" href="./load.php" class="list-group-item">ข้อมูลการเบิกสินค้า</a>';
            echo '<a id="sale" href="./sale.php" class="list-group-item">ข้อมูลการขาย</a>';
            echo '<a id="que" href="./que.php" class="list-group-item">ข้อมูลการจองคิว</a>';
            echo '<a id="listservice" href="./listservice.php" class="list-group-item">ข้อมูลรายการให้บริการ</a> ';
         }
     }
    ?>

    <!-- <a id="order" href="./order_orderdetail.php" class="list-group-item">ข้อมูลการสั่งสินค้า</a> -->
    
    


        <!-- <a id="order" class="point list-group-item">ข้อมูลการสั่งสินค้า <i style="float: right;" class="glyphicon glyphicon-chevron-down"></i></a>
        <div id="sub1" class="submenu">
                <a id="orderlist" href="./order.php" class="list-group-item"><i class="glyphicon glyphicon-chevron-right"></i> การสั่งสินค้า</a>
                <a id="orderdetail" href="./orderdetail.php" class="list-group-item"><i class="glyphicon glyphicon-chevron-right"></i> รายละเอียด</a>
        </div>

        <a id="receive" class="point list-group-item">ข้อมูลการรับสินค้า <i style="float: right;" class="glyphicon glyphicon-chevron-down"></i></a>
        <div id="sub2" class="submenu">
                <a id="receivelist" href="./receive.php" class="list-group-item"><i class="glyphicon glyphicon-chevron-right"></i> การรับสินค้า</a>
                <a id="receivedetail" href="./receivedetail.php" class="list-group-item"><i class="glyphicon glyphicon-chevron-right"></i> รายละเอียด</a>
        </div> -->

    
    <!--<a id="logout" href="../logout.php" class="list-group-item">ออกจากระบบ</a>--> 
</div> 

<script type="text/javascript">
    $('#sub1').hide();
    $('#order').click(function () {
        $('#sub1').toggle();
    });

    $('#sub2').hide();
    $('#receive').click(function () {
        $('#sub2').toggle();
    });
</script>


