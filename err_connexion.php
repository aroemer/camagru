<?php include "header.php"; ?>
<HTML>
<HEAD>
	<TITLE>Connexion Error</TITLE>
</HEAD>
<BODY>
<div class= "middle">
<h1>Could not Sign In</h1>
</br>
<p><b> Incorrect login or password. Please Try again. </b></p>
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
</div>

</BODY>
</HTML>