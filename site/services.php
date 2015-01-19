<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Service</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/reset.css" type="text/css" media="screen">
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
        <link rel="stylesheet" href="css/grid.css" type="text/css" media="screen"> 
        <script src="js/jquery-1.6.3.min.js" type="text/javascript"></script>
        <script src="js/cufon-yui.js" type="text/javascript"></script>
        <script src="js/cufon-replace.js" type="text/javascript"></script>
        <script src="js/PT_Sans_400.font.js" type="text/javascript"></script>
        <script src="js/PT_Sans_italic_400.font.js" type="text/javascript"></script> 
        <script src="js/Satisfy_400.font.js" type="text/javascript"></script>
        <script src="js/NewsGoth_400.font.js" type="text/javascript"></script>
        <script src="js/FF-cash.js" type="text/javascript"></script> 
        <script src="js/script.js" type="text/javascript"></script>	 
        <script src="js/easyTooltip.js" type="text/javascript"></script>
        <style>
            /* Custom Style */
            #ul{
                padding: 20px;
                text-align: center;
            }
            #li {
                padding: 20px 6% 14px;
                display: inline;
                font-family: cursive;
                font-size: 20px; 
            }  
            #li:hover{
                border-bottom: 4px solid rgb(89, 95, 98);
                cursor: pointer;
            }
            .activex{
                border-bottom: 4px solid orange;
            }
            .menu { 
                width: 60px;
                text-decoration: none;
            } 
        </style>
    </head>
    <body id="page4">
        <div class="extra"> 
            <header> 
                <div class="header-row"><div class="ic"></div>
                    <div class="main">
                        <h1 class="margin-bot">
                            <a href="./index.php">Sion</a>
                            <em>Keep Your Perfect Look</em>
                            <?php
                            if (empty($_SESSION['Username'])) {
                                echo '<em id="login" style="float:right;cursor: pointer;color: #15B715;">Login</em>';
                                // echo '<em id="signup" style="float:right;cursor: pointer;margin-right: 1em;color: white;">Sign up</em>';
                            } else {
                                echo '<em id="logout" style="float:right;cursor: pointer;">Logout</em>';
                                echo '<em id="username" style="float:right;color:orange;cursor: pointer;margin-right: 1em;">' . $_SESSION['Username'] . '</em>';
                            }
                            ?>  
                        </h1>
                        <div class="menux"> 
                            <ul id="ul"> 
                                <li id="li"><a class="menu" href="./">Home</a></li>
                                <li id="li"><a class="menu" href="./gallery.php">Gallery</a></li>
                                <li id="li" class="activex"><a class="menu" href="./services.php">Services</a></li>
                                <li id="li"><a class="menu" href="./contacts.php">Contacts</a></li> 
                                <!-- <li id="li"><a class="menu" href="./about.php">About</a></li>  -->
                            </ul> 
                        </div>
                        <script type="text/javascript">
                            $('#login').click(function () { $(location).attr('href', '.././manage/login.php'); });
                            // $('#signup').click(function () { $(location).attr('href', './signup.php'); });
                            $('#logout').click(function () { $(location).attr('href', '.././manage/logout.php'); });
                            $('#username').click(function () { $(location).attr('href', './profile.php'); });
                        </script>
                        <div class="container_12">
                            <div class="wrapper">
                                <article class="grid_3">
                                    <h4>Hair</h4>
                                    <p class="img-indent-bot">บริการเกี่ยวกับผม ที่ทางร้านได้ให้บริการกับลูกค้า ที่หลากหลาย ทั้งทำสี ตัด สปา และอื่นๆ ที่เกี่ยวกับผม และยังมีผลิตภัณฑ์เกี่ยวกับผมให้เลือกชมกันได้</p>
                                </article>
                                <article class="grid_3">
                                    <div class="indent-left">
                                        <h4>Makeup</h4>
                                        <p class="img-indent-bot">ทางร้านได้มีบริการเกี่ยวกับการแต่งหน้าเพื่อเข้างานต่างๆ และสินค้าเกี่ยวกับการแต่งหน้า</p>
                                    </div>
                                </article>
                                <article class="grid_3">
                                    <div class="indent-left">
                                        <h4>Spa</h4>
                                        <p class="img-indent-bot">บริการทางด้านสปา ซึ่งมีการทำสปาเกี่ยวกับใบหน้า และผลิตภัณฑ์เกี่ยวกับสปา</p>
                                    </div>
                                </article>
                            </div>
                        </div>					
                    </div>
                </div>
            </header>

            <!--==============================content================================-->
            <section id="content">
                <div class="main">
                    <div class="container_12">
                        <div class="wrapper">
                            <article class="grid_8">
                                <h3>About Our Services</h3>
                                <div class="wrapper p2">
                                    <figure class="img-indent img-border"><img src="images/sion.png" alt="" /></figure>
                                    <div class="extra-wrap">
                                        <h6>การให้บริการภายในร้าน ศรีอ้นแฮร์แอนด์สปา</h6>
                                        ทางร้านได้ให้บริการกับลูกค้าทั้งชายและหญิง ทั้งในด้านเกี่ยวกับผม หรือการแต่งหน้า และยังมีการทำสปาใบหน้าอีกด้วย ซึ่งมีบริการให้ลูกค้าได้เลือกหลากหลาย และยังมีสินค้าที่ทางร้านได้ใช้กับลูกค้าขาย สำหรับลูกค้าที่ต้องการนำกลับไปใช้ต่อ
                                    </div>
                                </div>
                            </article>
                            <article class="grid_4">
                                <div class="indent-left2">
                                    <h3>Services List</h3>
                                    <ul class="list-2 img-indent-bot">
                                        <li>ตัดผม ชาย-หญิง</li>
                                        <li>สระ ซอย ไดร์</li>
                                        <li>ทำสีผม</li>
                                        <li>แต่งหน้า</li>
                                        <li>สปาผม</li>
                                        <li>สปาหน้า</li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
                <div class="block"></div>
            </section>
        </div>

        <!--==============================footer=================================-->
        <?php include './footer.php'; ?>
        <script type="text/javascript"> Cufon.now();</script>
    </body>
</html>
