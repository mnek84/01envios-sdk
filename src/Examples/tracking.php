<?php
include '../../vendor/autoload.php';

$sdk = new \EnviosSDK\Logistica();

$sdk->setToken("666");

try {

#$user = $sdk->me();
#print "Usuario Logoneado: ".$user->name;


$drivers = $sdk->getDrivers();
foreach ($drivers as $driver)
{
  dd($driver['name']);
}


} catch (\EnviosSDK\AuthException $e) {
  die("Fallo al autenticar");

} catch (\EnviosSDK\ApiException $e) {
  die($e->getMessage());

} catch (\Exception $e) {
  die($e->getMessage());
}
