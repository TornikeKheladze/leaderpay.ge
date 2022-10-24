<?php

    require 'classes/config.php';
    require 'classes/db.php';
    require 'classes/static.php';

    $db = new db();
    // lang cookie
    $cookie = new cookie();

    // if auth get user info
    // check user
    if ($db->check_auch() == true) {
      // get user info
      $username = $_SESSION["user_name"];
      $token = $_SESSION["token"];
      $user = $db->get_date("users"," `personal_number` = '".$username."' AND `token` = '".$token."' ");
    //  print_r($_SESSION);
    }
    // var_dump($user);

    // if ($cookie::check('lang') == true) {
    //
    //   // get language
    //   $lang = $cookie::get('lang');
    //
    // } else {
    include 'lang.php';

 ?>
