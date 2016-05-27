<?php 
session_start();
include "config/setup.php";
if ($_SESSION['login'])
{
  include "header.php"; 
  $login = $_SESSION['login'];
  ?>
  <HTML>
  </br>
  <head>
  <title>Photo Capture Page</title>
  <meta charset='utf-8'>
  <link rel="stylesheet" href="index.css" type="text/css" media="all">
  </head>
  <BODY>
  <div class="wrapper">
    <nav>
    <p class="titre" style ="text-align: center;"> Select a picture</p>
    <img onclick="add('tablet');" src="images/tablet.png" style="width:160px;
    height: 100px; cursor: pointer;"/>
    <img onclick="add('Bear');" id="second" src="images/Bear.png" style="width:160px;
    height: 100px; cursor: pointer;"/>
    <img onclick="add('wtf');" src="images/wtf.png" style="width:160px;
    height: 100px; cursor: pointer;"/>
    <img onclick="add('mickey');" src="images/mickey.png" style="width:160px;
    height: 100px; cursor: pointer;"/>
    <img onclick="add('moustache');" src="images/moustache.png" style="width:160px;
    height: 100px; cursor: pointer;"/>
    <img onclick="add('chat');" src="images/chat.png" style="width:160px;
    height: 100px; cursor: pointer;"/>
    <img onclick="add('wanted');" src="images/wanted.png" style="width:160px;
    height: 100px; cursor: pointer;"/>
    </nav>
    <article>
    <center>
  <h1>
    <?php echo "Hi $login"; ?>
  </h1>
  <p>
    Let's Have Fun
  </p>
</br>  
    <img src =""  class ="hidden" id="upload">
    <img src="" class="hidden" id="myImg">
    <video id="video"></video>
    <canvas id="canvas"></canvas>

  </br>
  </br>

     <button name="startbutton" disabled id="startbutton" value="">Take a picture</button>
      </br>
      </br>
        
        <p style="text-align: center"> You don't have a webcam? Upload a picture (JPG, JPEG, PNG or GIF)</br></br></p>
        <div id='file_browse_wrapper'>
      <form method="post" action="" enctype="multipart/form-data">
      <input type='file' name='file' id='file' onchange="checkName(event, this)"/>
      </form>
      </div>
      </center>
      </article>
      <aside>

        <p id="lastpic">Your Last Pictures </p>
        <div id="pictu">
        <img src="" id="photo" class="hidden">
        <?php
        connect();
        $login = $_SESSION['login'];
        $email = $_SESSION['email'];
        $req = "SELECT * FROM pictures WHERE pic_login=? ORDER BY pic_id DESC LIMIT 6";
        $query = $bdd->prepare($req);
		    $query->execute( array($login));
		    if ($query->rowCount() > 0)
		    {
			     while ($data = $query->fetch())
			     {
				      $picname = $data["pic_filename"]; 
              ?>
              <img src=" images/<?php echo $data['pic_filename'] ?>" id="photo">
              <form method="post" action="deletepic.php">
              <button name="deletepic" id="deletepic" type="submit" value="Delete">Delete</button>
              <input type="hidden" name="pic_name" value="<?php echo $picname ?>"></input>
              </form>
              <?php
			     }
    	 }
?>
        </div>
      </aside>
    <script type="text/javascript" src="takeapic.js" media="all"></script>
    <script type="text/javascript" src="show.js"></script>
    <script type="text/javascript" src="ajax.js"></script>

<?php
}
else
{
  header( "refresh:7;url=index.php");
  include "header.php";
  ?> <div class="middle"> <?php
  echo "<h1>Register, It's Free and You will be able to have fun with Camagru</h1>";
  ?> </div> <?php
}
?>
</HTML>