var MAX_WIDTH = 640;
var MAX_HEIGHT = 480;

  function get_snaped() {
    display_previw(video);
    img_save();
  }

  function snap(e) {
    if (document.getElementById('filtre') !== null) {
		    load_fakefilter();
        img_save();
    }
 	  else
		    get_snaped();
  };

  function display_previw(img) {
    var width = img.width;
    var height = img.height;
    if (width > height) {
      if (width > MAX_WIDTH) {
        height *= MAX_WIDTH / width;
        width = MAX_WIDTH;
      }
    } else {
      if (height > MAX_HEIGHT) {
        width *= MAX_HEIGHT / height;
        height = MAX_HEIGHT;
      }
    }
    var canv = document.createElement('canvas');
    var ctx = canv.getContext('2d');
    canv.width = MAX_WIDTH;
    canv.height = MAX_HEIGHT;
    ctx.drawImage(img, 0, 0, canv.width, canv.height);
    var dataURL = canv.toDataURL("image/png");
    var p_display = document.createElement('img');
    p_display.src = dataURL;
    document.getElementById("content_canvas").appendChild(p_display);
    p_display.classList.add("img_preview");
  };

  document.getElementById('upload').onchange = function(e) {
    var file= e.target.value;
    var reg = /(.*?)\.(jpg|jpeg|png)$/;
    if(!file.match(reg))
    {
      alert("Invalid file type, only JPEG, JPEG or PNG");
      return false;
    }
    var reader = new FileReader();
    reader.onload = function(event){
      var img = new Image();
      img.onload = function(){
        display_previw(img);
      }
      img.src = event.target.result;
    }
    reader.readAsDataURL(e.target.files[0]);
    img_save();
  };
