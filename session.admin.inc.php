<?php
if(!(isset($_SESSION["user_level"])))
{
	//header("Location: index.php");
	header("location: http://".$_SERVER['HTTP_HOST']);
	echo "<meta http-equiv=\"Refresh\" content=\"0; index.php\">";
	die;
}

if((isset($_SESSION["user_level"]) and ($_SESSION["user_level"]!="1")))
{
	//header("Location: index.php");
	die;
}
?>
