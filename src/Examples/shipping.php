<?php
include '../../vendor/autoload.php';

$sdk = new \EnviosSDK\Logistica();

$sdk->setToken("2835754040");

try {

  $shipping = $sdk->get("shipping",['iqr'=>true,'shipping'=>"40559180982"]);
  $tracking = $shipping['tracking_number'];
  $info = $sdk->put("shipments/".$tracking,['status'=>10,'client_id'=>0,'comment'=>'']);
  die("cambiado correctamente");

} catch (\EnviosSDK\ApiException $e) {
  die($e->getMessage());

} catch (\Exception $e) {
  die($e->getMessage());
}
