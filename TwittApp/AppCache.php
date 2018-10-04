<?php
namespace TwittApp;

use Memcached;

class AppCache
{
  private static $_instance = null;

//private static MC_PORT = 11211;
//private static MC_SERVER = 'localhost';

  private function __construct () {
    $this->_instance = new Memcached();
    $this->_instance->addServer('localhost', 11211);
  }

  private function __clone () {}
  private function __wakeup () {}

  public static function getInstance()
  {
    if (static::$_instance != null) {
      return static::$_instance;
    }

    return new static;
  }
}
