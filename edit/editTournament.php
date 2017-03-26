<!DOCTYPE HTML>
<?php
session_start();
require_once "../session.admin.inc.php";
require_once "../config.inc.php";
require_once "../timefunction.php";

if(isset($_POST["save"]))
{
	$sql="UPDATE tournament SET name = :name, place = :place, date = :date, numTatami = :numTatami WHERE idTournament = :idTournament";
	$result = $db->prepare($sql);
	$result->bindValue(':name', $_POST["name"]);
	$result->bindValue(':place', $_POST["place"]);
	$result->bindValue(':date', $_POST["date"]);
	$result->bindValue(':numTatami', $_POST["numtatami"]);
	$result->bindValue(':idTournament', $_POST["idTournament"]);
	$result->execute();
	?>
	<script type='text/javascript'>
	parent.$.fancybox.close();
	</script>
	<?php
	die;
}

$sql="SELECT * FROM tournament WHERE idTournament = :idTournament";
$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_GET["idTournament"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>

<form method='post'>
	<input type="text" name="name" value="<?php echo htmlentities($row["name"]); ?>"/>
	<input type="text" name="place" value="<?php echo htmlentities($row["place"]); ?>"/>
	<input type="date" name="date" value="<?php echo $row["date"]; ?>"/>
	<select name="numtatami">
	<?php
	for($i=1; $i<=12; $i++)
	{
		if($row["numTatami"]==$i)
			$selected='selected';
		else
			$selected='';
		echo "<option $selected value='$i'>$i</option>";
	}
	?>
	</select>
	<input type='hidden' name='idTournament' value='<?php echo $row["idTournament"]; ?>'/>
	<input type='submit' name='save' value='save'/>
</form>

<input type='button' name='cancel' value='cancel' onclick='parent.$.fancybox.close();'>
</body>
</html>
