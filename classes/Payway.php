<?php

    class Payway {
        private $paywayUser = 'apw';
        private $paywayPass = 'apw!user';
        private $paywayUrl = 'https://payway.ge/init';
        private $paywaySecret = '5e8ee8a7815a2';
        private $customer_id = 2;
        public $db;
        public $post;
        public $method;

        public function __construct(db $db, $method = null){
            $this->db = $db;
            $this->method = $method;
        }

        public function check() {

            $request = $this->request();

            $json = [
                'errorCode' => 100,
                'errorMessage' => 'წარმატებული',
            ];

            if ($request->status != 00) {
                $json = [
                    'errorCode' => 99,
                    'errorMessage' => "ტექნიკური შეფერხება სკრინინგის სერვისზე",
                ];
            }
            if ($request->data->user->condition->state == 'UNCHECKED') {
                $json = [
                    'errorCode' => 98,
                    'errorMessage' => 'მიმდინარეობს მომხმარებლის გადამოწმება გთხოვთ სცადოთ მოგვიანებთ ან დაუკავშირდით “ოლლ ფეი ვეის“',

                ];
            }
            if ($request->data->user->status->terrorist) {
                $json = [
                    'errorCode' => 97,
                    'errorMessage' => 'მომხმარებელის მომსახურება შეზღუდულია. აუცილებლად დაუკავშირდით ოლ ფეი ვეი-ს',
                ];
            }

            return $json;
        }

        private function generateHesh() {
            $customer_id = $this->customer_id;
            $paywaySecret = $this->paywaySecret;
            $hash = hash( 'sha256', md5($customer_id . $paywaySecret ));

            return $hash;
        }

        public function request() {
            $paywayUser = $this->paywayUser;
            $paywayPass = $this->paywayPass;
            $paywayUrl = $this->paywayUrl;

            $paywayPost = $this->post;
            $paywayPost['hash'] = $this->generateHesh();
            $paywayPost['customer_id'] = $this->customer_id;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $paywayUrl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $paywayPost);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $paywayUser . ':' . $paywayPass);

            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

            $result = curl_exec($ch);
            curl_close ($ch);

            $arrayResult = json_decode($result);

            // insert log
            $params = [
                'method' => $this->method,
                'status_code' => $arrayResult->status,
                'status' => $arrayResult->description,
                'request' => json_encode($paywayPost, JSON_UNESCAPED_UNICODE),
                'response' => $result,
            ];
            $this->db->insert('payway_log', $params);

            return $arrayResult;
        }

    }
