<?php 
session_start();
include "config/setup.php";
include "header.php"; 
connect();

$picperpage = 10;

$request = "SELECT COUNT(*) AS total FROM pictures";
$query = $bdd->prepare($request);
$query->execute();
if ($query->rowCount() > 0)
{
    while ($data = $query->fetch())
    {
        $total = $data['total'];
    }
}
$nbpage=ceil($total/$picperpage);

if(isset($_GET['page']))
{
     $actualpage=intval($_GET['page']);
     if($actualpage>$nbpage)
          $actualpage=$nbpage;
}
else
     $actualpage=1;
$firstentry=($actualpage-1) * $picperpage;

$req = "SELECT * FROM pictures ORDER BY pic_id DESC LIMIT $firstentry, $picperpage";
$query = $bdd->prepare($req);
$query->execute();
if ($query->rowCount() > 0)
{
    ?>
    <div class="pic">
    <?php
    while ($data = $query->fetch())
    { 
    	$email = $data['pic_email'];
    	$login_pic = $data['pic_login'];
    	$pic_name = $data['pic_filename'];
    	?>
		<div id="block">
        <p style="text-align: center"><b> <?php echo $login_pic ?></b> posted: </p> 
		<img src=" images/<?php echo $data['pic_filename'] ?>" id="bigpic">
        <?php
        $reqbis = "SELECT COUNT(*) AS total FROM likes WHERE pic_name=?";
        $querybis = $bdd->prepare($reqbis);
        $querybis->execute( array($pic_name));
        if ($querybis->rowCount() > 0)
        {
            while ($databis = $querybis->fetch())
            {
                $totalbis = $databis['total'];
            }
            ?>
            <img src="https://techjoomla.com/cache/com_zoo/images/jlike_0110c7a06bb71e822e51e2856e577fda.png" style="height: 20px; width: 20px; margin-left: 45%; margin-top: 5px">
            <?php
            echo $totalbis;
        }
        if ($_SESSION['login'])
        {
            ?>
            <form id="form" action="comment.php" method="POST">
            <input type="textarea" name="comment" id="comment" value placeholder="Please type your comment"></input>
            <br />
            <input id="add" type="submit" name="submit" value="Add this comment">
            <input type="submit" id="like" name="submit" value="Add a like">
            <input type="hidden" name="email" value="<?php echo $email ?>"></input>
            <input type="hidden" name="login_pic" value="<?php echo $login_pic ?>"></input>
            <input type="hidden" name="pic_name" value="<?php echo $pic_name ?>"></input>
            </form>
            </br>
            <?php
        }
        $request = "SELECT COUNT(*) AS total FROM comments WHERE active='1' AND pic_name=?";
        $que = $bdd->prepare($request);
        $que->execute( array($pic_name));
        if ($que->rowCount() > 0)
        {
            while ($dat = $que->fetch())
            {
                $total = $dat['total'];
            }
            if ($total > 0)
            {
                ?>
                <form id="form" action="showcomments.php" method="POST">
                <input id="showcomment" type="submit" name="submit" value="Show <?php echo $total ?> comment(s)">
                <input type="hidden" name="email" value="<?php echo $email ?>"></input>
                <input type="hidden" name="login_pic" value="<?php echo $login_pic ?>"></input>
                <input type="hidden" name="pic_name" value="<?php echo $pic_name ?>"></input>
                </form>
                <?php
            }
            else
            {
                ?>
                <input id="hidecomment" type="submit" name="submit" value="">
                <?php
            }
        }
        $que->closeCursor();
        ?>
		</div>
		<?php 
    }
    $query->closeCursor();
}
echo '<p align="center">Page : ';
for($i = 1; $i <= $nbpage; $i++)
{
     if($i == $actualpage)
         echo ' [ '.$i.' ] '; 
     else
          echo ' <a href="photos.php?page='.$i.'">'.$i.'</a> ';
}
echo '</p>';
?>
</div>
<HEAD>
    <TITLE>Photo Album</TITLE>
</HEAD>