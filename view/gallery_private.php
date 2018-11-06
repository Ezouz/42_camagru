<?php if (isset($_SESSION['user_id'])) { ?>
<link rel="stylesheet" href="css/gallery.css"  type="text/css">
  <div id="account_forms">
    <?php $file = "app/icons/icone_account.png";?>

    <div  id="icon" style=background-image:url('<?=$file;?>') onclick="click_account()">
      <p class="title_nav">Account</p>
    </div>
    <div id="account" class="faded">
      <div class="account_forms">
        <p > Current email: <?= $_SESSION['email'] ?> </p>
          <div id="notify">
          <?php
          $form = new \Core\Form(['get notifications by email' =>
          ['checked' => ($_SESSION['notif'] === "1" ? "1" : "0"),
          'type' => 'checkbox']], null, 'Save');
          echo $form->__toString();
          ?>
          </div>
          <p style="cursor: pointer;" onclick="click_login()">change Login</p>
          <div id="change_login" class="faded">
            <?php
            $form = new \Core\Form(
              [
                'new_login' => ['required' => 1]
              ],
              null,
              "Update");
            echo $form->__toString();
            ?>
          </div>
            <p style="cursor: pointer;" onclick="click_email()"> change email address </p>
          <div id="change_email" class="faded">
            <?php
            $form = new \Core\Form(
              [
                'new_email' => ['required' => 1, 'type' =>'email']
              ],
              null,
              "Change");
              echo $form->__toString();
              ?>
          </div>
            <p style="cursor: pointer;" onclick="click_pwd()"> change password ? </p>
          <div id="change_pwd" class="faded">
            <?php
            $form = new \Core\Form(
              [
                'old_password' => ['required' => 1, 'type' =>'password'],
                'new_password' => ['required' => 1, 'type' =>'password'],
                'confirm_new_password' => ['required' => 1, 'type' =>'password']
              ],
              null,
              "Reset");
            echo $form->__toString();
            ?>
          </div>
        </div>
      </div>
    </div>
    <div id="gallery">
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
</div>

  <div id="mask" class="faded" onclick="click_mask()"></div>
  <script src="js/event_private_gallery.js"></script>
<?php } ?>
