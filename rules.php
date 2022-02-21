<?php
  require_once('includes/head.php');

  $active = 'wallet_rules';
  $page_title = $lang['wallet_rules'];

  include 'includes/header.php';

  $wallet_rules = $db->get_date("content", " `id` = 3 ");
?>

<div class="container page">
  <div class="row">
    <div class="col-md-12">
      <div class="page-bg clear">
        <div class="text">
          <h3 style = "text-align: center">
              <?php echo $wallet_rules['title']; ?>
          </h3>
          <div class="underline"></div>
          <?php if ($wallet_rules != false) { ?>
            <p><?php echo $wallet_rules['text']; ?></p>
          <?php } else { ?>
            <div class="msg msg-error">
              <?php echo $lang['list_is_empty']; ?>
              <div class="close-p msg-colose" rel="#"></div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div><!-- end col -->
  </div><!-- end row -->

</div><!-- end container -->

<?php
  include 'includes/footer.php';
?>
