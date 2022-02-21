
<?php
  require_once('includes/head.php');

  $active = 'about_us';
  $page_title = $lang['about_us'];

  include 'includes/header.php';

  $about = $db->get_date("content", " `id` = 1 ");
?>
<div class="container page">
  <div class="row">
    <div class="col-md-12">
      <div class="page-bg clear">
        <div class="post-des">
          <?php if ($about != false) { ?>
            <h3 class = "title">
              <!-- <span class="t"><?php echo $about['title']; ?></span> -->
              <?php echo $about['title']; ?>
            </h3>
            <div class="underline"></div>
            <div class = "text">
              <p><?php echo $about['text']; ?></p>
            <?php } else { ?>
            </div>
            <div class="msg msg-error">
              <?php echo $lang['list_is_empty']; ?>
              <div class="close-p msg-colose" rel="#"></div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
  include 'includes/footer.php';
?>
