<?php
include_once 'includes/new_lang.php';
if(!isset($_GET["lang"])){
    header("Location: index.php?lang=ge");
}
?>
<!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="assets/new_css/index.css">
    <link rel="stylesheet" href="assets/new_css/break.css">
    <link rel="stylesheet" href="assets/new_css/reset.css">
    <link rel="stylesheet" href="assets/new_css/responsiv.css">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon/title_icon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon/title_icon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title><?php echo  $lang['Title']?></title>
</head>
<body >
    <header id="pageHeader">
        <!-- LeaderPay logo -->
            <div class="leaderpay_logo">
                <a href="https://leaderpay.ge/">
                    <img src="/assets/img/favicon/title_icon.png" alt="LeaderPay">
                </a>
            </div>
            <div class="leaderpay_name">
                Leader Pay
            </div>
            <div class="openIcon open" rel="mobile-nav">
                <div class="bar arrow-top"></div>
                <div class="bar arrow-middle"></div>
                <div class="bar arrow-bottom"></div>
            </div>
            <!--Mobile Menu-->
            <div class="mob-menu" id="mobile-nav">
                <div class="closeIcon closeIcon"  rel="mobile-nav">
                    <div class="bar top"></div>
                    <div class="bar middle"></div>
                    <div class="bar bottom"></div>
                </div>
                <div class="relative">
                    <div class="mobile_menu">
                        <div class="mobile_leaderpay_logo">
                            <a href="https://leaderpay.ge/">
                                <img src="/assets/img/favicon/title_icon.png" alt="LeaderPay">
                            </a>
                        </div>
                        <div class="mobile_languages">
                            <div>
                                <a href="index.php?lang=ge" <?php echo ($_GET["lang"] == 'ge')?> > Geo </a>
                            </div>
                            <div>
                                <a href="index.php?lang=en" <?php echo ($_GET["lang"] == 'en')?> > Eng </a>
                            </div>
                            <div>
                                <a href="index.php?lang=ru" <?php echo ($_GET["lang"] == 'ru')?> > Rus </a>
                            </div>
                        </div>
                        <div class="mobile_content">
                            <div id="about_us"> 
                                <a href="about_us.php"><?php echo  $lang['About_us']?></a>
                            </div>
                            <div  id="news">
                                <a href="news.php"><?php echo  $lang['News']?></a>
                            </div>
                            <div id="contact">
                                <a href="contact.php"><?php echo  $lang['Contact']?></a>
                            </div>
                            <div id="wallet_rules">
                                <a href="rules.php"><?php echo  $lang['Rules']?></a>
                            </div>
                            <div id="aml">
                                <a href="aml.php"><?php echo  $lang['Aml']?></a>
                            </div>
                            <div  id="terms_service">
                                <a href="service.php"><?php echo  $lang['Service']?></a>
                            </div>
                            <div  id="safety">
                                <a href="partners.php"><?php echo  $lang['Partners']?></a>
                            </div>
                            <div  id="safety">
                                <a href="privacy.php"><?php echo  $lang['Security']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--Mobile Menu-->
    </header>
    <main id="main">
        <div class="anim-show slides">
            <div class="coin_cover1" >
                <div class="coin1">
                    <div class="logo">
                        <img src="/assets/img/favicon/title_icon.png" alt="LeaderPay">
                    </div>
                    <div class="border-1"></div>
                    <div class="border-2"></div>
                    <div class="slg url" data-url="register.php"></div>
                </div>
                <a href="login.php">
                    <div class="sub-n center-left" data-url="login.php" >
                        <div class="min_logo">
                            <img src="/assets/img/favicon/title_icon.png" alt="LeaderPay">
                        </div>
                        <div class="border"></div>
                        <div class="mini_slg"></div>
                        <div class="txt"><?php echo $lang['Authorization']; ?></div>
                    </div>
                </a> 
                <a href="services.php">
                    <div class="sub-n top-right" data-url="services.php" >
                        <div class="min_logo_top_right">
                            <img src="/assets/img/favicon/title_icon.png" alt="LeaderPay">
                        </div>
                        <div class="border"></div>
                        <div class="mini_slg"></div>
                        <div class="txt"><?php echo $lang['Pay']; ?></div>
                    </div>
                </a>
                <a href="game.php" target="_blank">
                    <div class="sub-n bottom-right" data-url="">
                        <div class="min_logo_bottom_right">
                            <img src="/assets/img/favicon/title_icon.png" alt="LeaderPay">
                        </div>
                        <div class="border"></div>
                        <div class="mini_slg"></div>
                        <div class="txt"><?php echo $lang['Fun']; ?></div>
                    </div>
                </a>
            </div>
            <div class="coin1Shadow"></div>
        </div>
    </main>
    <footer id="pageFooter">
        <div class="content">
            <div id="about_us"> 
                <a href="about_us.php"><?php echo  $lang['About_us']?></a>
            </div>
            <div  id="news">
                <a href="news.php"><?php echo  $lang['News']?></a>
            </div>
            <div id="contact">
                <a href="contact.php"><?php echo  $lang['Contact']?></a>
            </div>
            <div id="wallet_rules">
                <a href="rules.php"><?php echo  $lang['Rules']?></a>
            </div>
            <div id="aml">
                <a href="aml.php"><?php echo  $lang['Aml']?></a>
            </div>
            <div  id="terms_service">
                <a href="service.php"><?php echo  $lang['Service']?></a>
            </div>
            <div  id="partners">
                <a href="partners.php"><?php echo  $lang['Partners']?></a>
            </div>
            <div  id="safety">
                <a href="privacy.php"><?php echo  $lang['Security']?></a>
            </div>
        </div>
        <div class="languages">
            <div>
                <a href="index.php?lang=ge" <?php echo ($_GET["lang"] == 'ge')?> > Geo </a>
            </div>
            <div>
                <a href="index.php?lang=en" <?php echo ($_GET["lang"] == 'en')?> > Eng </a>
            </div>
            <div>
                <a href="index.php?lang=ru" <?php echo ($_GET["lang"] == 'ru')?> > Rus </a>
            </div>
        </div>
    </footer>
</body>
<script src="assets/new_js/index.js"></script>
</html>
