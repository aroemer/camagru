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
	$req = "SELECT * FROM users WHERE login=? AND email=? AND confirmation_code=?";
	$query = $bdd->prepare($req);
	$query->execute( array( $login, $email, $code) );
	if ($query->rowCount() == 1)
	{
		$req = "UPDATE users SET active='1' WHERE login=? AND  email=? AND confirmation_code=?";
		$query = $bdd->prepare($req);
		$result = $query->execute( array( $login, $email, $code));
		if ($result)
		{
			$_SESSION['login'] = $login;
			$_SESSION['email'] = $email;
			header('location: main.php');
		}
		else
			echo "<p>Sorry, there has been a problem confirming your email. Please contact admin.</p>";
	}
	else
		header('location: index.php');
	$query->closeCursor();
}

?>
