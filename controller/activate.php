<?php
namespace Controller;

class activate {

    public function activate() {
      if(empty($_GET) || !preg_match("#^[_a-zA-Z0-9-]{3,50}+$#", $_GET['login']) ||
          !preg_match("/^[a-f0-9]{13}$/", $_GET['token'])) {
        header('Location: index.php?page=404');
      }
      else {
        $new = new \Model\activate();
        if ($new->check_token_mail($_GET['login']) === true) {
          $_SESSION['log'] = $new->send_msg();
          if (empty($_SESSION['user_id']))
            header("Location:index.php?page=login");
          else
            header("Location:index.php?page=gallery_private");
        }
        return $new->send_msg();
      }
    }

}
