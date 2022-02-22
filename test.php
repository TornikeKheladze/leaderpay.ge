<?php 
    exit();
    ini_set("display_errors",1);
    error_reporting(E_ALL);
	ini_set('memory_limit', '256M');
    require_once "classes/config.php";
    require_once "classes/db.php";
    require_once "classes/verification.php";
	
	$db = new db();
	$verification = new verification();
	
	$list = $db->get_limited_list("users"," created_at < '2019-11-01 00:00:00' AND ISNULL(contract)","id","ASC",100);
	
	foreach($list as $l){
		
		list($date,$time) = explode(" ",$l["created_at"]);
		
		$params = array(
		    "personal_number" => $l["personal_number"],
		    "first_name" => $l["first_name"],
		    "last_name" => $l["last_name"],
		    "date" => $date,
		);
		
		$result = $verification->old_reg_file($params);
		
		$result = json_decode($result);
		
		if($result->errorCode=="100"){
			
			$p = array(
			    "contract" => $result->data
			);
			
			$db->update("users",$p,$l["id"]);
			
		}
		
	}
	
	echo "SUCCESS";

	//Gitlab Test 1