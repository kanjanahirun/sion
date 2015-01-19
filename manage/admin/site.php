<?php
session_start();
include("../connect/connect.php");

if (empty($_SESSION['Username'])) {
    if (empty($_SESSION['Username']) || empty($_SESSION['status']) || empty($_SESSION['name'])) {
        echo alert('กรุณาเข้าสู่ระบบ Admin ก่อน');
        echo location("../login.php");
    }
}else{
    if($_SESSION['ID_Status'] == "s002"){
        echo location("./addorder.php");
    }else{
        
    
        // Coding...
        
    
    
?>
<!DOCTYP html>
<html>
    <head>
        <title> ร้านศรีอ้น แฮร์ & สปาร์ </title> 
        <?php include("../fragments/libmanage.php"); ?> 
        <style>
            td{
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
                                <li role="presentation" class="dropdown active">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                        จัดการข้อมูลหน้าเว็บ <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Hair</a></li>
                                        <li><a href="#">Makeup</a></li>
                                        <li><a href="#">Spa</a></li> 
                                        <li><a href="#">Map</a></li>
                                    </ul>
                                </li>
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
                                <div style="margin-left: 3em;">
                                    <h2>Hair</h2> 
                                    <form action="" method="post"> 
                                        <table>
                                            <tr>
                                                <td>
                                                    <h4>เลือกรูปภาพ</h4>
                                                </td>
                                                <td>
                                                    <input type="file" name="file">
                                                </td>
                                                <td>
                                                    <input type="submit" name="upload" class="btn btn-primary" value="อัพโหลดรูปภาพ">
                                                </td>
                                            </tr>
                                        </table>
                                    </form> 
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        
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
                    $('#manageSite').addClass('active');
                });
            </script>
            <?php include("../fragments/footer.php"); ?>
        </footer>
    </body>
</html>
<?php }} ?>