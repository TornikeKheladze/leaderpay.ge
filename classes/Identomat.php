<?php

class Identomat {

    private $url = 'https://widget.identomat.com/external-api/';
    private $method = '';
    private $secret = '61bc5579572c89188656ad56_801caa7528991759965873d8e8cbd47f1b1e8728';
    public $body = [];
    private $session_token;
    public $Database;

    public function __construct($Database, $session_token = null) {

        $this->Database = $Database;

        $this->body = [
            'company_key' => $this->secret,
        ];

        if ($session_token) {

            $this->body['session_token'] = $session_token;

        } else {

            $this->body['flags'] = [
                'language' => 'ka',
                'document_types' => ['id', 'passport'],
                'allow_document_upload' => true,
                'skip_desktop' => false,
                'skip_face' => false,
            ];

        }

    }

    public function begin() {

        $this->method = 'begin';

        return $this->request();
    }

    public function result() {

        $this->method = 'result';

        return $this->request();

    }

    public function documentFront() {

        $this->method = 'result/card-front';

        return $this->grabImage();

    }

    public function documentBack() {

        $this->method = 'result/card-back/';

        return $this->grabImage();

    }

    public function passport() {

        $this->method = 'result/passport';

        return $this->grabImage();

    }

    public function self() {

        $this->method = 'result/face';

        return $this->grabImage();

    }

    public function grabImage() {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . $this->method . '/');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->body);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $raw = curl_exec($ch);
        curl_close ($ch);

        $this->Database->insert('identomat_logs', [
            'method' => $this->method,
            'api' => 'leaderpay.ge',
            'request' => json_encode($this->body, JSON_UNESCAPED_UNICODE),
            'response' =>  '...']);

        return base64_encode($raw);

    }

    public function request() {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . $this->method . '/');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->body, JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        $resultJson = trim(curl_exec($ch));
        curl_close($ch);

        $result = json_decode($resultJson, TRUE);

        $this->Database->insert('identomat_logs', [
            'method' => $this->method,
            'api' => 'leaderpay.ge',
            'request' => json_encode($this->body, JSON_UNESCAPED_UNICODE),
            'response' =>  $resultJson]);

        return $result;

    }

}
