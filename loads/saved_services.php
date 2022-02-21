<?php

require '../classes/config.php';
require '../classes/db.php';


$db = new db();


// check auch

if ($db->check_auch() == true) {

  // get user info
  $username = $_SESSION["user_name"];
  $token = $_SESSION["token"];
  $user = $db->get_date("users"," `personal_number` = '".$username."' AND `token` = '".$token."' ");

} else {

  die();

}


if (isset($get['saved_services_list'])) {

  $user_id = $username;

  $services = $db->get_unlimited_list("save_service"," user_id = '".$user_id."' ","id","desc");

  $array = array(
    "code" => 1,
    "msg" => 'წარმატებული',
    "data" => $services
  );
  echo json_encode($array);


} elseif(isset($get['saved_services_list_by_id'])) {

  $id = intval($get['saved_services_list_by_id']);

  $user_id = $username;

  $services = $db->get_unlimited_list("save_service"," user_id = '".$user_id."' AND service_id = '".$id."' ","id","desc");

  $array = array(
    "code" => 1,
    "msg" => 'წარმატებული',
    "data" => $services
  );
  echo json_encode($array);



} elseif(isset($get['delete'])) {

  $user_id = $username;
  $id = intval($get['delete']);

  if ($db->delete("save_service"," user_id = '".$user_id."' AND id = '".$id."' ")) {

    $array = array(
      "code" => 1,
      "msg" => 'წაშლა წარმატებით განხორციელდა',
    );
    echo json_encode($array);

  }


}
