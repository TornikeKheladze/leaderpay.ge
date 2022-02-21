<?php
// params
$agent_id = $_POST["agent_id"];
$agent_secret = 'qwertyuiop';
$url = 'https://api.allpayway.ge/cashdesk/apw/check_user.php';
$cashbox_id = $_POST["cashbox_id"];
$personal_number = $_POST["personal_number"];
$document_number = $_POST["document_number"];
$hash = hash('sha256', $agent_id . $agent_secret . $personal_number);

$postRequest = [
    'agent_id' => $agent_id,
    'cashbox_id' => $cashbox_id,
    'personal_number' => $personal_number,
    'document_number' => $document_number,
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