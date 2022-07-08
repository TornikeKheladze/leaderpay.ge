<?php

  require '../classes/config.php';
  require '../classes/db.php';
  require '../classes/bulkSms.php';

  $db = new db();
  $bulkSms = new bulkSms();


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
    $data = $db->UserByWalletNumber($wallet_number);

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
    $data = $db->UserByWalletNumber($wallet_number);

    // remove spaces
    $db_mobile = str_replace(' ', '', $data['mobile']);
    // remove +
    $db_mobile = str_replace('+', '', $db_mobile);

    if ($mobile == $db_mobile) {

      // reset password
      $new_pass = $db->generate_random_string(8);
      $password_hash = hash('sha256', $new_pass);
      $user_id = $data['id'];

      $params = [
        'password' => $password_hash,
        'updated_at' => $db->get_current_date(),
      ];

      $db->update('users', $params, $user_id);

      $mobile = ltrim($data['mobile'], '+');
      $mobile = str_replace(' ', '', $mobile);

      $smsParams = [
          'number' => $mobile,
          'text' => "Wallet Number: $wallet_number New Password: $new_pass",
      ];

      $send = $bulkSms->Send($smsParams);

      if ($send) {

        $output = [
          'status' => 2,
          'errorMessage' => 'ახალი პაროლი წარმატებით გაიგზავნა მითითებულ ტელეფონის ნომერზე',
          'phone' => '',
        ];

      } else {

        $output = [
          'status' => 0,
          'errorMessage' => 'დროებითი ტექნიკური შეფერხებაა',
        ];

      }

    } else {

      $output = [
        'status' => 0,
        'errorMessage' => 'ტელეფონის ნომერი არასწორია',
        'phone' => '',
      ];

    }

    echo json_encode($output);

  }
