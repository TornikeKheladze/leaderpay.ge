<?php

    require 'classes/Billing.php';
    $Billing = new Billing($db, 'Wallet');
?>
<div class="title clear-after">
  <?php echo $lang['cash_withdrawal']; ?>
</div>
<div class="sub-page-body tb clear-after">

  <ul class="tabs long clear">
    <li class="tab_last <?php if(!isset($get['tab']) OR $get['tab'] == '' OR empty($get['tab'])){ echo 'active'; } ?>" rel="tab1">APW სალაროებში</li>
    <li rel="tab2" class="tab_last <?php if(isset($get['tab']) AND $get['tab'] == 'banks'){ echo 'active'; } ?>">ბანკებში</li>
    <li rel="tab3" class="tab_last <?php if(isset($get['tab']) AND $get['tab'] == 'wallets'){ echo 'active'; } ?>">ელექტრონულ საფულეებში</li>
  </ul>
  <div class="tab_container">
    <div id="tab1" class="tab_content clear" style="<?php if(!isset($get['tab']) OR $get['tab'] == '' OR empty($get['tab'])){ echo 'display: block;'; } ?>">

    <?php

      $cashboxs = $db->get_unlimited_list('agent_cashbox',' `status` = 2', "city", "ASC");

      if ($cashboxs != false) { ?>

        <?php foreach ($cashboxs as $box) { ?>

          <h3></h3>
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

    </div><!-- .tab_1 -->
    <div id="tab2" class="tab_content clear" style=" <?php if(isset($get['tab']) AND $get['tab'] == 'banks'){ echo 'display: block;'; } ?>">

      <?php

          $services_lst = $Billing->services();

          // to uppercase lang id for service
          $langs = strtoupper($lang_id);

          if (!empty($services_lst['services'])) {

            foreach ($services_lst['services'] as $service) {

              /// service type
              $type = $db->get_date("service_options"," `service_id` = '".$service['id']."' ");

              if (!$type OR $type['type_id'] != 2) {
                continue;
              }

                ?>

                <div class="p-list clear">
                  <a href="pay.php?step=1&id=<?php echo $service['id']; ?>">
                    <div class="col-md-1">
                      <div class="c-image" style="background: url('https://uploads.allpayway.ge/files/services/<?php echo $service['image']; ?>') no-repeat center center"></div>
                    </div>
                    <div class="col-md-6">
                      <h5><?php echo $service['lang'][$langs]; ?></h5>
                      <p>თანხის გადატანა <?php echo $service['lang'][$langs]; ?>-ზე</p>
                    </div>
                    <div class="col-md-2">
                      <!-- <span>0%</span> -->
                    </div>
                    <div class="col-md-3 text-right">
                      <a href="pay.php?step=1&id=<?php echo $service['id']; ?>" class="btn btn-gradiet"><?php echo $lang['check']; ?></a>
                    </div>
                  </a>
                </div> <!-- End p-list -->

                <?php


            } // end foreach


          } // end services check


       ?>

    </div><!-- .tab_2 -->
    <div id="tab3" class="tab_content clear" style=" <?php if(isset($get['tab']) AND $get['tab'] == 'wallets'){ echo 'display: block;'; } ?>">
      <div class="content-infos">
        <div class="col-md-12 text-left">

          <?php

              $services_lst = $Billing->services();

              // to uppercase lang id for service
              $langs = strtoupper($lang_id);

              if (!empty($services_lst['services'])) {

                foreach ($services_lst['services'] as $service) {

                  /// service type
                  $type = $db->get_date("service_options"," `service_id` = '".$service['id']."' ");

                  if (!$type OR $type['type_id'] != 3) {
                    continue;
                  }


                    ?>

                    <div class="p-list clear">
                      <a href="pay.php?step=1&id=<?php echo $service['id']; ?>">
                        <div class="col-md-1">
                          <div class="c-image" style="background: url('https://uploads.allpayway.ge/files/services/<?php echo $service['image']; ?>') no-repeat center center"></div>
                        </div>
                        <div class="col-md-6">
                          <h5><?php echo $service['lang'][$langs]; ?></h5>
                          <p>თანხის გადატანა <?php echo $service['lang'][$langs]; ?>-ზე</p>
                        </div>
                        <div class="col-md-2">
                          <!-- <span>0%</span> -->
                        </div>
                        <div class="col-md-3 text-right">
                          <a href="pay.php?step=1&id=<?php echo $service['id']; ?>" class="btn btn-gradiet"><?php echo $lang['check']; ?></a>
                        </div>
                      </a>
                    </div> <!-- End p-list -->

                    <?php


                } // end foreach


              } // end services check


           ?>

        </div>
      </div>
    </div><!-- .tab_3 -->
  </div><!-- .tab_container -->

</div>
