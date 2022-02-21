<?php

require '../classes/config.php';
require '../classes/verification.php';

$verification = new verification();


// sms
if (isset($get['action']) AND $get['action'] == 'sms') {

  $personal_number = $post['personal_number'];
  $document_number = $post['document_number'];

  $params = array(
    'personal_number' => $personal_number,
    'document_number' => $document_number,
  );

  $result = $verification->sms($params);

  echo $result;

  $r = json_decode($result, true);

  if ($r['errorCode'] == 10) {

    $_SESSION['personal_number'] = $personal_number;
    $_SESSION['document_number'] = $document_number;

  }

}

// check
if (isset($get['action']) AND $get['action'] == 'check') {

  $sms = $post['sms'];

  $params = array(
    'sms' => $sms,
  );

  $result = $verification->check($params);

  echo $result;

}

// file
if (isset($get['action']) AND $get['action'] == 'file') {

  $params = array(
    'document_front' => $post['document_front'],
    'document_back' => $post['document_back'],
    'sfero_id' => $post['sfero_id'],
    'document_type' => $post['document_type'],
    'issue_date' => $post['issue_year'] .'-'. $post['issue_month'] .'-'. $post['issue_day'],
    'expiry_date' => $post['expiry_year'] .'-'. $post['expiry_month'] .'-'. $post['expiry_day'],
  );

  $result = $verification->file($params);

  echo $result;

}

// verification
if (isset($get['action']) AND $get['action'] == 'verification') {

  $params = array(
    'document_front' => $post['document_front'],
    'document_back' => $post['document_back'],
    'sfero_id' => $post['sfero_id'],
    'document_type' => $post['document_type'],
    'issue_date' => $post['issue_date'],
    'expiry_date' => $post['expiry_date'],
//    'pdf' => $post['pdf'],
/*      'agreement_document' =>$post['agreement_document'],*/

  );

  $result = $verification->insert($params);

  echo $result;


}
