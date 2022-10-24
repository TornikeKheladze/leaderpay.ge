<?php

class Merchant {

    private $secret = 'T8yiIkehXanhmAW6';
    private $service_id = 1;
    private $customer_id = 102;
    private $lang = 'ge';
    private $firstName = 'firstName';
    private $lastName = 'lastName';
    private $personal_no = 99999999999;
    private $birthdate = '1999-09-09';
    private $currency_id = 1;
    private $url = 'https://apw.ge/bank';
    public $db;

    public function __construct(db $db) {
        $this->db = $db;
    }

    /**
     * initialize
     * @param float  $amount
     * @param string  $description
     * @param int  $token
     * @return
     */
    public function Init($amount, $description, $token) {

        $hashString = $this->customer_id . $this->secret;

        //$hash = hash('sha256', md5($hashString));
        $hash = 'test';

        $data = [
            'hash' => $hash,
            'token' => $token,
            'service_id' => $this->service_id,
            'customer_id' => $this->customer_id,
            'lang' => $this->lang,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'personal_no' => $this->personal_no,
            'birthdate' => $this->birthdate,
            'currency_id' => $this->currency_id,
            'amount' => $amount,
            'description' => $description,
        ];

        $params = htmlspecialchars(http_build_query($data));
        $url = "$this->url?$params";
        $url = str_replace('&amp;', '&', $url);

        // insert log
        $params = [
            'token' => $token,
            'method' => 'Init',
            'request' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'ip' => $this->db->getClientIp(),
        ];
        $this->db->insert('apw_logs', $params);

        Header("Location: $url");
        die();

    }

    /**
     * generate uniq operation id
     * @param int  $length
     * @return string
     */
    public function Token($length = 64) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[rand(0, $charactersLength - 1)];
        }

        if ($this->CeckUnique($string)) {
            return $this->Generate();
        }

        return $string;

    }

    /**
     * check id unique
     * @param string  $token
     * @return boolean
     */
    public function CeckUnique($token) {

        return $this->db->get_date('apw_operations', " token = '$token'");

    }
}
