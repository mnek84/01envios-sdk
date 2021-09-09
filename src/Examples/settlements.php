<?php
include '../../vendor/autoload.php';

$sdk = new \LogisticaSdk\Logistica();

$sdk->setToken("2835754040");

try {

  $tracking = 114626706437;
  // Información de un Tracking
  $info = $sdk->get("driver/settlements",[
    'from'=>'2021-05-12',
    'to'=>'2021-05-13',
    'zones'=>'0',
    'driver'=>'21',
    'status'=>[1,2,3]
  ]);



  $info = $sdk->put("shipments/288741353957",[
    "client_id"=> 2,
    "status"=>18,
    "comment"=>"Prueba de cambio!"
  ]);




  var_dump($info['history']);

} catch (\LogisticaSdk\ApiException $e) {
  die($e->getMessage());

} catch (\Exception $e) {
  die($e->getMessage());
}
