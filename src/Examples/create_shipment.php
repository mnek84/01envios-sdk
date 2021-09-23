<?php
include '../../vendor/autoload.php';

$sdk = new \EnviosSDK\Logistica();

$sdk->setToken("666");

try {

  $info = [
    "external_type" => "ML",
    "external_value" => "1002",
    "client_id" => 2,
    "country" => "Argentina",
    "province" => "BS AS",
    "locality" => "Padua",
    "address_type" => "RESIDENCIAL",
    "address" => "gaona 1584",
    "zipcode" => 1425,
    "bulk" => [
      [
        "sku_id" => null,
        "weight" => 10000,
        "height" => 20,
        "width" => 20,
        "tall" => 20
      ]
    ],
    "comments" => "",
    "coords_lat" => "-59.23330",
    "coords_lng" => "-59.23400",
    "owner_fullname" => "MAxi",
    "auth_fullname" => "",
    "delivery_time" => "9:00",
    "email" => "mnek84@gmail.com",
    "mobile" => "123",
    "is_collect" => 1,
    "logistic_type" => 1,
    "service_type" => 1,
    "warehouse_origin" => 1
  ];

  $shipment = new \EnviosSDK\Shipment($sdk);

  $shipment->addBulk(1, 1, 1, 1);

  $shipment
    ->setCountry("ARGENTINA")
    ->setProvince("BUENOS AIRES")
    ->setLocality("MERLO")
    ->setAddressType("RESIDENTIAL")
    ->setAddress("GAONA 1584")
    ->setAddressComments("PAREDON NEGRO")
    ->setZipcode("1718")
    ->setCoords("","")
    ->setOwnerFullname("SAMANTA EMMANUELLI")
    ->setAuthFullname("SAMANTA EMMANUELLI")
    ->setDeliveryTime("9 a 18")
    ->setEmail("")
    ->setPhone("")
    ->setExternalReference("meli","1234")
    ->setIsCollect(1)
    ->setLogisticTypeId(1)
    ->setServiceTypeId(1);

   $createdShipment = $shipment->setWarehouseOriginId(1)->create();

   print "Tracking Number: ".($createdShipment->getTrackingNumber());

   foreach($createdShipment->history as $history)
   {
      dd($history);
   }

} catch (\EnviosSDK\ValidationFailedException $e) {
  foreach($e->getErrorBag() as $error)
  {
      print $error[0].chr(13).chr(10);
  }
} catch (\EnviosSDK\ApiException $e) {

  die($e->getMessage());

} catch (\Exception $e) {
  die($e->getMessage());
}
