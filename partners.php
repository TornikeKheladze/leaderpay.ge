
<?php

  require_once('includes/head.php');

  //
  $active = 'partners';
  $page_title = $lang['partners'];

  include 'includes/header.php';

  $partners = $db->get_unlimited_list('partners',' `id` > 0', "sort", "ASC");

?>

  <div class="container page">

    <div class="row">
      <div class="col-md-12">
        <div class="page-bg fluid partners-full clear">
          <h3 style = "text-align: center;">
            <?php echo $lang['partners']; ?>
          </h3>
          <div class="underline"></div>

          <?php if ($partners != false){ ?>

            <?php foreach ($partners as $partner) {

              ?>

              <div class="p-item" style="background: #fff url('http://uploads.allpayway.ge/files/partners/<?php echo $partner['image']; ?>') no-repeat center center">
                 <span><?php echo $partner['title_'.$lang_id]; ?></span>
               </div>


            <?php } ?>

          <?php } else { ?>

            <div class="no-found">
              <img src="assets/img/not.png" alt="no found">
              <span><?php echo $lang['list_is_empty']; ?></span>
            </div>

          <?php }  ?>


        </div> <!-- end page-bg -->
      </div><!-- end col -->
    </div><!-- end row -->

  </div><!-- end container -->

<?php
  include 'includes/footer.php';
?>
