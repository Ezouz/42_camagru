<div id="forms">
  <div id="center_form">
  <div id="title_div" >
    <h2 class="forms_account">Sign Up !</h2>
  </div>

     <?php
     $form = new \Core\Form(
       [
       'username' => ['required' => 1],
       'email' => ['required' => 1, 'type' =>'email'],
       'password' => ['required' => 1, 'type' =>'password'],
       'verify_password' => ['required' => 1, 'type' =>'password']
       ],
       null,
       "Sign Up");
    echo $form->__toString();
    ?>
  </div>
  </div>
