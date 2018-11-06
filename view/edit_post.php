<div id="forms">
  <div id="center_form">
  <div id="title_div" >
  <h2  class="forms_account" >Edit your post (:</h2>
</div>
  <?php
  $form = new \Core\Form(
    [
      'title' => ['type' =>'text'],
      'description' => ['type' =>'textarea']
    ],
    null,
    "Save");
    echo $form->__toString();
  ?>
</div>
</div>
