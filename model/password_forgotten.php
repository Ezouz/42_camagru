<?php
namespace Model;
use \Core\User_model;

class password_forgotten extends User_model {

  public function __construct($posts) {
    parent::__construct($posts);
  }

  public function update_token_pwd() {
    $u = self::select_user("users", array(array(0 => '*')), $this->_post);
    if (is_object($u)) {
      if ($user = get_object_vars($u)) {
        $user['token_pwd'] = uniqid("");
        if (self::update_user($user, array(0 => "users"))) {
          if (($this->_msg = self::send_mail(
            self::reinitialisation_mail(), $user, 'password_reset')) === true) {
              $this->_msg = "Please check your emails to proceed";
          }
        } else {
          $this->_msg = "could not update bdd";
        }
      } else {
        $this->_msg = "This email address isn't registered";
      }
    }
  }

  public function reinitialisation_mail() {
    $email['object'] = "Reset Password !" ;
    $email['header'] = "From: password@camagru.com" ;
    $email['msg'] = "Hello,\n";
    $email['msg'] .= "In order to reset your account password,";
    $email['msg'] .= "please click on the following link :\n";
    return ($email);
  }

}
