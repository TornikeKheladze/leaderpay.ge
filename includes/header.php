<?php

require_once('head.php');

?>

<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <title>Leader Pay<?php if (isset($page_title)) {echo " - ".$page_title;} ?></title>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel="stylesheet" href="assets/css/style.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/fonts_<?php echo $lang_id ?>.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/plugins/intl-tel-input/intlTelInput.css">
    <link rel="stylesheet" href="assets/plugins/boxslider/jquery.bxslider.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="assets/plugins/select2/select2.css?<?php echo time(); ?>">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <?php if ($active == "profile"){ ?>

        <!-- datepicker -->
        <link rel="stylesheet" href="assets/plugins/datepicker/css/bootstrap-datepicker.min.css">
        <!-- datepicker -->

    <?php } ?>

    <script
            src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
            crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>

    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon/title_icon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon/title_icon.png">
    <link rel="manifest" href="assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="assets/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- page style -->
    <?php

    if (isset($page_style)) {

        echo $page_style;
    }

    ?>
    <!-- end page style -->


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Open Graph data -->
    <meta property="og:title" content="All pay way<?php if (isset($page_title)) {echo " - ".$page_title;} ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.leaderpay.ge/" />
    <meta property="og:image" content="assets/img/apw_cover.png" />
    <meta property="og:description" content="კომპანია „ოლ ფეი ვეი“ შეიქმნა 2015 წელს 5 ივნისს, კომპანიის მთავარი მიზანი წარმოადგენს შექმნას სრულყოფილი სერვისი როგორც ელექტრონულ კომერციაში ასევე დანერგოს ახალი სერვისები საგადახდო სისტემებში." />

