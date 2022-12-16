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
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            die();

        }

        $service = $service['service'];

        if ($service['category_id'] == 30) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'ბარათით ტოტალიზატორის გადახდა არ არის შესაძლებელი!',
            ];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            die();

        }

        if ($service['commission']['min_amount'] > $amount) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'თანხა ნაკლებია მინიმალურ ჩასარიცხ თანხაზე!',
            ];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            die();

        }
        if ($service['commission']['max_amount'] < $amount) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'თანხა მეტია მაქსიმალურ ჩასარიცხ თანხაზე!',
            ];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            die();

        }

        if (!preg_match('/^[a-zA-Zა-ჰ]{2,20}$/', $post['mFirstName'])) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'სახელი არასწორია!',
            ];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            die();

        }

        if (!preg_match('/^[a-zA-Zა-ჰ]{2,20}$/', $post['mLastName'])) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'გვარი არასწორია!',
            ];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            die();

        }

        if (!preg_match('/^[a-zA-Z0-9]{5,15}$/', $post['mPersonal_no'])) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'პირადი ან საბუთის ნომერი არასწორია!',
            ];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            die();

        }

        if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $post['mBirthDate'])) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'დაბადების თარიღი არასწორია!',
            ];
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
            die();

        }

        $Merchant->firstName = $post['mFirstName'];
        $Merchant->lastName = $post['mLastName'];
        $Merchant->personal_no = $post['mPersonal_no'];
        $Merchant->birthdate = $post['mBirthDate'];

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
        
        $description = $service['lang']['EN'];

        $Merchant->Init($amount, $description, $token);

    }