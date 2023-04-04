<?php

    require_once '../classes/config.php';
    require_once '../classes/db.php';
    require_once '../classes/Convertation.php';

    $db = new db();
    $Convertation = new Convertation();

    // check user
    if ($db->check_auch() != true) {

        die();

    }

    $username = $_SESSION['user_name'];
    // get user
    $user = $db->get_date('users', " `personal_number` = '$username' ");

    if (isset($get['method']) AND $get['method'] == 'convertation') {

        $id = (INT) $user['id'];
        $from = (INT) $get['from'];
        $to = (INT) $get['to'];
        $amount = floatval($get['amount']);

        $params = [
            'id' => $id,
            'from' => $from,
            'to' => $to,
            'amount' => $amount,
        ];

        $convert = $Convertation->exchange($params);

        $json = [
            'errorCode' => $convert['errorCode'],
            'errorMessage' => $convert['errorMessage'],
        ];
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
        die();

    }

    if (isset($get['method']) AND $get['method'] == 'rate') {

        $id = (INT) $user['id'];
        $from = (INT) $get['from'];
        $to = (INT) $get['to'];
        $amount = floatval($get['amount']);

        $params = [
            'id' => $id,
            'from' => $from,
            'to' => $to,
            'amount' => $amount,
        ];

        $convert = $Convertation->rate($params);

        $json = [
            'errorCode' => $convert['errorCode'],
            'errorMessage' => $convert['errorCode'],
            'data' => $convert
        ];
        echo json_encode($convert, JSON_UNESCAPED_UNICODE);
        die();

    }
