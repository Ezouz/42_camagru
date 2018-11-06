<?php
namespace Core;
use \Core\DB_service;

class Post_model extends DB_service {

  public static $_table = "posts";
  public $_msg = "";
  protected $_post;

  public function __construct($posts = null) {
    if ($posts) {
      foreach ($posts as $key => $value) {
        if ($key === 'title')
        $key = "img_title";
        if ($key === 'description')
        $key = "img_desc";
        $this->_post[$key] = $this->test_input($value);
      }
    }
  }

  public function get_posts($stmt, $attributes) {
    return self::select_slice($stmt, $attributes, false);
  }

  public function display_post($posts) {
    if ($posts) {
      if (is_array($posts)) {
        foreach ($posts as $n => $object) {
          $i = get_object_vars($object);
          $post[$i['img_id']] = new \Core\Post($object);
        }
        return $post;
      } else {
        $post = new \Core\Post($posts);
        return $post;
      }
    }
    return NULL;
  }

  public function count_post($stmt, $attributes) {
    return self::count($stmt, $attributes, true);
  }

public function update_post($table){
    return self::update($this->_post, array(0 => $table));
  }

  public function last_insert_id($table, $object, $field = null){
    $that = array (array(0 => 'MAX('.$object.')'));
    if ($field === null)
      $obj = get_object_vars(self::select($that, $table, $this->_post, true));
    else
      $obj = get_object_vars(self::select($that, $table, $field, true));
    return $obj["MAX(img_id)"];
  }

  public function select_post($rows, $table, $one) {
    return self::select($rows, $table, $this->_post, $one);
  }

  public function create_post($table) {
    return self::create($this->_post, array(0 => $table));
  }

  public function delete_post($table) {
    return self::delete($this->_post, $table);
  }

  public function notify($info, $action) {
    $new = new \Core\User_model($info);
    $table = array("posts");
    $rows = array(0 => array("user_id"));
    $fields = array("img_id" => $info['img_id']);
    $user = get_object_vars($new->select_user($table, $rows, $fields));
    $table = array("users");
    $rows = array(array(0 => '*'));
    $fields = array("user_id" => $user['user_id']);
    $u = $new->select_user($table, $rows, $fields);
    if (is_object($u)) {
      $user = get_object_vars($u);
      if ($user['notif'] === "1" && $user['email'] !== $_SESSION['email']) {
        $user['img_id'] = $info['img_id'];
        return $new->send_mail(
              self::notification_mail($action), $user, 'notification');
      }
    }
    return false;
  }

  public function notification_mail($action) {
    $email['object'] = "New notification !" ;
    $email['header'] = "From: notification@camagru.com" ;
    $email['msg'] = "Hello,\n";
    $email['msg'] .= $_SESSION['login'] ." ". $action . " your post !";
    $email['msg'] .= "Click on the following link to see it:\n";
    return ($email);
  }

  public function send_msg() {
    return $this->_msg;
  }

  public function check_comm() {
    if (strlen($this->_post['comment']) > 200)
      $this->_msg = "Your comment must content maximum 200 caracters";
    else
      return true;
  }

  public function check_desc() {
    if (strlen($this->_post['img_desc']) > 200)
      $this->_msg = "Your description must content maximum 200 caracters";
    else if (strlen($this->_post['img_title']) > 50)
      $this->_msg = "Your title must content maximum 50 caracters";
    else
      return true;
  }

  public function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

}
