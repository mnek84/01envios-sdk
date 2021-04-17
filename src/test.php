<?php

include '../vendor/autoload.php';

$sdk = new \LogisticaSdk\Logistica();

$sdk->setToken("abc123");

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
  dd($e->getMessage());
}



