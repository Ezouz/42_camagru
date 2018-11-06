  <?php
  if (isset($_GET['token']) && isset($_GET['login'])) {
    ?>
    <div>
      <h2>Reset your password</h2>
    <?php
    $form = new \Core\Form(
      [
        'email' => ['required' => 1, 'type' =>'email'],
        'new_password' => ['required' => 1, 'type' =>'password'],
        'confirm_new_password' => ['required' => 1, 'type' =>'password']
      ],
      null,
      "Reset");
      echo $form->__toString();
    } else {
      require("view/home.php");
    }

  ?>
