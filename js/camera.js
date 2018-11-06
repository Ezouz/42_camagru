var constraints = { audio: false, video: { width: 640, height: 480 } };
var video = document.querySelector('video');

navigator.mediaDevices.getUserMedia(constraints)
.then(function(mediaStream) {
  video.srcObject = mediaStream;
  video.onloadedmetadata = function(e) {
    video.play();
  };
})
.catch(function(err) { console.log(err.name + ": " + err.message); });
