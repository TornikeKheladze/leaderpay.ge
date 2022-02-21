<?php

require_once('includes/head.php');

$active = 'login';
$page_title = $lang['log_in'];

?>

<div class="container page up" id="login_form">

    <div class="row">
        <div class="col-md-12">
            <div class="login-box clear">
                <div class="col-md-6 col-sm-6">
                    <div class="modal-body">
                        <h4 class="login-title"><?php echo $lang['enter_the_wallet'] ?></h4>
                        <form class="" action="" method="post" autocomplete="off" id="login" novalidate="novalidate">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="msg msg-error"
                                         style="display:none"><?php echo $lang['required'] ?></div>

                                    <?php if (isset($error_msg)) { ?>

                                        <div class="msg msg-error"><?php echo $error_msg ?></div>

                                    <?php } ?>

                                </div>
                            </div>

                            <?php if (isset($auth) && $auth['errorCode'] != 0): ?>

                                <div class="msg msg-error">
                                    <?php echo $auth['errorMessage'] ?>
                                    <div class="close msg-colose" rel="#"></div>
                                </div>

                            <?php endif; ?>

                            <div class="form-group inputs-whit-icon">
                                <label for="username"><?php echo $lang['wallet_number'] ?></label>
                                <span class="form-icon" style="background: url('assets/img/personal.png')"></span>
                                <input onkeypress="return isIntKey(event);" maxlength="11" type="text" name="login-username"
                                       id="login-username" class="input" autocomplete="off">
                            </div>
                            <div class="form-group inputs-whit-icon">
                                <label for="password"><?php echo $lang['password'] ?></label>
                                <span class="form-icon" style="background: url('assets/img/key.png')"></span>
                                <input type="password" name="login-password" id="login_password" class="input" autocomplete="off">
                            </div>
                            <div class="m-text">
                                <a href="lostpass.php">პაროლის აღდგენა</a>
                            </div>
                            <div class="form-group ">
                                <label for="security"><?php echo $lang['security_code'] ?></label>
                                <div id="login-g-recaptcha"></div>
                                <input id="login-hidden-grecaptcha" name="login-hidden-grecaptcha" type="text"
                                       style="visibility:hidden;height: 0;">
                            </div>
                            <div class="form-group  inputs-whit-icon text-center">
                                <button type="submit" name="login"
                                        class="g1-btn"><?php echo $lang['sign_in'] ?>  </button>
                            </div>
                        </form>
                    </div>
                </div> <!--End col-md-6 div -->
                <div class="col-md-6 col-sm-6">
                    <div class="register-txt">
                            <div class="reg-icon">
                                <img src="assets/img/add-user.png" alt="add user">
                            </div>
                        <!-- <h3>რეგისტრაცია</h3> -->
                        <p><?php echo $lang['login_txt_1'] ?>
                            <a href="https://leaderpay.ge/register.php" style="text-decoration: none;border-bottom: none;">
                                <button id="btn_registration" class=" button registration_button"><?php echo $lang['sign_up_1'] ?></button><?php echo $lang['create_wallet'] ?>
                            </a>
                        </p>
                    </div>
                </div> <!--End col-md-6 div -->
            </div>
        </div><!-- end col -->
    </div><!-- end row -->

</div><!-- end container -->

<?php

$page_script = '<script src="merchant/assets/js/login.js?1"></script>';
if (isset($page_script)) {
    echo $page_script;
}

?>
