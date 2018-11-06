<?php
namespace Model;
use \Core\User_model;

class activate extends User_model {

  public function check_token_mail($login) {
    $u = self::select_user("users", array(array(0 => '*')),
                                    array('login' => $login));
      if (is_object($u)) {
        $user = get_object_vars($u);
      if ($user['status'] == 1)
        $this->_msg = 'Your account was already activated.';
      else {
        if ($user['token_mail'] === $_GET['token'])
          return self::set_user_status($user);
        else
          $this->_msg = "ERROR : Wrong key.";
      }
      return $this->_msg;
    }
  }

  private function set_user_status($user) {
    $user['status'] = 1;
    if (self::update_user($user, array(0 => "users")) === false) {
      $this->_msg = "an error occured while updating user status";
      return false;
    }
    else {
      $this->_msg = "Success now you can sign in";
      $fuser = ROOT . "user/";
      if (!file_exists($fuser)) {
        mkdir($fuser);
        chmod($fuser, 0744);
      }
      $sch = $fuser.$user['login'];
      if (!file_exists($sch)) {
          mkdir($sch);
          chmod($sch, 0744);
      }
      return true;
    }
  }

}
