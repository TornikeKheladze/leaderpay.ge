<?php
  require_once('includes/head.php');

  $active = 'profile';
  $page_title = $lang['my_wallet'];
  //check user
  if ($db->check_auch() === false) {
    header('Location: index.php');
  }

  // logout
  if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
  }

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
              <div class="search p-h-item">
                <form class="" action="" method="post" id="search">
                  <input type="search" name="" placeholder="<?php echo $lang['search_wallet']; ?>" class="input">
                  <button type="submit" class="search-btn">
                    <img src="assets/img/search.png" alt="search">
                  </button>
                </form>
              </div><!-- end p-h-item -->
              <div class="p-h-item">
                <h5><?php echo $lang['wallet_number']; ?> <span><?php echo $user['personal_number']; ?></span></h5>
              </div>
              <div class="p-h-item">
                <h5>
                  <?php echo $lang['balance']; ?> 
                  <span class="user_balance "><?php echo $user['balance']; ?> 
                    <span class="lari" style="float: right; padding-top: 0;">¢</span> 
                  </span>
                </h5>
              </div>
              <!-- <div class="p-h-item">
                <h5><?php// echo $lang['verification_level']; ?> <span>40%</span></h5>
              </div>end p-h-item -->
              <div class="p-h-item">
                <a href="?action=templates" class="btn btn-c saves_services_btn">
                  <div class="cart">
                    <img src="assets/img/shopping-cart.png?" alt="">
                    <span class="count" rel="<?php echo $db->table_count("save_service", " user_id = '".$user['personal_number']."' "); ?>"><?php echo $db->table_count("save_service", " user_id = '".$user['personal_number']."' "); ?></span>
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
                  <a href="profile.php?action=transactions" <?php echo (isset($_GET['action']) && $_GET['action'] == 'transactions') ? "class='active'" : ''; ?>>
                    <img src="assets/img/transactions.png" alt="<?php echo $lang['transactions']; ?>">
                    <span class="image-title"><?php echo $lang['transactions']; ?></span>
                  </a>
                </li>
                <li>
                  <a href="profile.php?action=services" <?php echo (isset($_GET['action']) && $_GET['action'] == 'services') ? "class='active'" : ''; ?>>
                    <img src="assets/img/idea.png" alt="<?php echo $lang['services']; ?>">
                    <span class="image-title"><?php echo $lang['services']; ?></span>
                  </a>
                </li>
                <li>
                 <a href="profile.php?action=personal_info" <?php echo (isset($_GET['action']) && $_GET['action'] == 'personal_info') ? "class='active'" : ''; ?>>
                   <img src="assets/img/id.png" alt="<?php echo $lang['personal_informacions']; ?>">
                   <span class="image-title"><?php echo $lang['personal_informacions']; ?></span>
                  </a>
                </li>
                <!-- <li>
                 <a href="profile.php?action=favorites" <?php echo (isset($_GET['action']) && $_GET['action'] == 'favorites') ? "class='active'" : ''; ?>>
                   <img src="assets/img/heart.png" alt="<?php echo $lang['favorites']; ?>">
                   <span class="image-title"><?php echo $lang['favorites']; ?></span>
                  </a>
                </li> -->
                <li class="">
                  <a href="profile.php?action=balance" <?php echo (isset($_GET['action']) && $_GET['action'] == 'balance') ? "class='active'" : ''; ?>>
                    <img src="assets/img/wallet1.png?" alt="<?php echo $lang['balance_up']; ?>">
                    <span class="image-title"><?php echo $lang['balance_up']; ?></span>
                   </a>
                 </li>
                <li>
                  <a href="profile.php?action=payment" <?php echo (isset($_GET['action']) && $_GET['action'] == 'payment') ? "class='active'" : ''; ?>>
                    <img src="assets/img/money1.png" alt="<?php echo $lang['send_money']; ?>">
                    <span class="image-title"><?php echo $lang['send_money']; ?></span>
                   </a>
                 </li>
                 <li  class="">
                   <a href="profile.php?action=cashout" <?php echo (isset($_GET['action']) && $_GET['action'] == 'cashout') ? "class='active'" : ''; ?>>
                     <img src="assets/img/cashout.png" alt="<?php echo $lang['cash_withdrawal']; ?>">
                     <span class="image-title"><?php echo $lang['cash_withdrawal']; ?></span>
                    </a>
                  </li>
                  <li>
                  <a href="profile.php?action=settings" <?php echo (isset($_GET['action']) && $_GET['action'] == 'settings') ? "class='active'" : ''; ?>>
                    <img src="assets/img/option.png" alt="<?php echo $lang['settings']; ?>">
                    <span class="image-title"><?php echo $lang['settings']; ?></span>
                   </a>
                 </li>
                 <!-- <li>
                   <a href="profile.php?action=verification" <?php echo (isset($_GET['action']) && $_GET['action'] == 'verification') ? "class='active'" : ''; ?>>
                     <img src="assets/img/verification.png" alt="<?php echo $lang['verification']; ?>">
                     <span class="image-title"><?php echo $lang['verification']; ?></span>
                    </a>
                  </li> -->
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
                if (isset($_GET['action']) && $_GET['action'] != 'account' &&  $_GET['action'] != '' ) {
                  if ($_GET['action'] == 'transactions') {
                      include 'user/pages/transactions.php';
                    } elseif ($_GET['action'] == 'services') {
                      include 'user/pages/services.php';
                    }  elseif ($_GET['action'] == 'personal_info') {
                      include 'user/pages/personal_info.php';
                    }  elseif ($_GET['action'] == 'favorites') {
                      include 'user/pages/favorites.php';
                    }  elseif ($_GET['action'] == 'balance') {
                      include 'user/pages/balance.php';
                    }  elseif ($_GET['action'] == 'payment') {
                      include 'user/pages/payment.php';
                    } elseif ($_GET['action'] == 'cashout') {
                      include 'user/pages/cashout.php';
                    } elseif ($_GET['action'] == 'settings') {
                      include 'user/pages/settings.php';
                    } elseif ($_GET['action'] == 'verification') {
                      include 'user/pages/verification.php';
                    } elseif ($_GET['action'] == 'pay') {
                      include 'user/pages/pay.php';
                    } elseif ($_GET['action'] == 'templates') {
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
