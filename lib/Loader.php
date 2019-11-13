<?php
namespace Limbonia;

/**
 * Limbonia Loader Class
 *
 * @author Lonnie Blansett <lonnie@limbonia.tech>
 * @package Limbonia-Loader
 */
class Loader
{
  /**
   * List of Limbonia lib directories
   *
   * @var array
   */
  protected static $aLibList = [__DIR__];

  /**
   * List of Limbonia lib directories
   *
   * @var array
   */
  protected static $aViewDir = [];

  /**
   * PSR-4 compatible autoload method
   *
   * @param string $sClassName
   */
  public static function autoload($sClassName)
  {
    $sClassType = preg_match("#^" . __NAMESPACE__ . "\\\?(.+)#", $sClassName, $aMatch) ? $aMatch[1] : $sClassName;
    $sClassPath = preg_replace("#[_\\\]#", DIRECTORY_SEPARATOR, $sClassType);

    foreach (self::getLibs() as $sLibDir)
    {
      $sClassFile = $sLibDir . DIRECTORY_SEPARATOR . $sClassPath . '.php';

      if (is_file($sClassFile))
      {
        require $sClassFile;
        break;
      }
    }
  }

  /**
   * Register the PSR-4 autoloader
   */
  public static function registerAutoloader()
  {
    spl_autoload_register([__CLASS__ , 'autoload'], false);
  }

  /**
   * Add a new Limbonia library to the current list
   *
   * @param string $sLibDir - The root directory to the Limbonia library to add
   */
  public static function addLib($sLibDir)
  {
    if (is_dir($sLibDir) && !in_array($sLibDir, self::$aLibList))
    {
      array_unshift(self::$aLibList, $sLibDir);

      if (is_dir("$sLibDir/View"))
      {
        array_unshift(self::$aViewDir, "$sLibDir/View");
      }
    }
  }

  /**
   * Return the list of Limbonia libraries
   *
   * @return array
   */
  public static function getLibs()
  {
    return self::$aLibList;
  }

  /**
   * Return the list of view directories
   *
   * @return string
   */
  public static function viewDirs()
  {
    return self::$aViewDir;
  }
}