<?php
use \PHPUnit\Framework\TestCase;

class DriverListTest extends TestCase
{
  protected $aExpectedDriverList =
  [
    'bar' => 'Bar',
    'baz' => 'Baz'
  ];

  public function testDriverList()
  {
    $this->assertEquals($this->aExpectedDriverList, \Limbonia\Foo::driverList());
  }

  public function testClassType()
  {
    $this->assertEquals('Foo', \Limbonia\Foo::classType());
  }

  protected function generateType()
  {
    $aDriverKeys = array_keys($this->aExpectedDriverList);
    $iRandomKey = array_rand($aDriverKeys);
    return $aDriverKeys[$iRandomKey];
  }

  public function testGetType()
  {
    $oFoo = new \Limbonia\Foo\Bar;

    $this->assertEquals('Bar', $oFoo->getType());
  }

  public function testFactory()
  {
    $sType = $this->generateType();
    $oFoo = \Limbonia\Foo::driverFactory($sType);
    $this->assertEquals($this->aExpectedDriverList[$sType], $oFoo->getType());
  }

  public function testDriverName()
  {
    $sType = $this->generateType();
    $this->assertEquals($this->aExpectedDriverList[$sType], \Limbonia\Foo::driver($sType));
  }

  public function testDriverClass()
  {
    $sType = $this->generateType();
    $this->assertEquals('Limbonia\\Foo\\' . $this->aExpectedDriverList[$sType] , \Limbonia\Foo::driverClass($sType));
  }
}