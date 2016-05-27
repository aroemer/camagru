<?php
session_start();
require_once "config/setup.php";
$login = $_SESSION['login'];
$email = $_SESSION['email'];
$filename = date('YmdHis') . '.jpg';
$filetime = date("Y-m-d H:i:s");
file_put_contents('images/' . $filename, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['data'])));
connect();
$req = "INSERT INTO pictures( pic_filename, pic_filedate, pic_login, pic_email) VALUES( :pic_filename, :pic_filedate, :pic_login, :pic_email)";
$query = $bdd->prepare($req);
$result = $query->execute( array( ':pic_filename'=>$filename, ':pic_filedate'=>$filetime, ':pic_login'=>$login, ':pic_email'=>$email) );
$query->closeCursor();
?>
