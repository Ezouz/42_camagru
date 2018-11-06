<?php
namespace Core;
use \Config\config;

class DB_service {

  private static $_db;
  private static $_instance;

  private function getInstance(){
    if (self::$_instance === null){
      self::$_instance = new DB_service();
    }
    return self::$_instances;
  }

  private function getDB(){
    if (self::$_db === null){
      self::$_db = new DB(config::getInstance());
    }
    return self::$_db;
  }

  protected function count($stmt, $fields, $one) {
    try {
      self::getDB();
      $attributes = DB_stmt::attribut($fields);
      return self::$_db->operate($stmt, $attributes, $one);
    } catch(PDOException $e) {
      die('Error : Could not count the number of posts - ' . $e->getMessage());
    }
  }

  protected function select_slice($stmt, $fields, $one = false) {
    try {
      self::getDB();
      $attributes = DB_stmt::attribut($fields);
      return self::$_db->operate($stmt, $attributes, $one);
      } catch(PDOException $e) {
      die('Error : Could not get slices of posts - ' . $e->getMessage());
    }
  }

  protected function select(array $rows, $table, $fields, $one) {
    try {
      self::getDB();
      $attributes = DB_stmt::attribut($fields);
      $stmt = DB_stmt::stmt("SELECT", $rows[0], $table);
        $stmt .= DB_stmt::from_where("SELECT", $fields);
        if (isset($rows[1]))
          foreach ($rows[1] as $k => $v)
            $stmt .= $k.' '.$v.' ';
          if (isset($rows[2]))
            $stmt .= DB_stmt::order_by(array_slice($rows[2], 1, count($rows[2]) - 1, true));
          $stmt .= ';';
          return self::$_db->operate($stmt, $attributes, $one);
      } catch(PDOException $e) {
        die('Error : Could not select user - ' . $e->getMessage());
    }
  }

  protected function create(array $obj, array $table) {
    try {
      self::getDB();
      $stmt = DB_stmt::stmt("INSERT INTO", $table);
      $stmt .= DB_stmt::into_values($obj);
      $attributes = DB_stmt::attribut($obj);
      return self::$_db->operate($stmt, $attributes);
    } catch(PDOException $e) {
      die('Error : Could not select user - ' . $e->getMessage());
    }
  }

  protected function update(array $fields, $table){
    try {
      self::getDB();
      $stmt = DB_stmt::stmt("UPDATE", $table);
      $stmt .= DB_stmt::from_where("UPDATE", $fields);
      $attributes = DB_stmt::attribut($fields);
      return self::$_db->operate($stmt, $attributes);
    } catch(PDOException $e) {
      die('Error : Could not update user - ' . $e->getMessage());
    }
  }

  protected function delete(array $obj, $table) {
    try {
      self::getDB();
      $stmt = DB_stmt::stmt("DELETE", null, $table);
      $stmt .= DB_stmt::from_where("DELETE", $obj);
      $stmt .= ';';
      $attributes = DB_stmt::attribut($obj);
      return self::$_db->operate($stmt, $attributes);
    } catch(PDOException $e) {
     die('Error : Could not delete user - ' . $e->getMessage());
   }
  }

}
