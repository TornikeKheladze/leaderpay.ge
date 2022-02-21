<?php
// params
$agent_id = $_POST["agent_id"];
$agent_secret = 'qwertyuiop';
$url = 'https://api.allpayway.ge/cashdesk/liderbet/register_transaction.php';
$cashbox_id = $_POST["cashbox_id"];
$personal_number = $_POST["personal_number"];
$document_number = $_POST["document_number"];
$amount = $_POST["amount"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$birth_date = $_POST["birth_date"];
$pin_code = $_POST["pin_code"];
$hash = hash('sha256', $agent_id . $agent_secret . $personal_number);

$postRequest = [
    'agent_id' => $agent_id,
    'cashbox_id' => $cashbox_id,
    'personal_number' => $personal_number,
    'document_number' => $document_number,
    'amount' => $amount,
    'first_name' => $first_name,
    'last_name' => $last_name,
    'birth_date' => $birth_date,
    'pin_code' =>$pin_code,
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
echo $url . "<br>";
print_r($postRequest);
print_r($apiResponse);
echo "</pre>";
?>