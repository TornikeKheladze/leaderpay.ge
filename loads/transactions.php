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

    $from_date = (!@preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', @$get['from_date'])) ? '' : @$get['from_date'];
    $to_date = (!@preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', @$get['to_date'])) ? '' : @$get['to_date'];

    $from_amount = floatval(@$get['from_amount']);
    $to_amount = floatval(@$get['to_amount']);

    $where = " `personal_number`  = '$username' ";
    $where .= ($from_date != '') ? " AND DATE(`date`) >= '$from_date' " : '';
    $where .= ($to_date != '') ? " AND DATE(`date`) <= '$to_date' " : '';
    $where .= ($from_amount != '' && $from_amount != 0) ? " HAVING amount >= '$from_amount' " : '';
    $where .= ($to_amount != '' && $to_amount != 0) ? " AND amount <= '$to_amount' " : '';

    $sortColArr = ['date', 'date', 'credit', 'balance', 'id'];

    $sortColum = $sortColArr[intval(@$_REQUEST['order'][0]['column'])];
    $sort = strtoupper(trim(@$_REQUEST['order'][0]['dir']));
    $sort = ($sort == 'DESC') ? 'DESC' : 'ASC';

    $iTotalRecords = $db->getSql("SELECT COUNT(id) AS count, IF(credit > 0, credit, debt) AS amount, IF(credit > 0, 1, 0) AS type FROM user_balance_history WHERE $where ");

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

    $rows = $db->getListSql("SELECT date, description, IF(credit > 0, credit, debt) AS amount, IF(credit > 0, 1, 0) AS type, balance FROM user_balance_history WHERE $where ORDER BY $sortColum $sort LIMIT $start,$iDisplayLength");

    foreach($rows as $r) {

        $records['data'][] = [
            $r['date'],
            $r['description'],
            ($r['type'] == 1) ? '<span class="plus"><i class="fa fa-plus" aria-hidden="true"></i> ' . $r['amount'] . ' ' . $lang['gel'] .'</span>' :  '<span class="minus"><i class="fa fa-minus" aria-hidden="true"></i> ' . $r['amount'] . ' ' . $lang['gel'] .'</span>',
            $r['balance'],
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