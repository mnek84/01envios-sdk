<?php


namespace LogisticaSdk;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Logistica
{
  const API = 'https://logistics-api.intrasistema.com/v1/';
  #const API = 'http://logistics.local/v1/';

  private $token;

  private function getClient()
  {
    $handler = HandlerStack::create();

    $extraParams = [
      'token'=>$this->token
    ];

    $handler->push(Middleware::mapRequest(function (RequestInterface $request) use ($extraParams) {

      $uri  = $request->getUri();
      $url = parse_url($request->getUri());

      if (isset($url['query']))
      {
        $uri = $uri."&token=".$extraParams['token'];
      }else{
        $uri = $uri."?token=".$extraParams['token'];
      }



      return new Request(
        $request->getMethod(),
        $uri,
        $request->getHeaders(),
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

    if ($response->getStatusCode()==200)
    {
      if (!isset($data['status']))
      {
        //BAD RESPONSE
        var_dump($body);
        throw new ApiException("Bad Response");
      }

      if ($data['status']==1)
      {
        if (isset($data['data']))
        {
          return $data['data'];
        }else{
          return true;
        }

      }else{
        throw new ApiException($data['error']);
      }
    }else{
      throw new ApiException($data['error']);
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


}