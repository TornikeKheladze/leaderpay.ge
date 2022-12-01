<?php
    require '../classes/Billing.php';
    require '../classes/config.php';
    require '../classes/db.php';

    $db = new db();
    $Billing = new Billing($db, 'Wallet');

    if (isset($get['id'])) {

        $id = (INT) $get['id'];

        if (isset($get['subcat']) AND $get['subcat'] != 0) {

            $sub_id = (INT) $get['subcat'];

        }
        if (isset($get['lang_id'])) {

            $lang_id = htmlspecialchars(mb_strtoupper($get['lang_id']), ENT_QUOTES);

        }
        $services = $Billing->byCategory($id); ?>

        <div class="service_result clear">
            <div class="col-md-12 sub_cat_list clear">

                <?php

                $sub_categories = $db->get_unlimited_list('sub_categories', " `parent_id` = '$id' AND `is_deleted` = '0' ", 'sort', 'DESC');

                if ($sub_categories) {

                    foreach ($sub_categories as $subcat) {

                        $s_l_i = strtolower($lang_id); ?>

                        <div class="sub_cat_item clear <?=($sub_id == $subcat['id']) ? 'active' : '' ?>" rel="<?=$subcat['id'] ?>" parent="<?=$id ?>">
                            <img src="http://uploads.allpayway.ge/files/categories/<?=$subcat['image'] ?>" alt="sub-cat">
                            <h5><?=$subcat['name_'.$s_l_i] ?></h5>
                        </div>

                    <?php }
                } ?>
            </div>
            <?php

            if (!empty($services['services'])) {

                foreach ($services['services'] as $service) {

                    if ($service['id'] == 46) {
                        continue;
                    }

                    // hidden subs
                    $subs = $db->get_unlimited_list('sub_categories', " `parent_id` = '$id' AND `is_deleted` = '0' ", 'sort', 'DESC');

                    if ($subs) {

                        $sub_services_arr = [];
                        foreach ($subs as $sub) {

                            $sub_services_arr[] = $sub['services'];

                        }

                        if (isset($sub_id)) {

                            if (strpos($sub_services_arr['0'],',')) {

                                $sub_services = explode(',', $sub_services_arr['0']);

                                if (!in_array($service['id'], $sub_services)) {
                                    continue;
                                }

                            } else {

                                if (!in_array($service['id'], $sub_services_arr)) {
                                    continue;
                                }

                                $sss = $db->get_unlimited_list('sub_categories'," `parent_id` = '$id' AND `is_deleted` = '0' AND `id` = '$sub_id' ", 'sort', 'DESC');

                                if ($service['id'] != $sss[0]['services']) {
                                    continue;
                                }

                            }

                        } else {

                            if (strpos($sub_services_arr['0'],',')) {

                                $sub_services = explode(',', $sub_services_arr['0']);

                                if (in_array($service['id'], $sub_services)) {
                                    continue;
                                }

                            } else {

                                if (in_array($service['id'], $sub_services_arr)) {
                                    continue;
                                }

                            }

                        }

                    } ?>

                    <div class="s-cov" title="<?=$service['lang'][$lang_id] ?>">
                        <a href="pay.php?step=1&id=<?=$service['id'] ?>">
                            <div class="serv-item">
                                <img src="https://uploads.allpayway.ge/files/services/<?=$service['image'] ?>" alt="<?=$service['lang'][$lang_id] ?>" class="responsive">
                                <div class="hide tit"><?=$service['lang'][$lang_id] ?></div>
                            </div>
                        </a>
                    </div>

                <?php }

            } else { ?>
                <div class="service_result clear">
                    <div class="no-found">
                        <img src="assets/img/not.png" style="max-width: 40px;" alt="no found">
                        <span>სია ცარიელია</span>
                    </div>
                </div>

            <?php } ?>

        </div>
    <?php }
