# Logistica SDK

[![Latest Stable Version](https://img.shields.io/packagist/v/intrasistema/logsdk.svg?style=flat-square)](https://packagist.org/packages/intrasistema/logsdk)
[![Total Downloads](https://img.shields.io/packagist/dt/intrasistema/logsdk.svg?style=flat-square)](https://packagist.org/packages/intrasistema/logsdk)

Librareria para la gestión de Logistica de 01envios

```php
<?php

use LogisticaSdk\Logistica;

$sdk = new Logistica();

$sdk->setToken("abc123");

```

## Instalación

### Composer

```
$ composer require intrasistema/logsdk
```

```json
{
    "require": {
        "intrasistema/logsdk": "dev-master"
    }
}
```


### Lista de Choferes

```php
<?php

$sdk = new \LogisticaSdk\Logistica();

$sdk->setToken("TOKEN");

try {
  $drivers = $sdk->getDrivers("PATENTE,NOMBRE ó CODIGO",1,10);
  if ($drivers)
  {
    foreach($drivers as $driver)
    {
      echo "Driver:#".$driver['fullname'];
    }
  }
} catch (\LogisticaSdk\ApiException $e) {
  die($e->getMessage());
}

```

### Estados Existentes
```php
<?php

$sdk = new \LogisticaSdk\Logistica();

$sdk->setToken("TOKEN");

try {
  $statuses = $sdk->get("shipments/statuses");
  if ($statuses)
  {
    foreach($statuses as $status)
    {
      echo "#".$status['name'];
    }
  }
} catch (\LogisticaSdk\ApiException $e) {
  die($e->getMessage());
}

```


### Shipment By Estado
```php
<?php

$sdk = new \LogisticaSdk\Logistica();

$sdk->setToken("TOKEN");

try {
  $shipments = $sdk->get("shipments/by/701");
  if ($shipments)
  {
    foreach($shipments as $shipment)
    {
      echo "#".$shipment['tracking_number'];
    }
  }
} catch (\LogisticaSdk\ApiException $e) {
  die($e->getMessage());
}

```

### Ejecutar Manal un EP
```php
<?php

$sdk = new \LogisticaSdk\Logistica();
$shipments = $sdk->get("shipments",['param1'=>1])
```


### Listado de Shipments
##### Ver en Examples/tracking.php
```php
<?php
  $tracking = null; // Busca por Numero de Tracking o Control Externo
  $driver = [1,15]; // ID de Chofer ó Array de Choferes
  $statuses = null; // ID De estado o Array de Estados
  $limit = 10; //Cantidad de Datos por pagina, si es NULL no pagina.
  $page = 1; //Que pagina quiero ver
  $orderBY = 'owner_fullname'; #'id','tracking_number','owner_fullname','locality','province','country','zipcode','warehouse_origin_id','current_status','external_value'
  $orderType = 'desc'; #ASC , DESC

  $data = $sdk->getShippingList(
      $tracking,
      $driver,
      $statuses,
      null, //Desde
      null, //Hasta
      $limit,
      $page,
      null,
      $orderBY,
      $orderType
  );

  //Información de Páginacion Si $limit no es null.

  // $data['current_page'] = Pagina Actual
  // $data['per_page'] = Cantidad COnfigurada en Limit
  // $data['from'] = Pagina
  // $data['to'] = pagina
  // $data['last_page'] = Ultima Página
  // $data['links'] = Links de pagina | Solo si es Paginador Manual
  // $data['total'] = Total De Elementos

  //$data['data'] = Array de Elementos
  
  var_dump($data['data']);
```

### Ver un Tracking y Historia
##### Ver en Examples/ver_tracking.php
```php
 $tracking = 114626706437;
  // Información de un Tracking
  $info = $sdk->get("shipping",['shipping'=>'114626706437','history'=>1,'order'=>'LATEST']);
  print $info['owner_fullname'];

  var_dump($info['history']);
```


./vendor/bin/phpunit tests