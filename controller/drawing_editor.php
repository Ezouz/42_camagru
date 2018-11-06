<?php
namespace Controller;
use \Core\Post_controller;

class drawing_editor extends Post_controller {

  public function drawing_editor() {
    if (isset($_POST['img'])) {
      $_SESSION['POST_DRAW'] = $_POST;
      header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
      exit;
    }
  }

  public function load_image() {
    $target_dir = "user/" . $_SESSION['login'] ."/";
    $tmp = $target_dir."tmp_".$_SESSION['login'].".png";
    if (self::save_picture($tmp) === false)
      return "Sorry, an error occured, could not save picture";
    unset($_SESSION['POST_IMG']);
    return $tmp;
  }

}
