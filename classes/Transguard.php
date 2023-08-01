<?php

class Transguard {
    private $url = 'https://screening.apw.ge/check';
    private $customer_id = 2;
    private $secret = '649aae8bc137c';
    public $db;
    public $post;
    public $method;

    /**
     * set params
     *
     * @param object $db database class
     * @param string $method methode string
     *
     * @return void
     */
    public function __construct(db $db, $method = null) {
        $this->db = $db;
        $this->method = $method;
    }

    /**
     * chack user status.
     *
     * @return array
     */
    public function check(): array {

        $request = $this->request();

        if (isset($request->status)) {

            if ($request->status == 'ALLOW' || $request->status == 'ALLOW_PEP') {

                $json = [
                    'errorCode' => 100,
                    'errorMessage' => 'წარმატებული',
                ];

            } else {
                $json = [
                    'errorCode' => 98,
                    'errorMessage' => 'მიმდინარეობს მომხმარებლის გადამოწმება გთხოვთ სცადოთ მოგვიანებთ ან დაუკავშირდით “ოლლ ფეი ვეის“',
                ];
            }

        } else {

            $json = [
                'errorCode' => 99,
                'errorMessage' => 'ტექნიკური შეფერხება მომხმარებლის გადამოწმების დროს',
            ];

        }

        return $json;
    }

    /**
     * henerate hash string.
     *
     * @return string
     */
    private function generateHesh(): string {
        $customer_id = $this->customer_id;
        $secret = $this->secret;
        $hash = hash( 'sha256', md5($customer_id . $secret ));

        return $hash;
    }

    /**
     * send request to vendor.
     *
     * @return object
     */
    public function request(): object {

        $post = $this->post;
        $post['hash'] = $this->generateHesh();
        $post['customer_id'] = $this->customer_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        $result = curl_exec($ch);
        curl_close ($ch);

        $resultObj = json_decode($result, false);

        // insert log
        $params = [
            'method' => $this->method,
            'status' => @$resultObj->status,
            'request' => json_encode($post, JSON_UNESCAPED_UNICODE),
            'response' => $result,
        ];
        $this->db->insert('transguard_logs', $params);

        return $resultObj;
    }

}