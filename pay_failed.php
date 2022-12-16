<?php

    require_once('includes/head.php');

    if (isset($get['operation_id']) && isset($get['hash'])) {

        $token = htmlspecialchars(trim($get['operation_id']), ENT_QUOTES);
        $operation_id = htmlspecialchars(trim($get['hash']), ENT_QUOTES);

    } else {

        die();
    }

    $operation = $db->get_date('apw_operations', "token = '$token' AND status_id = 1");

    if ($operation != false) {

        $currentDate = $db->get_current_date();

        $db->update('apw_operations', ['status_id' => 2, 'merchant_opeartion_id' => $operation_id, 'canceled_at' => $currentDate, 'updated_at' => $currentDate], $operation['id']);
        // $db->getSql("UPDATE `user_payments` SET `status_id` = '3', `updated_at` = '$currentDate'  WHERE `operation_id` = '$operation[id]'");

        // insert log
        $params = [
            'token' => $token,
            'method' => 'Failed',
            'request' => json_encode(['token' => $token, 'operation_id' => $operation_id], JSON_UNESCAPED_UNICODE),
            'response' => 'გადახდა ვერ შესრულდა',
            'ip' => $db->getClientIp(),
        ];
        $db->insert('apw_logs', $params);

    } else {
        die();
    }

    $lng = strtoupper($lang_id);
    $page_title = 'გადახდა ვერ შესრულდა';
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
                            <h5>გადახდა ვერ შესრულდა</h5>
                            <span style="font-size: 10px;">სამწუხაროდ თქვენი გადახდა ვერ შესრულდა. გთხოვთ, დაუკავშირდეთ თქვენს მომსახურე ბანკს.</span>
                            <hr>
                            <a href="services.php" class="g1-btn"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> უკან დაბრუნება</a>
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
