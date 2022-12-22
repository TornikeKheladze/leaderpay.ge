<?php

    require_once '../classes/config.php';
    require_once '../classes/db.php';
    require_once '../classes/transfer.php';

    $db = new db();
    $transfer = new transfer();

    // check user
    if ($db->check_auch() != true) {

      die();

    }

    $username = $_SESSION['user_name'];
    // get user
    $user = $db->get_date('users', " `personal_number` = '$username' ");

    if (isset($get['method']) AND $get['method'] == 'info') {

        $wallet_number = (!@preg_match('/^(\d{11})$/i', htmlspecialchars($post['to'], ENT_QUOTES))) ? '' : htmlspecialchars($post['to'], ENT_QUOTES);

        $reciverUser = $db->get_date('users', " `personal_number` = '$wallet_number' ");

        $params = [
            'from' => $username,
            'to'   => $wallet_number,
        ];

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

        // same account
        if ($wallet_number == $username) {

            $json = [
                'errorCode' => 2,
                'errorMessage' => 'გადარიცხვა საკუთარ ანგარიშზე არ არის შესაძლებელი!',
            ];
            echo json_encode($json);
            die();
        }

        // check reciver user
        if ($reciverUser == false) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'მიმღები მომხმარებელი ვერ მოიძებნა!',
            ];
            echo json_encode($json);
            die();

        }

        // check reciver user block
        if ($reciverUser['is_blocked'] == 1) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'მიმღები მომხმარებელი დახურულია!',
            ];
            echo json_encode($json);
            die();

        }
        // check reciver user verification
        if ($reciverUser['verify_id'] == 1) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'მიმღები მომხმარებელი არ არის ვერიფიცირებული!',
            ];
            echo json_encode($json);
            die();
        }

        // check reciver user aml_block
        if ($reciverUser['aml_block'] == 1) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'მიმღები მომსახურება შეზღუდულია დაუკავშირდით AML დეპარტამენტს!',
            ];
            echo json_encode($json);
            die();
        }

        $info = $transfer->info($params);

        if ($info['errorCode'] == 1000) {

            $first_name = mb_substr($info['data']['first_name'],0,1, "utf-8") . '#######';

            $data = [
                'გვარი' => $info['data']['last_name'],
                'სახელი' => $info['data']['first_name'],
                'ვერიფიკაცია' => ($info['data']['verify'] == 1) ? 'ვერიფიცირებული' : 'არა ვერიფიცირებული',
            ];

            $json = [
                'errorCode' => 10,
                'errorMessage' => 'წარმატებული',
                'data' => $data,
                'percents' => $info['percents'],
            ];
            echo json_encode($json);
            die();

        } else {

            $json = [
                'errorCode' => 1,
                'errorMessage' => $info['errorMessage'],
            ];
            echo json_encode($json);
            die();

        }

    }

    if (isset($get['method']) AND $get['method'] == 'pay') {

        $wallet_number = (!@preg_match('/^(\d{11})$/i', htmlspecialchars($post['to'], ENT_QUOTES))) ? '' : htmlspecialchars($post['to'], ENT_QUOTES);

        $reciverUser = $db->get_date('users', " `personal_number` = '$wallet_number' ");

        $amount        = floatval($post['amount']);
        $currency_id   = intval($post['currency_id']);

        // balance
        $balance = $db->getSql("SELECT SUM(credit) - SUM(debt) AS balance FROM `user_balance_history` WHERE `personal_number` = '$username'");
        $balance = $balance['balance'];
        if ($amount > $balance) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'ბალანსი არ არის საკმარისი ტრანზაქციის განსახორციელებლად!',
            ];
            echo json_encode($json);
            die();

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

        // same account
        if ($wallet_number == $username) {

            $json = [
                'errorCode' => 2,
                'errorMessage' => 'გადარიცხვა საკუთარ ანგარიშზე არ არის შესაძლებელი!',
            ];
            echo json_encode($json);
            die();
        }

        // check reciver user
        if ($reciverUser == false) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'მიმღები მომხმარებელი ვერ მოიძებნა!',
            ];
            echo json_encode($json);
            die();

        }

        // check reciver user block
        if ($reciverUser['is_blocked'] == 1) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'მიმღები მომხმარებელი დახურულია!',
            ];
            echo json_encode($json);
            die();

        }
        // check reciver user verification
        if ($reciverUser['verify_id'] == 1) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'მიმღები მომხმარებელი არ არის ვერიფიცირებული!',
            ];
            echo json_encode($json);
            die();
        }

        // check reciver user aml_block
        if ($reciverUser['aml_block'] == 1) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => 'მიმღები მომსახურება შეზღუდულია დაუკავშირდით AML დეპარტამენტს!',
            ];
            echo json_encode($json);
            die();
        }

        $params = [
            'from'        => $username,
            'to'          => $wallet_number,
            'currency_id' => $currency_id,
            'amount'      => $amount,
        ];

        $pay = $transfer->pay($params);

        if ($pay['errorCode'] == 1000) {

            $json = [
                'errorCode' => 10,
                'errorMessage' => 'გადარიცხვა წარმატებით დასრულდა',
                'data' => $pay['data'],
            ];
            echo json_encode($json);
            die();

        } else {

            $json = [
                'errorCode' => 1,
                'errorMessage' => $pay['errorMessage'],
            ];
            echo json_encode($json);
            die();

        }

    }

