<?php

class sms {

  private $key = "c07ece1729174b789ece3a95b8acc12a";

  private $url = "http://smsoffice.ge/api/v2/send/";

  // send
  public function send($destination,$sender,$content) {

    $key = urlencode($this->key);
    $destination = urlencode($destination);
    $sender = urlencode($sender);
    $content = urlencode($content);

    $url = $this->url."?key=".$key."&destination=".$destination."&sender=".$sender."&content=".$content."&urgent=true";

    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		$result = trim(curl_exec($ch));
		curl_close($ch);

    //var_dump($result);

    $data = json_decode($result,true);

    // return
    return $data;



  } // end send method

  // generated code for send
  public function generate_code($digits = 6){

    $i = 0;
    $pin = "";

    while($i < $digits){

        $pin .= mt_rand(0, 9);
        $i++;
    }

    return $pin;

  } // generated code for send

} // end sms class
