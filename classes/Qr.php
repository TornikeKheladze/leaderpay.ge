<?php

class Qr {

    private $url = 'https://api.apw.ge/ufc_qr/api/';
    private $method = '';
    private $secret = 'adccf6d3f2317a093b2f951c641cd0afe44845363042e3b87c51beb4077bf786';
    private $name = 'leaderpay';
    public $body = [];

    public function init($user_id) {

        $this->method = 'init';
        $this->body = [
            'user_id' => $user_id,
            'hash' => $this->hash($user_id),
        ];

        return $this->request();
    }


    public function hash($parma) {

        return hash('sha256', $parma . $this->name . $this->secret);

    }

    public function request() {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . $this->method);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        $resultJson = trim(curl_exec($ch));
        curl_close($ch);

        $result = json_decode($resultJson, TRUE);

        return $result;

    }

}
