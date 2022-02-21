<?php

  require '../classes/config.php';
  require '../classes/db.php';
  require '../classes/sms.php';

  $db = new db();
  $sms = new sms();

  if ($db->check_auch() === false) {

    die();

  }



  if (isset($_GET['send'])) {


    //all required parameters
    $params = array('destination','sender');

    if (!is_array($post) or count($post) == 0) {

      echo "არ არის გადმოცემული პარამეტრები";
      die();

    } else {

      foreach ($params as $value) {

        if (array_key_exists($value, $post)) {

        } else {

          echo "არ არის გადმოცემული პარამეტრი ".$value."<br>";
          die();

        }

      } // end foreach

    } // check post

    $destination = ltrim($post['destination'],"+");

    // check if code sended
    if (!isset($_SESSION['code'])) {

      $code = $sms->generate_code();

      $_SESSION['code'] = $code;

    } // session check


    // send
    $send = $sms->send($destination,$post['sender'],$_SESSION['code']);

    if ($send['Success'] === true) {

      $error_code = 1;

    } else {

      if ($send['ErrorCode'] == 10) {

        $error_code = 99;

      } elseif ($send['ErrorCode'] == 20) {

        $error_code = 98;

      } elseif ($send['ErrorCode'] == 40) {

        $error_code = 97;

      } elseif ($send['ErrorCode'] == 60) {

        $error_code = 96;

      } elseif ($send['ErrorCode'] == 70) {

        $error_code = 95;

      } elseif ($send['ErrorCode'] == 80) {

        $error_code = 94;

      } elseif ($send['ErrorCode'] == 110) {

        $error_code = 93;

      } elseif ($send['ErrorCode'] == 120) {

        $error_code = 92;

      } elseif ($send['ErrorCode'] == 500) {

        $error_code = 91;

      } elseif ($send['ErrorCode'] == 600) {

        $error_code = 90;

      } elseif ($send['ErrorCode'] == 700) {

        $error_code = 89;

      } elseif ($send['ErrorCode'] == 800) {

        $error_code = 88;

      } elseif ($send['ErrorCode'] == -100) {

        $error_code = 87;

      } else {

        $error_code = 87;
        
      }

      // get error mesage
      $error_msg = $db->get_date("sms_error"," `id` = '".$error_code."' ");

      $json = array(
            "errorCode" => $error_code,
            "errorMessage" => $error_msg['name'],
        );

      echo json_encode($json);


    } //

    // sms logg
    $date = date('Y-m-d h:i:s');
    $response = json_encode($send);

    $sms_params = array(
      "title" => $post['sender'],
      "sms" => $_SESSION['code'],
      "number" => $post['destination'],
      "date" => $date,
      "error_code" => $error_code,
      "response" => $response,
    );

    $db->insert("sms_logs", $sms_params);


    // send
  } elseif(isset($_GET['delete_sesion'])) {

    unset($_SESSION['code']);

  } // delete session




 ?>
