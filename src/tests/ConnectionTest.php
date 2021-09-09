<?php

namespace LogisticaSdk\tests;

use LogisticaSdk\Logistica;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{

  public function testConnection()
  {
    $sdk = new Logistica();
    $sdk->setToken("1234");
    $this->assertSame("1234",$sdk->getToken());
  }

}