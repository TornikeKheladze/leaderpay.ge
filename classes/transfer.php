<?php

class transfer {

  private $agent_id = 1;
  private $url = "https://api.allpayway.ge/apw/transfer/";
  private $secret = "UKjrfyXqMLwyqhKA";
  public $post = array();
  public $name = 'info.php';

  public function info($params) {

    $agent_id = $this->agent_id;
    $secret = $this->secret;

    $from = trim($params['from']);
    $to = trim($params['to']);
    $amount = floatval(0.5);
    $currency_id = '981';
    $date = date('Y-m-d h:i:s');
    $date = str_replace(" ","T",$date);

    $this->name = "info.php";

    $hashstr = $agent_id . $from . $to . $secret;

    $hash = hash('sha256', $hashstr);

    $this->post = array(
      "agent_id"    => $agent_id,
      "from"        => $from,
      "to"          => $to,
      "amount"      => $amount,
      "currency_id" => $currency_id,
      "date"        => $date,
      "hash"        => $hash,
    );

    return $this->request();

  } // end info method

  public function pay($params) {

    $agent_id = $this->agent_id;
    $secret = $this->secret;

    $from = trim($params['from']);
    $to = trim($params['to']);
    $amount = floatval($params['amount']);
    $currency_id = trim($params['currency_id']);
    $date = date('Y-m-d h:i:s');
    $date = str_replace(" ","T",$date);

    $this->name = "transfer.php";

    $hashstr = $agent_id . $from . $to . $secret;

    $hash = hash('sha256', $hashstr);

    $this->post = array(
      "agent_id"    => $agent_id,
      "from"        => $from,
      "to"          => $to,
      "amount"      => $amount,
      "currency_id" => $currency_id,
      "date"        => $date,
      "hash"        => $hash,
    );

    return $this->request();


  } // end pay method

  public function request() {

    $params = '';
    foreach($this->post as $key => $value) {

      $params .= $key.'='.$value.'&';

    }

    $params = trim($params, '&');

    $url = $this->url.$this->name.'?'.$params;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    $result = trim(curl_exec($ch));
    curl_close($ch);

    return json_decode($result, true);
    // return $result;

  }// end request method

}
