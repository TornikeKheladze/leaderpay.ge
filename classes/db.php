<?php

  class db {
    private $db;

    public function __construct() {
      try {
        $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.CARSET,DB_USER,DB_PASS);
      } catch(PDOExeption $e) {
        exit("Unable to establish a connection to the database !");
      }
    }

      /**
       * Inserts api data into table
       *
       * @param $tableName
       * @param $request
       * @param $response
       *
       * @return bool|mixed
       */
      public function insertApiData($tableName, $request, $response) {
          $query = $this->db->prepare("INSERT INTO $tableName (request, response) values (:request, :response)");
          $query->bindParam(":request", $request, PDO::PARAM_LOB);
          $query->bindParam(":response", $response, PDO::PARAM_LOB);

          return $query->execute();
      }

    public function get_current_date() {
      $date = date("Y-m-d H:i:s");

      return $date;
    }

    public static function generate_random_string($length = 10) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
      $characters_length = strlen($characters);
      $random_string = '';

      for ($i = 0; $i < $length; $i++) {
          $random_string .= $characters[rand(0, $characters_length - 1)];
      }

      return $random_string;
    }

    //APW-42
      public function getUser($db, $where){
          $sth = $this->db->prepare("SELECT * FROM `$db` WHERE $where");
          $sth->execute();
          $row = $sth->fetch(PDO::FETCH_ASSOC);

          if ($sth->errorCode() == PDO::ERR_NONE ) {
              return $row;
          } else {
              return false;
          }
      }

          public function getCurrentDate() {
          $date = date("Y-m-d H:i:s");

          return $date;
      }
      public function getSmsLog($db,$where) {
          $date = $this->getCurrentDate();
          $sth = $this->db->prepare("SELECT date FROM `$db` WHERE $where ORDER BY `id` DESC LIMIT 1");
          $sth->execute();
          $row = $sth->fetch(PDO::FETCH_ASSOC);

          $date1 = date_create($date);
          $date2 = date_create($row["date"]);
          $interval = date_diff($date1, $date2);
          $inter = $interval->i*60 + $interval->s;


          if ($sth->errorCode() == PDO::ERR_NONE && $inter < 121  ) { //&& $inter < 121 
              return true; 
          } else {
              return false;
          }
      }

      public function getLastSmsCode($db, $where) {
          $date = $this->getCurrentDate();
          $sth = $this->db->prepare("SELECT * FROM `$db` WHERE $where  ORDER BY `id` DESC LIMIT 1");
          $sth->execute();
          $row = $sth->fetch(PDO::FETCH_ASSOC);

          $date1 = date_create($date);
          $date2 = date_create($row["date"]);
          $interval = date_diff($date1, $date2);
          $inter = $interval->i*60 + $interval->s;

          if ($sth->errorCode() == PDO::ERR_NONE && $inter < 121 && $inter != 0) { //&& $inter < 121 && $inter != 0
              return true;
          } else {
              return false;
          }

      }
