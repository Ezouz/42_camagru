<?php
namespace Controller;
use \Core\Post_controller;
use \Core\Post_model;

class show extends Post_controller {

  public function show() {
    if (isset($_POST["Post"])) {
      $_SESSION['POST'] = $_POST;
      header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
      exit;
    } else if (isset($_SESSION['POST'])) {
      $_POST = $_SESSION['POST'];
      unset($_SESSION['POST']);
      if (isset($_POST['Post']))
        return self::new_comment($_POST);
      } else if (isset($_POST["Delete_post"]) || isset($_POST["Edit_post"]) ||
        isset($_POST["Like"]) || isset($_POST["Unlike"]) ||
        isset($_POST["Delete_comment"])) {
          if (isset($_POST['Delete_post'])) {
            if (self::delete_post(array('img_id' => $_POST['Delete_post']), "posts"))
              header('Location: index.php?page=gallery_private');
          }
          else if (isset($_POST['Delete_comment']))
            return self::delete_post(array('Comment_id' => $_POST['Delete_comment']), "comments");
          else if (isset($_POST["Like"]) || isset($_POST["Unlike"]))
            return self::like_post($_POST);
          else if (isset($_POST["Edit_post"])) {
            header('Location: index.php?page=edit_post&post='.$_POST["Edit_post"]);
          }
      }
  }

}
