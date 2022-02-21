<?php

require '../classes/static.php';

$cookie = new cookie();

if (isset($_GET['lang'])) {

  // set language
  if ($cookie::set("lang", $_GET['lang'], time()+100000000) == true) {

    $page_uri = explode('lang', $_SERVER['REQUEST_URI']);
    header('Location:'.$page_uri[0]);

  }


  // get language
  $lang_id = $cookie::get('lang');

} else {

  if ($cookie::check('lang') == true) {

    // get language
    $lang_id = $cookie::get('lang');

  } else {

    // default language
    $lang_id = "ge";

  }

}

include '../language/'.$lang_id.'.php';

require '../classes/config.php';
require '../classes/db.php';
require '../classes/billing.php';

$billing = new billing();
$db = new db();

if ($db->check_auch() == true) {

  // get user info
  $username = $_SESSION["user_name"];
  $token = $_SESSION["token"];
  $user = $db->get_date("users"," `personal_number` = '".$username."' AND `token` = '".$token."' ");

} else {

  die();

}

$where_str = " `personal_number`  = '".$username."' ";


if (isset($_POST['from_date']) && !empty($_POST['from_date']) && $_POST['from_date'] != " " ) {

  $from_date = $_POST['from_date'];

  $where_str .= " AND DATE(`date`) >= '".$from_date."' ";

}

if (isset($_POST['to_date']) && !empty($_POST['to_date']) && $_POST['to_date'] != " " ) {

  $to_date = $_POST['to_date'];

  $where_str .= " AND DATE(`date`) <= '".$to_date."' ";

}

if (isset($_POST['from_amount']) && !empty($_POST['from_amount']) && $_POST['from_amount'] != " ") {

  $from_amount = $_POST['from_amount'];

  $where_str .= " AND `credit` >= '".$from_amount."' ";

}

if (isset($_POST['to_amount']) && !empty($_POST['to_amount']) && $_POST['to_amount'] != " ") {

  $to_amount = $_POST['to_amount'];

  $where_str .= " AND `credit` <= '".$to_amount."' ";

}

if (isset($_POST['limit'])) {

  $limit = intval($_POST['limit']);

} else {

  $limit = 10;

}


$balance_history = $db->get_limited_list("user_balance_history", $where_str, "id", "DESC",$limit);

$count = $db->table_count("user_balance_history", $where_str);

$transactions = array();


if ($balance_history != false) {

  $r['count'] = "";

  foreach ($balance_history as $history) {

    $amount = '';

    if ($history['type_id'] == 1 OR $history['type_id'] == 5 OR $history['type_id'] == 8) {

      $amount .= '<span class="plus"><i class="fa fa-plus" aria-hidden="true"></i> ';

      $amount .= $history['credit'].' ';

    } elseif ($history['type_id'] == 2 OR $history['type_id'] == 6 OR $history['type_id'] == 7) {

      $amount .= '<span class="minus"><i class="fa fa-minus" aria-hidden="true"></i> ';

      $amount .= $history['debt'].' ';

    } elseif ($history['type_id'] == 3) {

      $amount .= '<span class="minus"><i class="fa fa-minus" aria-hidden="true"></i> ';

      $amount .= $history['debt'].' ';

    } elseif ($history['type_id'] == 4) {

      $amount .= '<span class="minus"><i class="fa fa-minus" aria-hidden="true"></i> ';

      $amount .= $history['debt'].' ';

    }

    $amount .= $lang['gel'];

    // status
    // $status = $billing->get_operation_status($history['operation_id']);
    // //
    // if ($status['errorCode'] == 1000) {
    //
    //   $operation_status = $status['operation']['status'];
    //
    // } else {
    //
    //   $operation_status = ".....";
    //
    // }
    // var_dump($status);
    // tananianur anonce and imfrastruqture invalid

    array_push($transactions,
		    array(
			    "date" => $history['date'],
			    "description" => $history["description"],
          // "status"  =>  "",
			    "amount" => $amount,
			    "balance" => $history['balance'],
			)
		);

  } //

}

$json = array(
      "count" => $count,
      "transactions" => $transactions,
  );

echo json_encode($json);