//      public function getSmsCodeDate($db,$where) {
//          $sth = $this->db->prepare("SELECT date FROM `$db` WHERE $where LIMIT 1");
//          $sth->execute();
//          $row = $sth->fetch(PDO::FETCH_ASSOC);
//
//
//          if ($sth->errorCode() == PDO::ERR_NONE) {
//              return $row["date"];
//          } else {
//              return false;
//          }
//      }
   //APW-42

    public function get_unlimited_list($db, $where, $sort_colum, $sort) {
      $sth = $this->db->prepare("SELECT * FROM `$db` WHERE $where ORDER BY `$sort_colum` $sort");
      $sth->execute();
      $row = $sth->fetchAll(PDO::FETCH_ASSOC);

      if ($sth->errorCode() == PDO::ERR_NONE) {
          return $row;
      } else {
          return false;
      }
    }

    public function get_limited_list($db, $where, $sort_colum, $sort, $limit) {
      $sth = $this->db->prepare("SELECT * FROM `$db` WHERE $where ORDER BY `$sort_colum` $sort LIMIT $limit");
      $sth->execute();
      $row = $sth->fetchAll(PDO::FETCH_ASSOC);

      if ($sth->errorCode() == PDO::ERR_NONE) {
          return $row;
      } else {
          return false;
      }
    }

    public function get_date($db, $where) {
      $sth = $this->db->prepare("SELECT * FROM `$db` WHERE $where");
      $sth->execute();
      $row = $sth->fetch(PDO::FETCH_ASSOC);

      if ($sth->errorCode() == PDO::ERR_NONE) {
          return $row;
      } else {
          return false;
          // return $sth->errorInfo();
      }
    }

    public function getWallet($db, $where) {
        $sth = $this->db->prepare("SELECT * FROM `$db` WHERE $where LIMIT 1");
        $sth->execute();
        $row = $sth->fetch(PDO::FETCH_ASSOC);

        if ($sth->errorCode() == PDO::ERR_NONE) {
            return $row;
        } else {
            return false;
        }
    }

    public function get_date_row($db, $rows, $where) {
      $sth = $this->db->prepare("SELECT $rows FROM `$db` WHERE $where");
      $sth->execute();
      $row = $sth->fetch(PDO::FETCH_ASSOC);

      if ($sth->errorCode() == PDO::ERR_NONE) {
          return $row;
      } else {
          return false;
      }
    }

    public function update($db, $params, $id) {
      $old_date = $this->get_date($db," `id` = '".$id."' ");
      $sql = "UPDATE `$db` SET ";
      $update_str = '';

      foreach ($params as $key => $value) {
        $update_str .= " `".$key."` = :".$key." ,";
      }

      $update_str = rtrim($update_str, ",");
      $sql .= $update_str;
      $sql .= " WHERE id = :id";

      $sth = $this->db->prepare($sql);

      foreach ($params as $key => $value) {
          $sth->bindValue(":" . $key, $value, PDO::PARAM_STR);
      }

      $sth->bindValue(":id", $id, PDO::PARAM_INT);
      $sth->execute();

      if ($sth->errorCode() == PDO::ERR_NONE) {
        // create log
          $log_array = array(
              "old" => array(
              ),
              "new" => array(
              ),
          );

          foreach ($params as $key => $value) {
            $log_array['old'][] = $key.' => '.$old_date[$key];
          }

          foreach ($params as $key => $value) {
            $log_array['new'][] = $key.' => '.$value;
          }

          $json = json_encode($log_array);
          $log = $this->log($id,$db,"update",$json);
          // end logs

          return true;
      } else {
          return false;
      }
    }

    public function insert($db, $params) {
      $sql = "INSERT INTO `$db` (";
      $keys = '';

      foreach ($params as $key => $value) {
        $keys .= "`".$key."`,";
      }

      $keys = rtrim($keys, ",");
      $sql .= $keys;
      $sql .= ") VALUES (";
      $values = '';

      foreach ($params as $key => $value) {
        $values .= ":".$key.",";
      }

      $values = rtrim($values, ",");
      $sql .= $values;
      $sql .= ") ";
      $sth = $this->db->prepare($sql);

      foreach ($params as $key => $value) {
          $sth->bindValue(":" . $key, $value, PDO::PARAM_STR);
      }

      $sth->execute();

      if ($sth->errorCode() == PDO::ERR_NONE) {
        // get last id
        $last_id = $this->db->lastInsertId();

        // create log
          $log_array = array(
              "insert" => array(
              ),
          );

          foreach ($params as $key => $value) {
            $log_array['insert'] = $key.' => '.$value;
          }

          $json = json_encode($log_array);
          $log = $this->log($last_id,$db,"insert",$json);

          return $last_id;
      } else {
          return false;
          //return $sth->errorInfo();
      }
    }

    public function get_max($db) {
      $sth = $this->db->prepare("SELECT id FROM `$db` ORDER BY id DESC LIMIT 0, 1");
      $sth->execute();
      $row = $sth->fetch(PDO::FETCH_ASSOC);

      if ($sth->errorCode() == PDO::ERR_NONE) {
          return $row['id'];
      } else {
          return false;
      }
    }

    public function check_auch() {
      if (isset($_SESSION["user_name"]) && isset($_SESSION["token"])) {
        $username = $_SESSION["user_name"];
        $user_token = $_SESSION["token"];
        $data = $this->get_date("users", " `personal_number` = '".$username."' AND `token` = '".$user_token."' ");
      	$token = uniqid();
      	$token = hash("sha256",$token);
      	$token = strtolower($token);

      	if($data === false){
      		return false;
      	} else {
      		$params = array(
      		    "token" => $token,
      		);

      		$this->update("users", $params, $data["id"]);
          $_SESSION["token"] = $token;

      		return true;
      	}
      } else {
        	return false;
      } 
    }

    public function update_balance($user_id, $balance) {
      $user_id = intval($user_id);
      $new_balance = floatval($balance);
      $user_balance = $this->get_date_row("users", "balance", " `personal_number` = '".$user_id."' ");

      $sth = $this->db->prepare("UPDATE `users` SET `balance` = :balance WHERE `personal_number` = :personal_number ");
      $sth->bindValue(":balance", $new_balance, PDO::PARAM_STR);
      $sth->bindValue(":personal_number", $user_id, PDO::PARAM_INT);
      $sth->execute();

      if ($sth->errorCode() == PDO::ERR_NONE) {
          // create log
          $log_array = array(
              "old" => array(
                "balance" => $user_balance
              ),
              "new" => array(
                "balance" => $new_balance
              ),
          );

          $json = json_encode($log_array);
          $log = $this->log($user_id, "users", "update", $json);

          return true;
      } else {
          return false;
      }
    }

    public function table_count($db, $where) {
        $sth = $this->db->prepare("SELECT COUNT(*) as `count` FROM `$db` WHERE $where ");
        $sth->execute();
        $row = $sth->fetch(PDO::FETCH_ASSOC);

        if ($sth->errorCode() == PDO::ERR_NONE) {
            return intval($row["count"]);
        } else {
            return false;
        }
    }

    public function delete($db, $where) {
      $sth = $this->db->prepare("DELETE FROM `$db` WHERE $where ");
      $sth->execute();

      if ($sth->errorCode() == PDO::ERR_NONE) {
          // create log
          $log_array = array(
              "SQL" => "DELETE FROM `$db` WHERE $where "
          );

          $json = json_encode($log_array);
          $log = $this->log("",$db,"Delete",$json);

          return true;
      } else {
          return false;
      }
    }

    public function image_upload($name, $url, $file, $extensions) {
      $uploaded_extension = explode(".",$file[$name]["name"]);
      // if valid extension
      if (in_array($uploaded_extension[1], $extensions)) {
        foreach ($extensions as $extension) {
          if ($uploaded_extension[1] == $extension) {
            $new_name = uniqid().'.'.$extension;
            $upload_url = $url.$new_name;
          }
        }

        if(move_uploaded_file($file[$name]["tmp_name"],$upload_url)) {
          // $a = $this->resize_image($upload_url, 80, 80,1);
          return $new_name;
        } else{
          return false;
        }
      } else {
        return false;
      }
    }

    public function resize_image($file, $w, $h, $crop=FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }
        $src = imagecreatefromjpeg($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        return $dst;
    }

    // insert logs
    public function log($row_id, $table, $action, $json) {
      $date = $this->get_current_date();
      $rows = "`row_id`,`table`,`action`,`json`,`date`";
      $values = ":row_id,:table,:action,:json,:date";

      $sth = $this->db->prepare("INSERT INTO logs(".$rows.") VALUES(".$values.")");
      $sth->bindParam(":row_id", $row_id, PDO::PARAM_INT);
      $sth->bindParam(":table", $table, PDO::PARAM_STR);
      $sth->bindParam(":action", $action, PDO::PARAM_STR);
      $sth->bindParam(":json", $json, PDO::PARAM_STR);
      $sth->bindParam(":date", $date, PDO::PARAM_STR);
      $sth->execute();

       if ($sth->errorCode() == PDO::ERR_NONE) {
         return true;
       } else {
         return false;
       }
    }

    public function payment_logs($method, $request, $operation_id, $error_code, $response) {
      $date = $this->get_current_date();
      $rows = "`method`,`request`,`operation_id`,`error_code`,`response`,`date`";
      $values = ":method,:request,:operation_id,:error_code,:response,:date";

      $sth = $this->db->prepare("INSERT INTO payment_logs(".$rows.") VALUES(".$values.")");
      $sth->bindParam(":method", $method, PDO::PARAM_STR);
      $sth->bindParam(":request", $request, PDO::PARAM_STR);
      $sth->bindParam(":operation_id", $operation_id, PDO::PARAM_INT);
      $sth->bindParam(":error_code", $error_code, PDO::PARAM_STR);
      $sth->bindParam(":response", $response, PDO::PARAM_STR);
      $sth->bindParam(":date", $date, PDO::PARAM_STR);
      $sth->execute();

       if ($sth->errorCode() == PDO::ERR_NONE) {
         return true;
       } else {
         return false;
       }
    }

      public function get_personal_number() {
          $sth = $this->db->prepare("SELECT * FROM `users` where wallet_number LIKE '100000%' ORDER BY wallet_number DESC LIMIT 0, 1");
          $sth->execute();
          $row = $sth->fetch(PDO::FETCH_ASSOC);

          if ($sth->errorCode() == PDO::ERR_NONE) {
              $get_int = intval($row['wallet_number']);
              $new_wallet_number = $get_int +1;

              return $new_wallet_number;
          } else {
              return false;
          }
      }

      //kakha banace restore
      public function getUserBalanceHistory($personal_number, $currency = null){
          if (isset($currency)) {
              $w = " AND currency_id = :currency_id ";
          }

          $sth = $this->db->prepare("SELECT * FROM user_balance_history WHERE personal_number = :personal_number ".$w." ORDER BY date ASC");
          $sth->bindParam(":personal_number", $personal_number, PDO::PARAM_INT);

          if (isset($currency)) {
              $sth->bindParam(":currency_id", $currency, PDO::PARAM_INT);
          }

          $sth->execute();
          $row = $sth->fetchAll(PDO::FETCH_ASSOC);

          if ($sth->errorCode() == PDO::ERR_NONE) {
              return $row;
          }else{
              return false;
          }
      }

      public function updateUserAvance($id,$balance, $currency){
          $sth = $this->db->prepare("UPDATE user_balance_history SET balance = :balance WHERE id = :id AND currency_id = :currency_id");
          $sth->bindParam(":balance", $balance, PDO::PARAM_STR);
          $sth->bindParam(":id", $id, PDO::PARAM_INT);
          $sth->bindParam(":currency_id", $currency, PDO::PARAM_INT);
          $sth->execute();
      }

      public function updateUserBalance($id, $balance, $currency){
          if ($currency == '981') {
              $w = "balance";
          } else if ($currency == '840') {
              $w = "balance_usd";
          } else if ($currency == '978') {
              $w = "balance_eur";
          } else if ($currency == '643') {
              $w = "balance_rub";
          }

          $sth = $this->db->prepare("UPDATE users SET ".$w." = :".$w." WHERE id = :id");
          $sth->bindParam(":".$w, $balance, PDO::PARAM_STR);
          $sth->bindParam(":id", $id, PDO::PARAM_INT);
          $sth->execute();
      }
      // end kakha

    public function getClientIp() {

        $ip = '';
        if (!empty($_SERVER['HTTP_X_REAL_IP'])) {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;

    }

    public function Login($username, $password, $sms = null) {

        if ($sms) {

            $sth = $this->db->prepare('SELECT * FROM `users` WHERE wallet_number = :wallet_number AND password = :password AND sms_code = :sms_code AND is_blocked = 0 ');
            $sth->bindParam(':sms_code', $sms, PDO::PARAM_INT);

        } else {

            $sth = $this->db->prepare('SELECT * FROM `users` WHERE wallet_number = :wallet_number AND password = :password AND is_blocked = 0 ');

        }
        $sth->bindParam(':wallet_number', $username, PDO::PARAM_STR);
        $sth->bindParam(':password', $password, PDO::PARAM_STR);
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);

        return ($sth->errorCode() == PDO::ERR_NONE) ? $data : false;

    }

    public function UserByWalletNumber($wallet_number) {

        $sth = $this->db->prepare('SELECT * FROM `users` WHERE wallet_number = :wallet_number AND is_blocked = 0 ');

        $sth->bindParam(':wallet_number', $wallet_number, PDO::PARAM_STR);
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);

        return ($sth->errorCode() == PDO::ERR_NONE) ? $data : false;

    }

    public function EmailUser($email) {

        $sth = $this->db->prepare('SELECT * FROM `users` WHERE email = :email ');

        $sth->bindParam(':email', $email, PDO::PARAM_STR);
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);

        return ($sth->errorCode() == PDO::ERR_NONE) ? $data : false;

    }
    public function MobileUser($mobile) {

        $sth = $this->db->prepare('SELECT * FROM `users` WHERE mobile = :mobile ');

        $sth->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);

        return ($sth->errorCode() == PDO::ERR_NONE) ? $data : false;

    }

  }
