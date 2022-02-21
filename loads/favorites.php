<?php

require '../classes/config.php';
require '../classes/db.php';
$db = new db();



if ($db->check_auch() == true) {

  // get user info
  $username = $_SESSION["user_name"];
  $token = $_SESSION["token"];
  $user = $db->get_date("users"," `personal_number` = '".$username."' AND `token` = '".$token."' ");

} else {

  die();

}

if (isset($_GET['action']) && $_GET['action'] == "add" && isset($_GET['id']) && isset($_GET['logo'])) {

  $id = intval($_GET['id']);
  $logo = (string)$_GET['logo'];
  $date = date('Y-m-d h:i:s');

  $params = array(
    "user_id"    => $user['id'],
    "service_id" => $id,
    "logo" => $logo,
    // replace this
    "created_at" => $date
  );

  if ($db->get_date("favorites"," `user_id` = '".$user['id']."' AND `service_id` = '".$id."' ") === false) {

    $db->insert("favorites",$params);

    echo 1;

  } else {

    echo 0;

  }


} elseif(isset($_GET['action']) && $_GET['action'] == "remove" && isset($_GET['id'])) {

  $id = intval($_GET['id']);

  $db->delete("favorites"," `user_id` = '".$user['id']."' AND `service_id` = '".$id."' ");

}
