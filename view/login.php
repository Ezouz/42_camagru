<div id="forms">
  <div id="center_form">
  <div id="title_div" >
  <h2 class="forms_account">Sign in !</h2>
</div>
  <?php
  $form = new \Core\Form(
    ['email' => ['required' => 1, 'type' =>'email'],
      'password' => ['required' => 1, 'type' =>'password'],
      'remember_me' => ['checked' => (isset($_COOKIE)?"1":"0"),
      'type' => 'checkbox']],
    null,
    "Log in");
    echo $form->__toString();
    ?>
<p id="link_div" class="forms_account"><a href="index.php?page=password_forgotten">Forgot about your password ?</a></p>
</div>
  </div>
