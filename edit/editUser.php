<!DOCTYPE HTML>
<?php
session_start();
require_once "../session.admin.inc.php";
require_once "../config.inc.php";

if(isset($_POST["updatePasswd"]))
{
	if($_POST["password"] == $_POST["repeatpassword"] and $_POST["password"] != "")
	{
		$sql="UPDATE users SET password = :password WHERE userid = :userid";
		$result = $db->prepare($sql);
		$result->bindValue(':password', md5($_POST["password"]));
		$result->bindValue(':userid', $_POST["idUser"]);
		$result->execute();
		?>
		<script type='text/javascript'>
		parent.$.fancybox.close();
		</script>
		<?php
		die;
	}else{
		echo "error";
	}
}
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>

<form method='post'>
	<label for="password">password</label>
	<input type='password' name='password' value=""/>
	<br>
	<label for="repeatpassword">repeat</label>
	<input type='password' name='repeatpassword' value=""/>
	<br>
	<input type='hidden' name='idUser' value="<?php echo $_GET["idUser"]; ?>"/>
	<input type='submit' name='updatePasswd' value='update password'/>
</form>

<input type='button' name='cancel' value='cancel' onclick='parent.$.fancybox.close();'>
</body>
</html>
