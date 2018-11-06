var fade = (x) => (y = document.getElementById(x)) !== null ?
y.id = x + "_faded": 0;

var unfade = (x) => (y = document.getElementById(x)) !== null ?
y.id = x.substr(0, x.indexOf("_faded")) : 0;

document.getElementById("upload_a_pic").addEventListener("click", function() {
  if (document.getElementById("img_save") !== null)
    click_mask();
  unfade("mask_faded");
  unfade("img_upload_faded");
  document.getElementById('upload').value = null;
});

function click_mask() {
  fade("img_upload");
  fade("img_save");
  fade("filtre");
  fade("fakefiltre");
  document.querySelectorAll('.img_preview').forEach(function(a){
    a.remove()
  })
  fade("mask");
};

function img_save() {
  unfade("mask_faded");
  fade("snap");
  unfade("img_save_faded");
  if (document.getElementById('img_upload') !== null) {
    fade_elem("save");
    unfade_elem("go_paint");
    fade('img_upload');
  }
};

document.getElementById("peer").addEventListener("click", function() {
  fade("filtre");
  fade("snap");
});

x = document.getElementsByClassName("active_filtre");
for (var i = 0; i < x.length; i++) {
  x[i].addEventListener("click", function(e) {
    if (document.getElementById("img_save_faded") !== null) {
      fade("img_upload");
      if (document.getElementById('filtre_faded') !== null) {
        document.getElementById('filtre_faded').src = e.target.src;
        unfade('filtre_faded');
        unfade("snap_faded");
      }
      else if (document.getElementById('filtre') !== null)
        document.getElementById('filtre').src = e.target.src;
    } else if (document.getElementById("img_save") !== null) {
      if (document.getElementById('filtre') !== null) {
        if (document.getElementById('fakefiltre_faded') !== null) {
          document.getElementById('fakefiltre_faded').src = document.getElementById('filtre').src;
          unfade("fakefiltre_faded");
        }
        if (document.getElementById('save').classList.contains('faded')) {
          document.getElementById('save').classList.remove('faded');
          document.getElementById('save').classList.add('not_faded');
          document.getElementById('save').classList.add('picture_forms_input');
        }
        fade("filtre");
      }
      if (document.getElementById('fakefiltre_faded') !== null) {
        document.getElementById('fakefiltre_faded').src = e.target.src;
        unfade("fakefiltre_faded");
        unfade_elem("save");
        fade_elem("go_paint");
      } else {
        fade("fakefiltre");
        fade_elem("save");
        unfade_elem("go_paint");
      }
    }
  });
}

function load_fakefilter(){
  get_snaped();
  if (document.getElementById('filtre') !== null) {
    if  (document.getElementById('fakefiltre_faded') !== null) {
      document.getElementById('fakefiltre_faded').src = document.getElementById('filtre').src;
      unfade("fakefiltre_faded");
    }
  }
};

document.getElementById("save").addEventListener("click", function() {
  if (document.getElementById("fakefiltre") !== null) {
    var path = document.getElementById("fakefiltre").src;
    var filtre = path.substr(path.indexOf("filtre") + 6, 1);
  }
  var preview_datas = document.getElementsByClassName("img_preview")[0];
  var url = "index.php?page=edit_post&filtre=" + filtre;
  send_data_img(url, preview_datas.src);
});

document.getElementById("go_paint").addEventListener("click", function() {
  var url = "index.php?page=drawing_editor";
  var preview_datas = document.getElementsByClassName("img_preview")[0];
  send_data_img(url, preview_datas.src);
});
