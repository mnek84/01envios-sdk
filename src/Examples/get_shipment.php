<?php
include '../../vendor/autoload.php';

$sdk = new \EnviosSDK\Logistica();

$sdk->setToken("666");

try {


  //$createdShipment = $sdk->getShipment("2619872706");
  $createdShipment = $sdk->getShipmentByExternal("meli","1234");

  print $createdShipment->current_status['name'];

  foreach($createdShipment->history as $history)
  {
    print "ESTADOS: ".$history['name_displayed'];
  }

  //$createdShipment->makeLabelPrinted();
  $createdShipment->fullfiled();

  dd($createdShipment->history);

} catch (\EnviosSDK\ApiException $e) {

  die($e->getMessage());

} catch (\Exception $e) {
  die($e->getMessage());
}
