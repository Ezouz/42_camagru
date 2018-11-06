
    <link rel="stylesheet" href="css/drawing_editor.css"  type="text/css">
    <div id="main">
      <?php $new = new \Controller\drawing_editor(array('user_id'=>$_SESSION['user_id']));
      $path = $new->load_image();?>
    <input type="hidden" id="img_path" value="<?= $path ?>"/>
  <div id="draw_area">
    <canvas id="canvas" width="640" height="480"></canvas>
  </div>
  <div id="editor">
<div id="drawing_editor">
  <div id="edit_colors">
		 <button id="colorRed" class="color" type="button" style="background-color:#ff3333" onclick="setcolorRed()"></button>
     <button id="colorDarkBlue" class="color" type="button" style="background-color:#06023e" onclick="setcolorDarkBlue()"></button>
     <button id="colorBlue" class="color" type="button" style="background-color:#5da9fe" onclick="setcolorBlue()"></button>
     <button id="colorYellow" class="color" type="button" style="background-color:#ffe724" onclick="setcolorYellow()"></button>
     <button id="colorOrange" class="color" type="button" style="background-color:#ff5d31" onclick="setcolorOrange()"></button>
     <button id="colorDarkGreen" class="color" type="button" style="background-color:#004506" onclick="setcolorDarkGreen()"></button>
     <button id="colorGreen" class="color" type="button" style="background-color:#7fffd4" onclick="setcolorGreen()"></button>
     <button id="colorPink" class="color" type="button" style="background-color:#ff80d5" onclick="setcolorPink()"></button>
     <button id="colorBlack" class="color" type="button" style="background-color:#000000" onclick="setcolorBlack()"></button>
     <button id="colorWhite" class="color" type="button" style="background-color:#ffffff" onclick="setcolorWhite()"></button>
   </div>
<div id="edit_buttons">
     <button id="sizeSmall" type="button" onclick="setSizeSmall()">Small</button>
     <button id="sizeNormal" type="button" onclick="setSizeNormal()">Normal</button>
     <button id="sizeLarge" type="button" onclick="setSizeLarge()">Large</button>
   </div>
 </div>
  <div id="save_draw" class="save_icon">
    <button id="clear" class="picture_forms_input" type="button" onclick="clear_canvas()">Retry</button>
		<input id="save" class="picture_forms_input" type="submit" value="save">
  </div>
    <script src="js/drawing_params.js"></script>
    <script src="js/event_drawing_editor.js"></script>
    <script src="js/shared.js"></script>
  </div>
  </div>
