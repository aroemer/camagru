<?php
session_start();
require_once ("config/setup.php");
if (!$_GET['login'] || !$_GET['confirmation_code'] || !$_GET['email'])
	header('location: index.php');
else
{
	$login = $_GET['login'];
	$code = $_GET['confirmation_code'];
	$email = $_GET['email'];
	connect();
	$req = "SELECT * FROM users WHERE login=? AND email=? AND confirmation_code=? ";
	$query = $bdd->prepare($req);
	$query->execute( array($login, $email, $code) );
	if ($query->rowCount() == 1)
	{
		$req = "UPDATE users SET active='0', passwd='' WHERE login=? AND  email=? AND confirmation_code=?";
		$query = $bdd->prepare($req);
		$result = $query->execute( array($login, $email, $code));
		if ($result)
		{
			include "header.php";
			$_SESSION['login'] = $login;
			echo '
			<html>
			<HEAD>
			<TITLE>Password reset</TITLE>
			</HEAD>
			<body>
			<div class="middle"> 
			<h1>Your password has been reset successfully!</h1>
			<p>Please enter a new password</p>
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
			</body>';
		}
		else
			echo "<p>Sorry, there has been a problem reseting your password. Please contact admin.</p>";
	}
	else
		echo "error";
	$query->closeCursor();
}

?>