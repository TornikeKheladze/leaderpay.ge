
<?php
  require_once('includes/head.php');

  $active = 'privacy';
  $page_title = $lang['privacy_and_security'];

  include 'includes/header.php';

  $secure = $db->get_date("content", " `id` = 5 ");
?>

  <div class="container page">
    <div class="row">
      <div class="col-md-12">
        <div class="page-bg clear">
          <div class="text">
            <?php if ($secure != false) { ?>
              <h3 style = "text-align: center">
                <?php echo $secure['title']; ?>
              </h3>
              <div class="underline"></div>
              <p><?php echo $secure['text']; ?></p>
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
