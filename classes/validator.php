<?php

class validator {

  // form validation
  public function validation($post,$files = null,$rules,$fields,$multiple_file_rule = null) {

    $errors = array();

    foreach ($rules as $key => $value) {


        // rules
        $rule_arr = explode("|", $value);

        foreach ($rule_arr as $rule) {

          // required
          if ($rule == "required") {

            $count = 0;
            if (empty($post[$key]) || $post[$key] == '') {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b> აუცილებელია <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end  required rule if

          // string
          if ($rule == "string") {

            $count = 0;
            if (!preg_match('/^[ა-ზA-Za-z _-]*$/', $post[$key])) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b> გამოიყენეთ მხოლოდ ასოები (ლათინური - ქართული) <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end string rule if

          // string only latin
          if ($rule == "string_latin") {

            $count = 0;
            if (!preg_match('/^[A-Za-z0-9 _-]*$/', $post[$key])) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b> გამოიყენეთ მხოლოდ ლათინური ასოები <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end string only latin rule if

          // string only georgian
          if ($rule == "string_georgian") {

            $count = 0;
            if (!preg_match('/^[ა-ზ0-9 _-]*$/', $post[$key])) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b> გამოიყენეთ მხოლოდ ქართული ასოები <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end string only georgian rule if

          // string only russian /^[a-zA-Z\p{Cyrillic}\d\s\-]+$/uа-яА-Я
          if ($rule == "string_russian") {

            $count = 0;
            if (!preg_match("/^[\p{Cyrillic}0-9 ]+$/u", $post[$key])) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b> გამოიყენეთ მხოლოდ რუსული ასოები <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end string only russian rule if

          // int_space
          if ($rule == "int_space") {

            $count = 0;
            if (!preg_match('/^[0-9 _-]*$/', $post[$key])) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b> გამოიყენეთ მხოლოდ ციფრები <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end int_space rule if

          // int_space
          if ($rule == "phone") {

            $count = 0;
            if (!preg_match('/^[0-9+ _-]*$/', $post[$key])) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b> გამოიყენეთ მხოლოდ ციფრები <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end int_space rule if

          if ($rule == "personal_number") {

            $count = 0;

            if (!preg_match('/^(\d{11})$/i', $post[$key])) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b>  ფორმატი არასწორია <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end personal_number if

          if ($rule == "expiry_date") {

            $count = 0;

            // $errors[] = '<b>'.strtotime($post[$key]).':</b>  ---- '.strtotime("now");


            if (strtotime($post[$key]) <= strtotime("now")) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b>  საბუთი ვადაგასულია <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end personal_number if

          if ($rule == "issue_date") {

            $count = 0;

            if (strtotime($post[$key]) > strtotime("now")) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b>  თარიღი არასწორია <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end personal_number if


          // integer
          if ($rule == "integer") {

            $count = 0;
            if (!is_numeric($post[$key])) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b> დასაშვებია მხოლოდ ციფრების გამოყენება <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end integer rule  if

          if ($rule == "date" && !empty($post[$key])) {

            $count = 0;
            if (!preg_match('/^[0-9-_-]*$/', $post[$key])) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b> გთხოვთ შეიყვანეთ სწორი თარიღი მაგ (2012-05-11) <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end integer rule  if


          // email
          if ($rule == "email") {

            $count = 0;
            if (!filter_var($post[$key], FILTER_VALIDATE_EMAIL)) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b> გთხოვთ შეიყვანეთ მოქმედი ელ-ფოსტა <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end email rule  if


          // string and number
          if ($rule == "string_number") {

            $count = 0;
            if (!preg_match('/^[ა-ზA-Za-z0-9 _-]*$/', $post[$key])) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b> გამოიყენეთ მხოლოდ ციფრები და ასოები (ლათინური - ქართული) <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end string and number

          // string and number .,?!@#&()-"
          if ($rule == "string_mixed") {

            $count = 0;
            if (!preg_match('/^[ა-ზA-Za-z0-9.,?!@#&()\/ _-]*$/', $post[$key])) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b> გამოიყენეთ მხოლოდ ციფრები, ასოები (ლათინური - ქართული) და სასვენი ნიშნები <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end string and number

          // string and number
          if ($rule == "skype") {

            $count = 0;
            if (!preg_match('/^[a-zA-Z0-9\.,\-_]*$/', $post[$key])) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b> ფორმატი არასწორია <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end string and number


          // file required
          if ($rule == "file_required") {

            $count = 0;
            if ($files != false && $files[$key]['error'] > 0) {
              $count++;
              $errors[] = '<b>'.$fields[$key].':</b> აუცილებელია <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end file required


          // child valid
          if (strpos($rule, ':') !== FALSE) {

            $child_arr = explode(":",$rule);

            // child valids
            if ($child_arr[0] == "min") {

              if (mb_strlen($post[$key]) < $child_arr[1] && $post[$key] != "") {

                $errors[] = '<b>'.$fields[$key].':</b> გთხოვთ შეიყვანეთ მინიმუმ '.$child_arr[1].' სიმბოლო <br>';

              }

            } // end child valid item

            if ($child_arr[0] == "max") {

              if (mb_strlen($post[$key]) > $child_arr[1]) {

                $errors[] = '<b>'.$fields[$key].':</b> გთხოვთ შეიყვანეთ მაქსიმუმ <b>'.$child_arr[1].'</b> სიმბოლო <br>';

              }


            } // end child valid item

            // child valids regex
            if ($child_arr[0] == "regex") {

              // mb_strlen($post[$key]) < $child_arr[1] && $post[$key] != ""

              if (!preg_match('/'.$child_arr[1].'/', $post[$key])) {

                $errors[] = '<b>'.$fields[$key].':</b> არასწორია <br>';

              }

            } // end child valid item

            //child valid item
            if ($child_arr[0] == "file_types" && $files[$key]['type'] != "") {

              $file_types = explode(",",$child_arr[1]);

              if (!in_array($files[$key]['type'],$file_types,true)) {

                $format =   explode("/",$child_arr[1]);

                $errors[] = '<b>'.$fields[$key].':</b> უნდა იყოს <b>'.strtoupper($format[1]).'</b> ფორმატის <br>';

              }


            } // end child valid item

            if ($child_arr[0] == "resolution" && $files[$key]['name'] != "") {

              $file_resolution = explode(",",$child_arr[1]);

              $width_rule = $file_resolution[0];
              $height_rule = $file_resolution[1];

              $file = $files[$key]['tmp_name'];
              list($width,$height) = getimagesize($file);

              if ($width != $width_rule || $height != $height_rule) {

                $error_r = str_replace(",","X",$child_arr[1]);

                $errors[] = '<b>'.$fields[$key].':</b> რეზოლუცია (ზომა) უნდა იყოს <b>'.$error_r.'</b> <br>';

              }

            } // end child resolution item


            //child valid item
            if ($child_arr[0] == "max_size" && $files[$key]['size'] != 0) {

              if ($files[$key]['size'] > $child_arr[1]) {

                $errors[] = '<b>'.$fields[$key].':</b> მაქსიმალური ზომა არის <b>'.$child_arr[1].'</b> ბიტი <br>';

              }


            } // end child valid item


          } // END child valid




        } // end rule foreach loop



    } // end validator foreach loop

    // multiple file validation
    if (isset($multiple_file_rule)) {

      foreach ($multiple_file_rule as $value) {

        //
        $main_array = explode("@", $value);

        // rules
        $rule_arr = explode("|", $main_array[0]);

        foreach ($rule_arr as $rule) {

          // file required
          if ($rule == "file_required") {

            $count = 0;
            if ($files != false && $files[$main_array[1]]['error'] > 0) {
              $count++;
              $errors[] = '<b>'.$main_array[2].':</b> აუცილებელია <br>';

              if ($count == 1) {
                break;
              } // end count if

            } // end one valid if

          } // end file required

          // child valid
          if (strpos($main_array[0], ':') !== FALSE) {

            $child_arr = explode(":",$main_array[0]);


            //child valid item
            if ($child_arr[0] == "file_types" && $files[$main_array[1]]['type'] != "") {

              $file_types = explode(",",$child_arr[1]);

              if (!in_array($files[$main_array[1]]['type'],$file_types,true)) {

                $format =   explode("/",$child_arr[1]);

                $errors[] = '<b>'.$main_array[2].':</b> უნდა იყოს <b>'.strtoupper($format[1]).'</b> ფორმატის <br>';

              }


            } // end child valid item

            if ($child_arr[0] == "resolution" && $files[$main_array[1]]['name'] != "") {

              $file_resolution = explode(",",$child_arr[1]);

              $width_rule = $file_resolution[0];
              $height_rule = $file_resolution[1];

              $file = $files[$main_array[1]]['tmp_name'];
              list($width,$height) = getimagesize($file);

              if ($width != $width_rule || $height != $height_rule) {

                $error_r = str_replace(",","X",$child_arr[1]);

                $errors[] = '<b>'.$main_array[2].':</b> რეზოლუცია (ზომა) უნდა იყოს <b>'.$error_r.'</b> <br>';

              }

            } // end child resolution item


            //child valid item
            if ($child_arr[0] == "max_size" && $files[$main_array[1]]['size'] != 0) {

              if ($files[$main_array[1]]['size'] > $child_arr[1]) {

                $errors[] = '<b>'.$main_array[2].':</b> მაქსიმალური ზომა არის <b>'.$child_arr[1].'</b> ბიტი <br>';

              }


            } // end child valid item


          } // END child valid


        }


      }

    }
    // End multiple file validation



    // return errors
    $errorcount = count($errors);

    if ($errorcount > 0) {

      return $errors;

    } else {

      return false;

    }

  } // end validation method

}
