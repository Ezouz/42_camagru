<?php
namespace Controller;
use \Core\User_controller;

class logout extends User_controller {

  public function logout() {
    self::destroy_session();
    self::destroy_cookie();
  }

}
