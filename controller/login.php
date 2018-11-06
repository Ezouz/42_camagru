<?php
namespace Controller;
use \Core\User_controller;

class login extends User_controller {

  public function login() {

    if (empty($_SESSION['user_id'])) {
      if (isset($_POST['Log_in'])) {
        if (isset($_SESSION))
        unset($_SESSION['user_id']);
        $_SESSION['POST'] = $_POST;
        header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        exit;
      } else if (isset($_SESSION['POST'])) {
        $_POST = $_SESSION['POST'];
        unset($_SESSION['POST']);
        $new = new \Model\login($_POST);
        $u = $new->get_user();
        if (is_object($u)) {
          $user = get_object_vars($u);
          if (is_array($user)) {
            if ($new->check_passwd($user['passwd'],
            (isset($pwd) ? $pwd :
            hash("whirlpool", $new->test_input($_POST['password']))))) {
              if ($user['status'] === "1") {
                self::set_session($user);
                if (isset($_POST['remember_me']))
                self::set_cookie($user);
                else
                if (isset($_COOKIE['user_id']))
                self::destroy_cookie($user);
                header('Location: index.php?page=gallery_private');
              } else
              return "You did not confirm your account, please check your
              emails before sign in";

            } else
            return "Wrong password";
          }
        } else {
          unset($_POST['Log_in']);
          return "This email address isn't registered";
        }
      }
    }
    else
    header("Location: index.php?page=home");
  }

}
