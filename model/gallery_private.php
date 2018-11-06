<?php
namespace Model;
use \Core\Post_model;

class gallery_private extends Post_model {

  public function __construct($posts) {
    parent::__construct($posts);
  }

}
