<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Contacts</title>
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
    <body id="page5">
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
                                <li id="li"><a class="menu" href="./services.php">Services</a></li>
                                <li id="li" class="activex"><a class="menu" href="./contacts.php">Contacts</a></li> 
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
                                <div class="grid_12">
                                    <h4>Contact Form</h4>
                                    <form id="contact-form" action="MAILTO:jn_jirayu@hotmail.com" method="post" enctype="text/plain">					
                                        <fieldset>
                                            <div class="wrapper">
                                                <label class="img-indent2"><span class="text-form">ชื่อ-สกุล:</span><input name="fname" type="text" /></label>
                                                <label class="fleft"><span class="text-form">เบอร์โทร:</span><input name="tel" type="text" /></label>
                                            </div>
                                            <div class="wrapper">
                                                <label class="img-indent2"><span class="text-form">ที่อยู่:</span><input name="address" type="text" /></label>
                                                <label class="fleft"><span class="text-form">E-mail:</span><input name="email" type="text" /></label> 
                                            </div>							 
                                            <div class="wrapper">
                                                <div class="text-form">ข้อความ:</div>
                                                <div class="extra-wrap">
                                                    <label class="message"><input name="comment" type"textarea" width="50%" heigh="50%"/></label>
                                                    <div class="buttons">
                                                        <a class="button2" href="" onClick="document.getElementById('contact-form').reset()">Clear</a>
                                                        <a class="button2" href="" onClick="document.getElementById('contact-form').submit()">Send</a>
                                                    </div> 
                                                </div>
                                            </div>							
                                        </fieldset>						
                                    </form>
                                </div>
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
                            <article class="grid_12">
                                <h3 class="p2">Our Contacts</h3>
                                <div class="wrapper">
                                    <div class="grid_4 alpha">
                                        <h6>ปราจีนบุรี</h6>
                                        <dl>
                                            <dt>134 หมู่ที่ 5 ตำบล เนินหอม อำเภอ เมือง ปราจีนบุรี</dt>
                                            <dd><span>โทรศัพท์:</span>  +66 3xxx xxxx</dd>
                                            <!-- <dd><span>Telephone:</span>  +1 800 603 6035</dd>
                                            <dd><span>Fax:</span>  +1 800 889 9898</dd>
                                            <dd><span>Email:</span><a class="link" href="#">mail@demolink.org</a></dd> -->
                                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1934.3575579234728!2d101.36804100000002!3d14.152839000000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0x9f19213e2335cadb!2z4Lio4Lij4Li14Lit4LmJ4LiZIOC5geC4ruC4o-C5jCbguKrguJvguLI!5e0!3m2!1sth!2sth!4v1415805867126" width="600" height="450" frameborder="0" style="border:0"></iframe>
                                        </dl>
                                    </div>
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
        <!--coded by cheh-->
    </body>
</html>



