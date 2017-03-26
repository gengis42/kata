<!DOCTYPE HTML>
<html>
<head></head>
<body>
<?php
session_start();
require_once "../session.inc.php";
require_once "../session.admin.inc.php";
require_once "../config.inc.php";

if(isset($_POST["judge"]))
{
	$sql="UPDATE tablet SET judge = NULL WHERE 1";
	$result = $db->exec($sql);
}

if(isset($_POST["form"]))
{
	$sql="UPDATE form SET tablet = NULL WHERE 1";
	$result = $db->exec($sql);

	$sql="UPDATE tgroup SET poule = NULL WHERE 1";
	$result = $db->exec($sql);
}

if(isset($_POST["group"]))
{
	$sql="UPDATE tablet SET tgroup = NULL, grouporder = NULL WHERE 1";
	$result = $db->exec($sql);
}
?>
<form method='post'>
reset association with
<input type='submit' name='judge' value='judge'/>

<br><br>

reset association with
<input type='submit' name='form' value='form'/>

<br><br>

reset 
<input type='submit' name='group' value='group'/>
</form>
</body>
</html>
