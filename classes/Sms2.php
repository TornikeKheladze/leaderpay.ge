<?php

class Sms2 {
    private $url = 'https://manager.allpayway.ge/sms/';
    private $secret = 'n}Y2+SKsZdn[';
    private $name = "index.php";
    public $post = array();

    public function Send($params) {
        $this->name = "index.php";
        $hashStr = "LeaderPay" . $params["content"] .  $this->secret;
        $hash = hash('sha256', $hashStr);

        $this->post = array(
            "destination"  => trim($params["destination"]),
            "sender" => "LeaderPay",
            "content" => trim($params["content"]),
            "hash" => $hash,
        );

        return $this->request();

    } // end file method

    public function request() {
        //$data_string = json_encode($this->post);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.$this->name);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        $result = trim(curl_exec($ch));
        curl_close($ch);

        $result = json_decode($result, TRUE);

        if ($result['errorCode'] == 100) {
            return true;
        } else {
            return false;
        }

    } // end request method

} // end upload class
