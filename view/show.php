<link rel="stylesheet" href="css/gallery.css"  type="text/css">
<div id="show">
  <?php
  if (isset($_GET['post'])) {
    $new = new \Core\Post_model(array('img_id' => $_GET['post']));
    $post = $new->display_post(
                  $new->select_post(array(array(0 => '*')), "posts", true));
    if (empty($post))
      header("Location: index.php?page=home");
    else
      echo $post->getPost();
  }
  ?>
</div>
