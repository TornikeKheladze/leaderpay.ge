<?php

require '../classes/static.php';

$cookie = new cookie();

if (isset($_GET['lang'])) {

    if ($cookie::set("lang", $_GET['lang'], time()+100000000) == true) {

        $page_uri = explode('lang', $_SERVER['REQUEST_URI']);
        header('Location:'.$page_uri[0]);

    }

    $lang_id = $cookie::get('lang');

} else {

    if ($cookie::check('lang') == true) {

        $lang_id = $cookie::get('lang');

    } else {

        $lang_id = "ge";

    }

}

include "../language/$lang_id.php";

require '../classes/config.php';
require '../classes/db.php';
require '../classes/Identomat.php';
require '../classes/Upload.php';
require '../classes/Risk.php';
require '../classes/Payway.php';

$db = new db();
$Identomat = new Identomat($db);
$Upload = new Upload();
$Risk = new Risk();

$Payway = new Payway($db, 'WalletRegistration');

if (isset($post['step']) && $post['step'] == 1) {

    $mustParams = [
        'first_name1' => true,
        'last_name1' => true,
        'personal_number1' => true,

        'mobile' => true,
        'email' => true,
        'legal_address' => true,
        'real_address' => true,
        'password' => true,
        'repeat_password' => true,
    ];

    foreach($mustParams as $k => $v) {

        if ($v == true) {

            if (!isset($post[$k])) {

                $json = [
                    'errorCode' => 1,
                    'errorMessage' => "პარამეტრი '$k' არ არის გადმოცემული!",
                ];
                echo json_encode($json);
                die();
            }

        }

    }

    //payway
    $paywayPost = [
        'first_name' => $post['first_name1'],
        'last_name' => $post['last_name1'],
        'personal_no' => $post['personal_number1'],
        'mobile' => $post['mobile'],
    ];

    $Payway->post = $paywayPost;
    $paywayCheck = $Payway->check();

    if ($paywayCheck['errorCode'] != 100) {

        $json = [
            'errorCode' => 1,
            'errorMessage' => $paywayCheck['errorMessage']
        ];
        echo json_encode($json);
        die();

    }

    $mobile = trim($post['mobile']);
    $email = trim($post['email']);
    $personal_number1 = trim($post['personal_number1']);

    $password = trim($post['password']);
    $repeat_password = trim($post['repeat_password']);

    if ($password != $repeat_password) {

        $json = [
            'errorCode' => 2,
            'errorMessage' => 'გამეორებული პაროლი არ ემთხვევა!',
        ];
        echo json_encode($json);
        die();

    }

//    $mobileUser = $db->get_date('users', " mobile = '$mobile' ");
//    $emailUser = $db->get_date('users', " email = '$email' ");

    $mobileUser = $db->MobileUser($mobile);
    $emailUser = $db->EmailUser($email);
    $personalUser = $db->UserByWalletNumber($personal_number1);

    if ($mobileUser) {

        $json = [
            'errorCode' => 3,
            'errorMessage' => $lang['unique_phone'],
        ];
        echo json_encode($json);
        die();

    }

    if ($emailUser) {

        $json = [
            'errorCode' => 4,
            'errorMessage' => $lang['unique_email'],
        ];
        echo json_encode($json);
        die();

    }

    if ($personalUser) {

        $json = [
            'errorCode' => 3,
            'errorMessage' => $lang['user_exist'],
        ];
        echo json_encode($json);
        die();

    }

    $json = [
        'errorCode' => 10,
        'errorMessage' => 'წარმატებული',
        'data' => [
            'session' => $Identomat->begin(),
        ],
    ];
    echo json_encode($json);
    die();

}

