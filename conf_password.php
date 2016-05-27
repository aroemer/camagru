<?php
require_once ("config/setup.php");
if(!$_POST['login'] || !$_POST['passwd'] || strlen($_POST['passwd']) < 8 || $_POST['submit'] != "Save")
{
	include "header.php";
	echo '
			<html>
			<head>
				<title>Password Confirmation</title>
			</head>
			<body>
			<div class="middle">
			<h1>Please fill in all the fields </h1>
			</br>
			<p>The new password should contain at least 8 characters</p>
			</br>
			<div class ="formul">
				<form id="form" action="conf_password.php" method="POST">
				<p class="titre"> </p>
				  E-mail: <input type="email" name="email" value="'.$email.'"/>
						<br />
				  Login : <input type="text" name="login" value="'.$login.'" size="30" /><br />
				  New Password (min 8 characters) : <input type="password" name="passwd" size="30" /><br />
				  <input id="reset" type="submit" name="submit" value="Save" style="width: 223px;" />
				</form>
				</div>
			</div>
			</body>
			</html>';
	exit;
}
else
{
	$login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
	$email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
	$new_passwd = htmlentities($_POST['passwd'], ENT_QUOTES, "UTF-8");
	$new_passwd = hash('whirlpool',$new_passwd);
	connect();
	$req = "UPDATE users SET active='1', passwd=? WHERE login=? AND email=?";
	$query = $bdd->prepare($req);
	$query->execute( array( $new_passwd, $login, $email) );
	if ($query->rowCount() > 0)
	{
		header( "refresh:5;url=main.php");
		include "header.php";
		echo '
			<html>
			<head>
				<title>Password confirmed</title>
			</head>
			<body>
			<div class="middle">
			<center>
			<h1>Congrats</h1>
			</br>
			</br>
			<h2>Your password has been changed</h2>
			</br>
			</br>
			<img src="http://montreux.eerv.ch/wp-content/uploads/sites/139/2015/05/pouce.png">
			</br>
			</br>
			</center>
			</body>
			</html>';
	}
	else
	{
		include "header.php";
		echo '
			<html>
			<head>
				<title>Connexion error</title>
			</head>
			<body>
			<div class="middle"> 
			<h1>Incorrect email or login</h1>
			</br>
			<p>Please try again</p>
			</br>
			<div class ="formul">
				<form id="form" action="conf_password.php" method="POST">
				<p class="titre"> </p>
				  E-mail: <input type="email" name="email" value="'.$email.'"/>
						<br />
				  Login : <input type="text" name="login" value="'.$login.'" size="30" /><br />
				  New Password (min 8 characters) : <input type="password" name="passwd" size="30" /><br />
				  <input id="reset" type="submit" name="submit" value="Save" style="width: 223px;" />
				</form>
				</div>
			</div>
			</body>
			</html>';
	}
	$query->closeCursor();
}
?>