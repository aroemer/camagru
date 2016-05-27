<?php include "header.php" ?>
<HTML>
<HEAD>
	<TITLE>Create an Account</TITLE>
</HEAD>
<BODY>
<div class= "middle">
<h1>Create an account</h1>
	<div class ="formul">
	<form id="form" action="register.php" method="POST">
</br>
	
	  E-mail : <input type="email" name="email" value=""/>
			<br />
	  Login : <input type="text" name="login" size="30" /><br />
	  Password (min 8 characters) : <input type="password" name="passwd" size="30" /><br />
	  <input id="reset" type="submit" name="submit" value="Register" style="width: 223px;">
	</form>
	</div>
</div>
</BODY>
</HTML>
