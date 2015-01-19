<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Gallery</title>
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
        <script src="js/jquery.galleriffic.js" type="text/javascript"></script>
        <script src="js/jquery.opacityrollover.js" type="text/javascript"></script> 
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
    <body id="page3">
        <div class="extra"> 
            <header> 
                <div class="header-row" style="padding-bottom: 0px;"><div class="ic"></div>
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
                                <li id="li" class="activex"><a class="menu" href="./gallery.php">Gallery</a></li>
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
                    </div>
                </div>
            </header>

            <!--==============================content================================-->
            <section id="content">
                <div class="bg">
                    <div class="main">
                        <div id="gallery" class="content">
                            <div class="wrapper">
                                <div class="slideshow-container">
                                    <div id="slideshow" class="slideshow" style="background: #171616;"></div>
                                </div>
                            </div>
                        </div>
                        <div id="thumbs" class="navigation">
                            <h3>Gallery</h3>
                            <ul class="thumbs noscript">
                                <li>
                                    <a class="thumb" href="images/slide1.jpg" title=""> <img src="images/thumb1.jpg" alt="" /><span></span> </a>
                                </li> 
                                <li>
                                    <a class="thumb" href="images/slide2.jpg" title=""> <img src="images/thumb2.jpg" alt="" /> <span></span></a>
                                </li> 
                                <li>
                                    <a class="thumb" href="images/slide3.jpg" title=""> <img src="images/thumb3.jpg" alt="" /> <span></span></a>
                                </li> 
                                <li class="last">
                                    <a class="thumb" href="images/slide4.jpg" title=""> <img src="images/thumb4.jpg" alt="" /> <span></span></a>
                                </li>
                                <li>
                                    <a class="thumb" href="images/slide5.jpg" title=""> <img src="images/thumb5.jpg" alt="" /> <span></span></a>
                                </li> 
                                <li>
                                    <a class="thumb" href="images/slide6.jpg" title=""> <img src="images/thumb6.jpg" alt="" /> <span></span></a>
                                </li>
                                <li>
                                    <a class="thumb" href="images/slide7.jpg" title=""> <img src="images/thumb7.jpg" alt="" /><span></span> </a>
                                </li> 
                                <li class="last">
                                    <a class="thumb" href="images/hair.jpg" title=""> <img src="images/hairthumb.jpg" alt="" /> <span></span></a>
                                </li>  	   
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="block"></div>
            </section>
        </div>

        <!--==============================footer=================================-->
        <?php include './footer.php'; ?>
        <script type="text/javascript"> Cufon.now();</script>
        <script type="text/javascript">
            $(window).load(function () {
                // We only want these styles applied when javascript is enabled
                $('div.navigation').css({'width': '940px'});
                $('div.content').css('display', 'block');

                // Initially set opacity on thumbs and add
                // additional styling for hover effect on thumbs
                var onMouseOutOpacity = 0.5;
                $('#thumbs ul.thumbs li span').opacityrollover({
                    mouseOutOpacity: onMouseOutOpacity,
                    mouseOverOpacity: 0.0,
                    fadeSpeed: 'fast',
                    exemptionSelector: '.selected'
                });

                // Initialize Advanced Galleriffic Gallery
                var gallery = $('#thumbs').galleriffic({
                    delay: 7000,
                    numThumbs: 12,
                    preloadAhead: 6,
                    enableTopPager: false,
                    enableBottomPager: false,
                    imageContainerSel: '#slideshow',
                    controlsContainerSel: '',
                    captionContainerSel: '',
                    loadingContainerSel: '',
                    renderSSControls: true,
                    renderNavControls: true,
                    playLinkText: 'Play Slideshow',
                    pauseLinkText: 'Pause Slideshow',
                    prevLinkText: 'Prev',
                    nextLinkText: 'Next',
                    nextPageLinkText: 'Next',
                    prevPageLinkText: 'Prev',
                    enableHistory: true,
                    autoStart: 7000,
                    syncTransitions: true,
                    defaultTransitionDuration: 900,
                    onSlideChange: function (prevIndex, nextIndex) {
                        // 'this' refers to the gallery, which is an extension of $('#thumbs')
                        this.find('ul.thumbs li span')
                                .css({opacity: 0.5})
                    },
                    onPageTransitionOut: function (callback) {
                        this.find('ul.thumbs li span').css({display: 'block'});
                    },
                    onPageTransitionIn: function () {
                        this.find('ul.thumbs li span').css({display: 'none'});
                    }
                });
            });
        </script>
    </body>
</html>
