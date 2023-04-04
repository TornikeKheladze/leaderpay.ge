<?php

class Convertation {

    private $url = 'https://api.allpayway.ge/rate/convertation/';
    private $secret = 'Nks2IoP5if$8qAj8PG6BQ^WIR!TQ4fuf';
    public $file = '';
    public $params = [];

    public function exchange($params) {

        $hashStr = $params['id'] . $params['from'] . $params['to'] . $params['amount'] . $this->secret;
        $hash = hash('sha256', $hashStr);

        $this->file = 'convertation.php';
        $this->params = $params;
        $this->params['hash'] = $hash;

        return $this->request();

    }

    public function rate($params) {

        $hashStr = $params['id'] . $params['from'] . $params['to'] . $params['amount'] . $this->secret;
        $hash = hash('sha256', $hashStr);

        $this->file = 'convertation_check.php';
        $this->params = $params;
        $this->params['hash'] = $hash;

        return $this->request();

    }

    public function request() {

        $params = '';
        foreach($this->params as $key => $value) {
            $params .= $key.'='.$value.'&';
        }

        $params = trim($params, '&');
        $url = $this->url . $this->file . '?' . $params;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = trim(curl_exec($ch));
        curl_close($ch);

        $result = json_decode($result, TRUE);

        return $result;

    }

}
