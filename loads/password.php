<?php

require '../classes/config.php';
require '../classes/db.php';
require '../classes/sms.php';

$db = new db();
$sms = new sms();


if (isset($post['wallet_number']) && isset($post['g-recaptcha-response']) && !isset($post['mobile'])) {

  $wallet_number = $post['wallet_number'];
  $captcha = $post['g-recaptcha-response'];

  // recafch
  $url = "https://www.google.com/recaptcha/api/siteverify?secret=6LfLxE4UAAAAABp0TEprxIj8HtSqEi-wu1kleBqk&response=".$captcha;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_FAILONERROR,1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $getInfo = curl_exec($ch);
  curl_close($ch);

  $response = json_decode($getInfo,true);

  // check captcha respons
 if ($response['success'] === false) {

   $output = array(
     "status" => 0,
     "errorMessage" => "უსაფრთხოების კოდი არასწორია",
   );
   echo json_encode($output);
   die();

 } // check captcha respons

  // check wallet_number
  $data = $db->get_date("users", " `wallet_number` = '".$wallet_number."' ");

  if ($data) {

    // remove spaces
    $mobile = str_replace(' ', '', $data['mobile']);
    // remove +
    $mobile = str_replace('+', '', $mobile);
    // get first 4 charset
    $mobile_first = mb_substr($mobile, 0, 4);
    // get last 2 charset
    $mobile_last = mb_substr($mobile, -2);
    // get hidden string
    // $hidden = mb_substr($mobile, 4, 3);
    $hidden = str_replace($mobile_first, '', $mobile);
    $hidden = str_replace($mobile_last, '', $hidden);

    $snowflakes = '';

    for ($i=0; $i < strlen($hidden); $i++) {

      $snowflakes .= "*";

    } // end foreach

    $modified_phone = $mobile_first . $snowflakes . $mobile_last;


    $output = array(
      "status" => 1,
      "errorMessage" => "წარმატებული",
      "mobile" => $modified_phone,

    );

  } else {

    $output = array(
      "status" => 0,
      "errorMessage" => "მომხმარებელი ვერ მოიძებნა",
      "phone" => '',
    );

  }



echo json_encode($output);

} else if (isset($post['wallet_number']) && isset($post['mobile'])) {

  $wallet_number = $post['wallet_number'];
  $mobile = $post['mobile'];

  // check user
  $data = $db->get_date("users", " `wallet_number` = '".$wallet_number."' ");

  // remove spaces
  $db_mobile = str_replace(' ', '', $data['mobile']);
  // remove +
  $db_mobile = str_replace('+', '', $db_mobile);

  if ($mobile == $db_mobile) {


    // reset password
    $new_pass = $db->generate_random_string(8);
    $password_hash = hash('sha256', $new_pass);
    $user_id = $data['id'];

    $params = array(
      "password" => $password_hash,
      "updated_at" => $db->get_current_date(),
    );

    $db->update("users", $params, $user_id);

    // send sms
    $new_pass = 'საფულის ნომერი: ' . $wallet_number . ' ახალი პაროლი: ' . $new_pass;

    $send = $sms->send($mobile,"apw.ge",$new_pass);

    // if send
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
    }

    // get error mesage
    $error_msg = $db->get_date("sms_error"," `id` = '".$error_code."' ");

    // sms logg
    $date = date('Y-m-d h:i:s');
    $response = json_encode($send);

    $sms_params = array(
      "title" => 'apw.ge',
      "sms" => $new_pass,
      "number" => $mobile,
      "date" => $date,
      "error_code" => $error_code,
      "response" => $response,
    );

    $db->insert("sms_logs", $sms_params);

    //

    if ($error_code == 1) {

      $output = array(
        "status" => 2,
        "errorMessage" => "ახალი პაროლი წარმატებით გაიგზავნა მითითებულ ტელეფონის ნომერზე",
        "phone" => '',
      );

    } else {

      $output = array(
        "status" => 0,
        "errorMessage" => "No valid phones found",
        //დროებითი ტექნიკური შეფერხებაა
      );

    }


  } else {

    $output = array(
      "status" => 0,
      "errorMessage" => "ტელეფონის ნომერი არასწორია",
      "phone" => '',
    );

  }

  echo json_encode($output);

} //
