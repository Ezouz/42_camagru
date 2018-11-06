<?php
namespace Controller;
use \Core\Post_controller;

class picture extends Post_controller {

  public function picture(){
    if (isset($_SESSION['user_id'])) {
      if (isset($_POST['img'])) {
        $_SESSION['POST_IMG'] = $_POST;
        header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        exit;
      }
    } else
        header("Location: index.php?page=404");
  }

}
