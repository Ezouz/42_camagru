<?php
namespace Controller;
use \Core\Post_controller;

class edit_post extends Post_controller {

  public function edit_post() {
    if (isset($_POST['Save'])) {
      $_SESSION['POST'] = $_POST;
      header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
      exit;
    } else if (isset($_SESSION['POST']) && isset($_SESSION['user_id'])) {
      $_POST = $_SESSION['POST'];
      unset($_POST['Save']);
      unset($_SESSION['POST']);
      $target_dir = "user/" . $_SESSION['login'] ."/";
      $_POST['img_path'] = (isset($_GET['post']) ? "" : $target_dir.MD5(uniqid()).".png");
      if (!empty($_GET['filtre']))
        return self::merge_img($_POST);
      else if (isset($_GET['post'])) {
                $_post['img_id'] = $_GET['post'];
                $_post['img_title'] = $_POST['title'];
                $_post['img_desc'] = $_POST['description'];
                return self::post_infos($_post);
      } else {
        if (self::save_picture($_POST['img_path']) === false)
          return "Sorry, an error occured, could not save picture";
        return self::post_infos($_POST);
      }
    }
  }

}
