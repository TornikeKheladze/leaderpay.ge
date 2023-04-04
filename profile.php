<?php
    require_once('includes/head.php');

    $active = 'profile';
    $page_title = $lang['my_wallet'];
    //check user
    if ($db->check_auch() === false) {
        header('Location: index.php');
    }

    // logout
    if (isset($get['logout'])) {
        session_destroy();
        header('Location: index.php');
    }

    $action = (isset($get['action'])) ? htmlspecialchars(urlencode($get['action']), ENT_QUOTES) : '';

    include 'includes/header.php';

?>

<div class="container page">
    <div class="row">
        <div class="col-md-12">
            <div class="profile-bg clear">
                <div class="profile-header clear">
                    <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                        <button type="button" name="button" class="drop menu-btn" rel="slide-toggle"></button>
                    </div>
                    <div class="hidden-xs">
                        <div class="p-h-item">
                            <h5><?=$lang['wallet_number'] ?> <span><?=$username ?></span></h5>
                        </div>
                        <div class="p-h-item">
                            <h5>
                                <?=$lang['balance'] ?>
                                <span class="user_balance "><?=$user['balance_rub'] ?>
                                        <span class="lari" style="float: right; padding-top: 0;">₽</span>
                                    </span>
                            </h5>
                        </div>
                        <div class="p-h-item">
                            <h5>
                                <?=$lang['balance'] ?>
                                <span class="user_balance "><?=$user['balance_eur'] ?>
                                        <span class="lari" style="float: right; padding-top: 0;">€</span>
                                    </span>
                            </h5>
                        </div>
                        <div class="p-h-item">
                            <h5>
                                <?=$lang['balance'] ?>
                                <span class="user_balance "><?=$user['balance_usd'] ?>
                                        <span class="lari" style="float: right; padding-top: 0;">$</span>
                                    </span>
                            </h5>
                        </div>
                        <div class="p-h-item">
                            <h5>
                                <?=$lang['balance'] ?>
                                <span class="user_balance "><?=$user['balance'] ?>
                                        <span class="lari" style="float: right; padding-top: 0;">¢</span>
                                    </span>
                            </h5>
                        </div>
                        <div class="p-h-item">
                            <a href="?action=templates" class="btn btn-c saves_services_btn">
                                <div class="cart">
                                    <img src="assets/img/shopping-cart.png?" alt="">
                                    <span class="count" rel="<?=$db->table_count('save_service', " user_id = '$username' ") ?>"><?=$db->table_count('save_service', " user_id = '$username' ") ?></span>
                                </div>
                                <span class="t">ჩემი შაბლონები</span>
                            </a>
                        </div><!-- end p-h-item -->
                    </div><!-- end col -->
                </div><!-- end profile-header -->
                <div class="xs-hidden" id="slide-toggle">
                    <div class="profile-nav clear">
                        <ul class="menu">
                            <li>
                                <a href="profile.php?action=transactions" <?=($action == 'transactions') ? "class='active'" : '' ?>>
                                    <img src="assets/img/transactions.png" alt="<?=$lang['transactions'] ?>">
                                    <span class="image-title"><?=$lang['transactions'] ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="services.php">
                                    <img src="assets/img/idea.png" alt="<?=$lang['services'] ?>">
                                    <span class="image-title"><?=$lang['services'] ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="profile.php?action=convertation" <?=($action == 'convertation') ? "class='active'" : '' ?>>
                                    <img src="assets/img/exchange.png" alt="<?=$lang['convertation'] ?>">
                                    <span class="image-title"><?=$lang['convertation'] ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="profile.php?action=personal_info" <?=($action == 'personal_info') ? "class='active'" : '' ?>>
                                    <img src="assets/img/id.png" alt="<?=$lang['personal_informacions'] ?>">
                                    <span class="image-title"><?=$lang['personal_informacions'] ?></span>
                                </a>
                            </li>
                            <li class="">
                                <a href="profile.php?action=balance" <?=($action == 'balance') ? "class='active'" : '' ?>>
                                    <img src="assets/img/wallet1.png?" alt="<?=$lang['balance_up'] ?>">
                                    <span class="image-title"><?=$lang['balance_up'] ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="profile.php?action=payment" <?=($action == 'payment') ? "class='active'" : '' ?>>
                                    <img src="assets/img/money1.png" alt="<?=$lang['send_money'] ?>">
                                    <span class="image-title"><?=$lang['send_money'] ?></span>
                                </a>
                            </li>
                            <li  class="">
                                <a href="profile.php?action=cashout" <?=($action == 'cashout') ? "class='active'" : '' ?>>
                                    <img src="assets/img/cashout.png" alt="<?=$lang['cash_withdrawal'] ?>">
                                    <span class="image-title"><?=$lang['cash_withdrawal'] ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="profile.php?action=settings" <?=($action == 'settings') ? "class='active'" : '' ?>>
                                    <img src="assets/img/option.png" alt="<?=$lang['settings'] ?>">
                                    <span class="image-title"><?=$lang['settings'] ?></span>
                                </a>
                            </li>
                        </ul>
                    </div><!-- profile-nav -->
                </div><!-- end col -->

                <?php
                if ($user['verify_id'] == 1) {
                    echo '<script type="text/javascript">alert("ვერიფიკაციის გასავლელად მიბრძანდით ჩვენს ნებისმიერ სალაროში!");</script>';
                }
                ?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                    if ($action != 'account' &&  $action != '' ) {
                        if ($action == 'transactions') {
                            include 'user/pages/transactions.php';
                        } elseif ($action == 'convertation') {
                            include 'user/pages/convertation.php';
                        } elseif ($action == 'personal_info') {
                            include 'user/pages/personal_info.php';
                        } elseif ($action == 'balance') {
                            include 'user/pages/balance.php';
                        }  elseif ($action == 'payment') {
                            include 'user/pages/payment.php';
                        } elseif ($action == 'cashout') {
                            include 'user/pages/cashout.php';
                        } elseif ($action == 'settings') {
                            include 'user/pages/settings.php';
                        } elseif ($action == 'pay') {
                            include 'user/pages/pay.php';
                        } elseif ($action == 'templates') {
                            include 'user/pages/templates.php';
                        }
                    } else {
                        include 'user/pages/transactions.php';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include 'includes/footer.php';
?>

