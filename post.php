
<?php
  $active = 'post';

  require_once('includes/head.php');

  if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    $post = $db->get_date("news"," `id` = '".$id."' ");

    // view update
    if ($cookie::check('news_view') != true || $cookie::get('news_view') != $id) {

      $params = array(
          "views" => $post['views'] + 1
      );

      $view = $db->update("news", $params, $id);

      if ($view === true) {

        $cookie::set("news_view", $id, time()+100000000);

      }


    } // cookie exist check


    if ($post === false) {

       header('Location:index.php');

    }

  } else {

    header('Location:index.php');

  }

  include 'includes/header.php';


?>

  <div class="container page">

    <div class="row">
      <div class="col-md-12">
        <div class="page-bg clear">
          <div class="text">
            <h3 class="page-title">
              <span class="t">
                <?php

                  echo $post['title_'.$lang_id];

                  $date = new DateTime($post['date']);

                 ?>
              </span>
              <div class="title-tols clear">
                <div class="tol-item" title="გამაქვეყნების თარიღი">
                  <span><i class="fa fa-calendar"></i>  <?php echo $date->format('Y-m-d'); ?></span>
                </div>
                <div class="tol-item" title="ნახვების რაოდენობა">
                  <span><i class="fa fa-eye"></i> <?php echo $post['views']; ?></span>
                </div>
              </div>
            </h3>
            <div class="b-t">

              <?php if ($post['image'] != "") { ?>

                <img src="http://uploads.allpayway.ge/files/news/<?php echo $post['image']; ?>" class="img-responsive" alt="<?php echo $post['title_'.$lang_id]; ?>">


              <?php } else { ?>

                <img src="http://www.placehold.it/700x400/f8faff/828282&text=NO+IMAGE" class="img-responsive" alt="<?php echo $post['title_'.$lang_id]; ?>">


              <?php } ?>

              <div class="post-des">

                <?php

                 echo $post['txt_'.$lang_id];

                 ?>

              </div>

            </div>
          </div>
          <a href="news.php" class="g-back">
              <img src="assets/img/more.png" alt=""><span>იხილე ყველა სიახლე</span>
          </a>
        </div> <!-- end page-bg -->
      </div><!-- end col -->
    </div><!-- end row -->


  </div><!-- end container -->

<?php

  $page_script = '<script src="assets/pages/coment.js"></script>';

  include 'includes/footer.php';
?>
