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
  $drivers = $sdk->getDrivers();
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
