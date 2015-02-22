<?php
session_start();
include("../connect/connect.php");

if (empty($_SESSION['Username'])) {
    if (empty($_SESSION['Username']) || empty($_SESSION['status']) || empty($_SESSION['name'])) {
        echo alert('กรุณาเข้าสู่ระบบ Admin ก่อน');
        echo location("../login.php");
    }
}else{

if (!empty($_POST['Button'])) {
    $button = $_POST['Button'];
    //$Flag = true;

    if ($button == 'เพิ่มข้อมูล') {
        $strCount = "SELECT * FROM Company ORDER BY ID_Company DESC LIMIT 1";
        $objQueryCount = mysql_query($strCount);
        $Count_prefix = mysql_fetch_array($objQueryCount);
        $NUMCount = substr($Count_prefix["ID_Company"], -1);
        $nextNum = $NUMCount + 1;
        $Prefix_num = substr($Count_prefix["ID_Company"], 0, 3);

        $strEmp_ID = "" . ($Prefix_num . "" . $nextNum);
        $sql = "INSERT INTO Company (ID_Company, Name_Company,Tel,Address) VALUES ('" . $_POST["ID_Company"] . "', '" . $_POST["Name_Company"] . "','" . $_POST["Tel"] . "','" . $_POST["Address"] . "')";
        $Flag = mysql_query($sql); 
        echo $Flag ? alert('เพิ่มข้อมูลสำเร็จ') : alert('เพิ่มข้อมูลไม่สำเร็จ');
    } elseif ($button == 'แก้ไขข้อมูล') {
        $sql = "UPDATE Company SET Name_Company = '" . $_POST["Name_Company"] . "',Tel='" . $_POST["Tel"] . "',Address='" . $_POST["Address"] . "' WHERE ID_Company = '" . $_POST["ID_Company"] . "'";
        $Flag = mysql_query($sql);
        echo $Flag ? alert('แก้ไขข้อมูลสำเร็จ') : alert('แก้ไขข้อมูลไม่สำเร็จ');
    } else {
        $sql = "DELETE FROM Company WHERE ID_Company = '" . $_POST["ID_Company"] . "'";
        $Flag = mysql_query($sql);
        echo $Flag ? alert('ลบข้อมูลสำเร็จ') : alert('ลบข้อมูลไม่สำเร็จ');
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
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="./base.php">ข้อมูลบริษัทคู่ค้า</a></li>
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
                            <div class="padded">
                                <div class="col-md-12">
                                    <?php
                                    $lastsql = "SELECT ID_Company From Company order by cast(substr(ID_Company,3) AS UNSIGNED) DESC LIMIT 1";
                                    $result = mysql_query($lastsql);
                                    $OldId = mysql_fetch_assoc($result);
                                    $NewId = generateIDbyFix($OldId['ID_Company'], 2, "CP");
                                    ?>
                                    <form name="form1" method="post" action="">
                                        <center>
                                            <label style="margin-left: -155px;padding-top: 5px;">รหัสบริษัทคู่ค้า</label>
                                            <br>
                                            <input readonly"" style="background: #C0F9BD;width: 70%;" type="text" class="form-control" name="ID_Company" id="ID_Company" required placeholder="รหัสบริษัทคู่ค้า" value="<?php echo $NewId; ?>" maxlength="5" > 
                                            <label style="margin-left: -194px;padding-top: 5px;">ชื่อบริษัท</label><font color="red">*</font>
                                            <br>
                                            <input style="background: #C0F9BD;width: 70%;" type="text" class="form-control" name="Name_Company" id="Name_Company" required placeholder="ชื่อบริษัท" value="" > 
                                            <label style="margin-left: -155px;padding-top: 5px;">เบอร์โทรศัพท์</label><font color="red">*</font>
                                            <br>
                                            <input style="background: #C0F9BD;width: 70%;" type="tel" maxlength="10" class="form-control" name="Tel" id="Tel" required placeholder="เบอร์โทรศัพท์" value="" onKeyUp="if(this.value*1!=this.value) this.value='' ;"> 
                                            <label style="margin-left: -222px;padding-top: 5px;">ที่อยู่</label><font color="red">*</font>
                                            <br>
                                            <textarea style="background: #C0F9BD;width: 70%;" rows="3" cols="5" class="form-control" name="Address" id="Address" required placeholder="ที่อยู่" value="" > </textarea>
                                            <br> 
                                            <input onclick="return checkCompany();" id="add" type="submit" class="btn btn-primary" name="Button" value="เพิ่มข้อมูล">
                                            <input id="update"type="submit" class="btn btn-warning" name="Button" value="แก้ไขข้อมูล">
                                            <input onclick="return checkIDCompany()" id="delete"type="submit" class="btn btn-danger" name="Button" value="ลบข้อมูล">
                                            <input id="cancle" type="reset" class="btn btn-default" name="Button" value="ยกเลิก">
                                        </center> 
                                    </form>
                                    <script type="text/javascript"> 
                                        $('#cancle').click(function () {
                                            $('#add').show();
                                        });

                                        function checkNull(){  //ชื่อ function ตั้งได้ตามความสดวกของเราได้เลยครับ
                                          var forms=document.form1;  //ผมสร้างตัวแปรมาเพื่ออ้างถึง form ครับ
                                          if(forms1.ID_Company.value == "" || forms.Name_Company.value == "" || forms.Tel.value == "" || forms.Address.value == ""){ //เช็ค if ใน textfile ที่กำหนด ตรง .value == "" คือถ้าเป็นค่า null ก็ให้ทำงานภายใน if นี้.
                                             alert('กรุณาเติมข้อมูลให้ครบ');  //สั่งให้ขึ้นข้อความที่ต้องการ
                                             forms.textfile1.focus();  //เพิ่มความฉลาดให้โปรแกรมโดยการให้ cursor วิ่งไปในช่องที่ว่างอยู่  
                                             return false;  //return false เป็นการไม่ให้โปรแกรมหรือหน้าเว็บเราทำงานต่อ
                                          }
}

                                        // check ซ้ำ
                                        var result = false;
                                        $('#Name_Company').change(function () {
                                            var Name_Company = $('#Name_Company').val();
                                            var json = {'Name_Company': Name_Company};
                                            $.post("./company.service.php", json).done(function (data) {
                                                var company = JSON.parse(data);
                                                if (company.ID_Company > 0) {
                                                    result = false;
                                                } else {
                                                    result = true;
                                                }
                                            });
                                        });
                                        function checkCompany() {
                                            if (!result) {
                                                $('#Name_Company').val("");
                                                alert("ชื่อบริษัทนี้ได้มีการเพิ่มข้อมูลเข้าไปในระบบแล้ว");
                                            }
                                            return result;
                                        }

                                        // check ข้อมูลที่ใช้อยู่
                                        var useResult = false;
                                        function checkIDCompany() {
                                            if (!useResult)
                                                alert("บริษัทนี้ถูกใช้อยู่ไม่สามารถลบได้");
                                            return useResult;
                                        }
                                    </script>
                                </div>  
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-md-12"> 
                                <?php
                                $sql = "SELECT * FROM Company ";
                                $query = mysql_query($sql);
                                ?>
                                <div class="bs-example">
                                    <div class="panel panel-default"> 
                                        <div class="panel-heading"><h4>ข้อมูลบริษัทคู่ค้า</h4></div>  
                                        <div class="mygrid-wrapper-div">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>รหัส</th>
                                                        <th>ชื่อบริษัทคู่ค้า</th>
                                                        <th>เบอร์โทรศัพท์</th>
                                                        <th>ที่อยู่</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row_prefix = mysql_fetch_assoc($query)) { ?>
                                                        <tr>
                                                            <td>
                                                                <a id="<?= $row_prefix['ID_Company'] ?>" class="point">
                                                                    <?php echo $row_prefix['ID_Company']; ?>
                                                                </a>
                                                            </td>
                                                            <td><?php echo $row_prefix['Name_Company']; ?></td>
                                                            <td><?php echo $row_prefix['Tel']; ?></td>
                                                            <td><?php echo $row_prefix['Address']; ?></td>
                                                        </tr>
                                                    <script type="text/javascript">
                                                        $("#<?= $row_prefix['ID_Company'] ?>").click(function () {
                                                            $('#add').hide();
                                                            ID_Company.value = "<?= $row_prefix['ID_Company'] ?>";
                                                            Name_Company.value = "<?= $row_prefix['Name_Company'] ?>";
                                                            Tel.value = "<?= $row_prefix['Tel'] ?>";
                                                            Address.value = "<?= $row_prefix['Address'] ?>";

                                                            var json = {'ID_Company': "<?= $row_prefix['ID_Company'] ?>", 'table': 'product'};
                                                            $.post("./company.service.php", json).done(function (data) {
                                                                var company = JSON.parse(data);
                                                                var json2 = {'ID_Company': "<?= $row_prefix['ID_Company'] ?>", 'table': 'orders'};
                                                                $.post("./company.service.php", json2).done(function (data) {
                                                                    var orders = JSON.parse(data);
                                                                    var json3 = {'ID_Company': "<?= $row_prefix['ID_Company'] ?>", 'table': 'receive'};
                                                                    $.post("./company.service.php", json3).done(function (data) {
                                                                        var receive = JSON.parse(data);
                                                                        if (company.ID_Company > 0 || orders.ID_Company > 0 || receive.ID_Company > 0) {
                                                                            useResult = false;
                                                                        } else {
                                                                            useResult = true;
                                                                        }
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
            </div>
        </article>
        <footer>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#company').addClass('active');
                });
            </script>
            <?php include("../fragments/footer.php"); ?>
        </footer>
    </body>
</html>
<?php } ?>