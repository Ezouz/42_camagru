<?php
namespace Core;

class Post_controller extends Controller {

  protected function set_date() {
    date_default_timezone_set('Europe/Paris');
    return date('Y-m-d H:i:s', time());
  }

  protected function save_picture($file_name) {
    if (isset($_SESSION['POST_IMG']) || isset($_SESSION['POST_DRAW'])) {
      $data = (isset($_SESSION['POST_IMG']) ? $_SESSION['POST_IMG']
      : $_SESSION['POST_DRAW']);
      foreach ($data as $k => $v) {
        if ($k = "img")
          $img_data = $v;
      }
      $img_data = str_replace('data:image/png;base64,', '', $img_data);
      $img_data = str_replace(' ', '+', $img_data);
      $img_data = base64_decode($img_data);
      return file_put_contents($file_name, $img_data);
    }
  }

  public function merge_img($_post) {
    $target_dir = "user/" . $_SESSION['login'] ."/";
    $tmp = $target_dir."tmp_".$_SESSION['login'].".png";
    if (self::save_picture($tmp) === false)
      return "Sorry, an error occured, could not save picture";
    $dest = imagecreatefrompng($tmp);
    $src = imagecreatefrompng("app/app-filters/filtre".$_GET['filtre'].".png");
    $l_src = imagesx($src);
    $h_src = imagesy($src);
    imagealphablending($src, true);
    imagesavealpha($src, true);
    $l_dest = imagesx($dest);
    $h_dest = imagesy($dest);
    $dest_x = ($l_dest - $l_src)/2;
    $dest_y =  ($h_dest - $h_src)/2;
    if (imagecopy($dest, $src, $dest_x, $dest_y, 0, 0, $l_src, $h_src) === false)
      return "Sorry, an error occured, could not save picture";
    imagepng($dest, $_post["img_path"]);
    imagedestroy($dest);
    imagedestroy($src);
    return self::post_infos($_post);
  }

  public function post_infos($_post) {
    unset($_SESSION['POST_IMG']);
    unset($_SESSION['POST_DRAW']);
    $_post['user_id'] = $_SESSION['user_id'];
    $_post['login'] = $_SESSION['login'];
    $_post['img_modif_date'] = self::set_date();
    if (empty($_GET['post']))
    $_post['img_creation_date'] = $_post['img_modif_date'];
    $new = new \Core\Post_model($_post);
    if ($new->check_desc() === true) {
      $ans = (isset($_GET['post']) ? $new->update_post("posts")
      : $new->create_post("posts"));
      if ($ans === true)
      header("Location: http://$_SERVER[HTTP_HOST]/camagru/index.php");
    }
    return $new->send_msg();
  }

  public function get_likes($img_id) {
    $new = new Post_model(array('img_id' => $img_id));
    $array = $new->select_post(array(array(0 => '*')), 'likes', false);
    if ($array) {
      $i = 0;
      foreach ($array as $n => $tab) {
        $likes[$i] = get_object_vars($tab);
        $i++;
      }
      return $likes;
    }
    return NULL;
  }

  public function get_if_user_like($like) {
    if ($like)
    foreach($like as $nb => $info) {
      if ($info['user_id'] === $_SESSION['user_id'])
        return true;
    }
    return false;
  }

  public function get_comments($img_id) {
    $new = new Post_model(array('img_id' => $img_id));
    return $new->select_post(array(array(0 => '*')), "comments", false);
  }

  public function delete_post($fields, $table) {
    $new = new Post_model($fields);
    return $new->delete_post($table);
  }

  public function new_comment($POST) {
    if (trim($POST['comment']) != "") {
      $post = array('img_id' => $POST['Post'],
      'user_id' => $_SESSION['user_id'],
      'login' => $_SESSION['login'],
      'comment' => $POST['comment'],
      'comment_date' => self::set_date());
      $new = new Post_model($post);
      if ($new->check_comm() === true) {
        if ($new->create_post("comments") === true)
          return $new->notify($post, "commented");
      }
      return $new->send_msg();
    }
  }

  public function like_post($post) {
    $like = array( 'img_id' =>
    (isset($post["Like"]) ? $post["Like"] : $post["Unlike"]),
    'user_id' => $_SESSION['user_id']);
    $new = new Post_model($like);
    if (isset($post["Like"])) {
      if ($new->create_post("likes") === true)
        return $new->notify($like, "liked");
    }
    else
      return $new->delete_post("likes");
  }

}
