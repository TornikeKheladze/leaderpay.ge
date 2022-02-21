<?php
    require '../classes/config.php';
    require '../classes/db.php';

    $db = new db();

    if (isset($_POST['submit'])){
        $personal_number = trim($_POST['personal_number']);
        $country = trim($_POST['country']);
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $mobile = trim("+995".$_POST['phone']);

        // personal_number rule
        if (isset($country) AND $country == "GE") {
            $personal_number_rule = "personal_number";
            $wallet_number = $personal_number;
        } else {
            $wallet_number = $db->get_personal_number();
        }
        if ($_POST['birth_day']<10){
            $_POST['birth_day'] = "0".$_POST['birth_day'];
        }

        $birth_date = trim($_POST['birth_year']."-".$_POST['birth_month']."-".$_POST['birth_day']);
        $password = trim($_POST['password']);
        $password = hash('sha256', $_POST['password']);
        $repeat_password = trim($_POST['repeat_password']);
        $gender = trim($_POST['gender']);

        /**
         *მონიტორინგის აპისთანს შემოწმება
         */

        $Auth_Username = "apw";
        $Auth_Password = "apw!user";

        $hash = hash('sha256', md5("2" . "5e8ee8a7815a2"));
        $postRequest = [
            'customer_id' => 2,
            'hash' => $hash,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'country' => $country,
        ];
        if (!is_null($personal_number) && $personal_number!=''){
            $postRequest['personal_no'] = $personal_number;
        }
        if (!is_null($birth_date) && $birth_date!=''){
            $postRequest['birthdate'] = $birth_date;
        }
        if (!is_null($mobile) && $mobile!=''){
            $postRequest['phone'] = $mobile;
        }

        $ch = curl_init("https://payway.ge/init");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postRequest);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "{$Auth_Username}:{$Auth_Password}");

        $apiResponse = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($apiResponse);

        $queryResult = $db->insertApiData('registracion_api_log', json_encode($postRequest), $apiResponse);

        if (!$queryResult) {
            $json = array(
                "errorCode" => 50,
                "errorMessage" => "სერვისზე ტექნიკური შეფერხებაა სცადეთ მოგვიანებით!!",
            );

            echo json_encode($json);
            header("Location:/register.php");
        }
        if ($data->status !== 0) {
            $json = array(
                "errorCode" => 50,
                "errorMessage" => "ტექნიკური პრობლემაა სცადეთ მოგვიანებით!!",
            );

            echo json_encode($json);
            header("Location:/register.php");
        }
        if ($data->data->user->condition->state == 'UNCHECKED') {
            $json = array(
                "errorCode" => 50,
                "errorMessage" => 'ყურადღება ! მომხმარებლის მაიდენთიფიცირებელი მონაცემები საჭიროებს გადამოწმებას.  გთხოვთ გამოაგზავნოთ  სალაროს  ჩათში მომხმარებლის პირადი ნომერი, დაბადების თარიღი, დაბადების ადგილი. ან გამოაგზავნოთ დასკანერებული პირადობის დოკუმენტი. გადამოწმების დადასტურების მაქსიმალური ვადა 1 სამუშაო დღე.',
            );

            echo json_encode($json);
            header("Location:/register.php");
        }
        if ($data->data->user->condition->state == 'MATCHED' && ($data->data->user->status->terrorist)) {
            $json = array(
                "errorCode" => 50,
                "errorMessage" => 'მომხმარებელი ტერორისტია',
            );

            echo json_encode($json);
            header("Location:/register.php");
        }
        /**
         *მონიტორინგის აპისთან შემოწმება END::
         */
        $user = $db->get_date("users"," wallet_number = '".$wallet_number."' ");

        if ($user != false ) {
            $json = array(
                "errorCode" => 3,
                "errorMessage" => "მომხმარებელი მითითებული პირადი ნომრით უკვე რეგისტრირებულია",
            );
            header("Location:/register.php");
        }
            $post_params = array(
            'wallet_number'   => $wallet_number,
         /*   'personal_number' => $personal_number,*/
            'country'         => $country,
            'first_name'      => $first_name,
            'last_name'       => $last_name,
            'mobile'          => $mobile,
            'birth_date'      => $birth_date,
            'password'        => $password,
            'gender'          => $gender,
            "created_at"      => $db->get_current_date(),
            "verify_id"       => 1,
            "verify"          => 1,
            "user"            => "apw.ge",
            "confirmation" =>0,
        );

        if (!is_null($personal_number) && $personal_number!=''){
            $post_params['personal_number'] = $personal_number;
        }

        $post_status = $db->insert("users",$post_params);

        if ($post_status) {

            // insert not resident users
            $p = array(
                'user_id' => $wallet_number,
            );
            $db->insert("no_resident_users", $p);

            $json = array(
                "errorCode" => 10,
                "errorMessage" => "რეგისტრაცია წარმატებით დასრულდა",
                "wallet_number" => $wallet_number,
            );

            header("Location:/login.php");
        } else {
            $json = array(
                "errorCode" => 9,
                "errorMessage" => "რეგისტრაცია ვერ განხორციელდა",
            );
            header("Location:/register.php");
        }

    }
