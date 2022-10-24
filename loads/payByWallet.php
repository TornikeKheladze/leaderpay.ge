<?php
    require '../classes/config.php';
    require '../classes/db.php';
    require '../classes/Billing.php';
    require '../classes/Payway.php';
    require '../classes/bulkSms.php';
    require '../classes/Limit.php';

    $db = new db();
    $Payway = new Payway($db, 'PayServiceByWallet');
    $Billing = new Billing($db, 'Wallet');
    $bulkSms = new bulkSms();
    $Limit = new Limit($db);

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

    //payway
    $paywayPost = [
        'birthdate' => $user['birth_date'],
        'birth_place' => $user['birth_place'],
        'phone' => $user['mobile'],
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
        'personal_no' => $user['personal_number'],
        'country' => $user['country'],
        'registration_address' => $user['legal_address'],
        'real_actual_address' => $user['real_address'],
    ];

    $Payway->post = $paywayPost;
    $paywayCheck = $Payway->check();

    if ($paywayCheck['errorCode'] != 100) {

        $json = [
            'errorCode' => 0,
            'errorMessage' => $paywayCheck['errorMessage']
        ];
        echo json_encode($json);
        die();

    }

    if (isset($get['action']) && $get['action'] == 'pay') {

        $params = $post;

        if (isset($params['year']) && isset($params['month']) && isset($params['day'])) {
            $birthdate = $params['year'] . '-' . $params['month'] . '-' . $params['day'];
            $birthdate = ['birthdate' => $birthdate];

            unset($params['year']);
            unset($params['month']);
            unset($params['day']);

            $params = array_merge($birthdate, $params);
        }

        $user_id = $user['id'];
        $personal_number = $user['personal_number'];
        $service_id = intval($params['service_id']);
        $amount = floatval($params['generated']);
        $date = date('Y-m-d H:i:s');
        // unicdate
        list($usec, $sec) = explode(' ', substr(microtime(), 2));
        $unicdate = $sec . $usec;

        // balance
        $balance = $db->getSql("SELECT SUM(credit) - SUM(debt) AS balance FROM `user_balance_history` WHERE `personal_number` = '$personal_number'");
        $balance = $balance['balance'];
        if ($amount > $balance) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'ბალანსი არ არის საკმარისი ტრანზაქციის განსახორციელებლად!',
            ];
            echo json_encode($json);
            die();

        }

        // check user limites
        $checkLimit = $Limit->Check($user['wallet_number'], floatval($post['generated']));
        if ($checkLimit['errorCode']  != 1) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => $checkLimit['errorMessage'],
            ];
            echo json_encode($json);
            die();
        }

        $service = $Billing->service($service_id);
        $service = $service['service'];
        if ($service['commission']['min_amount'] > $amount) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'თანხა ნაკლებია მინიმალურ ჩასარიცხ თანხაზე!',
            ];
            echo json_encode($json);
            die();

        }
        if ($service['commission']['max_amount'] < $amount) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'თანხა მეტია მაქსიმალურ ჩასარიცხ თანხაზე!',
            ];
            echo json_encode($json);
            die();

        }

        // if need sms validate
        $type = $db->get_date('service_options', " `service_id` = '$service_id' ");
        if ($type and $type['sms'] == 1) {

            if (!isset($params['code']) || $params['code'] != $user['sms_code']) {
                $json = [
                    'errorCode' => 0,
                    'errorMessage' => 'SMS-ით მიღებული კოდი არასწორია!',
                ];
                echo json_encode($json);
                die();
            }
        }

        $pay_params = [];

        foreach ($service['params_pay'] as $param) {
            if ($service_id == 2) {
                $pay_params[$param['name']] = $params[$param['name']];
            } else {
                $pay_params[$param['name']] = urlencode($params[$param['name']]);
            }

            $pay_params['service_id'] = $service_id;
            $pay_params['amount'] = $amount;
            $pay_params['agent_transaction_id'] = $db->get_max('user_payments') + 1;
        }

        $pay_user = array_values($pay_params)[0];
        $pay = $Billing->pay($pay_params);

        if ($pay['errorCode'] != 1000) {
            $json = [
                'errorCode' => 0,
                'errorMessage' => 'დროებითი შეფერხება. კიდევ სცადეთ',
            ];
            echo json_encode($json);
            die();

        }

        // update balance
        $newBalance = $balance - $amount;
        $db->update('users', ['balance' => $newBalance], $user_id);

        // payments
        $user_payments_params = [
            'operation_id' => $pay['operationId'],
            'user_id' => $personal_number,
            'service_id' => $service_id,
            'amount' => $amount,
            'gen_amount' => $pay['accoutant']['genAmount'],
            'agent_comision' => $pay['accoutant']['agentBenefit'],
            'agent_benefit' => $pay['accoutant']['agentCommission'],
            'client_comision' => $pay['accoutant']['clientCommission'],
            'currency' => 981,
            'status_id' => $pay['status']['id'],
            'cron' => 0,
            'created_at' => $date,
            'ip' => $db->getClientIp(),
        ];

        $payment_id = $db->insert('user_payments', $user_payments_params);

        $history_params = [
            'personal_number' => $personal_number,
            'operation_id' => $payment_id,
            'credit' => 0,
            'debt' => $amount,
            'type_id' => 4,
            'date' => $date,
            'unicdate' => $unicdate,
            'balance' => $newBalance,
            'description' => "$service[name] - სერვისის გადახდა, მომხმარებელი: $pay_user",
            'agent_id' => 1,
            'agent' => 2,
        ];
        $db->insert('user_balance_history', $history_params);

        $pay_params = [];

        foreach ($service['params_pay'] as $key => $value) {
            $detail_params = [
                'payment_id' => $payment_id,
                'param_name' => $value['name'],
                'param_value' => $params[$value['name']],
                'created_at' => $date,
            ];
            $db->insert('payment_details', $detail_params);
        }
        unset($_SESSION['smsCode']);

        $json = [
            'errorCode' => 100,
            'errorMessage' => 'გადახდა წარმატებით დასრულდა',
        ];
        echo json_encode($json);
        die();

    }

    if (isset($get['action']) && $get['action'] == 'sendSms') {

        if (!isset($_SESSION['smsCode'])) {

            $code = $bulkSms->generateCode();

            $mobile = ltrim($user['mobile'],'+');
            $mobile = str_replace(' ', '', $mobile);

            $smsParams = [
                'number' => $mobile,
                'text' => "SMS Code: $code",
            ];

            $bulkSms->Send($smsParams);

            $params = [
                'sms_code' => $code,
                'updated_at' => $db->get_current_date(),
            ];
            $db->update('users', $params, $user['id']);

            $_SESSION['smsCode'] = $code;

            $json = [
                'errorCode' => 1,
                'errorMessage' => 'ok',
            ];
            echo json_encode($json);
            die();

        } else {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'no',
            ];
            echo json_encode($json);
            die();

        }

    }

    if (isset($get['action']) && $get['action'] == 'deleteSmsSession') {

        unset($_SESSION['smsCode']);

        $params = [
            'sms_code' => null,
            'updated_at' => $db->get_current_date(),
        ];
        $db->update('users', $params, $user['id']);

        $json = [
            'errorCode' => 1,
            'errorMessage' => 'ok',
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