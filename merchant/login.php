<?php
if (isset($_POST['login'])) {
//    print_r($_POST); die;
    $username = trim($_POST["login-username"]);
    $password = hash('sha256', trim($_POST["login-password"]));
    $captcha = $_POST['g-recaptcha-response'];


    // recafch
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=6LfLxE4UAAAAABp0TEprxIj8HtSqEi-wu1kleBqk&response=" . $captcha;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $getInfo = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($getInfo, true);


    if ($response['success'] == true) {

        // auch
        $data = $db->get_date("users", " `wallet_number` = '" . $username . "' AND `password` = '" . $password . "' ");

        $token = uniqid();

        $token = hash("sha256", $token);

        $token = strtolower($token);

        if ($data == false) {

            $error_msg = "სახელი ან პაროლი არასწორია";

        } else {

            $params = array(
                "last_date" => date("Y-m-d H:i:s"),
                "token" => $token,
            );

            // update
            $db->update("users", $params, $data["id"]);

            // session
            $_SESSION["user_name"] = $data['wallet_number'];
            $_SESSION["token"] = $token;

            $ip = "";

            if (!empty($_SERVER['HTTP_X_REAL_IP'])) {

                $ip = $_SERVER['HTTP_X_REAL_IP'];

            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

            } else {

                $ip = $_SERVER['REMOTE_ADDR'];

            }

            $params = array(
                "wallet_number" => $data['wallet_number'],
                "date" => date("Y-m-d H:i:s"),
                "ip" => $ip
            );

            $db->insert("login_log", $params);


            header('Location: merchant.php');


        }

    }


}