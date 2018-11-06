<?php
namespace Core;

class Post {

  public $img_id;
  public $img_title;
  public $img_desc;
  public $img_path;
  public $img_creation_date;
  public $img_modif_date;
  public $user_id;
  public $login;
  public $comments;
  public $likes;
  public $post;
  public $resume;
  public $link;

  public function __construct($data)
  {
    $this->hydrate($data);
    $this->likes = Post_controller::get_likes($this->img_id);
    $this->comments = Post_controller::get_comments($this->img_id);
    $this->complete_post();
    $this->resume_post();
    $this->link_post();
  }

  public function link_post() {
    $this->link = '<div id="image_post" style="max-width:250px;">';
    $this->link .=  $this->image_post();
    $this->link .= '</div>';
  }

  public function resume_post() {
    $this->resume = '<div id="post">';
    $this->resume .= '<div id="image_post">';
    $this->resume .= '<div id="sub_img">';
    $this->resume .=  $this->user_part(true);
    $this->resume .= '</div>';
    $this->resume .=  $this->image_post();
    $this->resume .=  $this->post_like_image();
    $this->resume .= '</div>';
  }

  public function complete_post() {
    $this->post = '<div id="post">';
    $this->post .=  $this->edit_post();
    $this->post .= '<div id="image_post">';
    $this->post .= '<div id="sub_img">';
    $this->post .=  $this->user_part(true);
    $this->post .= '</div>';
    $this->post .=  $this->image_post();
    $this->post .=  $this->post_like_image();
    $this->post .= '<div id="img_desc">';
    $this->post .=  $this->title_post();
    $this->post .= '<p class="desc">'.$this->img_desc.'</p></div>';
    $this->post .=  $this->comment_post();
    $this->post .= '</div>';
  }

  public function user_part($resume) {
    if ($resume === false) {
      $part = '<div id="com_title">';
      $part .= '<p class="post_text">'.$this->login.'</p>';
      $part .= '</div>';

    } else {
      $part = '<div id="com_title">';
      $part .= '<p class="post_text">'.$this->login.'</p>';
      $part .= '</div>';
      $part .= '</div>';
      $part .= '<div id="com_date">';
      $part .= '<p class="date_text">'.substr($this->img_modif_date, 0,16).'</p>';
      $part .= '</div>';
    }
    return $part;
  }

  public function edit_post() {
    $part = '<div id="edit_post">';
    if (isset($_SESSION['user_id']) && $this->user_id === $_SESSION['user_id']) {
      $form = new Form(null, $this->img_id, "Edit post");
      $part .= $form->__toString();
      $form = new Form(null, $this->img_id, "Delete post");
      $part .= $form->__toString();
    }
    $part .= '</div>';
    return $part;
  }

  public function title_post() {
    $part = '<div id="post_title">';
    $part .= '<p class="post_text" >'.$this->img_title.'</p>';
    $part .= '</div>';
    return $part;
  }

  public function image_post() {
    $part = '<a href="index.php?page=show&post='.$this->img_id.'">';
    $part .= '<img class="img_posted" src="'.$this->img_path.'" alt="'.$this->img_title.'">';
    $part .= '</a>';
    return $part;
  }

  public function post_like_image() {
  $part = '<div id="post_like">';
  $part .=  '<p class="post_text">'.count($this->comments).' comments</p>';
  $part .= '<p class="post_text">'.count($this->likes).' likes</p>';
  if (isset($_SESSION['user_id'])) {
    if (Post_controller::get_if_user_like($this->likes) === true) {
    $like = new Form(null, $this->img_id, "Unlike");
    } else {
      $like = new Form(null, $this->img_id, "Like");
    }
    $part .=  '<div class="input_like">';
    $part .= $like->__toString();
    $part .= "</div>";
  }
  $part .= "</div>";
  return $part;
}

  public function comment_post() {
    $part = '<div id="comments">';
    if (!empty($this->comments)) {
      $part .= '<div id="show_comment">';
      foreach ($this->comments as $nb => $obj) {
        if ($obj) {
          $vars = get_object_vars($obj);
          $part .= self::one_comment($vars);
        }
      }
      $part .= '</div>';
    }
    if (isset($_SESSION['user_id']))
        $part .=  self::comment_area();
    $part .= '</div>';
    return $part;
  }

  public function one_comment($comment) {
    $com = '<div id="com_post">';
    $com .= '<div id="com_bine">';
    $com .= '<div id="com_title">';
    $com .= '<p class="post_text">'.$comment['login'].": </p>";
    $com .=  '</div>';
    $com .= '<div id="com_date">';
    $com .= '<p class="date_text">'.$comment['comment_date'].'</p>';
    $com .=  '</div>';
    if (isset($_SESSION['user_id']) && $comment['user_id'] === $_SESSION['user_id']) {
      $com .= '<div class="input_comment">';
      $button = new Form(null, $comment['comment_id'], "Delete comment");
      $com .=  $button->__toString();
      $com .=  '</div>';
    }
    $com .=  '</div>';
    $com .= '<div id="com_comment">';
    $com .= '<p class="comment_text">'.$comment['comment']."</p>";
    $com .=  '</div>';
    $com .=  '</div>';
    return $com;
  }

  public function comment_area() {
    $area = '<div id="create_comment">';
    $new_comment = new Form(['comment' => ['type' =>'textarea']],
    $this->img_id, "Post");
    $area .=  $new_comment->__toString();
    $area .=  '</div>';
    return $area;
  }

  public function hydrate($post) {
    $data = get_object_vars($post);
    foreach ($data as $key => $value)
    {
      $method = 'set'.ucfirst($key);
      if (method_exists($this, $method))
      $this->$method($value);
    }
  }

  private function setUser_id($val) { $this->user_id = $val; }
  private function setLogin($val) { $this->login = $val; }
  private function setImg_id($val) { $this->img_id = $val; }
  private function setImg_title($val) { $this->img_title = $val; }
  private function setImg_desc($val) { $this->img_desc = $val; }
  private function setImg_path($val) { $this->img_path = $val; }
  private function setImg_creation_date($val) { $this->img_creation_date = $val; }
  private function setImg_modif_date($val) { $this->img_modif_date = $val; }

  public function getUser_id() { return $this->user_id; }
  public function getLogin() { return $this->login; }
  public function getImg_id() { return $this->img_id; }
  public function getImg_title() { return $this->img_title; }
  public function getImg_desc() { return $this->img_desc; }
  public function getImg_path() { return $this->img_path; }
  public function getImg_creation_date() { return $this->img_creation_date; }
  public function getImg_modif_date() { return $this->img_modif_date; }
  public function getPost() { return $this->post; }
  public function getResume() { return $this->resume; }
  public function getLink() { return $this->link; }

}
