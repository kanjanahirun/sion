<?php session_start(); ?>
<html lang="th">
    <head>
        <title>Welcome to SiOn Salon</title> 
        <meta charset="utf-8"> 
        <link rel="stylesheet" href="css/reset.css" type="text/css" media="screen">
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
        <link rel="stylesheet" href="css/grid.css" type="text/css" media="screen"> 
        <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>  
        <script src="js/jquery-1.6.3.min.js" type="text/javascript"></script>
        <script src="js/cufon-yui.js" type="text/javascript"></script>
        <script src="js/cufon-replace.js" type="text/javascript"></script>
        <script src="js/PT_Sans_400.font.js" type="text/javascript"></script>
        <script src="js/PT_Sans_italic_400.font.js" type="text/javascript"></script> 
        <script src="js/Satisfy_400.font.js" type="text/javascript"></script>
        <script src="js/NewsGoth_400.font.js" type="text/javascript"></script>
        <script src="js/FF-cash.js" type="text/javascript"></script> 
        <script src="js/script.js" type="text/javascript"></script>  
        <script src="js/tms-0.3.js" type="text/javascript"></script>
        <script src="js/tms_presets.js" type="text/javascript"></script>
        <script src="js/jquery.easing.1.3.js" type="text/javascript"></script>	 
        <script src="js/easyTooltip.js" type="text/javascript"></script> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
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
    <body id="page1"> 
        <article>
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
                                <li id="li" class="activex"><a class="menu" href="./">Home</a></li>
                                <li id="li"><a class="menu" href="./gallery.php">Gallery</a></li>
                                <li id="li"><a class="menu" href="./services.php">Services</a></li>
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
                            <div class="slider-wrapper" style="background: #171616;">
                                <div class="slider">
                                    <ul class="items">
                                        <li>
                                            <img src="images/hair.jpg" alt="" />
                                        </li>
                                        <li>
                                            <img src="images/makeup.jpg" alt="" />
                                        </li>
                                        <li>
                                            <img src="images/spa.jpg" alt="" />
                                        </li>
                                        <li>
                                            <img src="images/map.jpg" alt="" />
                                        </li>
                                    </ul>
                                </div>
                                <ul class="pagination">
                                    <li><a href="#">Hair</a></li>
                                    <li><a href="#">Makeup</a></li>
                                    <li><a href="#">Spa</a></li>
                                    <li><a href="#">Map</a></li>
                                </ul>
                            </div>
                            <div class="container_12">
                                <div class="wrapper">
                                    <article class="grid_4">
                                        <h4>About Sion</h4>
                                        เกี่ยวศรีอ้นนั้น ทางรั้านได้มีบริการหลากหลายเกี่ยวกับการเสริสวย หากลูกค้าท่านใดสนใจสามารถเยี่ยมชมรูปต่างๆภายในเว็บไซต์นี้ได้ค่ะ
                                    </article>
                                    <article class="grid_4">
                                        <div class="indent-left">
                                            <h4>Our Gallery</h4>
                                            ในอัลบั้มภาพของเราจะเป็นการรวมภาพต่างๆเกี่ยวกับผลงานทางร้านของเราที่ได้ให้บริการกับลูกค้า สามารถเข้าดูได้ที่นี่ >>> <a class="link" href="gallery.php">อัลบั้มภาพ</a>
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
                                    <h3>Welcome to Sion Hair&Spa</h3>
                                    <div class="wrapper p2">
                                        <figure class="img-indent img-border"><img src="images/sion.png" alt="" /></figure>
                                        <div class="extra-wrap">
                                            <h6>ยินดีต้อนรับเข้าสู่ร้าน ศรีอ้นแฮร์แอนด์สปา</h6>
                                            เมื่อพูดถึงร้านเสริมสวย หรือ ร้านทำผม จะมีไม่น้อยเลยที่นักศึกษาจะนึกถึงที่นี่ ศรีอ้น ร้านอยู่ติดถนน เมือเลี้ยวเข้ามาจากแยกนเศวรเพื่อขึ้นเขาใหญ่ร้านจะอยู่ทางซ้ายมือ อยู่ติดกับร้าน ไอศครีม "Happy Bew"สังเกตุได้ง่าย
                                            หากท่านใดได้ผ่านมาทางนี้ฝากมาเยี่ยมชมทางร้านได้นะคะ
                                        </div>
                                    </div>
                                </article>
                                <article class="grid_4">
                                    <div class="indent-left2 img-indent-bot">
                                        <h6>เคล็ดไม่ลับเกี่ยวกับการเสริมสวย</h6>
                                        <ul class="list-1">
                                            <li><a href="http://women.mthai.com/make-up-trend/187054.html"><span class="color-2">มือใหม่! เขียนคิ้ว สวยเป๊ะ ราวกับมืออาชีพ</span> จาก Mthai</a></li>
                                            <li><a href="http://women.mthai.com/make-up-trend/180392.html"><span class="color-2">แต่งหน้าเกาหลี สุดยอดเคล็ดลับ ความสวยใส</span> จาก Mhtai</a></li>
                                            <li><a href="http://women.kapook.com/view104233.html"><span class="color-2">เคล็ดลับหน้าสวยในหน้าหนาว</span> จาก Kapook.com</a></li>
                                            <li class="last-item"><a href="http://women.kapook.com/view102850.html"><span class="color-2">วิธีรักษาสิวอักเสบ ยุบเร็วทันใจไร้กังวล</span> จาก Kapook.com</a></li>
                                        </ul>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                    <div class="block"></div>
                </section>
            </div>
        </article>

        <!--==============================footer=================================-->
        <?php include './footer.php'; ?>
        <script type="text/javascript"> Cufon.now();</script>
        <script type="text/javascript">
            $(window).load(function () {
                $('.slider')._TMS({
                    duration: 800,
                    easing: 'easeOutQuad',
                    preset: 'simpleFade',
                    slideshow: 7000,
                    banners: false,
                    pauseOnHover: true,
                    pagination: '.pagination',
                    pagNums: false
                });
            });
        </script>
    </body>
</html>
