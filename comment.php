<?php
session_start();
include "config/setup.php";

if($_POST['comment'] && $_POST['submit'] === "Add this comment")
{
	$comment = htmlentities($_POST['comment'], ENT_QUOTES, "UTF-8");
	$login = $_SESSION['login'];
	$email_pic = $_POST['email'];
	$login_pic = $_POST['login_pic'];
	$pic_name = $_POST['pic_name'];
	$rand = rand(100000,100000000);
	connect();
	$req =  "INSERT INTO comments(com_login, comment, pic_name, com_confirmation_code, active) VALUES( :com_login, :comment, :pic_name, :com_confirmation_code, :active)";
	$query = $bdd->prepare($req);
	$result = $query->execute( array( ':com_login'=>$login, ':comment'=>$comment, ':pic_name'=>$pic_name, ':com_confirmation_code'=>$rand, ':active'=>0 ) );
	if ($result)
	{
		header( "refresh:10;url=photos.php");
		mail_comment($email_pic, $login_pic, $rand, $comment, $pic_name);
		include "header.php";
		echo '
		<html>
		<body>
		<div class="pic">
		<center>
		<h1>Thank You For Your Comment!</h1>
		</br>
		</br>
		<img src="http://montreux.eerv.ch/wp-content/uploads/sites/139/2015/05/pouce.png">
		</br>
		</br>
		<h2>An email has been sent to the picture\'s owner</h2>
		</br>
		<p>Your comment will appear on this page only once he/she approves it</p>
		</div>
		</body>
		</html>';
	}
	$query->closeCursor();
}
else
	header('location: '.$_SERVER['HTTP_REFERER']);

if ($_POST['submit'] === "Add a like")
{
	$pic_name = $_POST['pic_name'];
	$login = $_SESSION['login'];
	connect();
	$firstreq = "SELECT * FROM likes WHERE like_login=? AND pic_name=?";
	$firstquery = $bdd->prepare($firstreq);
	$res = $firstquery->execute( array( $login, $pic_name) );
	if ($firstquery->rowCount() == 0)
    {
		$req = "INSERT INTO likes(like_login, pic_name) VALUES( :like_login, :pic_name)";
		$query = $bdd->prepare($req);
		$result = $query->execute( array( ':like_login'=>$login, ':pic_name'=>$pic_name) );
		header('location: '.$_SERVER['HTTP_REFERER']);
	}
	else
		header('location: '.$_SERVER['HTTP_REFERER']);
	$firstquery->closeCursor();
	$query->closeCursor();
}

function mail_comment($email_pic, $login_pic, $rand, $comment, $pic_name)
{
	$subject = "Comment waiting for your approval";
	$headers = 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n" . 'From: noreply@camagru.com' . "\r\n" . 'X-Mailer: PHP/' .phpversion();
	$message = '
	<html>
	<body>
	<table class="w580" width="580" cellpadding="0" cellspacing="0" border="0">
    <tr>
    <td class="w580" width="580">
    <h2 style="color:#0E7693; font-size:22px; padding-top:12px;"> Comment verification </h2>
    <div align="left" class="article-content">
    <p>Hi '.$login_pic.'</p>
    <p>A new comment on one of your picture is waiting for your approval</p>
    <a href="http://localhost:8080/camagru/images/'.$pic_name.'">Click here to see the picture</a></br>
		
	<p><b>Comment:</b></br>
	<p>'.$comment.'</p></br>
	<a href="http://localhost:8080/camagru/approve.php?login='.$login_pic.'&email='.$email_pic.'&confirmation_code='.$rand.'">Approve this comment</a>
	</div>
    </td>
    </tr>
    <tr>
    <td class="w580" width="580" height="1" bgcolor="#c7c5c5"></td>
	</tr>
	</table>	
	</body>
	</html>';
	mail($email_pic, $subject, $message, $headers);
}