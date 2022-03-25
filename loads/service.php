<?php
require '../classes/config.php';
require '../classes/db.php';
require '../classes/pay.php';
require '../classes/billing.php';
require '../classes/sms.php';

$db = new db();

// check auch
if ($db->check_auch() === false) {
    die();
} else {
    // get user info
    $username = $_SESSION["user_name"];
    $token = $_SESSION["token"];
    $user = $db->get_date("users", " `personal_number` = '" . $username . "' AND `token` = '" . $token . "' ");
    $user_documents = $db->get_date("users_documents", " `personal_number` = '" . $username . "' ");
}

$service = new payment();
$billing = new billing();
$sms = new sms();

// check user block
if ($user['is_blocked'] == '1') {
    echo '<div class="msg msg-error" role="alert">მომხმარებელი ბლოკირებულია!</div>';

    die();
}

if (isset($_GET['action']) && $_GET['action'] == "info") {
    $first_name = $user['first_name'];
    $last_name = $user['last_name'];
    $country = $user['country'];
    $personal_number = $user['personal_number'];
    $document_number = $user_documents['document_number'];

    $Auth_Username = "apw";
    $Auth_Password = "apw!user";

    if ($user_documents["document_type"] == '1') {
        $user_document_type = 'Passport';
    } elseif ($user_documents["document_type"] == '2') {
        $user_document_type = 'ID Card';
    } elseif ($user_documents["document_type"] == '3') {
        $user_document_type = 'Identity';
    } elseif ($user_documents["document_type"] == '4') {
        $user_document_type = 'Driving license';
    } elseif ($user_documents["document_type"] == '5') {
        $user_document_type = 'Other Documents';
    }

    $birthdate = $user["birth_date"];
    $birth_place = $user["birth_place"];
    $phone = $user["mobile"];
    $email = $user["email"];
    $document_type = $user_document_type;
    $document_issuning_authority = $user_documents["issue_organisation"];
    $issue_date = $user_documents["issue_date"];
    $expiry_date = $user_documents["expiry_date"];
    $registration_address = $user["legal_address"];
    $real_actual_address = $user["real_address"];

    $hash = hash('sha256', md5("1" . "5e8ee8a7812f1"));
    $postRequest = [
        'customer_id' => 1,
        'hash' => $hash,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'personal_no' => $personal_number,
        'document_id' => $document_number,
        'country' => $country
    ];

    if (!is_null($birthdate) && $birthdate != '') {
        $postRequest['birthdate'] = $birthdate;
    }
    if (!is_null($birth_place) && $birth_place = '') {
        $postRequest['birth_place'] = $birth_place;
    }
    if (!is_null($phone) && $phone != '') {
        $postRequest['phone'] = $phone;
    }
    if (!is_null($email) && $email != '') {
        $postRequest['email'] = $email;
    }
    if (!is_null($document_type) && $document_type != '') {
        $postRequest['document_type'] = $document_type;
    }
    if (!is_null($document_issuning_authority) && $document_issuning_authority != '') {
        $postRequest['document_issuning_authority'] = $document_issuning_authority;
    }
    if (!is_null($issue_date) && $issue_date != '') {
        $postRequest['issue_date'] = $issue_date;
    }
    if ($expiry_date=="0000-00-00"){
        $postRequest['permanent_document '] = 1;
    }elseif(!is_null($expiry_date) &&$expiry_date!=''){
        $postRequest['expiry_date'] = $expiry_date;
        $postRequest['permanent_document '] = 0;
    }
    if (!is_null($registration_address) && $registration_address != '') {
        $postRequest['registration_address'] = $registration_address;
    }
    if (!is_null($real_actual_address) && $real_actual_address != '') {
        $postRequest['real_actual_address'] = $real_actual_address;
    }


    $ch = curl_init("https://payway.ge/init");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postRequest);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "{$Auth_Username}:{$Auth_Password}");

    $apiResponse = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($apiResponse);
    /*var_dump($postRequest);*/

    $queryResult = $db->insertApiData('wallet_billing_api_log', json_encode($postRequest), $apiResponse);

    if (!$queryResult) {
        echo '<div class="msg msg-error" role="alert">სერვისზე ტექნიკური შეფერხებაა სცადეთ მოგვიანებით!!</div>';
        die();
    }
    if ($data->status !== 0) {
        echo '<div class="msg msg-error" role="alert">ტექნიკური პრობლემაა სცადეთ მოგვიანებით!!</div>';
        die();
    }
    if ($data->data->user->condition->state == 'UNCHECKED') {
        echo '<div class="msg msg-error" role="alert">ყურადღება ! მომხმარებლის მაიდენთიფიცირებელი მონაცემები საჭიროებს გადამოწმებას.  გთხოვთ გამოაგზავნოთ  სალაროს  ჩათში მომხმარებლის პირადი ნომერი, დაბადების თარიღი, დაბადების ადგილი. ან გამოაგზავნოთ დასკანერებული პირადობის დოკუმენტი. გადამოწმების დადასტურების მაქსიმალური ვადა 1 სამუშაო დღე.</div>';
        die();
    }
    if ($data->data->user->condition->state == 'MATCHED' && ($data->data->user->status->terrorist || $data->data->user->status->pep)) {
        if ($data->data->user->status->terrorist == '1') {
            echo '<div class="msg msg-error" role="alert">მომხმარებელი ტერორისტია</div>';
            die();
        }
        if ($data->data->user->status->pep == '1') {
            echo '<div class="msg msg-error" role="alert">მომხმარებელი პოლიტიკურად აქტიურია</div>';
            die();
        }
    }

    $params = $post;

    if (isset($params['year']) && isset($params['month']) && isset($params['day'])) {
        $birthdate = $params['year'] . '-' . $params['month'] . '-' . $params['day'];
        $birthdate = array("birthdate" => $birthdate);

        unset($params['year']);
        unset($params['month']);
        unset($params['day']);

        $params = array_merge($params, $birthdate);
    }

    $service_id = intval($params['service_id']);
    // get pay params
    $b_params = $billing->get_service_info($service_id);

    $info_params = array();

    foreach ($b_params['params_info'] as $param) {
        $info_params[$param['name']] = urlencode($params[$param['name']]);
        $info_params["service_id"] = $service_id;
    } // params foreach

    $info = $service->info($info_params);
    
    $array = json_decode($info, true);

    if ($array['errorCode'] != 1000) {
        echo '<div class="msg msg-error" role="alert">' . $array['errorMessage'] . '</div>';
    } else {
        $output = '';

        if ($service_id == 114) {
            $output .= '<input type="hidden" name="xp_service_id" id="xp_service_id" value="' . current($array['data']['loan'])['service_id'] . '">';
        }

        foreach ($array['data'] as $key => $value) {

            if (is_array($value)) {

                // for xpay
                if ($service_id == 114) {

                    $output .= '<div class="form-group"><label for="' . $key . '">' . $service->get_label_names($key) . '</label>';
                    $output .= '<select class="input select2-container select2me" name="' . $key . '" id="xpay_' . $key . '">';

                    foreach ($value as $key => $value) {
                        $output .= '<option rel="' . $value['service_id'] . '" value="' . $value['value'] . '">' . $value['service'] . '. მიმდინარე დავალიანება ' . $value['montly_payment'] . '. გადახდის თარიღი ' . $value['next_pay'] .'</option>';
                    }

                    $output .= '</select>';
                    $output .= '</div>';

                } else {

                    $output .= '<div class="form-group"><label for="' . $key . '">' . $service->get_label_names($key) . '</label>';
                    $output .= '<select class="input select2-container select2me" name="' . $key . '" id="' . $key . '">';

                    foreach ($value as $key => $value) {
                        $output .= '<option value="' . $value['account'] . '">' . $value['name'] . '</option>';
                    }

                    $output .= '</select>';
                    $output .= '</div>';
                    
                }

            } else {
                $output .= '<div class="form-group"><label for="' . $key . '">' . $service->get_label_names($key) . '</label><input type="text" name="' . $key . '" id="' . $key . '" value="' . $value . '" class="input" readonly></div>';
            } // en if
        } // end foreach

        if ($service_id != 114) {

            $output .= '<div class="form-group"><label for="amount">ჩასარიცხი თანხა</label><input name="amount" type="text" id="amount" class="input float" autocomplete="off"></div>';
            $output .= '<div class="form-group"><label for="procent">საკომისიო</label><input name="procent" type="text" disabled="" id="procent" class="input" autocomplete="off"></div>';
            $output .= '<div class="form-group"><label for="generated">ჩამოგეჭრებათ</label><input name="generated" type="text" id="generated" class="input" autocomplete="off"></div>';

        }

        // if need sms validate
        $type = $db->get_date("service_options", " `service_id` = '" . $b_params['id'] . "' ");

        if ($type AND $type['sms'] == 1) {
            $output .= '<div class="form-group"><label for="code">SMS-ით მიღებული კოდი</label><div class="send_btn"><span> <img src="/assets/img/sms.png" alt="send"> გაგზავნა</span></div><input onkeypress="return isIntKey(event);"  data-rule-required="true" maxlength="6" minlength="6" name="code" type="txt" id="code" class="input" autocomplete="off"></div>';
        }

        echo $output;
    }
} elseif (isset($_GET['action']) && $_GET['action'] == "pay") {
    $params = $post;

    if (isset($params['year']) && isset($params['month']) && isset($params['day'])) {
        $birthdate = $params['year'] . '-' . $params['month'] . '-' . $params['day'];
        $birthdate = array("birthdate" => $birthdate);

        unset($params['year']);
        unset($params['month']);
        unset($params['day']);

        $params = array_merge($birthdate, $params);
    }

    $user_id = $_SESSION["user_name"];
    $service_id = intval($params['service_id']);
    $amount = floatval($params['generated']);
    $date = date('Y-m-d H:i:s');
    // unicdate
    list($usec, $sec) = explode(' ', substr(microtime(), 2));

    $unicdate = $sec . $usec;

    // balance
    $user_balance = $db->get_date_row("users", "balance", " `personal_number` = '" . $user_id . "' ");

    if ($user['verify_id'] == 2 || $user['verify_id'] == 3) {
        if ($user_balance['balance'] >= $amount) {
            // get pay params
            $b_params = $billing->get_service_info($service_id);

            if ($amount >= $b_params['commission']['min_amount']) {
                if ($amount <= $b_params['commission']['max_amount']) {
                    // if need sms validate
                    $type = $db->get_date("service_options", " `service_id` = '" . $service_id . "' ");

                    if ($type AND $type['sms'] == 1) {
                        // sms
                        // $number = $user['mobile'];
                        if (isset($params['code']) && isset($_SESSION['code']) && $params['code'] == $_SESSION['code']) {
                            unset($_SESSION['code']);
                        } else {
                            $array = array(
                                "code" => 0,
                                "msg" => 'SMS- ით მიღებული კოდი არასწორია',
                            );
                            echo json_encode($array);
                            die();
                        }
                    } // check sms

                    $pay_params = array();

                    foreach ($b_params['params_pay'] as $param) {
                        if ($service_id == 2) {
                            $pay_params[$param['name']] = $params[$param['name']];
                        } else {
                            $pay_params[$param['name']] = urlencode($params[$param['name']]);
                        }

                        $pay_params["service_id"] = $service_id;
                        $pay_params["amount"] = $amount;
                    } // params foreach

                    // user
                    $pay_user = array_values($pay_params)[0];
                    $get_pay = $service->pay($pay_params);
                    $pay = json_decode($get_pay, true);

                    if ($pay['errorCode'] == 1000) {
                        // update balance
                        $new_balance = $user_balance['balance'] - $amount;
                        $update_palance = $db->update_balance($user_id, $new_balance);
                        $ip = "";

                        if (!empty($_SERVER['HTTP_X_REAL_IP'])) {
                            $ip = $_SERVER['HTTP_X_REAL_IP'];
                        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                        } else {
                            $ip = $_SERVER['REMOTE_ADDR'];
                        }

                        // payments
                        $user_payments_params = array(
                            "operation_id" => $pay['operationId'],
                            "user_id" => $user_id,
                            "service_id" => $service_id,
                            "amount" => $amount,
                            "gen_amount" => $pay['accoutant']['genAmount'],
                            "agent_comision" => $pay['accoutant']['agentBenefit'],
                            "agent_benefit" => $pay['accoutant']['agentCommission'],
                            "client_comision" => $pay['accoutant']['clientCommission'],
                            "currency" => 981,
                            "status_id" => $pay['status']['id'],
                            "cron" => 0,
                            "created_at" => $date,
                            "ip" => $ip,
                        );

                        $payment_id = $db->insert("user_payments", $user_payments_params);

                        if ($payment_id != false) {
                            $description = $b_params['name'] . " - სერვისის გადახდა, მომხმარებელი: " . $pay_user;
                            // palance history
                            $history_params = array(
                                "personal_number" => $user_id,
                                "operation_id" => $payment_id,
                                "credit" => 0,
                                "debt" => $amount,
                                "type_id" => 4,
                                "date" => $date,
                                "unicdate" => $unicdate,
                                "balance" => $new_balance,
                                "description" => $description,
                                "agent_id" => 1,
                                "agent" => 2,
                            );
                            $insert_details = $db->insert("user_balance_history", $history_params);
                            $pay_params = array();

                            foreach ($b_params['params_pay'] as $key => $value) {
                                $detail_params = array(
                                    "payment_id" => $payment_id,
                                    "param_name" => $value['name'],
                                    "param_value" => $params[$value['name']],
                                    "created_at" => $date,
                                );
                                $insert_details = $db->insert("payment_details", $detail_params); //
                            } // params foreach
                             // kakha balanse restore
//                            $currencies = $db->get_unlimited_list("currencies", " id > 0 ", "id", "DESC"); curent code
                            $user_table_id = $db->get_date_row("users",'*',"wallet_number = '".$user_id."'");
                            $balance_history = $db->getUserBalanceHistory($user_table_id['personal_number'], 981);
                            $balance = 0;
                            foreach ($balance_history as $b) {
                                $debt = floatval($b["debt"]);
                                $credit = floatval($b["credit"]);
                                $balance = $balance + $credit - $debt;

                                $db->updateUserAvance($b["id"], $balance, 981);
                            }
                            $db->updateUserBalance($user_table_id["id"], $balance, 981);
                            //end kakha
                            // success
                            $array = array(
                                "code" => 1,
                                "msg" => 'გადახდა წარმატებით დასრულდა',
                            );
                            echo json_encode($array);
                        } // check insert
                    } else {
                        $array = array(
                            "code" => 0,
                            "msg" => $pay['errorMessage'],
                        );
                        echo json_encode($array);
                    }// check payment
                } else {
                    $array = array(
                        "code" => 0,
                        "msg" => 'თანხა მეტია მაქსიმალურ ჩასარიცხ თანხაზე',
                    );
                    echo json_encode($array);
                } // check max amount
            } else {
                $array = array(
                    "code" => 0,
                    "msg" => 'თანხა ნაკლებია მინიმალურ ჩასარიცხ თანხაზე',
                );
                echo json_encode($array);
            }  // check min amount
        } else {
            $array = array(
                "code" => 0,
                "msg" => 'ბალანსი არ არის საკმარისი ტრანზაქციის განსახორციელებლად',
            );
            echo json_encode($array);
        }  // check balance
    } else {
        $array = array(
            "code" => 0,
            "msg" => 'მომხმარებელი არ არის ვერიფიცირებული',
        );
        echo json_encode($array);
    }  // check verification
} elseif (isset($_GET['action']) && $_GET['action'] == "redirect") {

    // for xpay
    if ($post['service_id'] == 114) {

        $post['service_id'] = $post['xp_service_id'];
        $xpay_info = $service->info($post);
        $xpay_array = json_decode($xpay_info, true);

        if ($xpay_array['errorCode'] == 1000) {

            $id = $post['service_id'];

            $service = $billing->get_service_info($id);
            $array = [
                'code' => 1,
                'service_id' => $id,
                'name_ge' => $service['lang']['GE'],
                'name_en' => $service['lang']['EN'],
                'name_ru' => $service['lang']['RU'],
                'image' => $service['image'],
                'loan' => $post['loan'],
            ];
            echo json_encode($array);
            die();

        } else {
            $array = [
                'code' => $xpay_array['errorCode'],
                'msg' => $xpay_array['errorMessage'],
            ];
            echo json_encode($array);
        }

    }

    $poerator_info = $service->info($post);
    $operator_array = json_decode($poerator_info, true);

    if ($operator_array['errorCode'] == 1000) {

        // globals
        $services = array(
            "beeline_rus" => "beeline Russia",
            "tele2" => "Tele 2",
            "ukrtelekom" => "ukrtelekom",
            "mtc" => "MTC RUSSIA",
            "megafon" => "Megafon Russia",
            "intertelekom" => "intertelekom",
            "Lifecell" => "Lifecell",
            "lifecell_licevomu_schetu" => "Lifecell lic schet",
            "Vodafone" => "Vodafone",
            "Yezzz" => "Yezzz",
            "trimob" => "trimob",
            "Kyevstar" => "kievstar",
            "PeopleNet" => "PeopleNet",
        );

        if ($post['service_id'] == 4) {
            if (isset($services[$operator_array['data']['operator']])) {
                $operator = $services[$operator_array['data']['operator']]; //
                $services_lst = $billing->get("services", null);

                foreach ($services_lst['services'] as $s) {
                    if ($s['name'] == $operator) {
                        $array = array(
                            "code" => 1,
                            "service_id" => $s['id'],
                            "name_ge" => $s['lang']['GE'],
                            "name_en" => $s['lang']['EN'],
                            "name_ru" => $s['lang']['RU'],
                            "image" => $s['image'],
                        );
                        echo json_encode($array);
                    }
                } // end foreach
            } else {  // check operator
                $s = $billing->get_service_info(4);
                $array = array(
                    "code" => 1,
                    "service_id" => $s['id'],
                    "name_ge" => $s['lang']['GE'],
                    "name_en" => $s['lang']['EN'],
                    "name_ru" => $s['lang']['RU'],
                    "image" => $s['image'],
                );
                echo json_encode($array);
            } // check operator
        } else { // chck service id
            $operator = $operator_array['data']['operator'];
            $services_lst = $billing->get("services", null);

            foreach ($services_lst['services'] as $s) {
                if ($s['name'] == $operator) {
                    $array = array(
                        "code" => 1,
                        "service_id" => $s['id'],
                        "name_ge" => $s['lang']['GE'],
                        "name_en" => $s['lang']['EN'],
                        "name_ru" => $s['lang']['RU'],
                        "image" => $s['image'],
                    );
                    echo json_encode($array);
                }
            }
        } // chck service id
    } else {
        $array = array(
            "code" => 0,
            "msg" => $operator_array['errorMessage'],
        );
        echo json_encode($array);
    }
} elseif (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == "service") {
    $id = intval($_GET['id']);
    $service = $billing->get_service_info($id);
    echo json_encode($service);
} elseif (isset($_GET['action']) && $_GET['action'] == "save_service") {
    $service_id = intval($post['service_id']);
    $user_id = $user['personal_number'];
    $json = json_encode($post);
    $date = date('Y-m-d H:i:s');
    $params = array(
        "service_id" => $service_id,
        "user_id" => $user_id,
        "json" => $json,
        "created_at" => $date,
    );
    // insert
    if ($db->insert("save_service", $params)) {
        $array = array(
            "code" => 1,
            "msg" => 'სერვისი წარმატებით შეინახა',
        );
        echo json_encode($array);
    } else {
        $array = array(
            "code" => 0,
            "msg" => 'შეცდომა',
        );
        echo json_encode($array);
    }
} elseif (isset($_GET['action']) && $_GET['action'] == "info_json") {
    $params = $post;
    if (isset($params['year']) && isset($params['month']) && isset($params['day'])) {
        $birthdate = $params['year'] . '-' . $params['month'] . '-' . $params['day'];
        $birthdate = array("birthdate" => $birthdate);

        unset($params['year']);
        unset($params['month']);
        unset($params['day']);

        $params = array_merge($params, $birthdate);
    }

    $service_id = intval($params['service_id']);
    // get pay params
    $b_params = $billing->get_service_info($service_id);
    $info_params = array();

    foreach ($b_params['params_info'] as $param) {
        $info_params[$param['name']] = urlencode($params[$param['name']]);
        $info_params["service_id"] = $service_id;
    } // params foreach

    $info = $service->info($info_params);

    echo $info;
} elseif (isset($_GET['action']) && $_GET['action'] == "service_json" && isset($_GET['service_id'])) {
    $service_id = intval($get['service_id']);
    // sms
    $type = $db->get_date("service_options", " `service_id` = '" . $service_id . "' ");
    if ($type) {
        $sms = $type['sms'];
    } else {
        $sms = 0;
    }
    $service = $billing->get_service_info($service_id);
    $sms = array(
        "sms" => $sms,
    );
    $service = array_merge($service, $sms);
    echo json_encode($service);
} else {
    echo "404";
}

?>
