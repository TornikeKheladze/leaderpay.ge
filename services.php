
<?php

  require_once('includes/head.php');

  //
  $active = 'services';
  $page_title = $lang['payment_services'];

  include 'includes/header.php';

?>


  <div class="service_list service-page" id="services">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-right col-xs-text-center">
          <!-- <div class="top-btns">
            <a href="#" class="item"><img src="assets/img/favorite.png?1" alt=""> ფავორიტები</a>
            <a href="#" class="item"><img src="assets/img/top.png?1" alt=""> პოპულარული</a>
            <a href="#" class="item"><img src="assets/img/new.png?1" alt=""> ახალი</a>
          </div> -->
          <div class="serv-search-btn" title="სერვისის ძებნა"  style="display:none;"></div>
          <div class="ser-search-box">
            <form class="search" action="" method="post" id="Search">
              <div class="icon">
              </div>
              <input autocomplete="off" type="text" class="serach-inp" id="service_search_input" name="search" placeholder="<?php echo $lang['search_service']; ?>">
              <button type="submit" name="search" class="service-search-btn btn-icon"><img src="assets/img/magnifer1.png" alt="lang"></button>
            </form>
            <div class="service-search-result text-left">

              <?php

                  $services_lst = $billing->get("services",null);

                  // to uppercase lang id for service
                  $langs = strtoupper($lang_id);

                  foreach ($services_lst['services'] as $service) {

                    if ($service['id'] == 46) {
                      continue;
                    }

                      ?>

                      <a class="service-search-item none" alt="<?php echo $service['lang']['GE']; ?>, <?php echo $service['lang']['EN']; ?>, <?php echo $service['lang']['RU']; ?>" title="<?php echo $service['lang'][$langs]; ?>" href="pay.php?id=<?php echo $service['id']; ?>">
                        <div class="inline-block">
                          <div class="item-image" style="background-image: url('http://uploads.allpayway.ge/files/services/<?php echo $service['image']; ?>');">
                          </div>
                          <strong><?php echo $service['lang'][$langs]; ?></strong>
                        </div>
                      </a><!-- end search item -->

                      <?php

                  } // end foreach

               ?>

              <strong class="none service_no_found"><?php echo $lang['service_no_found']; ?></strong>
              <!-- <div class="service-search-loading">
                <img src="assets/img/loading.gif" alt="">
              </div> -->
            </div>
          </div>
        </div><!-- end col -->
      </div><!-- end row -->

      <div class="row">
        <div class="col-md-12">
          <div class="lst">

            <?php

              $categoryes = $billing->get("categories",null);

              //var_dump($categoryes);

              if (!empty($categoryes['categories'])) {

                foreach ($categoryes['categories'] as $categorye) {

                   ?>

                   <div class="service-item box-shadow1" rel="<?php echo $categorye['id']; ?>" title="<?php echo $categorye['name_'.$lang_id]; ?>" lang="<?php echo $lang_id; ?>">
                     <div class="service-cat-bg" style="background: url('http://uploads.allpayway.ge/files/categories/<?php echo $categorye['image']; ?>') no-repeat top center">
                     </div>
                     <h3 class=""><?php echo $categorye['name_'.$lang_id]; ?></h3>
                     <span class="count-service"><?php echo $categorye['count']; ?></span>
                   </div><!-- end service-item -->

                   <?php

                } //end foreach

              } // end if


             ?>

          </div><!-- end lst -->
        </div><!-- end col -->
      </div><!-- end row -->
    </div><!-- end container -->
  </div><!-- end service_list -->
<?php
  include 'includes/footer.php';
?>
