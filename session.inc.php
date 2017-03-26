<?php
if( !(isset($_SESSION['login'])) and $_SESSION['login']!="kata")
{
	//header("Location: index.php");
	header("Location: http://".$_SERVER['HTTP_HOST']);
	echo "<meta http-equiv=\"Refresh\" content=\"0; index.php\">";
	die;
}

?>

