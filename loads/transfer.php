<?php

require_once "../classes/config.php";
require_once "../classes/db.php";
require_once "../classes/transfer.php";

$db = new db();
$transfer = new transfer();

// check user
if ($db->check_auch() != true) {

  die();

}

$json = null;

$username = $_SESSION["user_name"];
// get user
$user = $db->get_date_row("users","balance,is_blocked,verify_id"," `personal_number` = '".$username."' ");

// check user blocked
if ($user['is_blocked'] == 0) {

  // check verification
  if ($user['verify_id'] == 2 OR $user['verify_id'] == 3 ) {

    if (isset($get['method']) AND $get['method'] == 'info') {

        $wallet_number = $post['to'];

        $params = array(
          "from" => $username,
          "to"   => $wallet_number,
        );

        if ($wallet_number != $username) {

          $info = $transfer->info($params);

          if ($info['errorCode'] == 1000) {

            $first_name = mb_substr($info['data']['first_name'],0,1, "utf-8") . '#######';

            $data = array(
              "გვარი" => $info['data']['last_name'],
              // "სახელი" => $first_name,
              "სახელი" => $info['data']['first_name'],
              "ვერიფიკაცია" => ($info['data']['verify'] == 1) ? 'ვერიფიცირებული' : 'არა ვერიფიცირებული',
            );

            $json = array(
              "errorCode" => 10,
              "errorMessage" => "წარმატებული",
              "data" => $data,
              "percents" => $info['percents'],

            );

          } else {

            $json = array(
              "errorCode" => 1,
              "errorMessage" => $info['errorMessage'],
            );


          }

        } else {

          $json = array(
            "errorCode" => 2,
            "errorMessage" => "გადარიცხვა საკუთარ ანგარიშზე არ არის შესაძლებელი!",

          );

        }



    }

    if (isset($get['method']) AND $get['method'] == 'pay') {

      $wallet_number = $post['to'];
      $amount        = floatval($post['amount']);
      $currency_id   = intval($post['currency_id']);

      $balance = $user['balance'];

      if ($balance >= $amount) {

        $params = array(
          "from"        => $username,
          "to"          => $wallet_number,
          "currency_id" => $currency_id,
          "amount"      => $amount,
        );

        $pay = $transfer->pay($params);

        if ($pay['errorCode'] == 1000) {

          $json = array(
            "errorCode" => 10,
            "errorMessage" => "გადარიცხვა წარმატებით დასრულდა",
            "data" => $pay['data'],
          );

        } else {

          $json = array(
            "errorCode" => 1,
            "errorMessage" => $pay['errorMessage'],
          );

        }

      } else {

        $json = array(
          "errorCode" => 2,
          "errorMessage" => 'ბალანსზე არსებული თანხა არ არს საკმარისი ტრანზაქციის განსახორციელებლად',
        );

      }

    }

  } else {

    $json = array(
      "errorCode" => 4,
      "errorMessage" => 'თანხის გადასარიცხად აუცილებელია მომხმარებლის ვერიფიკაცია!',
      "debug" => $user,
    );

  }

} else {

  $json = array(
    "errorCode" => 3,
    "errorMessage" => 'მომხმარებელი ბლოკირებულია!',
  );

}

echo json_encode($json);
