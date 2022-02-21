<?php

require_once('./../classes/config.php');
require_once('./../classes/db.php');

$db = new db();
// check user
if ($db->check_auch() == true && !isset($_GET['balance'])) {

  echo 1;

} elseif(isset($_GET['balance'])) {

  // check user balance
  $username = $_SESSION["user_name"];

  $user = $db->get_date_row("users","balance"," `personal_number` = '".$username."' ");

  $json = array(
        "balance" => $user['balance'],
    );

  echo json_encode($json);


} else {

  echo 0;

}
