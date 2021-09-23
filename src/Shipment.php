<?php

namespace EnviosSDK;

use LogisticaSdk\Responses\ShipmentResponse;

class Shipment
{
  private $bulks;
  private $sdk;
  private $shipment;

  /**
   * @param Logistica $sdk
   */
  public function __construct(Logistica $sdk)
  {
    $this->sdk = $sdk;
  }


  /**
   * @param string $service_type_id
   */
  public function setServiceTypeId(string $service_type_id): Shipment
  {
    $this->shipment['service_type_id'] = $service_type_id;
    return $this;
  }


  /**
   * @param string $owner_fullname
   */
  public function setOwnerFullname(string $owner_fullname): Shipment
  {
    $this->shipment['owner_fullname'] = $owner_fullname;
    return $this;
  }

  /**
   * @param string $auth_fullname
   */
  public function setAuthFullname(string $auth_fullname): Shipment
  {
    $this->shipment['auth_fullname'] = $auth_fullname;
    return $this;
  }


  /**
   * @param string $logistic_type_id
   */
  public function setLogisticTypeId(string $logistic_type_id): Shipment
  {
    $this->shipment['logistic_type_id'] = $logistic_type_id;
    return $this;
  }

  /**
   * @param string $email
   */
  public function setEmail(string $email): Shipment
  {
    $this->shipment['email'] = $email;
    return $this;
  }


  /**
   * @param string $address_type
   * @return Shipment
   */
  public function setAddressType($address_type): Shipment
  {
    $this->shipment['address_type'] = $address_type;
    return $this;
  }


  /**
   * @param string $delivery_time
   * @return Shipment
   */
  public function setDeliveryTime(string $delivery_time): Shipment
  {
    $this->shipment['delivery_time'] = $delivery_time;
    return $this;
  }


  /**
   * @param string $address
   * @return Shipment
   */
  public function setAddress(string $address): Shipment
  {
    $this->shipment['address'] = $address;
    return $this;
  }

  /**
   * @param $address_comments
   * @return Shipment
   */
  public function setAddressComments($address_comments): Shipment
  {
    if (!$address_comments)
      $address_comments = "";
    $this->shipment['address_comments'] = $address_comments;
    return $this;
  }


  /**
   * @param $locality
   * @return Shipment
   */
  public function setLocality($locality): Shipment
  {
    if(!$locality)
      $locality="";
    $this->shipment['locality'] = $locality;
    return $this;
  }


  /**
   * @param $province
   * @return Shipment
   */
  public function setProvince($province): Shipment
  {
    if (!$province)
      $province = "";
    $this->shipment['province'] = $province;
    return $this;
  }

  /**
   * @param $country
   * @return Shipment
   */
  public function setCountry($country): Shipment
  {
    if (!$country)
      $country = "";
    $this->shipment['country'] = $country;
    return $this;
  }


  /**
   * @param $zipcode
   * @return Shipment
   */
  public function setZipcode($zipcode): Shipment
  {
    if (!$zipcode)
      $zipcode = "";

    $this->shipment['zipcode'] = $zipcode;
    return $this;
  }


  /**
   * @param $latitude
   * @param $longitude
   * @return Shipment
   */
  public function setCoords($latitude,$longitude): Shipment
  {

    $this->shipment['coords'] = [
      'lat'=>floatval($latitude),
      'lng'=>floatval($longitude)
    ];

    return $this;
  }


  /**
   * @param $phone
   * @return Shipment
   */
  public function setPhone($phone): Shipment
  {
    if (!$phone)
      $phone = "";
    $this->shipment['phone'] = $phone;
    return $this;
  }

  /**
   * @param integer $total_bulk
   * @return Shipment
   */
  public function setTotalBulk(int $total_bulk): Shipment
  {
    $this->shipment['total_bulk'] = $total_bulk;

    return $this;
  }


  /**
   * @param int $tall
   * @param int $width
   * @param int $height
   * @param int $weight
   * @return Shipment
   */
  public function addBulk(int $tall,$width,$height,$weight): Shipment
  {
    $this->bulks[] = [
      'tall'=>$tall,
      'width'=>$width,
      'height'=>$height,
      'weight'=>$weight
    ];
    return $this;
  }

  /**
   * @param string $warehouse_origin_id
   * @return Shipment
   */
  public function setWarehouseOriginId(string $warehouse_origin_id): Shipment
  {
    $this->shipment['warehouse_origin_id'] = $warehouse_origin_id;
    return $this;
  }

  /**
   * @param bool $is_collect
   * @return Shipment
   */
  public function setIsCollect(bool $is_collect): Shipment
  {
    $this->shipment['is_collect'] = $is_collect;
    return $this;
  }

  /**
   * @param string $external_type
   * @return Shipment
   */
  public function setExternalReference(string $type,string $value): Shipment
  {
    $this->shipment['external_type'] = $type;
    $this->shipment['external_value'] = $value;
    return $this;
  }


  /**
   * @return ShipmentResponse
   * @throws \Exception
   */
  public function create()
  {

    $this->shipment['bulk'] = $this->bulks;
    $this->setTotalBulk(sizeof($this->bulks));


    return $this->sdk->createShipment($this->shipment);
  }

  /**
   * @return Shipment
   */
  public function getShipment(): Shipment
  {
    return $this->shipment;
  }
}