<?php
namespace Controller;
use \Core\Post_controller;

class home extends Post_controller {

  public function home() {
    if (isset($_POST['Like']) || isset($_POST['Unlike'])) {
      $_SESSION['POST'] = $_POST;
      header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
      exit;
    }
    else if (isset($_SESSION['POST'])) {
      $post = $_SESSION['POST'];
      unset($_SESSION['POST']);
      return self::like_post($post);
    }
  }

}
