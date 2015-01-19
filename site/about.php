<!DOCTYPE html>
<html lang="en">
    <head>
        <title>About</title>
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
        <!--[if lt IE 7]>
        <div style=' clear: both; text-align:center; position: relative;'>
                <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
                        <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
                </a>
        </div>
        <![endif]-->
        <!--[if lt IE 9]>
                <script type="text/javascript" src="js/html5.js"></script>
        <![endif]-->
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
    <body id="page2">
        <div class="extra"> 
            <header> 
                <div class="header-row"><div class="ic">More Website Templates @ TemplateMonster.com - November 07, 2011!</div>
                    <div class="main">
                        <h1 class="margin-bot">
                            <a href="./index.php">Sion</a>
                            <em>Keep Your Perfect Look</em>
                            <?php
                            if (empty($_SESSION['Username'])) {
                                echo '<em id="login" style="float:right;cursor: pointer;color: #15B715;">Login</em>';
                                echo '<em id="signup" style="float:right;cursor: pointer;margin-right: 1em;color: white;">Sign up</em>';
                            } else {
                                echo '<em id="logout" style="float:right;cursor: pointer;">Logout</em>';
                                echo '<em id="username" style="float:right;color:orange;cursor: pointer;margin-right: 1em;">' . $_SESSION['Username'] . '</em>';
                            }
                            ?>  
                        </h1>
                        <div class="menux"> 
                            <ul id="ul"> 
                                <li id="li"><a class="menu" href="./">Home</a></li>
                                <li id="li" class="activex"><a class="menu" href="./gallery.php">Gallery</a></li>
                                <li id="li"><a class="menu" href="./services.php">Services</a></li>
                                <li id="li"><a class="menu" href="./contacts.php">Contacts</a></li> 
                                <li id="li"><a class="menu" href="./about.php">About</a></li> 
                            </ul> 
                        </div>
                        <script type="text/javascript">
                            $('#login').click(function () { $(location).attr('href', './login.php'); });
                            $('#signup').click(function () { $(location).attr('href', './signup.php'); });
                            $('#logout').click(function () { $(location).attr('href', './logout.php'); });
                            $('#username').click(function () { $(location).attr('href', './profile.php'); });
                        </script>
                        <div class="container_12" style="padding-top: 50px;">
                            <div class="wrapper">
                                <article class="grid_4">
                                    <h4>Our Capabilities</h4>
                                    <p class="prev-indent-bot">Sed ut perspiciatis unde omnis istnatus error<br> sit voluptatem accusantium:</p>
                                    <ul class="list-2">
                                        <li><a href="#">Doloremque laudantium totam</a></li>
                                        <li><a href="#">Aperiam eaque ipsa quae illo inventore</a></li>
                                        <li><a href="#">Veritatis et quasi architecto beatae</a></li>
                                        <li><a href="#">Vitae dicta sunt explicabo</a></li>
                                    </ul>
                                </article>
                                <article class="grid_4">
                                    <div class="indent-left">
                                        <h4>Our Advantages</h4>
                                        <h5><a class="link" href="#">At vero eos et accusamus et iusto</a></h5>
                                        <p class="prev-indent-bot">Odio dignissimos ducimus blanditiis praesen tium voluptatum deleniti.</p>
                                        <h5><a class="link" href="#">Atque corrupti quos dolores</a></h5>
                                        Quas moleias excepturi occaecati cupiditate non provident, similique sunt.
                                    </div>
                                </article>
                                <article class="grid_4">
                                    <div class="indent-left2">
                                        <h4>Our Principles</h4>
                                        <p class="prev-indent-bot">Et harum quidem rerum facilis est et expedita nobis est eligendi:</p>
                                        <ul class="list-2">
                                            <li><a href="#">Optio cumque nihil impedit quo minus</a></li>
                                            <li><a href="#">Quod maxime placeat facere</a></li>
                                            <li><a href="#">Possimus omnis voluptas assumenda</a></li>
                                            <li><a href="#">Omnis dolor repellendu emporibus</a></li>
                                        </ul>
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
                                <h3>A Few Words About Us</h3>
                                <div class="wrapper p2">
                                    <figure class="img-indent img-border"><img src="images/page2-img1.jpg" alt="" /></figure>
                                    <div class="extra-wrap">
                                        <h6>At vero eos et accusamus etiusto dignissimos</h6>
                                        Ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum fuga harum quidem rerum facilis.
                                    </div>
                                </div>
                                <p><span class="color-2">Omnis voluptas assumenda est, omnis dolor repellendus.</span> Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae itaque earum rerum hic tenetur.</p>
                                <div class="wrapper p3">
                                    <figure class="img-indent img-border"><img src="images/page2-img2.jpg" alt="" /></figure>
                                    <div class="extra-wrap">
                                        <h6>Delectus, ut aut reiciendis voluptatibus</h6>
                                        Maiores alias consequatur aut perferendis doloribus asperiores repellat. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam.
                                    </div>
                                </div>
                                <a class="button" href="#">Read More</a>
                            </article>
                            <article class="grid_4">
                                <div class="indent-left2">
                                    <h3>What We Offer</h3>
                                    <p class="prev-indent-bot"><span class="color-2">At vero eos et accusamus et iusto</span> odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque:</p>
                                    <ul class="list-2 indent-bot">
                                        <li><a href="#">Corrupti quos dolores et quas</a></li>
                                        <li><a href="#">Molestias excepturi sint occaecati</a></li>
                                        <li><a href="#">Cupiditate non provident, similique sunt</a></li>
                                        <li><a href="#">Dulpa qui officia deserunt mollitia</a></li>
                                    </ul>
                                    <p class="prev-indent-bot"><span class="color-2">Animi, id est laborum et dolorum</span> fuga harum dolorem ipsum quia dolor sit amet, consecte tur quidem rerum facilis est et expedita dis tinctio nam libero:</p>
                                    <ul class="list-2 margin-bot">
                                        <li><a href="#">Tempore cum soluta nobis est eligendi</a></li>
                                        <li><a href="#">Optio cumque nihil impedit quo</a></li>
                                        <li><a href="#">Minus id quod maxime placeat facere</a></li>
                                        <li><a href="#">Possimus omnis voluptas assumenda</a></li>
                                    </ul>
                                    <a class="button" href="#">Read More</a>
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
