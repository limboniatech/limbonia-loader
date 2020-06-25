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
trait HasType
{
  /**
   * Return the sub-class type of this class
   *
   * @return string
   */
  public static function type()
  {
    if (__CLASS__ == static::class)
    {
      return '';
    }

    return preg_replace("#^.*\\\#", "", static::class);
  }

  /**
   * Return the full class type of this class
   *
   * @return string
   */
  public static function classType()
  {
    return preg_replace("#Limbonia\\\\#", '', __CLASS__);
  }

  /**
   * Get the subclass type for this object
   *
   * @return string
   */
  public function getType()
  {
    return static::type();
  }
}
