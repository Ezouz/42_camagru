<?php
namespace Model;
use \Core\User_model;

class show extends User_model {

  public function __construct($posts) {
    parent::__construct($posts);
  }

}
