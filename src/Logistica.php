<?php


namespace LogisticaSdk;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class Logistica
{
  const API = 'https://logistics-api.intrasistema.com/v1/';
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

  public function getDrivers()
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


}