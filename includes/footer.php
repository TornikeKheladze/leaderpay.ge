  <div class="load-c">
    <div class='loading'>
      <div class='loading__square'></div>
      <div class='loading__square'></div>
      <div class='loading__square'></div>
      <div class='loading__square'></div>
      <div class='loading__square'></div>
      <div class='loading__square'></div>
      <div class='loading__square'></div>
    </div>
  </div><!-- end load-c -->
  <footer>
    <div class="grdt"></div>
    <div class="footbar">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-12 clear">
            <div class="social-icons">
              <a href="https://www.facebook.com/All-Pay-Way-925278277645268/" target="_blank" class="fb"></a>
              <a href="https://twitter.com/Leaderpay1" target="_blank" class="tw"></a>
              <a href="skype:live:7f73d893582483c7?add" class="sk"></a>
            </div>
            <div class="langs">
              <a href="?<?php echo $get_url;  ?>lang=ge" class="<?php echo ($lang_id == 'ge') ? 'active': ''; ?>">GEO</a>
              <a href="?<?php echo $get_url;  ?>lang=en" class="<?php echo ($lang_id == 'en') ? 'active': ''; ?>">ENG</a>
              <a href="?<?php echo $get_url;  ?>lang=ru" class="<?php echo ($lang_id == 'ru') ? 'active': ''; ?>">RUS</a>
            </div>
          </div><!-- end col -->
          <div class="col-md-9 col-sm-12 text-right">
            <ul class="footer-menu">
              <li class="level-0 active">
                <a href="about_us.php"><?=$lang['about_us'] ?></a>
              </li>
              <li class="level-0 active">
                <a href="news.php"><?=$lang['news'] ?></a>
              </li>
              <li class="level-0 active">
                <a href="contact.php"><?=$lang['contact'] ?></a>
              </li>
              <li class="level-0 active">
                <a href="rules.php"><?=$lang['wallet_rules'] ?></a>
              </li>
              <li class="level-0 active">
                <a href="aml.php"><?=$lang['aml_policy'] ?></a>
              </li>
              <li class="level-0 active">
                <a href="service.php"><?=$lang['terms_of_service'] ?></a>
              </li>
              <li class="level-0 active">
                <a href="privacy.php"><?=$lang['privacy_and_security'] ?></a>
              </li>
            </ul>
          </div><!-- end col -->
        </div><!-- end row -->
        <div class="space"></div>
        <div class="row">
          <div class="col-md-7 col-xs-12 text-left">
            <div class="copyrights">&copy; 2015 - <?=date('Y') ?> leaderpay.ge All Rights Reserved.</div>
          </div><!-- end col -->
          <div class="col-md-5 col-xs-12">
          </div><!-- end col -->
        </div><!-- end row -->
      </div><!-- end container -->
    </div><!-- end footbar -->
  </footer>
  <!-- validation -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_<?=$lang_id ?>.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

    <!-- input masks -->
  <script type="text/javascript" src="./assets/plugins/inputmask/jquery.inputmask.bundle.js"></script>
  <!-- telephone -->
  <script src="./assets/plugins/intl-tel-input/intlTelInput.js"></script>
  <!-- slider -->
  <script src="./assets/plugins/boxslider/jquery.bxslider.js?"></script>
  <script  src="assets/js/index.js?<?php echo time(); ?>"></script>
  <!-- toastr -->
  <script src="./assets/plugins/toastr/toastr.min.js"></script>
  <!-- select2 -->
  <script src="./assets/plugins/select2/select2.min.js?<?php echo time(); ?>"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.js"></script> -->

  <script>
    // Handle Select2 Dropdowns


      $(document).ready(function() {
          $('.select2me').select2();
      });

  </script>

  <!-- page script -->
  <?php if (isset($page_script)) { ?>

    <?php echo $page_script; ?>

  <?php } ?>
  <!-- end page script -->

  <?php if ($active == "profile"){ ?>

    <!-- datepicker -->
    <script src="./assets/plugins/datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="./assets/plugins/datepicker/locales/bootstrap-datepicker.ka.min.js"></script>

    <script>

      $('.date-input').datepicker({format: 'yyyy-mm-dd',autoclose: true,language: 'ka'});
      $.fn.datepicker.defaults.language = 'ka';

    </script>
    <!-- datepicker -->

  <?php } ?>

  <script>
    // notification
    <?php
      if (isset($_COOKIE['alert_status']) && isset($_COOKIE['alert_msg'])) {
        switch ($_COOKIE['alert_status']) {
          case "info":
              echo "toastr.info('".$_COOKIE['alert_msg']."');";
              break;
          case "success":
              echo "toastr.success('".$_COOKIE['alert_msg']."');";
              break;
          case "danger":
              echo "toastr.danger('".$_COOKIE['alert_msg']."');";
              break;
          case "error":
              echo "toastr.error('".$_COOKIE['alert_msg']."');";
              break;
          default:
              echo "toastr.info('".$_COOKIE['alert_msg']."');";
          }
      }
     ?>
  </script>

  </body>
</html>
