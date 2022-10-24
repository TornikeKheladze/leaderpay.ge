<?php
    require '../classes/config.php';
    require '../classes/db.php';
    require '../classes/Billing.php';
    require '../classes/Merchant.php';

    $db = new db();
    $Billing = new Billing($db, 'Wallet');
    $Merchant = new Merchant($db);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $params = $post;

        if (isset($params['year']) && isset($params['month']) && isset($params['day'])) {
            $birthdate = $params['year'] . '-' . $params['month'] . '-' . $params['day'];
            $birthdate = ['birthdate' => $birthdate];

            unset($params['year']);
            unset($params['month']);
            unset($params['day']);

            $params = array_merge($birthdate, $params);
        }

        $service_id = (INT) $params['service_id'];
        $amount = floatval($params['generated']);
        //$date = date('Y-m-d H:i:s');
        // unicdate
        list($usec, $sec) = explode(' ', substr(microtime(), 2));
        $unicdate = $sec . $usec;

        $service = $Billing->service($service_id);

        if ($service['errorCode'] != 1000) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'დროებითი შეფერხებ კიდევ სცადეთ!',
            ];
            echo json_encode($json);
            die();

        }

        $service = $service['service'];

        if ($service['category_id'] == 30) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'ბარათით ტოტალიზატორის გადახდა არ არის შესაძლებელი!',
            ];
            echo json_encode($json);
            die();

        }

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

        $pay_params = [];

        foreach ($service['params_pay'] as $param) {
            if ($service_id == 2) {
                $pay_params[$param['name']] = $params[$param['name']];
            } else {
                $pay_params[$param['name']] = urlencode($params[$param['name']]);
            }

            $pay_params['service_id'] = $service_id;
            $pay_params['amount'] = $amount;
        }

        $pay_user = array_values($pay_params)[0];

        $token = $Merchant->Token();

        // payments
        $operationParams = [
            'token' => $token,
            'merchant_opeartion_id' => null,
            'billing_operation_id' => null,
            'amount' => $amount,
            'status_id' => 1,
            'ip' => $db->getClientIp(),
            'billing_operation_details' => json_encode($pay_params, JSON_UNESCAPED_UNICODE),
            'unicdate' => $unicdate,
        ];

        $id = $db->insert('apw_operations', $operationParams);

        //$db->insert('user_payments', ['operation_id' => $id, 'service_id' => $service_id, 'amount' => $amount, 'status_id' => 1, 'currency' => 981, 'ip' => $db->getClientIp()]);

        $description = 'სერვისი ' . $service['lang']['GE'] . '-ის გადახდა';

        $Merchant->Init($amount, $description, $token);

    }