<!DOCTYPE HTML>
<?php
session_start();
require_once "../session.admin.inc.php";
require_once "../config.inc.php";

if(isset($_POST["save"]))
{
	$sql="UPDATE judoka SET namesurname = :namesurname, country = :country WHERE idJudoka = :idJudoka";
	$result = $db->prepare($sql);
	$result->bindValue(':namesurname', $_POST["namesurname"]);
	$result->bindValue(':country', strtoupper($_POST["country"]));
	$result->bindValue(':idJudoka', $_POST["idJudoka"]);
	$result->execute();
	
	?>
	<script type='text/javascript'>
	parent.$.fancybox.close();
	</script>
	<?php
	die;
}

$sql="SELECT * FROM judoka WHERE idJudoka = :idJudoka";
$result = $db->prepare($sql);
$result->bindValue(':idJudoka', $_GET["idJudoka"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>

<form method='post'>
	<input type='text' name='namesurname' size='50' value="<?php echo $row["namesurname"]; ?>"/>
	<input type='text' name='country' value="<?php echo $row["country"]; ?>" size='3'/>
	<input type='hidden' name='idJudoka' value="<?php echo $row["idJudoka"]; ?>" size='3'/>
	<input type='submit' name='save' value='save'/>
</form>

<input type='button' name='cancel' value='cancel' onclick='parent.$.fancybox.close();'>
</body>
</html>
