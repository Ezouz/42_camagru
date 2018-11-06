<?php
namespace Core;

class Header {

  public $_group;
  function __construct($page, $active = false) {

    $img_dir = "app/icons/";

    $_group = '<ul id="navbar">';
    $_group .= '<li><a href="index.php" class="title_nav">';
    $_group .= '<div id="icon" ';
    $_group .= "style=background-image:url('".$img_dir."icone_gallery.png');>";
    $_group .= '<p>Gallery</p></div></a></li>';
    if (empty($_SESSION['user_id'])) {
      $_group .= '<li><a href="index.php?page=signup" class="title_nav">';
      $_group .= '<div id="icon"';
      $_group .= "style=background-image:url('".$img_dir."icone_logout.png');>";
      $_group .= '<p>New ?</p></div></a></li>';
      $_group .= '<li><a href="index.php?page=login" class="title_nav">';
      $_group .= '<div id="icon" ';
      $_group .= "style=background-image:url('".$img_dir."icone_picture.png');>";
      $_group .= '<p>Sign in!</p></div></a></li>';
    }
    else {
      $_group .= '<li><a href="index.php?page=gallery_private" class="title_nav">';
      $_group .= '<div id="icon" ';
      $_group .= "style=background-image:url('".$img_dir."icone_private.png');>";
      $_group .= '<p>My</p></div></a></li>';
      $_group .= '<li><a href="index.php?page=picture" class="title_nav">';
      $_group .= '<div id="icon" ';
      $_group .= "style=background-image:url('".$img_dir."icone_picture.png');>";
      $_group .= '<p>New Post</p></div></a></li>';
      $_group .= '<li><a href="index.php?page=logout" class="title_nav">';
      $_group .= '<div id="icon" ';
      $_group .= "style=background-image:url('".$img_dir."icone_logout.png');>";
      $_group .= '<p>Out !</p></div></a></li>';
    }
    $_group .= '</ul>';
    $this->_group = $_group;
  }

  function __toString() {
    return $this->_group;
  }

}
