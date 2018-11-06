<?php
namespace Model;
use \Core\Post_model;

class picture extends Post_model {

  public function __construct($posts = null) {
    parent::__construct($posts);
  }

  public function load_gallery() {
    $stmt = "SELECT * FROM `posts` WHERE `img_modif_date` IS NOT NULL";
    $stmt .= " AND `user_id` LIKE :user_id";
    $stmt .= " ORDER BY `img_creation_date` DESC";
    return self::display_post(
           self::get_posts($stmt, array('user_id' => $_SESSION['user_id'])));
  }

}
