<?php
namespace Core;

class DB_stmt {

  public function attribut($fields) {
    if ($fields !== null) {
      foreach ($fields as $field => $value) {
        $attributes[':'.$field] = $value;
      }
      return $attributes;
    }
  }

  public function stmt($action, $row, $table = null){
    $stmt = $action." ";
    $count = count($row);
    if (isset($row)) {
      foreach ($row as $r) {
        $stmt .= $r;
        $count--;
        if ($count > 0 AND $r != '*' AND $r != 'COUNT(*)')
        $stmt .= ", ";
      }
    }
    if (isset($table)) {
      if (is_array($table)) {
        $stmt .= " FROM `" . $table[0] ."` ";
      } else {
        $stmt .= " FROM `" . $table ."` ";
      }
    }
    return $stmt;
  }

  public function order_by($order) {
    $stmt = 'ORDER BY ';
    foreach ($order as $k => $v)
    {
      $stmt .= $k.' '.$v.' ';
    }
      return $stmt;
  }

  public function into_values($fields) {
    $stmt = " (";
    $count = count($fields);
    foreach ($fields as $field => $value) {
      $stmt .= "`".$field."`";
      $count--;
      if ($count > 0)
      $stmt .= ", ";
    }
    $stmt .= ") VALUES (";
    $count = count($fields);
    foreach ($fields as $field => $value) {
      $stmt .= ":".$field;
      $count--;
      if ($count > 0)
      $stmt .= ", ";
    }
    $stmt .= ")";
    return $stmt;
  }

  public function from_where($action, $fields){
    $count = count($fields);
    if ($action === "SELECT" || $action === "DELETE")
      $stmt = " WHERE ";
    if ($action === "UPDATE")
      $stmt = " SET ";
      if (isset($fields)) {
        foreach ($fields as $field => $value) {
              $stmt .= "`". $field ."` = :" . $field ;
          $count--;
          if ($count > 0) {
            if ($action === "SELECT" || $action === "DELETE")
              $stmt .= " AND ";
            if ($action === "UPDATE")
              $stmt .= ", ";
            }
          }
        }
        if ($action === "UPDATE") {
          $stmt .= " WHERE ";
          $stmt .= "`" . key($fields) . "` like :" . key($fields);
        }
        $stmt .= " ";
        return $stmt;
    }

}
