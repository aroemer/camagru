<?php session_start(); ?>
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="index.css">
</HEAD>
<BODY>
<div class="top-header">

		This is Camagru! 

		<ul id="menu">
		<li><a href="index.php">Home</a><ul></ul></li>
		<li><a href="photos.php">Pictures</a>
			<ul>
			<li><a href="photos.php">All Pictures</a></li>
			<?php 
				if($_SESSION['login'])
				{
			?>
					<li><a href="myphotos.php">My Pictures</a></li>
					<li><a href="main.php">Take New Pictures</a></li>
			</ul>
		</li>


				<?php
				}
				?>
</div>
	<div id="connexion">
	<?php 
	
		if($_SESSION['login'])
		{
			echo'<a class="connect" href="logout.php">Logout</a><span style="padding: 10px; color: white;">|</span>';
			echo'<a class="connect" href="myphotos.php">My pictures</a>';
		}
		else
		{
			echo'<a class="connect" href="connexion.php">Sign In</a><span style="padding: 10px; color: white;">|</span>';
			echo'<a class="connect" href="first_register.php">Register</a>';
		}
	?>
	</div>

</div>
</BODY>
<div class="footer">
    <p>
      Copyright 2016 | All Rights Reserved | © Audrey Roemer | Student @ 42
    </p>
</div>
</html>