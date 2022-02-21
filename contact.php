
<?php

  require_once('includes/head.php');

  //
  $active = 'contact';
  $page_title = $lang['contact'];

  include 'includes/header.php';

  $cashboxs = $db->get_unlimited_list('agent_cashbox',' `status` = 2', "city", "ASC");

  $contact = $db->get_date("contact", " `id` = 1 ");

?>

  <div class="container page">

    <div class="row">
      <div class="col-md-12">
        <div class="sa clear">

          <ul class="tabs long clear">
            <li class="tab_last active" rel="tab1"><?php echo $lang['our_cash_boxes_on_map']; ?></li>
            <li rel="tab2" class="tab_last"><?php echo $lang['cash_boxes_list']; ?></li>
            <li rel="tab3" class="tab_last"><?php echo $lang['contact_information']; ?></li>
          </ul>
          <div class="tab_container">
            <div id="tab1" class="tab_content clear" style="display: none;">
              <h3 class="page-title">
                <span class="t r"><?php echo $lang['our_cash_boxes_on_map']; ?></span>
              </h3>
              <div id="map"></div>
            </div><!-- .tab_1 -->
            <div id="tab2" class="tab_content clear" style="display: none;">
              <h3 class="page-title">
                <span class="t r"><?php echo $lang['our_cash_boxes_list']; ?></span>
              </h3>

              <?php if ($cashboxs != false) { ?>

                <?php foreach ($cashboxs as $box) { ?>


                  <div class="sa-item col-md-4">
                    <h5><?php echo $box['city']; ?></h5>
                    <div class="sa-text">
                      <div class="row t">
                        <div class="col-md-2">
                          <i class='fa fa-map-marker'></i>
                        </div>
                        <div class="col-md-10">
                          <p><?php echo $box['address']; ?></p>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-2">
                          <i class='fa fa-clock-o'></i>
                        </div>
                        <div class="col-md-10">
                           <p><?php echo $box['work']; ?></p>
                        </div>
                      </div>
                    </div><!-- end sa-text -->
                  </div><!-- end sa-item -->

                <?php }// end foreach ?>

              <?php } else { // end if ?>

                <div class="no-found">
                  <img src="assets/img/not.png" alt="no found">
                  <span><?php echo $lang['list_is_empty']; ?></span>
                </div>

              <?php } ?>

            </div><!-- .tab_2 -->
            <div id="tab3" class="tab_content clear" style="display: none;">
              <h3 class="page-title">
                <span class="t r"><?php echo $lang['contact_information']; ?></span>
              </h3>
              <div class="content-infos">
                <div class="col-md-12 text-left">

                  <?php if ($contact != false) { ?>

                    <div class="map-c-item ">
                      <a href="#">
                        <p>
                          <img src="assets/img/marker.png?" alt="">
                          <span><?php echo $contact['address']; ?></span>
                        </p>
                      </a>
                    </div>
                    <div class="map-c-item ">
                      <a href="tel:<?php echo $contact['phone']; ?>">
                        <p>
                          <img src="assets/img/call.png" alt="">
                          <span><?php echo $contact['phone']; ?></span>
                        </p>
                      </a>
                    </div>
                    <div class="map-c-item ">
                      <a href="mailto:<?php echo $contact['email']; ?>">
                        <p>
                          <img src="assets/img/email.png" alt="">
                          <span><?php echo $contact['email']; ?></span>
                        </p>
                      </a>
                    </div>
                    <div class="map-c-item ">
                      <a href="http://apw.ge" target="_blank">
                        <p>
                          <img src="assets/img/mweb.png" alt="">
                          <span> www.apw.ge</span>
                        </p>
                      </a>
                    </div>

                  <?php } else { ?>

                    <div class="msg msg-error">
                      <?php echo $lang['list_is_empty']; ?>
                      <div class="close-p msg-colose" rel="#"></div>
                    </div>

                  <?php } ?>

                </div>
                <div class="clear"></div>
              </div>
            </div><!-- .tab_3 -->
          </div><!-- .tab_container -->

        </div><!-- end sa -->
      </div><!-- end col -->
    </div><!-- end row -->

  </div><!-- end container -->

    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWtMHpIG8SVizr6nUfqHWeKeJhzrJkv3E"></script>

    <?php if ($cashboxs != false) { ?>

      <script>

      var locations = [

        <?php foreach ($cashboxs as $box) { ?>

          <?php $image  = ($box['image'] != '') ? $box['image'] : 'assets/img/no_img.png' ; ?>

              ["<div class='map_m clear'>"+
                "<div class='col-md-4 left'>"+
                  "<img style='max-width: 100%' src='<?php echo $image ?>'>"+
                "</div>"+
                "<div class='col-md-8 right'>"+
                  "<p>"+
                    "<i class='fa fa-map-marker'></i> <b><?php echo $box['city']; ?></b>, <?php echo $box['address']; ?>"+
                  "</p>"+
                  "<p>"+
                    "<i class='fa fa-clock-o'></i> <?php echo $box['work']; ?>"+
                  "</p>"+
                "</div>"+
              "</div>", <?php echo $box['lat']; ?>, <?php echo $box['lng']; ?>, 4],

          <?php } ?>

            ];

      </script>

    <?php } ?>


    <script>

      var markers = [];
      function initialize() {
         var latLng = new google.maps.LatLng(42.0746698,43.6905859);
         var map = new google.maps.Map(document.getElementById('map'), {
         zoom: 7,
         center: latLng,
         mapTypeId: google.maps.MapTypeId.ROADMAP
         });

        var infowindow = new google.maps.InfoWindow();

       var marker, i;

       for (i = 0; i < locations.length; i++) {
         marker = new google.maps.Marker({
         position: new google.maps.LatLng(locations[i][1], locations[i][2]),
         map: map,
         icon : 'assets/img/marker.png?1'
         });
         markers.push(marker);

         google.maps.event.addListener(marker, 'click', (function(marker, i) {
         return function() {
           infowindow.setContent(locations[i][0]);
           infowindow.open(map, marker);
         }
         })(marker, i));

         // google.maps.event.addListener(marker, 'mouseout', (function(marker, i) {
         // return function() {
         //   infowindow.close(map, marker);
         // }
         // })(marker, i));
       }

       // var markerCluster = new MarkerClusterer(map, markers,
       //         {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m',maxZoom: 20,gridSize: 20});
      }

      // Onload handler to fire off the app.
      google.maps.event.addDomListener(window, 'load', initialize);

    </script>

  <?php
    include 'includes/footer.php';
  ?>
