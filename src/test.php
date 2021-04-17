<?php

include '../vendor/autoload.php';

$sdk = new \LogisticaSdk\Logistica();

$sdk->setToken("2835754040x");

try {
  $drivers = $sdk->getDrivers();
  if ($drivers)
  {

    foreach($drivers as $driver)
    {
      echo "Driver:#".$driver['fullname'];
    }
  }
} catch (\LogisticaSdk\ApiException $e) {
  die($e->getMessage());

} catch (\Exception $e) {
  die($e->getMessage());
}




