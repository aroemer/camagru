<?php include "header.php"; ?>
<HTML>
<HEAD>
	<TITLE>Reset your Password</TITLE>
</HEAD>
<BODY>
<div class= "middle">
	<h1>Forgot your password?</h1>
	</br>
	Please Enter your email address below and we'll send you password reset instructions.
	</br>
	</br>
	<form id="form" action="forgot.php" method="POST">
		<input type="email" name="email" value placeholder="Email address"/>
		<br />
		<input id="reset" type="submit" name="submit" value="Send me reset instructions">
	</form>
</div>
</BODY>
</HTML>