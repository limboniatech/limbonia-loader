<?php
namespace Limbonia\Traits;

/**
 * Limbonia DriverList Trait
 *
 * This trait allows an inheriting class to add a driver list to help with the
 * implementation of a factory method in the receiving class.
 *
 * @author Lonnie Blansett <lonnie@limbonia.tech>
 * @package Limbonia-Loader
 */
trait DriverList
{
  use \Limbonia\Traits\HasType;
  protected static $hDriverList = [];

  /**
   * Generate and return an object of the specified type with specified parameters
   *
   * @param string $sType - the type of object to create
   * @param array $aParam - array of parameters to initialize the
   * @return self
   * @throws \Exception
   */
  public static function driverFactory(string $sType, ...$aParam)
  {
    if (empty($sType))
    {
      throw new \Exception("Driver for " . static::classType() . " not specified!");
    }

    $sTypeClass = static::driverClass($sType);

    if (!class_exists($sTypeClass, true))
    {
      throw new \Exception("Driver for " . static::classType() . " ($sType) not found!");
    }

    return new $sTypeClass(...$aParam);
  }

  /**
   * Generate and return the class name for the specified type returning an empty string if none is found
   *
   * @param string $sType
   * @return string
   */
  public static function driverClass($sType): string
  {
    $sDriver = static::driver($sType);
    return empty($sDriver) ? '' : static::class . "\\" . $sDriver;
  }

  /**
   * Generate and cache the driver list for the current object type
   *
   * @return array
   */
  public static function driverList(): array
  {
    if (empty(static::$hDriverList))
    {
      if (class_exists('\Limbonia\SessionManager') && \Limbonia\SessionManager::isStarted() && isset($_SESSION['DriverList'][__CLASS__]))
      {
        static::$hDriverList = $_SESSION['DriverList'][__CLASS__];
      }
      else
      {
        static::$hDriverList = [];
        $sClassDir = preg_replace("#\\\#", '/', self::classType());

        foreach (\Limbonia\Loader::getLibs() as $sLib)
        {
          foreach (glob("$sLib/$sClassDir/*.php") as $sClassFile)
          {
            $sDriverName = basename($sClassFile, ".php");

            if (isset(static::$hDriverList[strtolower($sDriverName)]))
            {
              continue;
            }

            include_once $sClassFile;

            $sClassName = __CLASS__ . "\\" . $sDriverName;

            if (!class_exists($sClassName, false))
            {
              continue;
            }

            if (__CLASS__ . '\\' . $sDriverName != $sClassName)
            {
              continue;
            }

            static::$hDriverList[strtolower($sDriverName)] = $sDriverName;
          }
        }

        ksort(static::$hDriverList);
        reset(static::$hDriverList);

        if (class_exists('\Limbonia\SessionManager') && \Limbonia\SessionManager::isStarted())
        {
          $_SESSION['DriverList'][__CLASS__] = static::$hDriverList;
        }
      }
    }

    return static::$hDriverList;
  }

  /**
   *  Return the driver name for the specified name, if there is one
   *
   * @param string $sName
   * @return string
   */
  public static function driver(string $sName): string
  {
    $hDriverList = self::driverList();
    return $hDriverList[strtolower($sName)] ?? '';
  }
}
