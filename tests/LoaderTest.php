<?php
use PHPUnit\Framework\TestCase;

class LoaderTest extends TestCase
{
  public function testGetLibs()
  {
    $aLibs = \Limbonia\Loader::getLibs();

    //to start with there should only be one lib
    $this->assertCount(1, $aLibs);

    //make sure the lib dir we get is what we exepect
    $this->assertEquals(preg_replace("#tests#", 'lib', __DIR__), $aLibs[0]);
  }

  public function testAddLib()
  {
    \Limbonia\Loader::addLib(__DIR__ . '/lib');

    $aLibs = \Limbonia\Loader::getLibs();

    //to start with there should be two libs
    $this->assertCount(2, $aLibs);

    //make sure the new lib dir we get is what we exepect
    $this->assertEquals(__DIR__ . '/lib', $aLibs[0]);

    //make sure the old lib dir we get is still what we exepect
    $this->assertEquals(preg_replace("#tests#", 'lib', __DIR__), $aLibs[1]);
  }

  public function testPreAutoloadError()
  {
    $this->expectErrorMessage("Class 'Limbonia\Foo' not found");

    //this should fail with an error since the autoloader hasn't been registered yet...
    $oFoo = new \Limbonia\Foo;
  }

  public function testAutoload()
  {
    \Limbonia\Loader::registerAutoloader();

    //this should work
    $oFoo = new \Limbonia\Foo;

    //make sure the object we got is of the expected class
    $this->assertEquals(\Limbonia\Foo::class, get_class($oFoo));
  }
}