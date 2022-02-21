<?php


// cookye
class cookie {

  // check
  public static function check($name) {

    if (isset($_COOKIE[$name])) {

      return true;

    } else {

      return false;

    }
  }

  // set cookie
  public static function set($name,$value,$time = null) {

    if ($time != null) {

      setcookie($name,$value,$time);
      return true;

    } else {

      setcookie($name,$value);
      return true;

    }
  }
  // get cookie
  public static function get($name) {

    return $_COOKIE[$name];

  }
  // destroy cookie
  public static function destroy($name) {

    unset($_COOKIE[$name]);

  }

  // cockie alert


  public static function alert($tipe,$msg) {

    setcookie('alert_status', $tipe,  time()+2, '/');
    setcookie('alert_msg', $msg,  time()+2, '/');

  }


}
