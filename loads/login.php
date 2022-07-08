<?php

    require_once '../classes/config.php';
    require_once '../classes/db.php';
    require_once '../classes/bulkSms.php';

    $bulkSms = new bulkSms();
    $db = new db();

    if (isset($post['username']) && isset($post['password']) && $post['method'] == 'user') {

        $username = $post['username'];
        $password = hash('sha256', trim($post['password']));

        $data = $db->Login($username, $password);

        if ($data == false) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'საფულის ნომერი ან პაროლი არასწორია',
            ];

            $logParams = [
                'wallet_number' => $username,
                'type' => 'loginFiled',
                'mobile' => '',
                'sms_code' => '',
                'date' => $db->get_current_date(),
                'ip' => $db->getClientIp(),
            ];
            $db->insert('login_log', $logParams);


            echo json_encode($json);
            die();

        } else {

            $code = $bulkSms->generateCode();
            $_SESSION['sms'] = $code;

            $mobile = ltrim($data['mobile'],'+');
            $mobile = str_replace(' ', '', $mobile);

            $smsParams = [
                'number' => $mobile,
                'text' => "SMS Code: $code",
            ];

            $b = $bulkSms->Send($smsParams);

            $params = [
                'sms_code' => $code,
                'updated_at' => $db->get_current_date(),
            ];
            $db->update('users', $params, $data['id']);

            $json = [
                'errorCode' => 1,
                'errorMessage' => 'წარმატებული',
                'b' => $b,
            ];

            $logParams = [
                'wallet_number' => $data['wallet_number'],
                'type' => 'sendSms',
                'mobile' => $mobile,
                'sms_code' => $code,
                'date' => $db->get_current_date(),
                'ip' => $db->getClientIp(),
            ];
            $db->insert('login_log', $logParams);

            echo json_encode($json);
            die();

        }
    }

    if (isset($post['username']) && isset($post['sms_code']) && $post['method'] == 'sms') {

        $username = $post['username'];
        $sms_code = $post['sms_code'];

        $data = $db->get_date('users', " `wallet_number` = '$username' AND `sms_code` = '$sms_code' AND is_blocked = 0");

        if ($data == false) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'sms კოდი არასწორია',
            ];

            $logParams = [
                'wallet_number' => $username,
                'type' => 'loginSmsFiled',
                'mobile' => '',
                'sms_code' => $sms_code,
                'date' => $db->get_current_date(),
                'ip' => $db->getClientIp(),
            ];
            $db->insert('login_log', $logParams);

            echo json_encode($json);
            die();

        }

        $smsLog = $db->get_date('login_log', " `wallet_number` = '$username' AND `type` = 'sendSms' AND  `sms_code` = '$sms_code' AND date > date_sub(now(), interval 5 minute)");

        if ($smsLog) {

            $token = uniqid();
            $token = hash('sha256', $token);
            $token = strtolower($token);

            $params = [
                'token' => $token,
                'last_date' => $db->get_current_date(),
            ];
            $db->update('users', $params, $data['id']);

            $_SESSION['user_name'] = $data['wallet_number'];
            $_SESSION['token'] = $token;

            $logParams = [
                'wallet_number' => $data['wallet_number'],
                'type' => 'loginSuccess',
                'mobile' => $data['mobile'],
                'sms_code' => $sms_code,
                'date' => $db->get_current_date(),
                'ip' => $db->getClientIp(),
            ];

            $db->insert('login_log', $logParams);

            $json = [
                'errorCode' => 1,
                'errorMessage' => 'წარმატებული',
            ];

            echo json_encode($json);
            die();

        } else {

            $logParams = [
                'wallet_number' => $data['wallet_number'],
                'type' => 'smsExpired',
                'mobile' => $data['mobile'],
                'sms_code' => $sms_code,
                'date' => $db->get_current_date(),
                'ip' => $db->getClientIp(),
            ];

            $db->insert('login_log', $logParams);

            unset($_SESSION['sms']);

            $json = [
                'errorCode' => 2,
                'errorMessage' => 'sms-ის თვის განსაზღვრული დრო 5 წუთი ამოიწურა',
            ];

            echo json_encode($json);
            die();

        }

    }

    $json = [
        'errorCode' => 0,
        'errorMessage' => 'საფულის ნომერი ან პაროლი არასწორია',
    ];

    echo json_encode($json);
    die();