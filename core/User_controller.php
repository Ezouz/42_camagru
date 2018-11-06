<?php
namespace Core;

class User_controller extends Controller {

  protected function set_session($user) {
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['login'] = $user['login'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['notif'] = $user['notif'];
  }

  protected function set_cookie($user) {
    setcookie("user_id", $user['user_id'], time()+365*24*3600, "/", false);
    setcookie("login", $user['login'], time()+365*24*3600, "/", false);
    setcookie("email", $user['email'], time()+365*24*3600, "/", false);
    setcookie("notif", $user['notif'], time()+365*24*3600, "/", false);
  }

  public function get_cookie() {
    if (isset($_COOKIE['user_id']) && empty($_SESSION['user_id'])) {
      $user = array ('user_id' => $_COOKIE['user_id'],
                     'login' => $_COOKIE['login'],
                     'notif' => $_COOKIE['notif'],
                     'email' => $_COOKIE['email']);
      self::set_session($user);
    }
  }

  protected function destroy_cookie() {
    unset($_COOKIE);
    setcookie("user_id", null, -1, '/');
    setcookie("login", null, -1, '/');
    setcookie("email", null, -1, '/');
    setcookie("status", null, -1, '/');
    setcookie("passwd", null, -1, '/');
  }

  protected function destroy_session() {
    unset($_SESSION);
    session_destroy();
  }

}
