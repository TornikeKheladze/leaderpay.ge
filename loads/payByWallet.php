<?php
    require '../classes/config.php';
    require '../classes/db.php';
    require '../classes/Billing.php';
    require '../classes/bulkSms.php';
    require '../classes/Limit.php';
    require '../classes/Risk.php';
    require '../classes/TransGuard.php';

    $db = new db();
    $Billing = new Billing($db, 'Wallet');
    $bulkSms = new bulkSms();
    $Limit = new Limit($db);
    $Risk = new Risk();
    $TransGuard = new TransGuard($db, 'PayServiceByWallet');

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
        'document_id' => ($user['country'] == 'GE') ? $user['personal_number'] : $user_document_number,
        'passport_id' => $user_document_number,
        'legal_address' => $user['legal_address'],
        'actual_address' => $user['real_address'],
        'birth_date' => $user['birth_date'],
    ];
    $TransGuard->post = $transPost;
    $transCheck = $TransGuard->check();

    if ($transCheck['errorCode'] != 100) {

        $json = [
            'errorCode' => 0,
            'errorMessage' => $transCheck['errorMessage']
        ];
        echo json_encode($json);
        die();

    }

    if (isset($get['action']) && $get['action'] == 'pay') {

        if ($post['service_id'] == 2) {

            if (!isset($post['personal_number']) || $post['personal_number'] != $user['personal_number']) {
                $json = [
                    'errorCode' => 0,
                    'errorMessage' => "სერვისი თქვენთვის მიუწვდომელია, გთხოვთ დაუკავშირდით 'ოლლ ფეი ვეის'"
                ];
                echo json_encode($json);
                die();
            }
        }

        if ($post['service_id'] == 90) {
            if ($user['pin_code'] == '' || $user['pin_code'] == null) {
                $json = [
                    'errorCode' => 0,
                    'errorMessage' => "სერვისი თქვენთვის მიუწვდომელია, გთხოვთ დაუკავშირდით 'ოლლ ფეი ვეის'"
                ];
                echo json_encode($json);
                die();
            }
            if (!isset($post['account']) || $post['account'] != $user['pin_code']) {
                $json = [
                    'errorCode' => 0,
                    'errorMessage' => "სერვისი თქვენთვის მიუწვდომელია, გთხოვთ დაუკავშირდით 'ოლლ ფეი ვეის'"
                ];
                echo json_encode($json);
                die();
            }
        }

        $params = $post;

        if (isset($params['year']) && isset($params['month']) && isset($params['day'])) {

            $year = (!@preg_match('/^[0-9]{4}$/', $params['year'])) ? '' : $params['year'];
            $month = (!@preg_match('/^(0[1-9]|1[0-2])$/', $params['month'])) ? '' : $params['month'];
            $day = (!@preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])$/', $params['day'])) ? '' : $params['day'];

            $birthdate = $year . '-' . $month . '-' . $day;
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

        if (isset($params['sender_firstname'])) {
            $pay_params['sender_firstname'] = $params['sender_firstname'];
        }
        if (isset($params['sender_lastname'])) {
            $pay_params['sender_lastname'] = $params['sender_lastname'];
        }
        if (isset($params['sender_document_number'])) {
            $pay_params['sender_document_number'] = $params['sender_document_number'];
        }
        if (isset($params['receiver_firstname'])) {
            $pay_params['receiver_firstname'] = $params['receiver_firstname'];
        }
        if (isset($params['receiver_lastname'])) {
            $pay_params['receiver_lastname'] = $params['receiver_lastname'];
        }
        if (isset($params['receiver_type'])) {
            $pay_params['receiver_type'] = $params['receiver_type'];
        }

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

        if ($service_id == 90) {
            // detect risk
            $Risk->Change($user['id']);
        }

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
                'text' => "leaderpay.ge service payment confirm code: $code",
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

    if (isset($get['action']) && $get['action'] == 'info') {

        if ($db->check_auch() == false) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => '0',
            ];
            echo json_encode($json);
            die();

        }

        $params = $post;
        if (isset($params['year']) && isset($params['month']) && isset($params['day'])) {
            $birthdate = $params['year'] . '-' . $params['month'] . '-' . $params['day'];
            $birthdate = ['birthdate' => $birthdate];

            unset($params['year']);
            unset($params['month']);
            unset($params['day']);

            $params = array_merge($params, $birthdate);
        }

        $service_id = (INT) $params['service_id'];

        $service = $Billing->service($service_id);
        $service = $service['service'];

        // get payment params
        $params_info = $service['params_info'];
        $info_params = [];
        foreach ($params_info as $param) {
            $info_params[$param['name']] = urlencode($params[$param['name']]);
            $info_params['service_id'] = $service_id;
        }

        $info = $Billing->info($info_params);

        if ($info['errorCode'] != 1000) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'შეცდომა!',
                'debt' => 0,
                'credit' => 0,
            ];
            echo json_encode($json);
            die();

        }

        $debt = 0;
        $credit = 0;
        foreach ($info['data'] as $key => $value) {

            if ($key == 'debt') {
                $debt = $value;
            }

            if ($key == 'balance') {
                $credit = $value;
            }

        }

        $json = [
            'errorCode' => 1,
            'errorMessage' => 'წარმატებული!',
            'debt' => $debt,
            'credit' => $credit,
        ];
        echo json_encode($json);
        die();

    }

    if (isset($get['action']) && $get['action'] == 'saveService') {

        if ($db->check_auch() == false) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => '0',
            ];
            echo json_encode($json);
            die();

        }

        $service_id = (INT) $post['service_id'];

        $service = $Billing->service($service_id);
        $service = $service['service'];

        // get payment params
        $params_info = $service['params_info'];
        $data = [];
        foreach ($params_info as $param) {

            if ($param['name'] == 'birthdate') {

                $data['year'] = (!preg_match('/^[0-9]{4}$/', $post['year'])) ? '' : $post['year'];
                $data['month'] = (!preg_match('/^(0[1-9]|1[0-2])$/', $post['month'])) ? '' : $post['month'];
                $data['day'] = (!preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])$/', $post['day'])) ? '' : $post['day'];

            } else {

                $regexp = $param['regexp'];

                $data[$param['name']] = (!preg_match("$regexp", $post[$param['name']])) ? '' : $post[$param['name']];
                $data['service_id'] = $service_id;

            }

        }

        $db->insert('save_service', ['service_id' => $service_id, 'user_id' => $username, 'json' => json_encode($data)]);

        $json = [
            'errorCode' => 1,
            'errorMessage' => 'შენახვა წარმატებით დასრულდა!',
        ];
        echo json_encode($json);
        die();

    }

    if (isset($get['action']) && $get['action'] == 'deleteService') {

        if ($db->check_auch() == false) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => '0',
            ];
            echo json_encode($json);
            die();

        }

        $id = (INT) $post['id'];

        $db->delete('save_service', "id = $id AND user_id = $username");

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