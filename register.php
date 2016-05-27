<?php
session_start();
include "config/setup.php";

if(!$_POST['email'] || !$_POST['login'] || !$_POST['passwd'] || $_POST['submit'] != "Register" || strlen($_POST['passwd']) < 8)
{
	header('location: err_register.php');
	exit;
}
else
{
	$email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
	$login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
	$passwd = htmlentities($_POST['passwd'], ENT_QUOTES, "UTF-8");
	$passwd = hash('whirlpool',$passwd);
	$rand=rand(100000,100000000);
	connect();
	$req = "SELECT id FROM users WHERE login =? OR email =?";
	$query = $bdd->prepare($req);
	$query->execute( array($login, $email) );
	if ($query->rowCount() > 0)
	{
		include 'header.php';?>
		<HTML>
		<BODY>
		<div class= "middle">
		<h1><?php echo "This login or email address is already used. "; ?> Please try another one!</h1>
		</br>
			<div class ="formul">
			<form id="form" action="register.php" method="POST">
			<p class="titre"> </p>
			  E-mail : <input type="email" name="email" value=""/>
					<br />
			  Login : <input type="text" name="login" size="30" /><br />
			  Password (min 8 characters) : <input type="password" name="passwd" size="30" /><br />
			  <input id="reset" type="submit" name="submit" value="Register" style="width: 223px;" />
			</form>
			</div>
		</div>
		</BODY>
		</HTML>
		<?php
	}
	else
	{
		$req =  "INSERT INTO users(email, login, passwd, confirmation_code, active) VALUES( :email, :login, :passwd, :confirmation_code, :active)";
		$query = $bdd->prepare($req);
		$result = $query->execute( array( ':email'=>$email, ':login'=>$login, ':passwd'=>$passwd, ':confirmation_code'=>$rand, ':active'=>0 ) );
		if ($result)
		{
			header( "refresh:10;url=connexion.php");
			mail_confirmation($email, $login, $rand);
			include "header.php";
			echo '
			<html>
			<body>
			<div class="middle">
			<center>
			<h1>Thank You For Registering!</h1>
			</br>
			</br>
			<img src="http://montreux.eerv.ch/wp-content/uploads/sites/139/2015/05/pouce.png">
			</br>
			</br>
			<h2>An email has been sent to this address: '.$email.'</h2>
			</br>
			<p>Please click on the link you received to confirm your account</p>
			<a target="_blank" href="https://accounts.google.com/ServiceLogin?service=mail&passive=true&rm=false&continue=https://mail.google.com/mail/&ss=1&scc=1&ltmpl=default&ltmplcache=2&emr=1&osid=1#identifier"><img src="https://www.seeklogo.net/wp-content/uploads/2015/09/google-mail-logo-vector-download.jpg" title="Check My Emails" alt="Email" class="" style="height: 5vw; width: 5vw;"></a>
			<a target="_blank" href="https://login.live.com/login.srf?wa=wsignin1.0&rpsnv=12&ct=1462888764&rver=6.4.6456.0&wp=MBI_SSL_SHARED&wreply=https:%2F%2Fmail.live.com%2Fdefault.aspx%3Frru%3Dinbox&lc=1033&id=64855&mkt=en-us&cbcxt=mai"><img src="http://www.hotmail-iniciar.com/wp-content/uploads/2015/05/Hotmail-logo_3.jpg" title="Check My Emails" alt="Email" class="" style="height: 5vw; width: 5vw;"></a>
			</center>
			</div>
			</body>
			</html>';
		}
		else
			echo "<p>Sorry, there has been a problem inserting your details. Please contact admin.</p>";
	}
	$query->closeCursor();
}

function mail_confirmation($email, $login, $rand)
{
	$subject = "Email confirmation";
	$headers = 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n" . 'From: noreply@camagru.com' . "\r\n" . 'X-Mailer: PHP/' .phpversion();
	$message = '
	<html>
	<body>
	<table class="w580" width="580" cellpadding="0" cellspacing="0" border="0">
    <tr>
    <td class="w580" width="580">
    <h2 style="color:#0E7693; font-size:22px; padding-top:12px;"> Account verification  </h2>
    <div align="left" class="article-content">
    <p>Hi '.$login.'</p>
    <p>Please click on the below link to verify your account</p>
		<a href="http://localhost:8080/camagru/confirmation.php?login='.$login.'&email='.$email.'&confirmation_code='.$rand.'">Confirm my account</a>
	<p>You will not have access to camagru until you click on the above link</p>
	</div>
    </td>
    </tr>
    <tr>
    <td class="w580" width="580" height="1" bgcolor="#c7c5c5"></td>
	</tr>
	</table>	
	</body>
	</html>';
	mail($email, $subject, $message, $headers);
}
?>
