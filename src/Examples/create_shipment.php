<?php
include '../../vendor/autoload.php';

$sdk = new RimoldSDK\Logistica();

$sdk->setToken("666");

try {

  $shipment = new \RimoldSDK\Shipment($sdk);

  $shipment->addBulk(1, 1, 1, 1);

  $shipment
    ->setCountry("ARGENTINA")
    ->setProvince("BUENOS AIRES")
    ->setLocality("SAN ANTONIO DE PADUA")
    ->setAddressType("RESIDENTIAL")
    ->setAddress("GAONA 1584")
    ->setAddressComments("PAREDON NEGRO")
    ->setZipcode("1718")
    ->setCoords("","")
    ->setReceiver("XXX EMMANUELLI")
    ->setReceiverEmail("pepe@pepe.com")
    ->setReceiverMobile("")
    ->setExternalReference(\RimoldSDK\Shipment::EXTERNAL_TYPE_ML,"1234")
    ->setIsCollect(1)
    ->setLogisticTypeId(1)
    ->setServiceTypeId(1);

   $createdShipment = $shipment
     ->create();


   print "Tracking Number: ".($createdShipment->getTrackingNumber());

   dd($createdShipment);

} catch (\RimoldSDK\ValidationFailedException $e) {

  foreach($e->getErrorBag() as $error)
  {
      print $error[0].chr(13).chr(10);
  }

} catch (\RimoldSDK\ApiException $e) {

  die($e->getMessage());

} catch (\Exception $e) {
  die($e->getMessage());
}
