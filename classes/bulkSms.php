<?php

    class bulkSms {
    
        private $url = 'https://api.allpayway.ge/bulksms/index.php';
        private $secret = '$%^G$fh56$@*)&';
        public $post = [];

        public function Send($params) {

            $number = trim($params['number']);
            $text = trim($params['text']);

            $hashStr = $number . $text .  $this->secret;
            $hash = hash('sha256', $hashStr);

            $this->post = [
                'number'    => $number,
                'text'      => $text,
                'hash'      => $hash,
            ];

            return $this->request();

        }

        public function generateCode($digits = 6){

            $i = 0;
            $pin = '';

            while($i < $digits){

                $pin .= mt_rand(0, 9);
                $i++;
            }

            return $pin;

        }

        public function request() {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

            $result = trim(curl_exec($ch));
            $result = json_decode($result,true);

            curl_close($ch);

            if ($result['errorCode'] == 10) {
                return true;
            } else {
                return false;
            }

        }

    }
