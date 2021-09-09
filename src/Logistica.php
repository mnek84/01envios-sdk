<?php

namespace LogisticaSdk;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use LogisticaSdk\Responses\ShipmentResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Tightenco\Collect\Support\Collection;

class Logistica
{
  #const API = 'https://logistics-api.intrasistema.com/v1/';
  const API = 'http://01envios.local/api/';

  private $token;

  private function getClient()
  {
    $handler = HandlerStack::create();

    $extraParams = [
      'Authorization'=>'Bearer '.$this->token
    ];

    $handler->push(Middleware::mapRequest(function (RequestInterface $request) use ($extraParams) {

      $uri  = $request->getUri();
      $headers = $request->getHeaders();
      $headers['Authorization'] = $extraParams['Authorization'];

      return new Request(
        $request->getMethod(),
        $uri,
        $headers,
        $request->getBody(),
        $request->getProtocolVersion()
      );
    }));

    return new Client([
      'base_uri' => self::API,
      'handler' => $handler,
      'exceptions' => false,
    ]);

  }

  private function getResponse(ResponseInterface $response)
  {
    $body = $response->getBody()->getContents();
    $data =  json_decode((string) $body,true);
    //var_dump($data);

    if ($response->getStatusCode()==200)
    {
      if (!isset($data['status']))
      {
        throw new ApiException("Bad Response");
      }

      if ($data['status']==1)
      {
        if (isset($data['data']))
        {


          if (count($data['data']) == count($data['data'], COUNT_RECURSIVE))
          {
            return Collection::make([$data['data']]);
          }else{
            return Collection::make($data['data']);
          }

        }else{
          return true;
        }
      }else{
        if ($data['error']=="VALIDATION_FAILED")
        {
          throw new ValidationFailedException($data['error'],$data['errors']);
        }else{
          throw new ApiException($data['error']);
        }
      }
    }else{
      if ($response->getStatusCode()==401)
      {

        throw new AuthException($data['error']);

      }else{
        throw new ApiException($data['error']);
      }

    }
  }

  /**
   * @param $search
   * @param $page
   * @param $perPage
   * @return false|mixed
   * @throws ApiException
   */
  public function getDrivers($search=null,$page=null,$perPage=null)
  {
    $params = [];
    if ($search)
      $params['search'] =  $search;

    if ($page)
    {
      $params['page'] = $page;
      $params['limit'] = ($perPage)?$perPage:10;
    }

    return $this->get("driver",$params);
  }

  public function findShipping($trackingNumber)
  {
    $client = $this->getClient();

    $response = $client->get('driver', [
      'debug' => FALSE,
      'headers' => [
        'Content-Type' => 'application/x-www-form-urlencoded',
      ]
    ]);

    if ($response->getStatusCode()==200)
    {
      $body = $response->getBody();
      $data =  json_decode((string) $body,true);
      if ($data['status']==1)
      {
        return $data['data'];
      }else{
        throw new ApiException($data['error']);
      }

    }else{
      return false;
    }
  }

  public function setToken(string $string)
  {
    $this->token = $string;
  }


  /**
   * @param $tracking
   * @return mixed
   * @throws ApiException
   */
  public function traceShipment($tracking)
  {
    $client = $this->getClient();

    $response = $client->get('shipments/'.$tracking.'/history', [
      'debug' => FALSE,
      'headers' => [
        'Content-Type' => 'application/x-www-form-urlencoded',
      ]
    ]);

    return $this->getResponse($response);
  }


  /**
   * @param $ep
   * @param null $params
   * @return mixed
   * @throws ApiException
   */
  public function get($ep,$params=null)
  {
    $client = $this->getClient();

    $defaultData = [
      'debug' => FALSE,
      'headers' => [
        'Content-Type' => 'application/x-www-form-urlencoded',
      ]
    ];

    if ($params)
      $defaultData['query'] = $params;

    $response = $client->get($ep, $defaultData);

    return $this->getResponse($response);
  }

  /**
   * @param $ep
   * @param null $params
   * @return mixed
   * @throws ApiException
   */
  public function post($ep,$params=null)
  {
    $client = $this->getClient();

    $defaultData = [
      'debug' => FALSE,
      'headers' => [
        'Content-Type' => 'application/x-www-form-urlencoded',
      ]
    ];

    if ($params)
      $defaultData['query'] = $params;

    $response = $client->post($ep, $defaultData);


    return $this->getResponse($response);
  }

  /**
   * @param $ep
   * @param null $params
   * @return mixed
   * @throws ApiException
   */
  public function put($ep,$params=null)
  {
    $client = $this->getClient();

    $defaultData = [
      'debug' => FALSE,
      'headers' => [
        'Content-Type' => 'application/x-www-form-urlencoded',
      ]
    ];

    if ($params)
      $defaultData['query'] = $params;


    $response = $client->put($ep, $defaultData);


    return $this->getResponse($response);
  }

  public function getShippingList($tracking=null, $driver=null, $statuses=null,$from=null,$to=null, $paginated=null, $page=null,$clientId=null,$orderBy="id",$orderType='ASC')
  {
    return $this->get("shipments",[
      'search'=>$tracking,
      'client_id'=>$clientId,
      'driver'=>$driver,
      'statuses'=>$statuses,
      'from'=>$from,
      'to'=>$to,
      'limit'=>$paginated,
      'page'=>$page,
      'orderby'=>$orderBy,
      'ordertype'=>$orderType,
    ]);
  }

  public function getToken()
  {
    return $this->token;
  }

  public function me()
  {
    $userCollection =  $this->get('user');
    return ((object)$userCollection->first());
  }

  /**
   * @param $shipment
   * @return ShipmentResponse
   * @throws ApiException
   */
  public function createShipment($shipment)
  {
    return ShipmentResponse::createFromRequest($this,$this->post("shipment",$shipment));
  }

  /**
   * @param $shipment
   * @return ShipmentResponse
   * @throws ApiException
   */
  public function getShipment($tracking)
  {
    return ShipmentResponse::createFromRequest($this,$this->get("shipment/".$tracking));
  }

}