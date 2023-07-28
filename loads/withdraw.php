<?php
    require '../classes/config.php';
    require '../classes/db.php';
    require '../classes/Billing.php';
    require '../classes/bulkSms.php';
    require '../classes/Limit.php';
    require '../classes/Transguard.php';
    require '../classes/Card.php';

    $db = new db();
    $Billing = new Billing($db, 'Wallet');
    $bulkSms = new bulkSms();
    $Limit = new Limit($db);
    $Transguard = new Transguard($db, 'WithdrawByWallet');
    $Card = new Card($db);

    // check auch
    if ($db->check_auch() === false) {

        $json = [
            'errorCode' => 0,
            'errorMessage' => 'არაავტორიზებული მომხმარებელი!',
        ];
        echo json_encode($json);
        die();

    } else {

        $username = $_SESSION['user_name'];
        $token = $_SESSION['token'];
        $user = $db->get_date('users', " `personal_number` = '$username' AND `token` = '$token' ");
        $user_document_number = $db->getSql("SELECT document_number FROM `users_documents` WHERE personal_number = '$username' LIMIT 1");

    }

    // check user block
    if ($user['is_blocked'] == 1) {

        $json = [
            'errorCode' => 0,
            'errorMessage' => 'მომხმარებელი დახურულია!',
        ];
        echo json_encode($json);
        die();

    }
    // check user verification
    if ($user['verify_id'] == 1) {

        $json = [
            'errorCode' => 0,
            'errorMessage' => 'მომხმარებელი არ არის ვერიფიცირებული!',
        ];
        echo json_encode($json);
        die();
    }

    // check user aml_block
    if ($user['aml_block'] == 1) {

        $json = [
            'errorCode' => 0,
            'errorMessage' => 'მომსახურება შეზღუდულია დაუკავშირდით AML დეპარტამენტს!',
        ];
        echo json_encode($json);
        die();
    }

    $transPost = [
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
        'resident' => $user['country'],
        'document_id' => ($user['country'] == 'GE') ? $user['personal_number'] : $user_document_number['document_number'],
        'passport_id' => $user_document_number['document_number'],
        'legal_address' => $user['legal_address'],
        'actual_address' => $user['real_address'],
        'birth_date' => $user['birth_date'],
    ];
    $Transguard->post = $transPost;
    $transCheck = $Transguard->check();

    if ($transCheck['errorCode'] != 100) {

        $json = [
            'errorCode' => 0,
            'errorMessage' => $transCheck['errorMessage']
        ];
        echo json_encode($json);
        die();

    }

    if (isset($get['action']) && $get['action'] == 'addNewCard') {

        $card_id = $Card->GenerateId(6);

        $db->insert('cards', ['personal_number' => $username, 'card_id' => $card_id]);

        $Card->Binding($card_id, $username);

    }

    if (isset($get['action']) && $get['action'] == 'sms') {

        $card_id = (string) $post['card_id'];
        $amount = floatval($post['amount']);
        $current_date = $db->get_current_date();

        // chek card
        $card = $db->get_date('cards', "card_id = '$card_id' AND personal_number = '$username'");
        if (!$card) {

            $json = [
                'errorCode' => 10,
                'errorMessage' => 'შეცდომა!',
            ];
            echo json_encode($json);
            die();

        }

        $operationsPercent = $db->get_date('card_operations_percents', "id = '1'");

        // chek amount
        if ($amount < $operationsPercent['min_amount']) {

            $json = [
                'errorCode' => 9,
                'errorMessage' => 'თანხა ნაკლებია მინიმალურზე!',
            ];
            echo json_encode($json);
            die();

        }
        if ($amount > $operationsPercent['max_amount']) {

            $json = [
                'errorCode' => 10,
                'errorMessage' => 'თანხა მეტია მაქსიმალურზე!',
            ];
            echo json_encode($json);
            die();

        }

        $balance = $db->getSql("SELECT SUM(credit) - SUM(debt) AS balance FROM `user_balance_history` WHERE `personal_number` = '$username' AND `currency_id` = '981'");
        $balance = $balance['balance'];

        $commision = ($operationsPercent['percent'] / 100) * $amount;
        $commision = ($commision > $operationsPercent['min_commision']) ? $commision : $operationsPercent['min_commision'];

        if ($balance < ($amount + $commision)) {

            $json = [
                'errorCode' => 10,
                'errorMessage' => 'ბალანსზე არ არის საკმარისი თანხა!',
            ];
            echo json_encode($json);
            die();

        }

        $code = $bulkSms->generateCode();

        $mobile = ltrim($user['mobile'],'+');
        $mobile = str_replace(' ', '', $mobile);

        $smsParams = [
            'number' => $mobile,
            'text' => "leaderpay.ge withdraw confirm code: $code",
        ];

        $bulkSms->Send($smsParams);

        $db->getSql("UPDATE `cards` SET `sms` = '$code', `updated_at` = '$current_date' WHERE `card_id` = '$card_id' AND `personal_number` = '$username'");

        $json = [
            'errorCode' => 1,
            'errorMessage' => 'წარმატებული!',
            'data' => [
                'commision' => $commision,
                'card_name' => $card['name'],
                'card_id' => $card['card_id'],
            ]
        ];
        echo json_encode($json);
        die();

    }

    if (isset($get['action']) && $get['action'] == 'withdraw') {

        $card_id = (string) $post['card_id'];
        $amount = floatval($post['amount']);
        $sms = floatval($post['sms']);
        $current_date = $db->get_current_date();

        // chek sms
        $card = $db->get_date('cards', "card_id = '$card_id' AND personal_number = '$username' AND sms = '$sms'");
        if (!$card) {

            $json = [
                'errorCode' => 10,
                'errorMessage' => 'sms-კოდი არასწორია!',
            ];
            echo json_encode($json);
            die();

        }

        $operationsPercent = $db->get_date('card_operations_percents', "id = '1'");

        // chek amount
        if ($amount < $operationsPercent['min_amount']) {

            $json = [
                'errorCode' => 9,
                'errorMessage' => 'თანხა ნაკლებია მინიმალურზე!',
            ];
            echo json_encode($json);
            die();

        }
        if ($amount > $operationsPercent['max_amount']) {

            $json = [
                'errorCode' => 10,
                'errorMessage' => 'თანხა მეტია მაქსიმალურზე!',
            ];
            echo json_encode($json);
            die();

        }

        $balance = $db->getSql("SELECT SUM(credit) - SUM(debt) AS balance FROM `user_balance_history` WHERE `personal_number` = '$username' AND `currency_id` = '981'");
        $balance = $balance['balance'];

        $commision = ($operationsPercent['percent'] / 100) * $amount;
        $commision = ($commision > $operationsPercent['min_commision']) ? $commision : $operationsPercent['min_commision'];

        if ($balance < ($amount + $commision)) {

            $json = [
                'errorCode' => 10,
                'errorMessage' => 'ბალანსზე არ არის საკმარისი თანხა!',
            ];
            echo json_encode($json);
            die();

        }

        $cardResult = $Card->Pay($card_id, $username, $amount);

        if ($cardResult->result->status == 'SUCCESS') {

            $operationParams = [
                'type_id' => 2,
                'card_id' => $card_id,
                'wallet_number' => $username,
                'amount' => $amount,
                'commision' => $commision,
                'currency' => 981,
                'status_id' => 2,
            ];

            $operationId = $db->insert('card_operations', ['personal_number' => $username, 'card_id' => $card_id]);

            // unicdate
            list($usec, $sec) = explode(' ', substr(microtime(), 2));
            $unicdate = $sec . $usec;

            // update balance
            $newBalance = $balance - $amount;
            $db->getSql("UPDATE `users` SET `balance` = '$newBalance' WHERE `personal_number` = '$username'");

            $history_params = [
                'personal_number' => $username,
                'operation_id' => $operationId,
                'credit' => 0,
                'debt' => $amount,
                'type_id' => 15,
                'unicdate' => $unicdate,
                'balance' => $newBalance,
                'description' => 'ბარათზე გატანიდან ჩამოჭრილი თანხა',
                'agent_id' => 1,
                'agent' => 2,
            ];
            $db->insert('user_balance_history', $history_params);

            // update balance
            $balance = $db->getSql("SELECT SUM(credit) - SUM(debt) AS balance FROM `user_balance_history` WHERE `personal_number` = '$username' AND `currency_id` = '981'");

            $newBalance = $balance['balance'] - $commision;
            $db->getSql("UPDATE `users` SET `balance` = '$newBalance' WHERE `personal_number` = '$username'");

            $history_params = [
                'personal_number' => $username,
                'operation_id' => $operationId,
                'credit' => 0,
                'debt' => $commision,
                'type_id' => 16,
                'unicdate' => $unicdate,
                'balance' => $newBalance,
                'description' => 'ბარათზე გატანიდან ჩამოჭრილი პროცენტი',
                'agent_id' => 1,
                'agent' => 2,
            ];
            $db->insert('user_balance_history', $history_params);

            $json = [
                'errorCode' => 1,
                'errorMessage' => 'წარმატებული!',
            ];
            echo json_encode($json);
            die();

        } else {
            $json = [
                'errorCode' => 10,
                'errorMessage' => 'შეფერხება!',
            ];
            echo json_encode($json);
            die();
        }

    }

    if (isset($get['action']) && $get['action'] == 'deleteCard') {

        $card_id = (string) $post['card_id'];
        $current_date = $db->get_current_date();

        $db->getSql("UPDATE `cards` SET `is_deleted` = '1', `deleted_at` = '$current_date' WHERE `card_id` = '$card_id' AND `personal_number` = '$username' ");

        $json = [
            'errorCode' => 1,
            'errorMessage' => 'წაშლა წარმატებით დასრულდა!',
        ];
        echo json_encode($json);
        die();

    }

    $json = [
        'errorCode' => 0,
        'errorMessage' => 'დროებით ტექნიკური შეფერხება!',
    ];
    echo json_encode($json);
    die();