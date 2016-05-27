<?php 
session_start();
include "header.php" 
?>
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="index.css">
	<title>Camagru Home Page</title>
</HEAD>
<BODY>
<div class="block">    
        <h1>Take Great Pictures</h1>
        <h2>Millions of people use Camagru every day to have fun and take stunning pictures.</h2>

    	<div class="seperator"></div>
		<?php if (!$_SESSION['login'])
		{ ?>
    	<a href="first_register.php" id="reg">Register, It's Free!</a>
    	<?php } ?>
</div>
<center>
<div class= "index">
	<h1>Welcome to Camagru! </h1>
	</br>
	<?php if (!$_SESSION['login'])
	{ ?>
	Already Registered? Please Sign In
	</br>
	</br>
	<form id="form" action="login.php" method="POST">

        Login: <input type="text" name="login" value=""/>
        <br />
        Password: <input type="password" name="passwd" value=""/>
        <br />
        <input id="reset" type="submit" name="submit" value="Sign In" style="width: 223px;">
	</form>
</br>
<a href="forgot_pass.php">Forgot Password?</a>
</br>
	<div class="separator separator_login_page">
            <div class="middle_separator">or</div>
	</div>

	<a href="first_register.php" id="register">Register</a>
</br>
</br>
</br>
<?php
}
?>
<a href="photos.php"><img src="https://unsplash.global.ssl.fastly.net/assets/core/logo-black-b37a09de4a228cd8fb72adbabc95931c5090611a0cae8e76f1fd077d378ec080.svg" title="View pictures" alt="Picture" class=""></br>View Pictures</a>
</div>
</center>
</BODY>
</HTML>