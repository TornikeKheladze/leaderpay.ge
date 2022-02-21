<?php

class verification {

	private $url = "https://api.allpayway.ge/verification_api/";
  private $secret = "Q^q76-Ma7[p!";


  public function sms($params) {
		//
    $personal_number = trim($params['personal_number']);
    $document_number = trim($params['document_number']);

    $hash_string =  $personal_number . $document_number . $this->secret;
    $hash = hash("sha256",$hash_string);

    $url = $this->url . 'sms.php?personal_number=' . $personal_number . '&document_number=' . $document_number . '&hash=' . $hash;

    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) .'/cookie.txt'); //save cookies here
		$result = trim(curl_exec($ch));
		curl_close($ch);

    return $result;



  }

  public function check($params) {

    $sms = trim($params['sms']);

    $personal_number = trim($_SESSION['personal_number']);
    $document_number = trim($_SESSION['document_number']);

    $hash_string =  $personal_number . $document_number . $this->secret;
    $hash = hash("sha256",$hash_string);

    $url = $this->url . 'check.php?personal_number=' . $personal_number . '&document_number=' . $document_number . '&sms=' . $sms . '&hash=' . $hash;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
		curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__).'/cookie.txt'); //read cookies from here
    $result = trim(curl_exec($ch));
    curl_close($ch);

		$r = json_decode($result, true);

	  if ($r['errorCode'] == 7) {

	    $_SESSION['document_front'] = "1";

	  }

		if ($r['errorCode'] == 8) {

	    $_SESSION['document_back'] = "1";

	  }

    return $result;

  }

  public function file($params) {

		$personal_number = trim($_SESSION['personal_number']);
    $document_number = trim($_SESSION['document_number']);

		$document_front = $params['document_front'];
    $document_back = $params['document_back'];


		$document_type = $params['document_type'];
		$issue_date = $params['issue_date'];
		$expiry_date = $params['expiry_date'];
    $sfero_id = $params['sfero_id'];

		$hash_string =  $personal_number . $document_number . $this->secret;
		$hash = hash("sha256",$hash_string);


    $url = $this->url . 'file.php';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS,"personal_number=" . $personal_number . "&document_number=" . $document_number . "&document_type=" . $document_type ."&document_front=" . $document_front . "&document_back=" . $document_back . "&sfero_id=" . $sfero_id . "&issue_date=" . $issue_date . "&expiry_date=" . $expiry_date . "&hash=" . $hash . " ");

    $result = trim(curl_exec($ch));
    curl_close($ch);

    return $result;

  }


  public function insert($params) {

    $personal_number = trim($_SESSION['personal_number']);
    $document_number = trim($_SESSION['document_number']);

    $document_front = $params['document_front'];
    $document_back = $params['document_back'];

		$document_type = $params['document_type'];
		$issue_date = $params['issue_date'];
		$expiry_date = $params['expiry_date'];
    $sfero_id = $params['sfero_id'];


    $hash_string =  $personal_number . $document_number . $this->secret;
    $hash = hash("sha256",$hash_string);

		$url_get = "";

		if (isset($_SESSION['document_front'])) {

			$url_get .= "document_front";

		}
		if (isset($_SESSION['document_back'])) {

			$url_get .= "document_back";

		}

		// $url = $this->url . 'verification.php?'.$url_get;
    $url = $this->url . 'verification.php';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,"personal_number=" . $personal_number . "&document_number=" . $document_number . "&document_type=" . $document_type ."&document_front=" . $document_front . "&document_back=" . $document_back . "&sfero_id=" . $sfero_id . "&issue_date=" . $issue_date . "&expiry_date=" . $expiry_date .  "&hash=" . $hash . " ");
    $result = trim(curl_exec($ch));
    curl_close($ch);

    return $result;

  }


	public function reg_file($params) {

		$personal_number = trim($params['personal_number']);
		$time = $params['date'];

		$hash_string =  $personal_number  . $this->secret;
		$hash = hash("sha256",$hash_string);

		$url = $this->url . 'reg_file.php';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,

		"&personal_number=" . $personal_number .
		"&first_name=" . $params['first_name'] .
		"&last_name=" . $params['last_name'] .
        "&time=".$time.
		"&hash=" . $hash . " ");

		$result = trim(curl_exec($ch));
		curl_close($ch);

		return $result;

	}
    public function old_reg_file($params) {

        $personal_number = trim($params['personal_number']);
        $time = $params['date'];

        $hash_string =  $personal_number . $this->secret;
        $hash = hash("sha256",$hash_string);

        $url = $this->url . 'old_reg_file.php';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,

            "&personal_number=" . $personal_number .
            "&first_name=" . $params['first_name'] .
            "&last_name=" . $params['last_name'] .
            "&time=".$time.
            "&hash=" . $hash . " ");

        $result = trim(curl_exec($ch));
        curl_close($ch);

        return $result;

    }

	public function registracion($params) {

		$personal_number = trim($params['personal_number']);
		$document_number = trim($params['document_number']);
       /* $time=date("Y-m-d");*/
		$hash_string =  $personal_number . $document_number . $this->secret;
		$hash = hash("sha256",$hash_string);

		$url = $this->url . 'registracion.php';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,

		"personal_number=" . $personal_number .
		"&country=" . $params['country'] .
		"&first_name=" . $params['first_name'] .
		"&last_name=" . $params['last_name'] .
		"&mobile=" . $params['mobile'] .
		"&email=" . $params['email'] .
		"&birth_date=" . $params['birth_date'] .
		"&birth_place=" . $params['birth_place'] .
		"&real_address=" . $params['real_address'] .
		"&password=" . $params['password'] .
		"&repeat_password=" . $params['repeat_password'] .
		"&gender=" . $params['gender'] .
		"&sfero_id=" . $params['sfero_id'] .
		"&sfero=" . $params['sfero'] .
		"&selfie=" . $params['selfie'] .


		"&document_type=" . $params['document_type'] .
		"&document_number=" . $document_number .
		"&document_front=" . $params['document_front'] .
		"&document_back=" . $params['document_back'] .
		"&issue_date=" . $params['issue_date'] .
		"&issue_organisation=" . $params['issue_organisation'] .
		"&expiry_date=" . $params['expiry_date'] .
		"&expiry=" . $params['expiry'] .

		"&checkbox=" . $params['checkbox'] .
		"&hash=" . $hash . " ");

		$result = trim(curl_exec($ch));
		curl_close($ch);

		return $result;

	}



}
