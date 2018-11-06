<link rel="stylesheet" href="css/picture.css"  type="text/css">
<link rel="stylesheet" href="css/theme.css"  type="text/css">
<link rel="stylesheet" href="css/gallery.css"  type="text/css">
<?php $img_dir = "app/app-filters/";?>
<div id="block_content">
<div id="video_container">
	<div id="catalog" >
		<img class="active_filtre img_button" src="<?= $img_dir."filtre2.png"?>" alt="filtre" >
		<img class="active_filtre img_button" src="<?= $img_dir."filtre1.png"?>" alt="filtre" >
		<img class="active_filtre img_button" src="<?= $img_dir."filtre3.png"?>" alt="filtre" >
		<img class="active_filtre img_button" src="<?= $img_dir."filtre4.png"?>" alt="filtre" >
	</div>
	<div id="peer">
		<div class="screencontent">
			<video autoplay> </video>
			<img id="filtre_faded" class="filtre">
			<div id="vid_option">
				<div class="option_block_snap">
					<input id="snap_faded" class="picture_forms_input" type="submit" value="snap" onclick="snap(this)">
				</div>
				<div class="option_block">
					<button type="button" class="picture_forms_input" id="upload_a_pic">
						upload a picture
					</button>
				</div>
			</div>
		</div>
		<div id="img_upload_faded" class="forms_account">
			<label >Upload image :</label><br/>
			<input type="file" id="upload" name="upload">
		</div>
	</div>
	</div>
	<div id="mini_gallery">
		<div id="gallery_content">
			<?php
		    $new = new \Model\picture();
				$posts = $new->load_gallery();
				if (!empty($posts)) {
					foreach ($posts as $key => $object) {
						echo $object->getLink();
					}
				}
		  ?>
		</div>
	</div>
</div>
<div id="img_save_faded">
	<div id="content_canvas">
		<img id="fakefiltre_faded" class="filtre">
	</div>
	<div id="command_save">
		<button class="picture_forms_input" type="button"  onclick="click_mask()">retry</button>
		<input id="save" class="picture_forms_input not_faded" type="submit" value="Save">
		<input id="go_paint" class="picture_forms_input faded" type="submit" value="Paint it yourself" style="width:fit-content;">
		</div>
	</div>
</div>
<div id="mask_faded" onclick="click_mask()"></div>
<script src="js/shared.js"></script>
<script src="js/event_picture.js"></script>
<script src="js/snap.js"></script>
<script src="js/camera.js"></script>
