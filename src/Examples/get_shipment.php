<?php
include '../../vendor/autoload.php';

$sdk = new \LogisticaSdk\Logistica();

$sdk->setToken("666");

try {


  $createdShipment = $sdk->getShipment("2619872706");

  print $createdShipment->current_status['name'];

  foreach($createdShipment->history as $history)
  {
    print "ESTADOS: ".$history['name'];
  }

  //$createdShipment->makeLabelPrinted();
  $createdShipment->fullfiled();

  dd($createdShipment->history);

} catch (\LogisticaSdk\ApiException $e) {

  die($e->getMessage());

} catch (\Exception $e) {
  die($e->getMessage());
}
