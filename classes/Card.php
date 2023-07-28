<?php

class Card {

    private $url = 'https://pay.allpayway.ge';
    private $secret = 'bJdqGRV5X6!#v4**';
    public $post;
    public $method;

    public function __construct(db $db) {
        $this->db = $db;
    }

    /**
     * Card binding
     * @param int $operation_id
     * @param int $order_id
     * @return
     */
    public function Binding($operation_id, $order_id) {

        $data = [
            'operation_id' => $operation_id,
            'order_id' => $order_id,
            'pay_Register' => 1,
        ];

        $params = htmlspecialchars(http_build_query($data));
        $url = $this->url . "/pay?$params";
        $url = str_replace('&amp;', '&', $url);

        // insert log
        $params = [
            'operation_id' => $operation_id,
            'method' => 'Binding',
            'request' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'ip' => $this->db->getClientIp(),
        ];
        $this->db->insert('card_logs', $params);

        Header("Location: $url");
        die();

    }

    /**
     * Withdraw money to the card
     * @param int $operation_id
     * @param int $order_id
     * @param float $amount
     * @return string
     */
    public function Pay($operation_id, $order_id, $amount) {

        $amount = (int) round($amount * 100);

        $this->method = 'depositing-pay';

        $this->post = [
            'operation_id' => $operation_id,
            'order_id' => $order_id,
            'id' => $order_id,
            'pay_Register' => 1,
            'amount' => $amount
        ];

        return $this->request();

    }

    /**
     * henerate hash string.
     * @param int $order_id
     * @return string
     */
    private function generateHesh($order_id): string {

        $date = date('Y-m-d');
        $secret = $this->secret;

        $hash = $order_id . $secret . $date;

        return hash('sha256', md5($hash));
    }

    /**
     * send request to vendor.
     *
     * @return object
     */
    public function request(): object {

        $post = $this->post;
        $post['hash'] = $this->generateHesh($post['id']);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . '/' . $this->method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        $result = curl_exec($ch);
        curl_close ($ch);

        $resultObj = json_decode($result);

        // insert log
        $params = [
            'operation_id' => $post['operation_id'],
            'method' => $this->method,
            'request' => json_encode($post, JSON_UNESCAPED_UNICODE),
            'response' => $result,
        ];
        $this->db->insert('card_logs', $params);

        return $resultObj;
    }

    /**
     * generate uniq card id
     * @param int  $length
     * @return string
     */
    public function GenerateId($length = 64) {

        $characters = '0123456789';
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
     * @param string  $id
     * @return boolean
     */
    public function CeckUnique($id) {

        return $this->db->get_date('cards', " card_id = '$id'");

    }

}
