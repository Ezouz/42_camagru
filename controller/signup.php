<?php
namespace Controller;

class signup {
  
  public function signup() {
    if (empty($_SESSION['user_id'])) {
      if (isset($_POST['Sign_Up'])) {
        $_SESSION['POST'] = $_POST;
        header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        exit;
      } else if (isset($_SESSION['POST'])) {
        $_POST = $_SESSION['POST'];
        unset($_SESSION['POST']);
        $new = new \Model\signup($_POST);
        $user = $new->getNew_user();
        if (is_array($user))
        $new->setNew_user();
        else
        unset($_POST['Sign_Up']);
        return $new->send_msg();
      }
    } else
    header("Location: index.php?page=home");
  }

}
