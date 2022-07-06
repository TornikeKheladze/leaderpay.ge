<?php
class payment {

  private $agent_id = 1;
  private $url = "https://allpayment.ge/";
  private $secret = "UKjrfyXqMLwyqhKA";


  public function info($params) {

      if ($this->time_restriction) {

          return json_encode(['errorCode' => 99, 'errorMessage' => '00:01 საათამდე გადახდას ვერ შეძლებთ'], JSON_UNESCAPED_UNICODE);

      }

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

     // echo $url_str;

    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		$result = trim(curl_exec($ch));
		curl_close($ch);


    // create log
    $r = json_decode($result, true);

    $db = new db();

    $log = $db->payment_logs("info",$url_str,null,$r['errorCode'],$result);
    // end logs

    return $result;


  } // end info method

  public function pay($params) {

      if ($this->time_restriction) {

          return json_encode(['errorCode' => 99, 'errorMessage' => '00:01 საათამდე გადახდას ვერ შეძლებთ'], JSON_UNESCAPED_UNICODE);

      }

    $db = new db();

    $service_id = intval($params['service_id']);

    $agent_id = $this->agent_id;
    $url = $this->url;
    $secret = $this->secret;
    $date = date('Y-m-d h:i:s');
    $date = str_replace(" ","T",$date);
    $amount = floatval($params['amount']);
    $agent_transaction_id = $db->get_max("user_payments") + 1;

    $hashstr = $agent_id . $agent_transaction_id . $service_id . $amount . $date . $secret;
    $hash = hash('sha256', $hashstr);

    $param_str = "";

    foreach ($params as $key => $value) {

      $param_str .= "&".$key."=".$value;

    }
	
	


    $url_str = $url."pay.php?agent_id=".$agent_id."&service_id=".$service_id."&agent_transaction_id=".$agent_transaction_id."&date=".$date."&hash=".$hash."&amount=".$amount.$param_str;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_str);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    $result = trim(curl_exec($ch));
    curl_close($ch);


    // create log
    $r = json_decode($result, true);

    $log = $db->payment_logs("pay",$url_str,(isset($r['operationId'])) ? $r['operationId'] : 0 ,(isset($r['errorCode'])) ? $r['errorCode'] : 0 ,@$result);

    // end logs

    return $result;


  } // end pay method

  public function get_label_names($name) {

    $agent_id = $this->agent_id;
    $secret = $this->secret;
    $time = time();

    $hashstr = $agent_id . $time . $secret;
    $hash = hash('sha256', $hashstr);

    $url = "https://allpayment.ge/params.php?agent_id=".$agent_id."&time=".$time."&hash=".$hash;

    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		$result = trim(curl_exec($ch));
		curl_close($ch);

    $r = json_decode($result, true);

    if ($r['errorCode'] == 1000) {

      foreach ($r['params'] as $key => $value) {


        if ($value['name'] == $name) {

          return $value['description'];

        }

      }

    }

  } // get_label_names method

    public function time_restriction() {

        $currentDatatime = date('Y-m-d h:i:s');
        $currentData = date('Y-m-d');

        $minutesToAdd = 31;

        $from = "$currentData 23:30:00";

        $newtimestamp = strtotime("$from  + $minutesToAdd minute");
        $newtimes = date('Y-m-d H:i:s', $newtimestamp);

        $to = $newtimes;

        return (strtotime($currentDatatime) > strtotime($from) && strtotime($currentDatatime) < strtotime($to)) ? true : false;

    }

} // end pay class
