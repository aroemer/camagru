<?php
session_start();
include "config/setup.php";
include "header.php"; 
connect();
$pic_name = $_POST['pic_name'];
$req = "SELECT * FROM pictures WHERE pic_filename=?";
$que = $bdd->prepare($req);
$que->execute( array($pic_name));
if ($que->rowCount() > 0)
{
	?>
	<div class="middle">
    <?php
    while ($data = $que->fetch())
    { 
    	$email = $data['pic_email'];
    	$login_pic = $data['pic_login'];

    	?>
		<div id="block">
        <p style="text-align: center"><b> <?php echo $login_pic ?></b> posted: </p> 
		<img src=" images/<?php echo $pic_name ?>" id="bigpic">
        <?php
        $reqsql = "SELECT * FROM comments WHERE active='1' AND pic_name=? ORDER BY com_id ASC LIMIT 5";
        $query = $bdd->prepare($reqsql);
        $query->execute( array($pic_name));
        if ($query->rowCount() > 0)
        {
        	while ($com = $query->fetch())
            {   
                $com_login = $com['com_login'];
            ?>
                <div id="com" style="font-size: 0.8vw; max-font-size: 5px;">
            <?php 
                $request = "SELECT * FROM pictures WHERE pic_login=? ORDER BY pic_id DESC LIMIT 1";
                $quer = $bdd->prepare($request);
                $quer->execute( array($com_login));
                if ($quer->rowCount() > 0)
                {
                    while ($da = $quer->fetch())
                    { 
                        $pic_filename = $da['pic_filename'];
                    ?>
                        <img src=" images/<?php echo $pic_filename ?>" style="height: 2vw; width: 2vw; min-height: 40px; min-width: 40px;">
                    <?php
                    }
                }
                echo "<b>".$com_login."</b> commented: ".$com['comment']; ?>
            	</div>
            <?php
            }
            $query->closeCursor();
        }
        ?>
        </div>
        <form action="<?php echo $_SERVER['HTTP_REFERER'] ?>">
    	<input type="submit" style="margin-left: 60%; margin-top: 35px; height: 1.6vw; width: 8vw; min-height: 30px; min-width: 180px;" value="Go Back to Pictures">
		</form>
    <?php
    }
}
?>
</div>