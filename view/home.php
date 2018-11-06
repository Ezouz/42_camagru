<link rel="stylesheet" href="css/gallery.css"  type="text/css">

<div id="gallery_posts">
  <div id="posts">
  <?php
  $pagin = new \Core\Page($page, (isset($_GET['p']) ? $_GET['p'] : null));
  $posts = $pagin->get_slice();
  if ($posts)
    foreach ($posts as $tab => $object)
      echo $object->getResume();
  ?>
      </div>
</div>
<?php
echo $pagin->__toString();
?>
