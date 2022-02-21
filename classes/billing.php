<?php

class billing {

	private $url = "https://allpayment.ge/";
	private $agent_id = 1;
  private $secret = "UKjrfyXqMLwyqhKA";


  // get servise
  public function get($service,$category_id = null) {

    $agent_id = $this->agent_id;
    $time = time();
    $secret = $this->secret;

    if ($category_id == null) {

      $hashStr = $agent_id . $time . $secret;
      $hash = hash('sha256', $hashStr);

      $url = $this->url.$service.".php?agent_id=".$agent_id."&time=".$time."&hash=".$hash;

    } else {

      $category_id = intval($category_id);

      $hashStr = $agent_id . $category_id . $time . $secret;
      $hash = hash('sha256', $hashStr);

      $url = $this->url.$service.".php?agent_id=".$agent_id."&time=".$time."&category_id=".$category_id."&hash=".$hash;

    }


    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		$result = trim(curl_exec($ch));
		curl_close($ch);

    $data = json_decode($result,true);

		// create log
		$response = json_encode($data);

		$db = new db();

		$log = $db->payment_logs("info",$url,null,$data['errorCode'],$response);
		// end logs

    // return array
    if ($data['errorCode'] == 1000) {

      return $data;

    } else {

      return $data['errorMessage'];

    }

  }  //  get servise

	// get service details info
  public function get_service_info($service_id) {

    $agent_id = $this->agent_id;
    $time = time();
    $secret = $this->secret;

    $hashStr = $agent_id . $service_id . $time . $secret;
    $hash = hash('sha256', $hashStr);

    $url = 'https://allpayment.ge/service.php?agent_id='.$agent_id.'&service_id='.$service_id.'&time='.$time.'&hash='.$hash;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    $result = trim(curl_exec($ch));
    curl_close($ch);

    $data = json_decode($result,true);

		// create log
		$response = json_encode($data);

		$db = new db();

		$log = $db->payment_logs("info",$url,null,$data['errorCode'],$response);
		// end logs

    // return array
    if ($data['errorCode'] == 1000) {

      return $data['service'];

    } else {

      return $data['errorMessage'];

    }

  } // get service details info

	// get balance
	public function get_balance() {

		$agent_id = $this->agent_id;
		$time = time();
		$secret = $this->secret;

		$hashStr = $agent_id . $time . $secret;
		$hash = hash('sha256', $hashStr);

		$url = 'https://allpayment.ge/balance.php?agent_id='.$agent_id.'&time='.$time.'&hash='.$hash;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		$result = trim(curl_exec($ch));
		curl_close($ch);

		$data = json_decode($result,true);

		// create log
		$response = json_encode($data);

		$db = new db();

		$log = $db->payment_logs("balance",$url,null,$data['errorCode'],$response);
		// end logs

		// return array
		if ($data['errorCode'] == 1000) {

			return $data;

		} else {

			return $data['errorMessage'];

		}


	} // get balance

	// get operation_status
	public function get_operation_status($agent_transaction_id) {

		$agent_id = $this->agent_id;
		$time = time();
		$secret = $this->secret;
		$agent_transaction_id = intval($agent_transaction_id);

		$hashStr = $agent_id . $agent_transaction_id . $time . $secret;
		$hash = hash('sha256', $hashStr);

		$url = 'https://allpayment.ge/status.php?agent_id='.$agent_id.'&time='.$time.'&hash='.$hash.'&agent_transaction_id='.$agent_transaction_id;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		$result = trim(curl_exec($ch));
		curl_close($ch);

		$data = json_decode($result,true);

		// create log
		$response = json_encode($data);

		$db = new db();

		$log = $db->payment_logs("operation_status",$url,null,$data['errorCode'],$response);
		// end logs

		// return array

		return $data;





	} // get operation_status


}
