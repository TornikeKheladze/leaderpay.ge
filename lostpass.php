<?php

  require_once('includes/head.php');

  //
  $active = 'login';
  $page_title = $lang['log_in'];


  //check user
  if ($db->check_auch() == true) {

    header('Location: profile.php');

  }

  $page_style = "<script src='https://www.google.com/recaptcha/api.js'></script>";


  include 'includes/header.php';



?>

  <div class="container page">

    <div class="row">
      <div class="col-md-12">
        <div class="login-box clear" style="max-width:365px">
          <div class="col-md-12 col-sm-12">
            <div class="modal-body">
              <h4 class="login-title">პაროლის აღდგენა<?php //echo $lang['enter_the_wallet'] ?></h4>
              <form class="relative" action="loads/password.php" method="post" autocomplete="nope" id="loas_pass_form" novalidate="novalidate">
                <div class="row">
                  <div class="col-md-12">
                    <div class="msg msg-error" style="display:none"><?php echo $lang['required'] ?></div>

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

                <div class="inputs1">
                  <div class="form-group inputs-whit-icon">
                    <label for="wallet_number"><?php echo $lang['wallet_number'] ?></label>
                    <span class="form-icon" style="background: url('assets/img/personal.png')"></span>
                    <input onkeypress="return isIntKey(event);" maxlength="11" type="text" name="wallet_number" id="wallet_number" class="input" autocomplete="off">
                  </div>
                  <div class="form-group ">
                    <label for="security"><?php echo $lang['security_code'] ?></label>
                    <div class="g-recaptcha"  data-sitekey="6LfLxE4UAAAAAAiq2Io2JclnSwYuUJftQOOk7RMX"></div>
                    <input id="hidden-grecaptcha" name="hidden-grecaptcha" type="text" style="visibility:hidden;height: 0;">
                  </div>
                </div>

                <div class="form-group  inputs-whit-icon text-center">
                  <button type="submit" class="g1-btn"><?php echo $lang['send'] ?>  </button>
                </div>
              </form>
            </div>
          </div> <!--End col-md-12 div -->
        </div>
      </div><!-- end col -->
    </div><!-- end row -->

  </div><!-- end container -->

<?php

  $page_script = '<script src="assets/pages/lostpass.js?1"></script>';

  include 'includes/footer.php';
?>
