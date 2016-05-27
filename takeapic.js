(function() {

  var streaming = false,
      video        = document.querySelector('#video'),
      cover        = document.querySelector('#cover'),
      canvas       = document.querySelector('#canvas'),
      photo        = document.querySelector('#photo'),
      startbutton  = document.querySelector('#startbutton'),
      width = 320,
      height = 240;

  navigator.getMedia = ( navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia);

  navigator.getMedia(
    {
      video: true,
      audio: false
    },
    function(stream) {
      if (navigator.mozGetUserMedia000111) 
      {
        video.mozSrcObject = stream;
      } 
      else 
      {
        var vendorURL = window.URL || window.webkitURL;
        video.src = vendorURL.createObjectURL(stream);
      }
      video.play();
    },
    function(err) {
      console.log("An error occured! " + err);
    }
  );

  video.addEventListener('canplay', function(ev)
  {
    if (!streaming) 
    {
      height = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
      streaming = true;
    }
  }, false);

  document.getElementById('upload').src = '.';

  function takepicture() 
  {
  	var img = document.getElementById('myImg');
    var upload = document.getElementById('upload');
    var video =  document.getElementById('video');
    canvas.width = width;
    canvas.height = height;
    var wid = img.offsetWidth;
    var hei = img.offsetHeight;
    var x = parseInt(img.style.marginLeft);
    if (img.style.marginLeft == '')
      x = 0;
    var y = parseInt(img.style.marginTop);
    if (img.style.marginTop == '')
        y = 0;
    var Class = upload.className;
    if (Class == "shown")
      canvas.getContext('2d').drawImage(upload, 0, 0, width, height);
    else
      canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    canvas.getContext('2d').drawImage(img, x, y, wid, hei);
    var data = canvas.toDataURL('image/png');
    ajax.post('savepicture.php', {data: data}, function() {} );
    var photo = document.getElementById('photo');
    photo.parentNode.innerHTML = "<img src="+data+" id='photo'><button name='deletepic' id='deletepic'>Delete</button></br>" + photo.parentNode.innerHTML;
  }

  startbutton.addEventListener('click', function(ev){
      takepicture();
    ev.preventDefault();
  }, false);
})();