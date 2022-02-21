<?php
  require_once('includes/head.php');

  //
  $active = 'register';
  $page_title = 'ვერიფიკაცია';


  $page_style = "<link rel='stylesheet' type='text/css' href='https://manager.allpayway.ge/assets/global/plugins/cropperjs/cropper.min.css'><script src='https://www.google.com/recaptcha/api.js'></script>";

 include 'includes/header.php';

 $users_document_types = $db->get_unlimited_list('users_document_types',' `id` > 0', "id", "ASC");

 $sferos = $db->get_unlimited_list('sferos',' `id` > 0', "id", "ASC");


?>

  <div class="container page">
    <div class="row">
      <div class="col-md-12">
        <div class="page-bg fluid clear">
          <h3 class="page-title">
            <span class="t r">ვერიფიკაცია<?php // echo $lang['sing_up']; ?></span>
          </h3>

          <div class="alert alert-primary" role="alert" style="font-family: 'title';">
		    ვერიფიკაციის გასავლელად მიბრძანდით ჩვენს ნებისმიერ <a href="https://leaderpay.ge/profile.php?action=cashout" style="font-family: 'title';">სალაროში</a> ან ჩვენს მთავარ ოფიში !
		  </div>

        </div><!-- end page-bg -->
      </div><!-- end col -->
    </div><!-- end row -->

  </div><!-- end container -->

<?php

  $page_script = '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script><script src="https://manager.allpayway.ge/assets/global/plugins/cropperjs/cropper.min.js"></script><script src="assets/pages/verification.js?'.time().'"></script>';

  include 'includes/footer.php';
?>