if (isset($post['step']) && $post['step'] == '2') {

    $mustParams = [
        'iToken' => true,
        'mobile' => true,
        'email' => true,
        'legal_address' => true,
        'real_address' => true,
        'password' => true,
        'repeat_password' => true,
    ];

    foreach($mustParams as $k => $v) {

        if ($v == true) {

            if (!isset($post[$k])) {

                $json = [
                    'errorCode' => 1,
                    'errorMessage' => "პარამეტრი '$k' არ არის გადმოცემული!",
                ];
                echo json_encode($json);
                die();
            }

        }

    }

    $token = trim($post['iToken']);

    $Identomat = new Identomat($db, $token);
    $result = $Identomat->result();

    if ($result == 'SESSION_NOT_FOUND') {

        $resultStatus = 'SESSION_NOT_FOUND';
        $rejectReason = 'SESSION_NOT_FOUND';

    } else {

        $resultStatus = $result['result'];
        $rejectReason = $result['reject_reason']['value'];

    }

    if ($resultStatus == 'approved') {

        $personal_number = $result['person']['personal_number'];
        $document_number = $result['person']['document_number'];

        $mobile = trim($post['mobile']);
        $email = trim($post['email']);
        $password = trim($post['password']);
        $password = hash('sha256', $password);
        $legal_address = trim($post['legal_address']);
        $real_address = trim($post['real_address']);

        $user = $db->UserByWalletNumber($personal_number);

        if ($user) {

            $json = [
                'errorCode' => 3,
                'errorMessage' => $lang['user_exist'],
            ];
            echo json_encode($json);
            die();

        }

        if ($result['document_type'] == 'id') {

            $documentFront = 'data:image/jpeg;base64,' . $Identomat->documentFront();
            $documentBack = 'data:image/jpeg;base64,' . $Identomat->documentBack();

        }

        if ($result['document_type'] == 'passport') {

            $documentFront = 'data:image/jpeg;base64,' . $Identomat->passport();

        }

        $self = 'data:image/jpeg;base64,' . $Identomat->self();

        $today = date('Y-m-d');
        $diff = date_diff(date_create($result['person']['birthday']), date_create($today));
        $age = $diff->format('%y');

        if ($age < 18 ) {

            $json = [
                'errorCode' => 4,
                'errorMessage' => $lang['user_must_18'],
            ];
            echo json_encode($json);
            die();

        }

        // upload
        $document_front_name = $personal_number . '-' . $document_number . '-imageFront';
        $document_back_name = $personal_number . '-' . $document_number . '-imageRear';
        $dir = 'files/documents/';

        $document_front = $Upload->file([
            'file'      => $documentFront,
            'file_name' => $document_front_name,
            'dir'       => $dir,
        ]);

        if ($result['document_type'] == 'id') {

            $document_back = $Upload->file([
                'file'      => $documentBack,
                'file_name' => $document_back_name,
                'dir'       => $dir,
            ]);

        }

        // upload
        $self_name = $personal_number . '-' . '-self';
        $dir = 'files/self/';

        $self = $Upload->file([
            'file'      => $self,
            'file_name' => $self_name,
            'dir'       => $dir,
        ]);

        $userParams = [
            'wallet_number' => $personal_number,
            'personal_number' => $personal_number,
            'mobile' => $email,
            'mobile' => $mobile,
            'legal_address' => $legal_address,
            'real_address' => $real_address,
            'password' => $password,
            'country' => substr_replace($result['person']['citizenship'], '', -1),
            'first_name' => $result['person']['local_first_name'],
            'last_name' => $result['person']['local_last_name'],
            'birth_date' => date('Y-m-d', strtotime($result['person']['birthday'])),
            'birth_place' => $result['person']['birth_place'],
            'gender' => ($result['person']['sex'] == 'M') ? 1 : 2,
            'user' => 'leaderpay.ge',
            'self' => $self,
        ];
        $documentParams = [
            'personal_number' => $personal_number,
            'document_number' => $document_number,
            'document_type' => ($result['document_type'] == 'id') ? 2 : 1,
            'issue_organisation' => (isset($result['person']['local_authority'])) ? $result['person']['local_authority'] : $result['person']['authority'],
            'issue_date' => date('Y-m-d', strtotime($result['person']['document_issued'])),
            'expiry_date' => date('Y-m-d', strtotime($result['person']['document_expires'])),
            'expiry' => 0,
            'document_front' => $document_front,
            'document_back' =>  ($result['document_type'] == 'id') ? $document_back : '',
            'user' => 'leaderpay.ge',
            'was_done' => 1,
        ];

        $db->insert('users', $userParams);
        $db->insert('users_documents', $documentParams);

    } else if ($resultStatus == 'manual_check') {

        $json = [
            'errorCode' => 5,
            'errorMessage' => $lang['user_checking'],
        ];

        echo json_encode($json);
        die();

    } else {

        $json = [
            'errorCode' => 6,
            'errorMessage' => $rejectReason,
        ];

        echo json_encode($json);
        die();
    }

    $json = [
        'errorCode' => 10,
        'errorMessage' => 'წარმატებული',
        'data' => [
            'personal_number' => $personal_number,
        ],
    ];

    echo json_encode($json);
    die();
}

