<?php
namespace Model;
use \Core\User_model;

class login extends User_model {

  public function __construct($posts) {
    parent::__construct($posts);
  }

  public function get_user() {
    return self::select_user("users",
                              array(array(0 => '*')),
                              array('email' => $this->_post['email'])
                            );
  }

}