</head>
<body class="bg">
<header>
    <div class="headbar">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-9">

                    <?php if ($db->check_auch() === true) { ?>

                        <a href="https://leaderpay.ge/profile.php" class="logo" style="background-image: url('/assets/img/lp.png?')"></a>


                    <?php } else { ?>

                        <a href="https://leaderpay.ge/" class="logo" style="background-image: url('/assets/img/lp.png?')"></a>


                    <?php } ?>

                </div>

                <div class="col-md-10 col-sm-10 hidden-xs text-right clear" style="padding-left: 120px;">

                    <?php

                    if (isset($_GET)) {

                        $get_url = '';
                        foreach ($_GET as $key => $value) {
                            $get_url .= $key.'='.$value.'&';
                        }


                    }



                    if ($db->check_auch() === true) { ?>

                        <div class="relative" style="display: contents;">
                            <a href="#"class="header-user-pic drop-icon" rel="down">

                                <?php

                                $avatar = 'assets/img/ku_avatar.png';

                                ?>

                                <img class="header-user-picture" alt="user-picture" src="<?php echo $avatar; ?>">
                                <span class="header-user-name"><?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?></span>
                                <div class="d-icon"></div>
                            </a>

                            <div class="header-menu-container" id="down">
                                <a class="md-button" href="profile.php?action=personal_info">
                                    <img src="assets/img/user.png" alt="">
                                    <span class="ng-binding ng-scope"><?php echo $lang['my_wallet']; ?></span>
                                </a>
                                <a class="md-button" href="profile.php?action=settings">
                                    <img src="assets/img/settings.png" alt="">
                                    <span class="ng-binding ng-scope"><?php echo $lang['settings']; ?></span>
                                </a>
                                <a class="md-button" href="profile.php?logout">
                                    <img src="assets/img/logout.png" alt="">
                                    <span class="ng-binding ng-scope"><?php echo $lang['exit']; ?></span>
                                </a>
                            </div><!-- end header-menu-container -->
                        </div>

                    <?php } else { ?>
                        <a href="login.php" class="btn btn-reg btn-icon"> <span id="login" style="display: none;"><?php echo $lang['sign_in']; ?> </span><img src="assets/img/login.png" alt="login" onmouseover="document.getElementById('login').style.display = 'inline-block';"></a>
                        <a href="register.php" class="btn btn-reg btn-icon"> <span id="registration" style="display: none;"><?php echo $lang['sing_up']; ?> </span><img src="assets/img/reg.png" alt="register" onmouseover="document.getElementById('registration').style.display = 'inline-block';"></a>

                    <?php } ?>

                </div><!-- end col md -->

                <div class="hidden-lg hidden-md hidden-sm col-xs-3">
            <span class="mobile-icon drop" rel="mobile-nav">
              <span></span>
              <span></span>
              <span></span>
            </span>
                </div>

            </div><!-- end row -->
        </div><!-- end container -->

        <div class="top-fav" style="display:none" id="top_fav">
            <div class="container">
                <div class="u-title" style="font-size: 14px;">
                    საყვარელი სერვისები
                </div>
                <?php

                if ($db->check_auch() === true) {

                    $favorites = $db->get_unlimited_list("favorites"," `user_id` = '".$user['id']."'","created_at","ASC");

                } // check user

                if (!empty($favorites)) {

                    foreach ($favorites as $favorite) {

                        ?>

                        <div class="s-cov">
                            <a href="profile.php?action=pay&id=<?php echo $favorite['service_id']; ?>">
                                <div class="serv-item">
                                    <?php
                                    if ($db->get_date("favorites"," `user_id` = '".$user['id']."' AND `service_id` = '".$favorite['service_id']."' ") === false) {
                                        ?>
                                        <div class="fov_palce_<?php echo $favorite['service_id']; ?>">
                                            <div class="add-f" title="ფავორიტებში დამატება" rel="<?php echo $favorite['service_id']; ?>" is="1"></div>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="fov_palce_<?php echo $favorite['service_id']; ?>">
                                            <div class="remove-f" title="ფავორიტებიდან წაშლა" rel="<?php echo $favorite['service_id']; ?>" is="1"></div>
                                        </div>
                                        <?php

                                        $lng_id = strtoupper ($lang_id);

                                    }
                                    ?>
                                    <img src="https://allpayway.ge/admin/uploads/services/<?php echo $favorite['logo']; ?>" alt="" class="responsive">
                                </div>
                            </a>
                        </div>

                        <?php

                    }

                } else {

                    ?>

                    <div class="no-found">
                        <img src="assets/img/not.png" alt="no found">
                        <span><?php echo $lang['list_is_empty']; ?></span>
                    </div>

                    <?php

                }

                ?>

            </div><!-- end container -->
        </div> <!-- end top-fav -->

    </div><!-- end headbar -->

    <div class="mob-menu" id="mobile-nav" style="display: none;">
        <div class="close"></div>
        <div class="block">
            <i class="star drop" rel="top_fav"  title="საყვარელი სერვისები"></i>
        </div>
        <div class="m-langs">
            <a href="?<?php echo $get_url;  ?>lang=ge" class="<?php echo ($lang_id == 'ge') ? 'active' : '' ; ?>">GEO</a>
            <a href="?<?php echo $get_url;  ?>lang=en" class="<?php echo ($lang_id == 'en') ? 'active' : '' ; ?>">ENG</a>
            <a href="?<?php echo $get_url;  ?>lang=ru" class="<?php echo ($lang_id == 'ru') ? 'active' : '' ; ?>">RUS</a>
        </div>
        <br>
        <div class="relative">

            <?php if ($db->check_auch() === true): ?>

                <div class="profile_info  m-p">
                    <div class="profile-image" style="background: url('<?php echo $avatar; ?>') no-repeat center center">
                    </div>
                    <h2><?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?></h2>
                    <ul>
                        <li>
                            <a class="md-button" href="profile.php?action=personal_info">
                                <img src="assets/img/user.png" alt="">
                                <span class="ng-binding ng-scope"><?php echo $lang['my_wallet']; ?></span>
                            </a>
                        </li>
                        <li>
                            <a class="md-button" href="profile.php?action=settings">
                                <img src="assets/img/settings.png" alt="">
                                <span class="ng-binding ng-scope"><?php echo $lang['settings']; ?></span>
                            </a>
                        </li>
                        <li>
                            <a class="md-button" href="profile.php?logout">
                                <img src="assets/img/logout.png" alt="">
                                <span class="ng-binding ng-scope"><?php echo $lang['exit']; ?></span>
                            </a>
                        </li>
                    </ul>
                </div>

            <?php else: ?>

                <a href="login.php" class="btn btn-gradiet btn-icon"><?php echo $lang['sign_in']; ?> <img src="assets/img/login.png" alt="login"></a>
                <a href="register.php" class="btn btn-reg btn-icon"><?php echo $lang['sing_up']; ?> <img src="assets/img/reg.png" alt="register"></a>

            <?php endif; ?>

        </div>
    </div><!-- mob-menu -->
</header>
