<?php
require '../classes/billing.php';
require '../classes/config.php';
require '../classes/db.php';

$billing = new billing();
$db = new db();

if ($db->check_auch() == true) {

  // get user info
  $username = $_SESSION["user_name"];
  $token = $_SESSION["token"];
  $user = $db->get_date("users"," `personal_number` = '".$username."' AND `token` = '".$token."' ");

} else {

  $user['id'] = 0;

}


if (isset($get['id'])) {

  $id = intval($get['id']);


  if (isset($get['subcat']) AND $get['subcat'] != 0) {

    $sub_id = intval($get['subcat']);

  }


  if (isset($get['lang_id'])) {

    $lang_id = mb_strtoupper($get['lang_id']);

  }
  $services = $billing->get("category",$id);


  ?>

  <div class="service_result clear">

    <div class="col-md-12 sub_cat_list clear">

    <?php


    $sub_categories = $db->get_unlimited_list("sub_categories"," `parent_id` = '".$id."' AND `is_deleted` = '0' ","sort","DESC");

    if ($sub_categories) {

      foreach ($sub_categories as $subcat) {

        $s_l_i = strtolower($lang_id);


        ?>

          <div class="sub_cat_item clear <?php if($get['subcat'] == $subcat['id']) {echo "active";} ?>" rel="<?php echo $subcat['id']; ?>" parent="<?php echo $get['id']; ?>">
           <img src="http://uploads.allpayway.ge/files/categories/<?php echo $subcat['image']; ?>" alt="sub-cat">
            <h5><?php echo $subcat['name_'.$s_l_i]; ?></h5>
          </div> <!--end sub_cat_item -->

      <?php

      } // end foreach

    } // end if


    ?>
    </div> <!--end sub_cat_list -->
    <?php


  if (!empty($services['services'])) {

    foreach ($services['services'] as $service) {

      if ($service['id'] == 46) {
        continue;
      }

      // hidden subs
      $subs = $db->get_unlimited_list("sub_categories"," `parent_id` = '".$id."' AND `is_deleted` = '0' ","sort","DESC");

      if ($subs) {

        $sub_services_arr = array();

        // foreach
        foreach ($subs as $sub) {


          $sub_services_arr[] = $sub['services'];

        }


        //
        if (isset($sub_id)) {

          if (strpos($sub_services_arr['0'],",")) {

            $sub_services = explode(",",$sub_services_arr['0']);

            if (!in_array($service['id'], $sub_services)) {
              continue;
            }


          } else {


            if (!in_array($service['id'], $sub_services_arr)) {
              continue;
            }

            $sss = $db->get_unlimited_list("sub_categories"," `parent_id` = '".$id."' AND `is_deleted` = '0' AND `id` = '".$sub_id."' ","sort","DESC");


            if ($service['id'] != $sss[0]['services']) {
              continue;
            }

          }


        } else {

          if (strpos($sub_services_arr['0'],",")) {

            $sub_services = explode(",",$sub_services_arr['0']);

            if (in_array($service['id'], $sub_services)) {
              continue;
            }


          } else {

            if (in_array($service['id'], $sub_services_arr)) {
              continue;
            }

          }


        }


      }


      /// service tupe
      $type = $db->get_date("service_options"," `service_id` = '".$service['id']."' ");

      if ($type) {

        if ($type AND $type['type_id'] == 1) {

          $url = 'profile.php?action=pay&id='.$service['id'];


        } elseif($type AND $type['type_id'] == 2) {

          $url = 'profile.php?action=cashout&tab=banks';

        } elseif($type AND $type['type_id'] == 3) {

          $url = 'profile.php?action=cashout&tab=wallets';

        } else {

          $url = 'profile.php?action=pay&id='.$service['id'];

        }

      } else {

        $url = 'profile.php?action=pay&id='.$service['id'];

      }



      ?>

      <div class="s-cov" title="<?php echo $service['lang'][$lang_id]; ?>">
        <a href="<?php echo $url; ?>" class="<?php if ($db->check_auch() === false) {echo "check_uath";} ?>">
          <div class="serv-item">
            <?php
                if ($db->get_date("favorites"," `user_id` = '".$user['id']."' AND `service_id` = '".$service['id']."' ") === false) {
                  ?>
                  <div class="fov_palce_<?php echo $service['id']; ?>">
                    <div class="add-f" title="ფავორიტებში დამატება" logo="<?php echo $service['image']; ?>" rel="<?php echo $service['id']; ?>" is="0"></div>
                  </div>
                  <?php
                } else {
                  ?>
                  <div class="fov_palce_<?php echo $service['id']; ?>">
                    <div class="remove-f" title="ფავორიტებიდან წაშლა" rel="<?php echo $service['id']; ?>" is="0"></div>
                  </div>
                  <?php
                }
             ?>
            <img src="https://uploads.allpayway.ge/files/services/<?php echo $service['image']; ?>" alt="<?php echo $service['lang'][$lang_id]; ?>" class="responsive">
            <div class="hide tit">
              <?php echo $service['lang'][$lang_id]; ?>
            </div>
          </div>
        </a>
      </div>

      <?php

    } // end foreach

    ?>

    <?php

  } else {

    ?>
    <div class="service_result clear">
      <div class="no-found">
        <img src="assets/img/not.png" style="max-width: 40px;" alt="no found">
        <span>სია ცარიელია</span>
      </div>
    </div>

    <?php

  }
  ?>

</div><!-- end service_result -->

  <?php


} // end get check
