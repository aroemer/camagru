function add(name) {
  var myImg = document.getElementById('myImg');
  myImg.src="images/"+name+".png";
  myImg.setAttribute("class", "shown");
  document.getElementById('startbutton').disabled = false;
}

function changesize(event) 
{
	var obj = document.getElementById("myImg");
  var width = obj.offsetWidth;
  var height = obj.offsetHeight;
  var left = parseInt(obj.style.marginLeft);
  var top = parseInt(obj.style.marginTop);
  if (obj.style.marginLeft == '')
    left = 0;
  if (obj.style.marginTop == '')
    top = 0;
  var right = parseInt(left) + parseInt(width);
  var down = parseInt(top) + parseInt(height);
  if (event.keyCode == 43)
  {
    if (width <= 320.5 && height <= 235 && right <= 322 && down <= 239) 
    {
      obj.style.height = height + 7 + 'px';
      obj.style.width = width + 8 + 'px';
    }
  }
  else if (event.keyCode == 45)
  {
    if (width >= 120 && height >= 60 && left >= 0)
    {
      obj.style.height = height - 7 + 'px';
      obj.style.width = width - 8 + 'px'; 
    }
  }
}

var objLeft = 0;
var objDown = 0;

function anim(event)
{
  var object = document.getElementById('myImg');

  var objwidth = object.offsetWidth;
  var objheight = object.offsetHeight;
  var objright = parseInt(objLeft) + parseInt(objwidth);
  var objdown = parseInt(objDown) + parseInt(objheight);

  if (event.keyCode == 39) 
  {
    objLeft += 2;
    object.style.marginLeft = objLeft + 'px';
    if (objright >= 322)
    objLeft -=2; 
  }
  else if (event.keyCode == 37) 
  {
    objLeft -= 2;
    object.style.marginLeft = objLeft + 'px';
    if (objLeft <= 0)
    objLeft +=2; 
  }
  else if (event.keyCode == 40) 
  {
    objDown += 2;
    object.style.marginTop = objDown + 'px';
    if (objdown >= 240)
      objDown -=2;
  }
  else if (event.keyCode == 38)
  {
    objDown -= 2;
    object.style.marginTop = objDown + 'px';
    if (objDown <= 0)
      objDown +=2;
  }
}
document.onkeydown = anim;
document.onkeypress = changesize;

function checkName(event, el) {
  var ar_ext = ['png', 'gif', 'jpeg', 'jpg']; 
  var name = el.value;
  var ar_name = name.split('.');
  var re = 0;
  for(var i=0; i<ar_ext.length; i++) {
    if(ar_ext[i] == ar_name[1]) {
      re = 1;
      break;
    }
  }
  if (re == 1) 
  {
    var output = document.getElementById("upload");
    var video = document.getElementById("video");
    video.style.visibility = "hidden"; 
    output.setAttribute("class", "shown");
    output.src = window.URL.createObjectURL(event.target.files[0]);
    video.setAttribute("class", "hidden");
  }
  else 
  {
    el.value = '';
    alert('".'+ ar_name[1]+ '" is not an extension file type allowed for upload');
  }
}