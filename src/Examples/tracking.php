<?php
include '../../vendor/autoload.php';

$sdk = new \LogisticaSdk\Logistica();

$sdk->setToken("2835754040");

try {

  $tracking = null; // Busqueda
  $driver = [1,15]; // 1 ó [1,3]
  $statuses = null; // 1 ó [1,3]
  $limit = 10; //Null para que no pagine
  $page = 1;

  $data = $sdk->getShippingList(
      $tracking,
      $driver,
      $statuses,
      null,
      null,
      $limit,
      $page,
    null

  );

  //Información de Páginacion
  // $data['current_page'] = Pagina Actual
  // $data['per_page'] = Cantidad COnfigurada en Limit
  // $data['from'] = Pagina
  // $data['to'] = pagina
  // $data['last_page'] = Ultima Página
  // $data['links'] = Links de pagina | Solo si es Paginador Manual
  // $data['total'] = Total De Elementos

  //$data['data'] = Array de Elementos

  if ($limit)
  {
    var_dump($data['data']);

  }else{

    var_dump($data);

  }



} catch (\LogisticaSdk\ApiException $e) {
  die($e->getMessage());

} catch (\Exception $e) {
  die($e->getMessage());
}