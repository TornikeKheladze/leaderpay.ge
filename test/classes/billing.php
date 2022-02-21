<?php
    class billing{
        private $secret="UKjrfyXqMLwyqhKA";
        private $agent_id=16;
        private $url="https://allpayment.ge/";

        public function get_category(){

            $agent_id=$this->agent_id;
            $secret=$this->secret;
            $time=time();

            $hashstr=$agent_id . $time . $secret;
            $hash=hash('sha256',$hashstr);

            $url=$this->url."categories.php?agent_id=".$agent_id."&time=".$time."&hash=".$hash;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            $result = trim(curl_exec($ch));
            curl_close($ch);

            $data=json_decode($result,true);
            return $data;

        }

        public function get_services($category_id){
            $agent_id=$this->agent_id;
            $secret=$this->secret;
            $time=time();

            $hashstr=$agent_id . $category_id . $time . $secret;
            $hash=hash('sha256',$hashstr);
            $url=$this->url."category.php?agent_id=".$agent_id."&category_id=".$category_id."&hash=".$hash."&time=".$time;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            $result = trim(curl_exec($ch));
            curl_close($ch);

            $data=json_decode($result,true);
            return $data;
        }

        public function get_service($service_id){
            $agent_id=$this->agent_id;
            $secret=$this->secret;
            $time=time();

            $hashstr=$agent_id . $service_id . $time . $secret;
            $hash=hash('sha256',$hashstr);
            $url=$this->url."service.php?agent_id=".$agent_id."&$service_id=".$service_id."&hash=".$hash."&time=".$time;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            $result = trim(curl_exec($ch));
            curl_close($ch);

            $data=json_decode($result,true);
            return $data;
        }

    }
?>