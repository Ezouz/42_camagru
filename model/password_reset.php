<?php
namespace Model;
use \Core\User_model;

class password_reset extends User_model {

  public function __construct($posts) {
    parent::__construct($posts);
  }

  public function update_login() {
    if (self::check_user_login($this->_post['login']) === true) {
      if (self::select_user("users",
                            array(array(0 => '*')),
                            array ('login' => $this->_post['login'])
                        ) === true) {
          return "This login is already taken";
        } else {

        if (self::update_user(array ('user_id' => $_SESSION['user_id'],
                                     'login' => $this->_post['login'],
                             ), array(0 => "users")) === true) {
          if (self::update_user(array ('user_id' => $_SESSION['user_id'],
                                      'login' => $this->_post['login'],
                               ), array(0 => "posts")) === true) {
            if (self::update_user(array ('user_id' => $_SESSION['user_id'],
                                         'login' => $this->_post['login'],
                               ), array(0 => "comments")) === true) {
                return true;
            }
          }
        }
      }
    }
    return $this->_msg;
  }

  public function update_email() {
    if (self::check_user_email($this->_post['email']) === false)
      return $this->_msg;
    if (self::select_user("users",
                          array(array(0 => '*')),
                          array ('email' => $this->_post['email'])
                      ) === false) {
      if (self::update_user(array ('user_id' => $_SESSION['user_id'],
                                    'email' => $this->_post['email'],
                                    'token_mail' => uniqid(""),
                                    'status' => 0
                                  ),
                            array(0 => "users"))) {
        $user = get_object_vars(
                self::select_user("users",
                                  array(array(0 => '*')),
                                  array('user_id' => $_SESSION['user_id']))
                                  );
        if ((self::send_mail(self::change_mail(),
                              $user, 'activate')) === true)
          $this->_msg = "success, check your emails to confirm update";
      }
      } else
        $this->_msg = "This email address is already registered";
      return $this->_msg;
  }

  public function update_pwd() {
    $user = get_object_vars(self::select_user("users",
                                    array(array(0 => '*')),
                                    array('user_id' => $_SESSION['user_id']))
                            );
    $pwd = $user['passwd'];
    if (self::check_passwd($pwd,
                            hash("whirlpool",
                            $this->_post['old_password'])) === true) {
      if (self::check_user_passwd($this->_post['passwd']) === false)
        return $this->_msg;
      else {
          if ($this->_post['passwd'] === $this->_post['passwd_v']) {
            $passwd =  hash("whirlpool", $this->_post['passwd']);
            return self::update_user(array ('user_id' => $_SESSION['user_id'],
                                            'passwd' => $passwd),
                                     array(0 => "users"));
        }
      }
    }
    return $this->_msg;
  }

  public function check_token_pwd($login) {
    $user = get_object_vars(self::select_user("users",
                                              array(array(0 => '*')),
                                              array ('login' => $login))
                                            );
    if ($user['token_pwd'] === $_GET['token']) {
      return self::set_user_pwd($user);
    } else
      return "ERROR : Wrong key.";
  }

  private function set_user_pwd($user) {
    if ($user['email'] === $this->_post['email']) {
      if (self::check_user_passwd($this->_post['passwd']) === true) {
        if (self::check_passwd(
          $this->_post['passwd'], $this->_post['passwd_v'])
          === true) {
            $user['passwd'] =  hash("whirlpool", $this->_post['passwd']);
            $user['token_pwd'] = "0";
            return self::update_user($user, array(0 => "users"));
        }
      }
    } else
      $this->_msg = "Invalid email address";
  }

    public function change_mail() {
      $email['object'] = "You updated your CAMAGRU account !" ;
      $email['header'] = "From: update@camagru.com" ;
      $email['msg'] = "Welcome to Camagru,\n";
      $email['msg'] .= "We have to check your new email address,";
      $email['msg'] .= " please click on the following link :\n";
      return ($email);
    }

  }
