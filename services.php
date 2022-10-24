<?php

    require_once('includes/head.php');

    $active = 'services';
    $page_title = $lang['payment_services'];

    include 'includes/header.php';

    require 'classes/Billing.php';
    $Billing = new Billing($db, 'Wallet');

    $services = $Billing->services();
    $categoryes = $Billing->categories();

    $langs = strtoupper($lang_id);

?>

    <div class="service_list service-page" id="services">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-right col-xs-text-center">
                    <div class="ser-search-box">
                        <form class="search" action="" method="post" id="Search">
                            <input autocomplete="off" type="text" class="serach-inp" id="service_search_input" name="search" placeholder="<?php echo $lang['search_service']; ?>">
                            <button type="submit" name="search" class="service-search-btn btn-icon"><img src="assets/img/magnifer1.png" alt="lang"></button>
                        </form>
                        <div class="service-search-result text-left">

                            <?php foreach ($services['services'] as $service) {

                                if ($service['id'] == 46) {
                                    continue;
                                } ?>

                                <a class="service-search-item none" alt="<?=$service['lang']['GE'] ?>, <?=$service['lang']['EN'] ?>, <?=$service['lang']['RU'] ?>" title="<?=$service['lang'][$langs] ?>" href="pay.php?step=1&id=<?=$service['id'] ?>">
                                    <div class="inline-block">
                                        <div class="item-image" style="background-image: url('http://uploads.allpayway.ge/files/services/<?php echo $service['image']; ?>');"></div>
                                        <strong><?=$service['lang'][$langs] ?></strong>
                                    </div>
                                </a><!-- end search item -->
                            <?php } ?>

                            <strong class="none service_no_found"><?=$lang['service_no_found'] ?></strong>
                        </div>
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="lst">

                        <?php if (!empty($categoryes['categories'])) {

                            foreach ($categoryes['categories'] as $categorye) { ?>

                                <div class="service-item box-shadow1" rel="<?=$categorye['id'] ?>" title="<?=$categorye['name_'.$lang_id] ?>" lang="<?=$lang_id ?>">
                                    <div class="service-cat-bg" style="background: url('http://uploads.allpayway.ge/files/categories/<?php echo $categorye['image']; ?>') no-repeat top center"></div>
                                    <h3 class=""><?=$categorye['name_'.$lang_id] ?></h3>
                                    <span class="count-service"><?=$categorye['count'] ?></span>
                                </div><!-- end service-item -->

                            <?php }

                        } ?>

                    </div><!-- end lst -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end service_list -->
<?php
    include 'includes/footer.php';
?>
