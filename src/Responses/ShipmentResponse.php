<?php

namespace EnviosSDK\Responses;

use EnviosSDK\Logistica;

class ShipmentResponse
{

  private $shipment;
  /**
   * @var Logistica
   */
  private $sdk;

  /**
   * @param $shipment
   */
  public function __construct($shipment,$sdk)
  {
    $this->sdk = $sdk;
    $this->shipment = $shipment;
  }

  public static function createFromRequest($sdk,$post)
  {

      return new self($post,$sdk);
  }


  public function __get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    }else{

      if (isset($this->shipment[$property])){
        return $this->shipment[$property];
      }
    }
  }

  public function getTrackingNumber()
  {
    return $this->tracking;
  }

  public function makeLabelPrinted()
  {
    $this->shipment =  $this->sdk->post("shipment/".$this->_id."/status/201");
  }

  public function fullfiled()
  {
    $this->shipment =  $this->sdk->post("shipment/".$this->_id."/status/202");
  }


}