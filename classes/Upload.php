<?php

class Upload {

  private $url = 'https://uploads.allpayway.ge/';
  private $secret = 'Jur\k2$DkR"!2J}';
  private $name = "index.php";
  public $post = array();

  public function file($params) {
    $secret = $this->secret;
    $this->name = "index.php";

    $hashStr = $params["file_name"] . $secret;
    $hash = hash('sha256', $hashStr);

    $this->post = array(
      "file"      => trim($params["file"]),
      "file_name" => trim($params["file_name"]),
      "dir"       => trim($params["dir"]),
      "hash"      => $hash,
    );

    return $this->request();

  } // end file method

  public function get($params) {
    $secret = $this->secret;
    $this->name = "get.php";

    $hashStr = $params["name"] . $secret;
    $hash = hash('sha256', $hashStr);

    $this->post = array(
      "name"      => trim($params["name"]),
      "hash"      => $hash,
    );

    return $this->request();

  } // end delete method


  public function delete($params) {
    $secret = $this->secret;
    $this->name = "delete.php";

    $hashStr = $params["pach"] . $secret;
    $hash = hash('sha256', $hashStr);

    $this->post = array(
      "pach"      => trim($params["pach"]),
      "hash"      => $hash,
    );

    return $this->request();
  } // end delete method

  public function request() {
    // $data_string = json_encode($this->post);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->url.$this->name);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

    $result = trim(curl_exec($ch));
    curl_close($ch);

    $result = json_decode($result, TRUE);

    if ($result['errorCode'] == 10) {
      return $result['data']['file_name'];
    } else {
      return false;
    }

  } // end request method

} // end upload class
