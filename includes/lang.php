<?php

$lang_id = "ge";

  if (isset($_GET['lang'])) {

    // set language
    if ($cookie::set("lang", $_GET['lang'], time()+100000000) == true) {

      $page_uri = explode('lang', $_SERVER['REQUEST_URI']);
      header('Location:'.$page_uri[0]);

    }


    // get language
    $lang_id = $cookie::get('lang');

  } else {

    if ($cookie::check('lang') == true) {

      // get language
      $lang_id = $cookie::get('lang');

    } else {

      // default language
      $lang_id = "ge";

    }

  }
  
  if(!in_array($lang_id,array("ge","ru","en"))){
	  
	  $lang_id = "ge";
	  
  }

include 'language/'.$lang_id.'.php';


 ?>
