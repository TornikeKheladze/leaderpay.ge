<?php

    class Risk {
    
        private $url = 'https://api.allpayway.ge/risks/index.php';
        private $secret = '6%^THR^#$%RDSE!@#%GFG^3rr$#42sdffFDER#7';
        public $id = '';
        public $hash = '';

        public function Get($id) {

            $hashStr = $id . $this->secret;
            $hash = hash('sha256', $hashStr);

            $this->id = $id;
            $this->hash = $hash;

            return $this->request();

        }

        public function request() {

            $url = $this->url . '?id=' . $this->id . '&hash=' . $this->hash;
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
            $result = trim(curl_exec($ch));
            curl_close($ch);

        }

    }
