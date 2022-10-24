<?php

class Billing {
    private $url = 'https://allpayment.ge/';
    private $agent_id;
    private $secret;
    private $name;
    public $post = [];
    public $db;

    public function __construct(db $db, $by) {
        $this->db = $db;

        if ($by == 'Merchant') {

            $this->agent_id = 27;
            $this->secret = "rY3To@WeS1#Iy3gK";

        }
        if ($by == 'Wallet') {

            $this->agent_id = 1;
            $this->secret = "UKjrfyXqMLwyqhKA";

        }

    }

    public function categories() {
        $agent_id = $this->agent_id;
        $time = time();
        $secret = $this->secret;

        $hashStr = $agent_id . $time . $secret;
        $hash = hash('sha256', $hashStr);

        $this->name = 'categories.php';

        $this->post = [
            'agent_id' => $agent_id,
            'time'     => $time,
            'hash'     => $hash,
        ];

        return $this->request();
    }

    /** get all categoryes
     * @param  int  $id
     */
    public function byCategory($id) {
        $agent_id = $this->agent_id;
        $time = time();
        $secret = $this->secret;

        $hashStr = $agent_id . $id . $time . $secret;
        $hash = hash('sha256', $hashStr);

        $this->name = 'category.php';

        $this->post = [
            'agent_id'    => $agent_id,
            'category_id' => $id,
            'time'        => $time,
            'hash'        => $hash,
        ];

        return $this->request();

    }

    /**
     * get all services
     *
     */
    public function services() {
        $agent_id = $this->agent_id;
        $time = time();
        $secret = $this->secret;

        $hashStr = $agent_id . $time . $secret;
        $hash = hash('sha256', $hashStr);

        $this->name = 'services.php';

        $this->post = [
            'agent_id'    => $agent_id,
            'time'        => $time,
            'hash'        => $hash,
        ];

        return $this->request();

    }

    /**
     * @param  int  $id
     */
    public function service($id) {
        $agent_id = $this->agent_id;
        $time = time();
        $secret = $this->secret;

        $hashStr = $agent_id . $id . $time . $secret;
        $hash = hash('sha256', $hashStr);

        $this->name = 'service.php';

        $this->post = [
            'agent_id'    => $agent_id,
            'service_id'  => $id,
            'time'        => $time,
            'hash'        => $hash,
        ];

        return $this->request();

    }

    /**
     * @param  array  $params
     */
    public function info($params) {

        if ($this->timeRestriction()) {

            return json_encode(['errorCode' => 99, 'errorMessage' => '00:01 საათამდე გადახდას ვერ შეძლებთ'], JSON_UNESCAPED_UNICODE);

        }

        $agent_id = $this->agent_id;
        $secret = $this->secret;

        $service_id = intval($params['service_id']);

        $date = date('Y-m-d h:i:s');
        $date = str_replace(' ', 'T', $date);

        $amount = 100;
        $hashstr = $agent_id . $service_id . $date . $secret;
        $hash = hash('sha256', $hashstr);

        $this->name = 'info.php';

        $this->post = [
            'agent_id'   => $agent_id,
            'service_id' => $service_id,
            'date'       => $date,
            'hash'       => $hash,
            'amount'     => $amount,
        ];

        foreach ($params as $key => $value) {
            $this->post[$key] = $value;
        }


        return $this->request();

    }

    public function names() {

        $agent_id = $this->agent_id;
        $secret = $this->secret;
        $time = time();

        $hashstr = $agent_id . $time . $secret;
        $hash = hash('sha256', $hashstr);

        $this->name = 'params.php';

        $this->post = [
            'agent_id'   => $agent_id,
            'time'       => $time,
            'hash'       => $hash,
        ];
        return $this->request();

    }

    /**
     * @param  array  $params
     */
    public function pay($params) {

        if ($this->timeRestriction()) {

            return json_encode(['errorCode' => 99, 'errorMessage' => '00:01 საათამდე გადახდას ვერ შეძლებთ'], JSON_UNESCAPED_UNICODE);

        }

        $agent_id = $this->agent_id;
        $secret = $this->secret;

        $service_id = intval($params['service_id']);

        $date = date('Y-m-d h:i:s');
        $date = str_replace(' ', 'T', $date);

        $amount = floatval($params['amount']);
        $agent_transaction_id = intval($params['agent_transaction_id']);

        $hashstr = $agent_id . $agent_transaction_id . $service_id . $amount . $date . $secret;
        $hash = hash('sha256', $hashstr);

        $this->name = 'testpay.php';

        $this->post = [
            'agent_id'              => $agent_id,
            'agent_transaction_id'  => $agent_transaction_id,
            'service_id'            => $service_id,
            'date'                  => $date,
            'hash'                  => $hash,
            'amount'                => $amount,
        ];

        foreach ($params as $key => $value) {
            $this->post[$key] = $value;
        }

        return $this->request();

    }

    public function request() {

        $params = '';
        foreach($this->post as $key => $value) {
            $params .= $key.'='.$value.'&';
        }

        $params = trim($params, '&');
        $url = $this->url . $this->name . '?' . $params;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = trim(curl_exec($ch));
        curl_close($ch);

        $result = json_decode($result, TRUE);

        // insert log
        $params = [
            'method' => $this->name,
            'operation_id' => 0,
            'error_code' => $result['errorCode'],
            'request' => json_encode($params, JSON_UNESCAPED_UNICODE),
            'response' => json_encode($result, JSON_UNESCAPED_UNICODE),
            'date' => $this->db->get_current_date(),
        ];
        $this->db->insert('payment_logs', $params);

        return $result;

    }

    public function timeRestriction() {

        $datetime = new DateTime( 'now', new DateTimeZone( 'Asia/Tbilisi' ) );

        $currentDatatime = $datetime->format('Y-m-d H:i:s');

        $currentData = $datetime->format('Y-m-d');

        $minutesToAdd = 31;

        $from = "$currentData 23:30:00";

        $newtimestamp = strtotime("$from  + $minutesToAdd minute");
        $newtimes = date('Y-m-d H:i:s', $newtimestamp);

        $to = $newtimes;

        return (strtotime($currentDatatime) > strtotime($from) && strtotime($currentDatatime) < strtotime($to)) ? true : false;

    }

}
