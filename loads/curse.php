<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// $client = new SoapClient('https://services.nbg.gov.ge/Rates/Service.asmx?wsdl');
//
// // Only two Currency - USD and EUR
// $currencies = 'USD,EUR';
// $result = $client->GetCurrentRates(array('Currencies'=>$currencies));
//

// All Currencies
//$result = $client->GetCurrentRates();

require '../classes/config.php';
require '../classes/db.php';

$db = new db();

$rates = $db->get_unlimited_list("cross_rates"," `from` = 'USD' AND `to` = 'GEL' OR `from` = 'EUR' AND `to` = 'GEL' ", "date", "DESC");

echo '<div class="title"><span>ვალუტის კურსი</span></div>';

$count = 0;

foreach($rates as $rate) {

  if ($rate['from'] == "USD") {

    $c = "$";

  } elseif($rate['from'] == "EUR") {

    $c = "€";

  } else {

    $c = "0";

  }

  // if ($rate->Diff < 0) {
  //
  //   $k = '<i class="fa fa-caret-down down" aria-hidden="true"></i>';
  //
  // } else {
  //
  //   $k = '<i class="fa fa-caret-up up" aria-hidden="true"></i>';
  //
  //
  // }



  echo '<div class="result-list">
          <div class="icon">'.$c.'</div>
          <div class="course">'.number_format($rate['rate'],4).'</div>
          <div class="rat"></div>
        </div>';

  $count++;
  if ($count == 2) {
    return false;
  }

}
