<?php
include '../../vendor/autoload.php';

$sdk = new \LogisticaSdk\Logistica();

$sdk->setToken("666");

try {

#$user = $sdk->me();
#print "Usuario Logoneado: ".$user->name;


$drivers = $sdk->getDrivers();
foreach ($drivers as $driver)
{
  dd($driver['name']);
}


} catch (\LogisticaSdk\AuthException $e) {
  die("Fallo al autenticar");

} catch (\LogisticaSdk\ApiException $e) {
  die($e->getMessage());

} catch (\Exception $e) {
  die($e->getMessage());
}
