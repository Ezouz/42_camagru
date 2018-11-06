<?php
namespace Core;
use PDO;
use \Config\config;

class DB {

    private $DB_DRIVER;
    private $DB_NAME;
    private $DB_USER;
    private $DB_PASS;
    private $DB_HOST;
    private $DB_DNS;
    private static $_pdo;

    public function __construct (Config $settings) {
      $this->DB_DRIVER = $settings->get("driver");
      $this->DB_HOST = $settings->get("host");
      $this->DB_USER = $settings->get("username");
      $this->DB_PASS = $settings->get("password");
      $this->DB_NAME = $settings->get("dbname");
      $this->DB_DNS = $settings->get("dns"). ";dbname=" .
                          $this->DB_NAME. ";charset=utf8mb4;";
    }

    private function getPDO() {
      if  (self::$_pdo === null) {
        $pdo = new PDO($this->DB_DNS,
        $this->DB_USER,
        $this->DB_PASS
      );
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      self::$_pdo = $pdo;
    }
    return (self::$_pdo);
  }

  public function operate($stmt, $attributes, $one = false) {
    self::getPDO();
    $req = self::$_pdo->prepare($stmt);
    $res = $req->execute($attributes);
    if (strpos($stmt, 'UPDATE') === 0 || strpos($stmt, 'INSERT') === 0 ||
    strpos($stmt, 'DELETE') === 0) {
      return $res;
    }
    $req->setFetchMode(PDO::FETCH_OBJ);
    if ($one)
    $datas = $req->fetch();
    else
    $datas = $req->fetchAll();
    return $datas;
  }

}
