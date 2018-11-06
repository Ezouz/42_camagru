<div id="forms">
  <div id="center_form">
    <div id="title_div" >
      <h2>Forgot about your password ?</h2>
    </div>
     <?php
     $form = new \Core\Form(
       [
       'email' => ['required' => 1, 'type' =>'email']
       ],
       null,
       "Send mail");
    echo $form->__toString();
    ?>
</div>
</div>
