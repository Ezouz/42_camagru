<?php
namespace Controller;
use \Core\Post_controller;

class gallery_private extends Post_controller {

  public function gallery_private() {
    if (isset($_SESSION['user_id'])) {
      if (isset($_POST['Save']) || isset($_POST['Reset']) ||
      isset($_POST['Change']) || isset($_POST['Like']) ||
      isset($_POST['Unlike']) || isset($_POST['Update'])) {
        $_SESSION['POST'] = $_POST;
        header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        exit;
      }
      else if (isset($_SESSION['POST'])) {
        $post = $_SESSION['POST'];
        unset($_SESSION['POST']);
        foreach ($post as $key => $value) {
          if ($key === 'Save') {
            unset($post['Save']);
            return self::user_save_notif($post);
          } else if ($key === 'Reset') {
            unset($post['Reset']);
            return self::user_reset_pwd($post);
          } else if ($key === 'Change') {
            unset($post['Change']);
            return self::user_reset_email($post);
          } else if ($key === 'Like' || $key === 'Unlike') {
            return self::like_post($post);
          } else if ($key === 'Update') {
            unset($post['Update']);
            return self::user_reset_login($post);
          }
        }
      }
    } else {
      header("Location: index.php?page=home");
    }
  }

  public function user_reset_login($post) {
    $ins = new \Model\password_reset($post);
    if ($ins->update_login() === true)
    return "Your login has been updated";
    else
    return $ins->send_msg();
  }

  public function user_reset_pwd($post) {
    $ins = new \Model\password_reset($post);
    if ($ins->update_pwd() === true)
    return "Your password has been updated";
    else
    return $ins->send_msg();
  }

  public function user_reset_email($post) {
    $ins = new \Model\password_reset($post);
    $ins->update_email();
    return $ins->send_msg();
  }

  public function user_save_notif($post) {
    $notif = (empty($post['get_notifications_by_email']) ? "0" : "1");
    $fields = array('user_id' => $_SESSION['user_id'],
    'notif' => $notif);
    $new = new \Core\User_model($fields);
    if ($new->update_user($fields, array(0 => "users")) === true) {
      $_SESSION['notif'] = $notif;
      return true;
    }
  }

}
