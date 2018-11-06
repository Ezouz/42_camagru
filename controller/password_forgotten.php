<?php
namespace Controller;

class password_forgotten {

  public function password_forgotten() {
    if (isset($_POST['Send_mail']))
    {
      $_SESSION['POST'] = $_POST;
      header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
      exit;
    } else if (isset($_SESSION['POST'])) {
      $_POST = $_SESSION['POST'];
      unset($_SESSION['POST']);
      $new = new \Model\password_forgotten(array('email' => $_POST['email']));
      $new->update_token_pwd();
      $_SESSION['log'] = $new->send_msg();
      header("Location: index.php?page=login");
    }
  }

}
