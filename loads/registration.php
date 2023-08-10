<?php

die();
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
    //require '../classes/Payway.php';
    require '../classes/Transguard.php';
    require '../classes/Sda.php';

    $db = new db();
    $Identomat = new Identomat($db);
    $Upload = new Upload();
    $Risk = new Risk();
    $Sda = new Sda($db);

    //$Payway = new Payway($db, 'WalletRegistration');
    $Transguard = new Transguard($db, 'WalletRegistration');

    if (isset($post['step']) && $post['step'] == 1) {

        $mustParams = [
            'mobile' => true,
            'email' => true,
            'real_address' => true,
            'password' => true,
            'repeat_password' => true,
            'pep_status' => true,
            'pep' => (@$post['pep_status'] == 1) ? true : false,
            'limits' => true,
            'privacy_policy' => true,
            'contract' => true,
        ];

        foreach($mustParams as $k => $v) {

            if ($v == true) {

                if (!isset($post[$k])) {

                    $json = [
                        'errorCode' => 1,
                        'errorMessage' => "პარამეტრი '$k' არ არის გადმოცემული!",
                    ];
                    $db->insert('registration_logs', ['method' => 'registration', 'step' => 1, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
                    echo json_encode($json);
                    die();
                }

            }

        }

        $mobile = trim($post['mobile']);
        $email = trim($post['email']);

        $password = trim($post['password']);
        $repeat_password = trim($post['repeat_password']);

        if ($password != $repeat_password) {

            $json = [
                'errorCode' => 2,
                'errorMessage' => 'გამეორებული პაროლი არ ემთხვევა!',
            ];
            $db->insert('registration_logs', ['method' => 'registration', 'step' => 1, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
            echo json_encode($json);
            die();

        }

    //    $mobileUser = $db->get_date('users', " mobile = '$mobile' ");
    //    $emailUser = $db->get_date('users', " email = '$email' ");

        $mobileUser = $db->MobileUser($mobile);
        $emailUser = $db->EmailUser($email);

        if ($mobileUser) {

            $json = [
                'errorCode' => 3,
                'errorMessage' => $lang['unique_phone'],
            ];
            $db->insert('registration_logs', ['method' => 'registration', 'step' => 1, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
            echo json_encode($json);
            die();

        }

        if ($emailUser) {

            $json = [
                'errorCode' => 4,
                'errorMessage' => $lang['unique_email'],
            ];
            $db->insert('registration_logs', ['method' => 'registration', 'step' => 1, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
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
        $db->insert('registration_logs', ['method' => 'registration', 'step' => 1, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
        echo json_encode($json);
        die();

    }

    if (isset($post['step']) && $post['step'] == '2') {

        $mustParams = [
            'iToken' => true,
            'mobile' => true,
            'email' => true,
            'real_address' => true,
            'password' => true,
            'repeat_password' => true,
            'pep_status' => true,
            'pep' => (@$post['pep_status'] == 1) ? true : false,
            'limits' => true,
            'privacy_policy' => true,
            'contract' => true,
        ];

        foreach($mustParams as $k => $v) {

            if ($v == true) {

                if (!isset($post[$k])) {

                    $json = [
                        'errorCode' => 1,
                        'errorMessage' => "პარამეტრი '$k' არ არის გადმოცემული!",
                    ];
                    $db->insert('registration_logs', ['method' => 'registration', 'step' => 2, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
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

            if ($result['person']['citizenship'] == 'GEO') {

                $personal_number = $result['person']['personal_number'];
                $first_name = $result['person']['local_first_name'];
                $last_name = $result['person']['local_last_name'];

            } else {

                $personal_number = $db->generateWalletNumber();
                $first_name = $result['person']['first_name'];
                $last_name = $result['person']['last_name'];

            }

            $document_number = $result['person']['document_number'];

            $mobile = trim($post['mobile']);
            $email = trim($post['email']);
            $password = trim($post['password']);
            $password = hash('sha256', $password);
            $real_address = trim($post['real_address']);
            $pep_status = (INT) $post['pep_status'];
            $pep = (INT) $post['pep'];

    //        $sdaCheck = $Sda->Check($personal_number, $document_number);
    //
    //        if ($sdaCheck['status'] != 200) {
    //
    //            $json = [
    //                'errorCode' => 3,
    //                'errorMessage' => 'დოკუმენტმა ვერ გაიარა ვალიდაცია სერვისების განვითარების სააგენტოში!',
    //            ];
    //            echo json_encode($json);
    //            die();
    //
    //        }

            $user = $db->UserByWalletNumber($personal_number);

            if ($user) {

                $json = [
                    'errorCode' => 3,
                    'errorMessage' => $lang['user_exist'],
                ];
                $db->insert('registration_logs', ['method' => 'registration', 'step' => 2, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
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
                $db->insert('registration_logs', ['method' => 'registration', 'step' => 2, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
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
                'email' => $email,
                'mobile' => $mobile,
                'real_address' => $real_address,
                'password' => $password,
                'country' => substr_replace($result['person']['citizenship'], '', -1),
                'first_name' => $first_name,
                'last_name' => $last_name,
                'birth_date' => date('Y-m-d', strtotime($result['person']['birthday'])),
                'birth_place' => $result['person']['birth_place'],
                'gender' => ($result['person']['sex'] == 'M') ? 1 : 2,
                'user' => 'leaderpay.ge',
                'verified_at' => date('Y-m-d H:i:s'),
                'confirmation' => 1,
                'verify_id' => 3,
                'verify_type' => 1,
                'selfie' => $self,
                'pep_status' => $pep_status,
                'pep' => $pep,
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

            $user_id = $db->insert('users', $userParams);
            $db->insert('users_documents', $documentParams);
            // detect risk
            $Risk->Get($user_id);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://leaderpay.ge/loads/pep.php');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, ['personal_number' => $personal_number]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            $result = trim(curl_exec($ch));
            curl_close($ch);

        } else if ($resultStatus == 'manual_check') {

            $json = [
                'errorCode' => 5,
                'errorMessage' => $lang['user_checking'],
            ];
            $db->insert('registration_logs', ['method' => 'registration', 'step' => 2, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
            echo json_encode($json);
            die();

        } else {

            $json = [
                'errorCode' => 6,
                'errorMessage' => $rejectReason,
            ];
            $db->insert('registration_logs', ['method' => 'registration', 'step' => 2, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
            echo json_encode($json);
            die();
        }

        //payway
//        $paywayPost = [
//            'first_name' => $first_name,
//            'last_name' => $last_name,
//            'personal_no' => $personal_number,
//            'mobile' => $mobile,
//        ];
//
//        $Payway->post = $paywayPost;
//        $paywayCheck = $Payway->check();

        $transPost = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'resident' =>  substr_replace($result['person']['citizenship'], '', -1),
            'document_id' => (substr_replace($result['person']['citizenship'], '', -1) == 'GE') ? $personal_number : $document_number,
            'passport_id' => $document_number,
            //'legal_address' => '',
            'actual_address' => $real_address,
            'birth_date' => date('Y-m-d', strtotime($result['person']['birthday'])),
        ];
        $Transguard->post = $transPost;
        $transCheck = $Transguard->check();

        if ($transCheck['errorCode'] != 100) {

            $json = [
                'errorCode' => 7,
                'errorMessage' => $transCheck['errorMessage']
            ];

            $db->insert('registration_logs', ['method' => 'registration', 'step' => 2, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
            echo json_encode($json);
            die();

        }

        $json = [
            'errorCode' => 10,
            'errorMessage' => $lang['registration_completed'] . ' ' . $lang['wallet_number2'] . ': ' . $personal_number,
            'data' => [
                'personal_number' => $personal_number,
            ],
        ];
        $db->insert('registration_logs', ['method' => 'registration', 'step' => 2, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
        echo json_encode($json);
        die();
    }

    if (isset($post['verification']) && $post['verification'] == '1') {

        if ($db->check_auch() === false) {

            $json = [
                'errorCode' => 1,
                'errorMessage' => 'არა ავტორიზებული მომხმარებელი',
            ];
            $db->insert('registration_logs', ['method' => 'verification', 'step' => 1, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
            echo json_encode($json);
            die();

        }
        $Identomat->body['flags'] = [
            'language' => 'ka',
            'document_types' => ['id', 'passport'],
            'allow_document_upload' => true,
            'skip_desktop' => false,
            'skip_face' => true,
        ];

        $json = [
            'errorCode' => 10,
            'errorMessage' => 'წარმატებული',
            'data' => [
                'session' => $Identomat->begin(),
            ],
        ];
        $db->insert('registration_logs', ['method' => 'verification', 'step' => 1, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
        echo json_encode($json);
        die();
    }

    if (isset($post['verification']) && $post['verification'] == '2') {

        if ($db->check_auch() === false) {

            $json = [
                'errorCode' => 1,
                'errorMessage' => 'არა ავტორიზებული მომხმარებელი',
            ];
            $db->insert('registration_logs', ['method' => 'verification', 'step' => 2, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
            echo json_encode($json);
            die();

        } else {

            $personal_number = $_SESSION['user_name'];

        }

        $mustParams = [
            'iToken' => true,
        ];

        foreach($mustParams as $k => $v) {

            if ($v == true) {

                if (!isset($post[$k])) {

                    $json = [
                        'errorCode' => 1,
                        'errorMessage' => "პარამეტრი '$k' არ არის გადმოცემული!",
                    ];
                    $db->insert('registration_logs', ['method' => 'verification', 'step' => 2, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
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

            $document_number = $result['person']['document_number'];

            if ($personal_number != $result['person']['personal_number']) {

                $json = [
                    'errorCode' => 1,
                    'errorMessage' => 'არასწორი დოკუმენტი',
                ];
                $db->insert('registration_logs', ['method' => 'verification', 'step' => 2, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
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

            $db->insert('users_documents', $documentParams);

        } else if ($resultStatus == 'manual_check') {

            $json = [
                'errorCode' => 5,
                'errorMessage' => $lang['user_checking'],
            ];
            $db->insert('registration_logs', ['method' => 'verification', 'step' => 2, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
            echo json_encode($json);
            die();

        } else {

            $json = [
                'errorCode' => 6,
                'errorMessage' => $rejectReason,
            ];
            $db->insert('registration_logs', ['method' => 'verification', 'step' => 2, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
            echo json_encode($json);
            die();
        }

        $json = [
            'errorCode' => 10,
            'errorMessage' => 'ვერიფიკაცია წარმატებით დასრულდა',
        ];
        $db->insert('registration_logs', ['method' => 'verification', 'step' => 2, 'request' => json_encode($post, JSON_UNESCAPED_UNICODE), 'response' => json_encode($json, JSON_UNESCAPED_UNICODE)]);
        echo json_encode($json);
        die();
    }
