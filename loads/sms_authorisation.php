<?php
require_once "../classes/config.php";
require_once "../classes/db.php";
require_once "../classes/Sms2.php";
require_once "../classes/db.php";

$Database = new db();
$Sms2 = new Sms2();
$db = new db();

//Check if wallet exists
if(isset($get['action']) && $get['action'] == "wallet"){
    $username = $_POST["username"];
    $password = hash('sha256',trim($_POST["password"]));
    $data = $db->getWallet("users", " `wallet_number` = '".$username."' AND `password` = '".$password."' ");

    if (is_array($data)){
        $json = array(
            "errorCode" => 1,
            "errorMessage" =>"Wallet exists"
        );

        echo json_encode($json);
        die();
    } else {
        $json = array(
            "errorCode" => 0,
            "errorMessage" =>"Wallet doesn't exists"
        );

        echo json_encode($json);
        die();
    }
}

// Send sms code after password entered
if (isset($get['action']) && $get['action'] == 'send') {
    $username = $_POST["username"];
    $user = $Database->getUser("users", " `wallet_number` = '" . $username . "'  ");
    $mobile = substr($user["mobile"], 4);
    $sms_code = rand(100000, 999999);
    //$sent_sms_code = $Database->getSmsLog("sms_logs", " `sms` = '" . $_SESSION['sms_code']["content"] . "' ");
    $sent_sms_code = $Database->getLastSmsCode("sms_logs", " `number` = '".$mobile."' AND  `title` = 'LeaderPay' " );

     if($sent_sms_code === false) {
        $params = array(
            "destination" => $mobile,
            "content" => "Sms code : " . $sms_code,
        );

        $result = $Sms2->Send($params);
        $_SESSION['sms_code'] = $params;

        $json = array(
            "errorCode" => 1,
            "errorMessage" => "Send sms code",
        );


        echo json_encode($json);
        die();
    } else {
         $json = array(
             "errorCode" => 0,
             "errorMessage" => "Sms code send error"
         );

         echo json_encode($json);
        die();
     }
}

//Check sms code
if (isset($get['action']) && $get['action'] == 'check'){
    $sms_code = $_POST["sms_code"];
    $sent_sms_code = substr($_SESSION['sms_code']["content"], -6);
    $compare_sms_code_date = $Database->getSmsLog("sms_logs"," `sms` = '".$_SESSION['sms_code']["content"]."' ");

    $_SESSION["sms_date"] = $compare_sms_code_date;

    if($sms_code === $sent_sms_code && $sms_code !== "" && $compare_sms_code_date === true){

        $json = array(
            "errorCode" => 1,
            "errorMessage" => "Sms codes are equal",
        );
        echo json_encode($json);
        die();
    } else {
        $json = array(
            "errorCode" => 0,
            "errorMessage" => "Sms codes are not equal",
        );

        echo json_encode($json);
        die();
    }
}

// Resend sms code
    if(isset($get['action']) && $get['action'] == "resend"){
        $username = $_POST["username"];
        $user = $Database->getUser("users", " `wallet_number` = '" . $username . "'  ");
        $mobile = substr($user["mobile"], 4);
        $sent_sms_code = $Database->getLastSmsCode("sms_logs", " `number` = '".$mobile."' " );

        if($sent_sms_code === false){ //თუ ბოლო გაგზავნილი სმს-დან გასულია 2 წუთზე მეტი
            $username = $_POST["username"];
            $user = $Database->getUser("users", " `wallet_number` = '".$username."'  ");
            $mobile = substr($user["mobile"], 4);
            $sms_code = rand(100000, 999999);
            $params = array(
                "destination" => $mobile,
                "content" => "Sms code : " . $sms_code,
            );

            $result = $Sms2->Send($params);
            $_SESSION['sms_code'] = $params;

            $json = array(
                "errorCode" => 1,
                "errorMessage" => "Resend",
            );

            echo json_encode($json);
            die();
        }
    }