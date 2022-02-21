<?php

class Payment {

  private $url = "https://allpayment.ge/";
  private $agent_id = 16;
  private $secret = "UKjrfyXqMLwyqhKA";


  public function info($params) {

    $service_id = intval($params['service_id']);

    $agent_id = $this->agent_id;
    $url = $this->url;
    $secret = $this->secret;
    $date = date('Y-m-d h:i:s');
    $date = str_replace(" ","T",$date);
    $amount = 100;


    $hashstr = $agent_id . $service_id . $date . $secret;
    $hash = hash('sha256', $hashstr);

    $param_str = "";

    foreach ($params as $key => $value) {

      $param_str .= "&".$key."=".$value;

    }


    $url_str = $url."info.php?agent_id=".$agent_id."&service_id=".$service_id."&date=".$date."&hash=".$hash."&amount=".$amount.$param_str;

    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		$result = trim(curl_exec($ch));
		curl_close($ch);

    return $result;

  }
  public function pay($params) {

    $service_id = intval($params['service_id']);

    $agent_id = $this->agent_id;
    $url = $this->url;
    $secret = $this->secret;
    $date = date('Y-m-d h:i:s');
    $date = str_replace(" ","T",$date);
    $amount = floatval($params['amount']);
    $agent_transaction_id = 8; //  ყველა ოპერაციის დასრულების შემდეგ +1

    $hashstr = $agent_id . $agent_transaction_id . $service_id . $amount . $date . $secret;
    $hash = hash('sha256', $hashstr);

    $param_str = "";

    foreach ($params as $key => $value) {

      $param_str .= "&".$key."=".$value;

    }


    $url_str = $url."testpay.php?agent_id=".$agent_id."&service_id=".$service_id."&agent_transaction_id=".$agent_transaction_id."&date=".$date."&hash=".$hash."&amount=".$amount.$param_str;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_str);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    $result = trim(curl_exec($ch));
    curl_close($ch);

    return $result;

  }

}
