<?php
    // params
    $agent_id = $_POST["agent_id"];
    $agent_secret = 'qwertyuiop';
    $url = 'https://api.allpayway.ge/cashdesk/verification/user.php';
    $cashbox_id = $_POST["cashbox_id"];
    $personal_number = $_POST["personal_number"];
    $document_number = $_POST["document_number"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $birth_date = $_POST["birth_date"];
    $mobile = $_POST["mobile"];
    $country = $_POST["country"];
    $email = $_POST["email"];
    $sfero = $_POST["sfero"];
    $birth_place = $_POST["birth_place"];
    $real_address = $_POST["real_address"];
    $gender = $_POST["gender"];
    $hash = hash('sha256', $agent_id . $agent_secret . $personal_number);

    $postRequest = [
        'agent_id' => $agent_id,
        'cashbox_id' => $cashbox_id,
        'personal_number' => $personal_number,
        'document_number' => $document_number,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'birth_date' => $birth_date,
        'mobile' => $mobile,
        'country' => $country,
        'email' => $email,
        'sfero' => $sfero,
        'birth_place' => $birth_place,
        'real_address' => $real_address,
        'gender' => $gender,
        'hash' => $hash
    ];

    // request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postRequest);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $apiResponse = trim(curl_exec($ch));

    echo "<pre>";
    print_r($postRequest);
    print_r($apiResponse);
    echo "</pre>";
?>