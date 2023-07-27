<?php

class Sda {

    private $url = 'https://api.apw.ge/sda/';
    private $secret = 'HUm6V8aTWtCFPNFQ';
    private $type = 1;
    private $body = [];
    public $Database;

    public function __construct($Database) {

        $this->Database = $Database;

    }

    public function Check($personal_number, $document_number) {

        $hash = hash('sha256', md5($personal_number . $this->secret));

        $this->body = [
            'type' => $this->type,
            'PrivateNumber' => $personal_number,
            'Number' => $document_number,
            'hash' => $hash,
        ];

        return $this->request();
    }

    public function request() {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->body, JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->body);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        $resultJson = trim(curl_exec($ch));
        curl_close($ch);

        $result = json_decode($resultJson, TRUE);

        $this->Database->insert('sda_logs', [
            'api' => 'leaderpay.ge',
            'request' => json_encode($this->body, JSON_UNESCAPED_UNICODE),
            'response' =>  $resultJson]);

        return $result;

    }

}
