var img_path = document.getElementById('img_path').value;
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
MAX_WIDTH = 640;
MAX_HEIGHT = 480;
var paint;
var color = colorYellow;
var size = 5;
var clickSize = new Array();
var clickColor = new Array();
var clickX = new Array();
var clickY = new Array();
var clickDrag = new Array();

console.log(img_path);

function recreate_img(img_path) {
  var img = new Image();
  img.src = img_path;
  context.drawImage(img, 0, 0, MAX_WIDTH, MAX_HEIGHT);
};

window.addEventListener("load", function(event) {
  recreate_img(img_path)
});

function checkImage(imageSrc, bad) {
  var img = new Image();
  img.onerror = bad;
  img.src = imageSrc;
};

checkImage(img_path, function(){
  if (!alert("An Error Occured"))
    window.location.href="index.php?page=picture";
});

canvas.addEventListener("mousedown", function(e){
  e.stopPropagation();
  var mouseX = e.pageX - this.offsetLeft;
  var mouseY = e.pageY - this.offsetTop;
  console.log(this, this.offsetLeft, this.offsetRight, this.offsetTop);
  paint = true;
  addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
  redraw();
});

canvas.addEventListener("mousemove", function(e){
  e.stopPropagation();
  if (paint) {
    addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
    redraw();
  }
});

canvas.addEventListener("mouseup", function(e){
  paint = false;
});

document.body.addEventListener("mousemove", function(e){
  paint = false;
});

canvas.addEventListener("touchstart", function(e) {
  console.log(e);
  e.stopPropagation();
  var mouseX = e.targetTouches[0].pageX - this.offsetLeft;
  var mouseY = e.targetTouches[0].pageY - this.offsetTop;
  console.log(this, this.offsetLeft, this.offsetRight, this.offsetTop);
  paint = true;
  addClick(e.targetTouches[0].pageX - this.offsetLeft, e.targetTouches[0].pageY - this.offsetTop);
  redraw();
});

canvas.addEventListener("touchmove", function(e) {
  console.log(e);
  e.stopPropagation();
  if (paint) {
    addClick(e.targetTouches[0].pageX - this.offsetLeft, e.targetTouches[0].pageY - this.offsetTop, true);
    redraw();
  }
});

canvas.addEventListener("touchend", function(e) {
  paint = false;

});

canvas.addEventListener("touchleave", function(e) {
  paint = false;
});

function clear_canvas()
{
	context.clearRect(0, 0, MAX_WIDTH, MAX_HEIGHT);
  clickSize = new Array();
  clickColor = new Array();
  clickX = new Array();
  clickY = new Array();
  clickDrag = new Array();
  recreate_img(img_path);
};

function addClick(x, y, dragging)
{
  clickX.push(x);
  clickY.push(y);
  clickDrag.push(dragging);
  clickColor.push(color);
  clickSize.push(size);
};

function redraw(){
  context.lineJoin = "round";
  for(var i=0; i < clickX.length; i++) {
    context.beginPath();
    if(clickDrag[i] && i){
      context.moveTo(clickX[i-1], clickY[i-1]);
     }else{
       context.moveTo(clickX[i]-1, clickY[i]);
     }
     context.lineTo(clickX[i], clickY[i]);
     context.closePath();
     context.strokeStyle = clickColor[i];
     context.lineWidth = clickSize[i];
     context.stroke();
  }
};

document.getElementById("save").addEventListener("click", function() {
	var url = "index.php?page=edit_post";
	var preview_datas = canvas.toDataURL("image/png");
	send_data_img(url, preview_datas);
});
