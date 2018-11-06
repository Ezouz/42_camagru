<?php
namespace Config;

class config {

  private $_settings = [];
  private $_db;
  private static $_instance;

  public function __construct() {
      $this->_settings = require dirname(__DIR__) . '/config/database.php';
  }

  public static function getInstance() {
    if (is_null(self::$_instance)) {
      self::$_instance = new Config();
    }
    return self::$_instance;
  }

  public function get($key) {
    if (!isset($this->_settings[$key])) {
      return null;
    }
    return $this->_settings[$key];
  }

  public function set_db() {
    require_once 'db_initializer.php';
    $database = new db_initializer(self::$_instance);
  }
}
