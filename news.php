
<?php
  require_once('includes/head.php');

  $active = 'news';
  $page_title = $lang['news'];

  include 'includes/header.php';

  $news = $db->get_unlimited_list('news',' `id` > 0', "date", "DESC");
?>

  <div class="container page">
    <div class="row">
      <div class="col-md-12">
        <div class="page-bg fluid clear">
          <h3 style ="text-align: center">
            <?php echo $lang['news']; ?>
          </h3>
          <div class="underline" style = "margin-bottom: 10px"></div>
          <?php if ($news != false){ ?>
            <?php foreach ($news as $new) {
               $date = new DateTime($new['date']);
              ?>

              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="post-module url" data-url="post.php?id=<?php echo $new['id']; ?>">
                  <!-- Thumbnail-->
                  <div class="thumbnail">
                    <div class="date">
                      <div class="day"><?php echo $date->format('d'); ?></div>
                      <div class="month">
                        <?php
                          echo  mb_substr($month_array[$date->format('m')][$lang_id],0,4,"utf-8");
                         ?>
                      </div>
                     </div>

                     <?php if ($new['image'] != "") { ?>
                       <img src="http://uploads.allpayway.ge/files/news/<?php echo $new['image']; ?>" class="img-responsive" alt="<?php echo $new['title_'.$lang_id]; ?>">
                     <?php } else { ?>
                       <img src="http://www.placehold.it/500x300/f8faff/828282&text=NO+IMAGE" class="img-responsive" alt="<?php echo $new['title_'.$lang_id]; ?>">
                     <?php } ?>
                    </div>
                    <!-- Post Content-->
                    <div class="post-content">
                      <!--<div class="category">სიახლეები</div>-->
                      <h1 class="title"><?php echo $new['title_'.$lang_id]; ?></h1>
                      <div class="description">
                        <?php echo strip_tags(mb_substr($new['txt_'.$lang_id],0,120,"utf-8")); ?>
                      </div>
                      <div class="post-meta">
                        <span class="timestamp"><i class="fa fa-clock-o"></i> <?php echo $date->format('Y-m-d'); ?></span>
                        <span class="comments"><i class="fa fa-eye"></i><a href="#"> <?php echo $new['views']; ?> ნახვების რაოდენობა</a></span>
                      </div>
                  </div>
                </div><!-- end post-module -->
              </div><!-- end col -->


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
