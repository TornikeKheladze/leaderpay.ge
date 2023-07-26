<?php

    require_once('includes/head.php');

    // insert log
    $logParams = [
        'method' => 'SuccessRequest',
        'request' => json_encode($get, JSON_UNESCAPED_UNICODE),
        'response' => 'წარმატებული რექვესტი',
        'ip' => $db->getClientIp(),
    ];
    $db->insert('card_logs', $logParams);

    if (isset($get['operation_id']) && isset($get['order_id']) && isset($get['amount'])) {

        $card_id = htmlspecialchars(trim($get['o_operation_id']), ENT_QUOTES);
        $personal_number = htmlspecialchars(trim($get['o_order_id']), ENT_QUOTES);
        $amount = (intval($get['amount']) / 100);

        $card_number = htmlspecialchars(trim($get['p_maskedPan']), ENT_QUOTES);
        $card_type = htmlspecialchars(trim($get['p_paymentSystem']), ENT_QUOTES);
        $card_expiry = htmlspecialchars(trim($get['p_expiry']), ENT_QUOTES);

    } else {

        die();

    }

    $card = $db->get_date('cards', "card_id = '$card_id' AND personal_number = '$personal_number'");

    if ($card != false) {

        $currentDate = $db->get_current_date();

        $db->update('cards', ['type' => $card_type, 'name' => $card_number, 'expiry' => $card_expiry, 'status_id' => 1, 'updated_at' => $currentDate], $card['id']);

        // insert operation
        $operationParams = [
            'type_id' => 1,
            'card_id' => $card['id'],
            'wallet_number' => $card['personal_number'],
            'amount' => $amount,
            'commision' => 0,
            'currency' => 981,
            'status_id' => 2,
        ];
        $operationId = $db->insert('card_operations', $operationParams);

        // unicdate
        list($usec, $sec) = explode(' ', substr(microtime(), 2));
        $unicdate = $sec . $usec;

        // update balance
        $balance = $db->getSql("SELECT SUM(credit) - SUM(debt) AS balance FROM `user_balance_history` WHERE `personal_number` = '$personal_number' AND `currency_id` = '981'");

        $newBalance = $balance['balance'] + $amount;
        $db->getSql("UPDATE `users` SET `balance` = '$newBalance' WHERE `personal_number` = '$personal_number'");

        // insert balance history
        $history_params = [
            'personal_number' => $personal_number,
            'operation_id' => $operationId,
            'credit' => $amount,
            'debt' => 0,
            'type_id' => 14,
            'date' => $currentDate,
            'unicdate' => $unicdate,
            'balance' => $newBalance,
            'description' => 'ბარათის ვერიფიკაციიდან მიღებული თანხა',
            'agent_id' => 1,
            'agent' => 2,
        ];
        $db->insert('user_balance_history', $history_params);

        // insert log
        $logParams = [
            'method' => 'SuccessBinding',
            'request' => json_encode($get, JSON_UNESCAPED_UNICODE),
            'response' => 'ბარათის წარმატებით მიბმა',
            'ip' => $db->getClientIp(),
        ];
        $db->insert('card_logs', $logParams);

    } else {
        die();
    }

    $lng = strtoupper($lang_id);
    $page_title = 'გადახდა წარმატებით დასრულდა';
    $active = '';

    include 'includes/header.php';

?>
<div class="service_list service-page" id="services">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div style="background: #fff; border-radius: 2px; box-shadow: 0 1px 1px #dad2d2; padding: 30px; height: 40vh;">

                    <div style="padding: 20px; max-width: 400px; margin: 0 auto; border: 1px solid #f3f3f3;">
                        <img src="assets/img/success.png" alt="">
                        <h5>წარმატებით დასრულდა</h5>
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
