<?php

require '../classes/config.php';
require '../classes/db.php';
require '../classes/sms.php';

$db = new db();
$sms = new sms();

$send = $sms->send('995598477680',"apw.ge",'sssss');

var_dump($send);