<?php
namespace Model;
use \Core\User_model;

class signup extends User_model {
  private $_new;

  public function __construct($posts) {
    parent::__construct($posts);
  }

  public function init_insertuser() {
    $this->_new['token_pwd'] = "0";
    $this->_new['token_mail'] = uniqid("");
    $this->_new['notif'] = "1";
  }

  public function getNew_user(){
    if ($this->check_user_email($this->_post['email']) === true) {
      $this->_new['email'] = $this->_post['email'];
      if ($this->check_user_login($this->_post['login']) === true) {
        $this->_new['login'] = $this->_post['login'];
        if ($this->check_user_passwd($this->_post['passwd']) === true) {
          if ($this->check_passwd($this->_post['passwd'],
                                  $this->_post['passwd_v']) === true) {
            $this->init_insertuser();
            $this->_new['passwd'] = hash("whirlpool", $this->_post['passwd']);
            return $this->_new;
          }
        }
      }
    }
    return $this->send_msg();
  }

  public function setNew_user() {
    if (self::select_user("users", array(
                                      array(0 => '*')),
                                      array('email' => $this->_new['email']))
                                   === false) {
      if (self::select_user("users",
                              array(array(0 => '*')),
                              array('login' => $this->_new['login']))
                                    === false) {
        if (self::create_user($this->_new)) {
          $this->_msg = "success, check your emails to confirm suscription";
          return (self::send_mail(self::registration_mail(),
                                                    $this->_new, 'activate'));
        } else {
          $this->_msg = "could not create your profile now, please retry";
        }
      } else {
        $this->_msg = "This login is already taken";
        }
      } else {
      $this->_msg = "This email address is already registered";
    }
    return $this->_msg;
  }

  public function registration_mail() {
  $email['object'] = "Activate your CAMAGRU account !" ;
  $email['header'] = "From: registration@camagru.com" ;
  $email['msg'] = "Welcome to Camagru,\n";
  $email['msg'] .=
  "In order to activate your account, please click on the following link :\n";
  return ($email);
}

}
