<?php
session_start();
require_once "config/setup.php";
connect();
$login = $_SESSION['login'];
$filename = $_POST['pic_name'];
$req = "DELETE FROM pictures WHERE pic_filename = ?";
$query = $bdd->prepare($req);
$result = $query->execute( array($filename) );
$query->closeCursor();
$filename = 'images/'.$filename;
unlink($filename);
header('location: '.$_SERVER['HTTP_REFERER']);
?>
