<?php

include '../vendor/autoload.php';

$sdk = new \EnviosSDK\Logistica();

$sdk->setToken("2835754040");

try {
  $shipmentHistory = $sdk->traceShipment(34794766800);

  if ($shipmentHistory)
  {
    foreach($shipmentHistory as $info)
    {
      echo "Status:".$info['status']." - ".( ($info['status_info'])?$info['status_info']['name']:'Unknown' ).chr(13).chr(10);
    }
  }
} catch (\LogisticaSdk\ApiException $e) {
  die($e->getMessage());

} catch (\Exception $e) {
  die($e->getMessage());
}