if (isset($post['step']) && $post['step'] == '3') {

    $mustParams = [
        'pNumber' => true,
        'dual_citizen' => true,
        'country2' => (@$post['dual_citizen'] == 1) ? true : false,
        'birth_country' => true,
        'employee_status' => true,
        'sfero_id' => (@$post['employee_status'] == 1) ? true : false,
        'job_title' => (@$post['employee_status'] == 1) ? true : false,
        'occupied_position' => (@$post['employee_status'] == 1) ? true : false,
        'self_employed' => (@$post['employee_status'] == 2) ? true : false,
        'source_of_income' => (@$post['employee_status'] == 3) ? true : false,
        'monthly_income' => true,
        'expected_turnover' => true,
        'purpose_id' => true,
        'pep_status' => true,
        'pep' => (@$post['pep_status'] == 1) ? true : false,
        'checkbox' => true,
    ];

    foreach($mustParams as $k => $v) {

        if ($v == true) {

            if (!isset($post[$k])) {

                $json = [
                    'errorCode' => 1,
                    'errorMessage' => "პარამეტრი '$k' არ არის გადმოცემული!",
                ];
                echo json_encode($json);
                die();
            }

        }

    }

    $pNumber = trim($post['pNumber']);
    $dual_citizen = (INT) $post['dual_citizen'];
    $country2 = trim($post['country2']);
    $birth_country = trim($post['birth_country']);
    $employee_status = (INT) $post['employee_status'];
    $sfero_id = (INT) $post['sfero_id'];
    $job_title = trim($post['job_title']);
    $occupied_position = trim($post['occupied_position']);
    $self_employed = (INT) $post['self_employed'];
    $source_of_income = (INT) $post['source_of_income'];
    $monthly_income = (INT) $post['monthly_income'];
    $expected_turnover = (INT) $post['expected_turnover'];
    $purpose_id = (INT) $post['purpose_id'];
    $pep_status = (INT) $post['pep_status'];
    $pep = (INT) $post['pep'];

    $user = $db->UserByWalletNumber($pNumber);

    if (!$user) {

        $json = [
            'errorCode' => 3,
            'errorMessage' => 'ტექნიკური შეფერხება!',
        ];
        echo json_encode($json);
        die();

    }

    $userParams = [
        'dual_citizen' => $dual_citizen,
        'birth_country' => $birth_country,
        'employee_status' => $employee_status,
        'monthly_income' => $monthly_income,
        'expected_turnover' => $expected_turnover,
        'purpose_id' => $purpose_id,
        'pep_status' => $pep_status,
        'confirmation' => 0,
    ];

    if ($dual_citizen == 1) {
        $userParams['country2'] = $country2;
    }
    if ($employee_status == 1) {
        $userParams['sfero_id'] = $sfero_id;
        $userParams['job_title'] = $job_title;
        $userParams['occupied_position'] = $occupied_position;
    }
    if ($employee_status == 2) {
        $userParams['self_employed'] = $self_employed;
    }
    if ($employee_status == 3) {
        $userParams['source_of_income'] = $source_of_income;
    }
    if ($pep_status == 1) {
        $userParams['pep'] = $pep;
    }

    $db->update('users', $userParams, $user['id']);

    // detect risk
    $Risk->Get($user['id']);

    $json = [
        'errorCode' => 10,
        'errorMessage' => $lang['registration_completed'],
        'data' => [
            'personal_number' => $pNumber,
        ],
    ];

    echo json_encode($json);
    die();

}
