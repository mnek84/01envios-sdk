<?php
include '../../vendor/autoload.php';

$sdk = new \EnviosSDK\Logistica();

$sdk->setToken("2835754040");

try {

  $tracking = 114626706437;
  // Información de un Tracking
  $info = $sdk->get("shipping",['shipping'=>'114626706437','history'=>1,'order'=>'LATEST']);


  print $info['owner_fullname'];

  var_dump($info['history']);

} catch (\EnviosSDK\ApiException $e) {
  die($e->getMessage());

} catch (\Exception $e) {
  die($e->getMessage());
}
