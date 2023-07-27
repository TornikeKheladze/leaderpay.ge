<?php

    require_once('includes/head.php');

    if ($db->check_auch() === false) {

        header('Location: https://leaderpay.ge');

    }

    // insert log
    $logParams = [
        'method' => 'FaileRequest',
        'request' => json_encode($get, JSON_UNESCAPED_UNICODE),
        'response' => 'შეცდომა',
        'ip' => $db->getClientIp(),
    ];
    $db->insert('card_logs', $logParams);

//    if (isset($get['o_operation_id']) && isset($get['o_order_id'])) {
//
//        $card_id = htmlspecialchars(trim($get['o_operation_id']), ENT_QUOTES);
//        $personal_number = htmlspecialchars(trim($get['o_order_id']), ENT_QUOTES);
//
//    } else {
//
//        die();
//    }
//
//    $card = $db->get_date('cards', "card_id = '$card_id' AND personal_number = '$personal_number'");
//
//    if ($card == false) {
//        die();
//    }

    $lng = strtoupper($lang_id);
    $page_title = 'ოპერაცია ვერ შესრულდა';
    $active = '';

    include 'includes/header.php';

?>
<div class="service_list service-page" id="services">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div style="background: #fff; border-radius: 2px; box-shadow: 0 1px 1px #dad2d2; padding: 30px; height: 40vh;">

                    <div style="padding: 20px; max-width: 400px; margin: 0 auto; border: 1px solid #f3f3f3;">
                        <img src="assets/img/warning.png" alt="">
                        <h5>ოპერაცია ვერ შესრულდა</h5>
                        <span style="font-size: 10px;">სამწუხაროდ ოპერაცია ვერ შესრულდა. გთხოვთ, დაუკავშირდეთ ადმინისტრაციას.</span>
                        <hr>
                        <a href="profile.php?action=withdraw" class="g1-btn"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> უკან დაბრუნება</a>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end service_list -->

<?php
    include 'includes/footer.php';
?>
