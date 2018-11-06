<?php
namespace Core;
use \Config\config;
use \Core\DB_service;

class User_model extends DB_service {

  public static $_table = "users";
  public $_msg = "";
  protected $_post;

  public function __construct($posts = null) {
    if ($posts !== null) {
      foreach ($posts as $key => $value) {
        if ($key === "username" || $key === "new_login")
          $key = "login";
        else if ($key === "new_email")
          $key = "email";
        else if ($key === "password" || $key === "new_password")
          $key = "passwd";
        else if ($key === "verify_password" || $key === "confirm_new_password")
          $key = "passwd_v";
        $this->_post[$key] = $this->test_input($value);
      }
    }
  }

  public function select_user($table, $rows, array $fields) {
    return self::select($rows, $table, $fields, true);
  }

  protected function create_user(array $user) {
    unset($user['user_id']);
    unset($user['profil_pic']);
    return self::create($user, array(0 => self::$_table));
  }

  public function update_user(array $user, $table){
    return self::update($user, $table);
  }

  protected function delete_user($user) {
    return self::delete(array(key($user) => $user['user_id']), self::$_table);
  }

  public function send_mail($email, $user, $action) {
    $config = config::getInstance();
    if ($action == "notification") {
      $email['msg'] .= "http://".$config->get('host').":8080/".$config->get('dbname');
      $email['msg'] .= '/index.php?page=show&post='.$user['img_id']."\n";
    } else {
      if ($action == "password_reset")
        $token = $user['token_pwd'];
      if ($action == "activate")
        $token = $user['token_mail'];
      $email['msg'] .= "http://".$config->get('host').":8080/".$config->get('dbname')."/index.php?page=".$action."&login=";
      $email['msg'] .= urlencode($user['login'])."&token=".urlencode($token)."\n";
    }
    $email['msg'] .= "---------------\n".'This is an automatic email, thanks to not answer.';
    if (!(mail($user['email'], $email['object'], $email['msg'], $email['header']))) {
      return "An error occured while sending email";
    }
    return true;
  }

  public function send_msg() {
    return $this->_msg;
  }

  public function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  public function check_user_login($login) {
    if (!preg_match("#^[_a-zA-Z0-9-]{3,50}+$#", $login)) {
      $this->_msg =
      "Your login must comport only letters, numbers, underscore or dash";
      $this->_msg .= " and be 50 characters maximum";
      return false;
    }
    return true;
  }

  public function check_user_email($email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->_msg = "Invalid email format";
      return false;
    } else if (strlen($email) > 50) {
      $this->_msg = "Email address too long";
      return false;
    }
    return true;
  }

  public function check_passwd($passwd, $passwd_v) {
    if (strcmp($passwd, $passwd_v) !== 0) {
      $this->_msg = "passwords don't matches";
      return false;
    }
    return true;
  }

  public function check_user_passwd($passwd) {
    if (!preg_match("#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,50}$#", $passwd)) {
      $this->_msg = "Passwords not secure enough. You need at least capital
      letters, lower ones and digits. No signs";
      return false;
    }
    return true;
  }

}
