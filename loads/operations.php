<?php

    require '../classes/static.php';

    $cookie = new cookie();

    if (isset($get['lang'])) {

        // set language
        if ($cookie::set('lang', $get['lang'], time()+100000000) == true) {

            $page_uri = explode('lang', $_SERVER['REQUEST_URI']);
            header("Location: $page_uri[0]");

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

    include "../language/$lang_id.php";

    require '../classes/config.php';
    require '../classes/db.php';

    $db = new db();

    if ($db->check_auch() == true) {

        // get user info
        $username = $_SESSION['user_name'];
        $token = $_SESSION['token'];
        $user = $db->get_date('users', " `personal_number` = '$username' AND `token` = '$token' ");

    } else {

        die();

    }

    $status_id = intval(@$get['status_id']);
    $type_id = intval(@$get['type_id']);
    $from_date = (!@preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', @$get['from_date'])) ? '' : @$get['from_date'];
    $to_date = (!@preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', @$get['to_date'])) ? '' : @$get['to_date'];

    $from_amount = floatval(@$get['from_amount']);
    $to_amount = floatval(@$get['to_amount']);

    $where = " `wallet_number` = '$username' ";
    $where .= ($status_id != '' AND $status_id != 0) ? " AND status_id = '$status_id' " : '';
    $where .= ($type_id != '' AND $type_id != 0) ? " AND type_id = '$type_id' " : '';
    $where .= ($from_date != '') ? " AND DATE(`created_at`) >= '$from_date' " : '';
    $where .= ($to_date != '') ? " AND DATE(`created_at`) <= '$to_date' " : '';
    $where .= ($from_amount != '' && $from_amount != 0) ? " AND `amount` >= '$from_amount' " : '';
    $where .= ($to_amount != '' && $to_amount != 0) ? " AND `amount` <= '$to_amount' " : '';

    $sortColArr = ['created_at', 'created_at', 'amount', 'amount', 'created_at'];

    $sortColum = $sortColArr[intval(@$_REQUEST['order'][0]['column'])];
    $sort = strtoupper(trim(@$_REQUEST['order'][0]['dir']));
    $sort = ($sort == 'DESC') ? 'DESC' : 'ASC';

    $iTotalRecords = $db->getSql("SELECT COUNT(id) AS count FROM card_operations WHERE $where ");

    $iTotalRecords = $iTotalRecords['count'];

    $iDisplayLength = intval($_REQUEST['length']);
    $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
    $iDisplayStart = intval($_REQUEST['start']);
    $sEcho = intval($_REQUEST['draw']);

    $records = [];
    $records['data'] = [];

    $end = $iDisplayStart / $iDisplayLength;
    $end = $end > $iTotalRecords ? $iTotalRecords : $end;
    $end = $end + 1;
    $start = $end * $iDisplayLength;
    $start = $start - $iDisplayLength;

    $rows = $db->getListSql("SELECT * FROM card_operations WHERE $where ORDER BY $sortColum $sort LIMIT $start,$iDisplayLength");

    $statusList = [
        1 => '<p class="text-primary">რეგისტრირებული</p>',
        2 => '<p class="text-success">შესრულებული</p>',
        3 => '<p class="text-danger">გაუქმებული</p>',
    ];
    $tipesList = [
        1 => 'ბარათის მიბმა',
        2 => 'თანხის გატანა',
    ];

    foreach($rows as $r) {

        $records['data'][] = [
            $statusList[$r['status_id']],
            $tipesList[$r['type_id']],
            $r['amount'],
            $r['created_at'],
            $r['commision'],
        ];
    }

    if (isset($_REQUEST['customActionType']) && $_REQUEST['customActionType'] == 'group_action') {
        $records['customActionStatus'] = 'OK';
        $records['customActionMessage'] = 'Group action successfully has been completed. Well done!';
    }

    $records['draw'] = $sEcho;
    $records['recordsTotal'] = $iTotalRecords;
    $records['recordsFiltered'] = $iTotalRecords;

    echo json_encode($records);