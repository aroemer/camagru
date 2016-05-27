<?php include "config/setup.php";
if(!$_POST['email'] || $_POST['submit'] != "Send me reset instructions")
	header('location: forgot_pass.php');
else
{
	$email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
	connect();
	$req = "SELECT * FROM users WHERE email =?";
	$query = $bdd->prepare($req);
	$query->execute( array ($email));
	while ($data = $query->fetch())
	{
		$login = $data['login'];
		$rand = $data['confirmation_code'];
	}
	if ($query->rowCount() > 0)
	{
		header( "refresh:10;url=connexion.php");
		mail_password($email, $login, $rand);
		include "header.php";
					echo '
				<html>
				<HEAD>
					<TITLE>Password Forgotten</TITLE>
				</HEAD>
				<body>
				<div class="middle">
				<center>
				<h1>Well Done For Forgetting your Password!</h1>
				</br>
				</br>
				<img src="http://montreux.eerv.ch/wp-content/uploads/sites/139/2015/05/pouce.png">
				</br>
				</br>
				<h2>An email has been sent to this address: '.$email.'</h2>
				</br>
				<p>Please click on the link you received to reset your password</p>
				<a target="_blank" href="https://accounts.google.com/ServiceLogin?service=mail&passive=true&rm=false&continue=https://mail.google.com/mail/&ss=1&scc=1&ltmpl=default&ltmplcache=2&emr=1&osid=1#identifier"><img src="https://www.seeklogo.net/wp-content/uploads/2015/09/google-mail-logo-vector-download.jpg" title="Check My Emails" alt="Email" class="" style="height: 5vw; width: 5vw;"></a>
				<a target="_blank" href="https://login.live.com/login.srf?wa=wsignin1.0&rpsnv=12&ct=1462888764&rver=6.4.6456.0&wp=MBI_SSL_SHARED&wreply=https:%2F%2Fmail.live.com%2Fdefault.aspx%3Frru%3Dinbox&lc=1033&id=64855&mkt=en-us&cbcxt=mai"><img src="http://www.hotmail-iniciar.com/wp-content/uploads/2015/05/Hotmail-logo_3.jpg" title="Check My Emails" alt="Email" class="" style="height: 5vw; width: 5vw;"></a>
				</center>
				</div>
				</body>
				</html>';
	}
	else
	{
		include "header.php"; ?>
		<HTML>
		<HEAD>
			<TITLE>Email Error</TITLE>
		</HEAD>
		<BODY>
		<div class= "middle">
		<h1>Forgot your password?</h1>
		</br>
		Sorry, this email address is not valid. Try again!
		</br>
		</br>
		<form id="form" action="forgot.php" method="POST">
				<input type="email" name="email" value placeholder="Email address"/>
					<br />
		        <input id="reset" type="submit" name="submit" value="Send me reset instructions" style="width: 223px;" >
		</form>
		</div>

		</BODY>
		</HTML>
		<?php
	}
	$query->closeCursor();
}

function mail_password($email, $login, $rand)
{
	$subject = "Reset Your Password";
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
    <p>Someone has requested a link to change your password. You can do this through the link below.</p>
		<a href="http://localhost:8080/camagru/password.php?login='.$login.'&email='.$email.'&confirmation_code='.$rand.'">Change my password</a>
	<p>If you did not request this, please ignore this email</p>
	<p>Your password will not change until you access the link above and create a new one</p>
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