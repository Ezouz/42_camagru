<?php
namespace Controller;
use \Core\User_controller;

class password_reset extends User_controller {

  public function password_reset() {
    if (isset($_POST['Reset'])) {
      $_SESSION['POST'] = $_POST;
      header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
      exit;
    } else if (isset($_SESSION['POST'])) {
      $_POST = $_SESSION['POST'];
      unset($_SESSION['POST']);
      if (preg_match("#^[_a-zA-Z0-9-]{3,50}+$#", $_GET['login'])
      || preg_match("/^[a-f0-9]{13}$/", $_GET['token'])) {
        $new = new \Model\password_reset($_POST);
        if ($new->check_token_pwd($_GET['login']) === true) {
        $_SESSION['log'] = "Success, your password has benn changed";
          header("Location: index.php?page=home");
        } else
          return $new->send_msg();
      } else {
        header('Location: index.php?page=404');
      }
    }
  }

}
