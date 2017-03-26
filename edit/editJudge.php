<!DOCTYPE HTML>
<?php
session_start();
require_once "../session.admin.inc.php";
require_once "../config.inc.php";

if(isset($_POST["save"]))
{
	$sql="UPDATE judge SET name = :name, country = :country WHERE idJudge = :idJudge";
	$result = $db->prepare($sql);
	$result->bindValue(':name', $_POST["name"]);
	$result->bindValue(':country', strtoupper($_POST["country"]));
	$result->bindValue(':idJudge', $_POST["idJudge"]);
	$result->execute();
	
	//tolgo tutte le ability e gliele rimetto
	$sql="DELETE FROM ability WHERE judge = :idJudge";
	$result = $db->prepare($sql);
	$result->bindValue(':idJudge', $_POST["idJudge"]);
	$result->execute();
	
	//salvo solo quelle selezionate
	foreach ($_POST['ability'] as $value) {
		$sql="INSERT INTO ability (katatype, judge) VALUES (:katatype, :judge)";
		$result = $db->prepare($sql);
		$result->bindValue(':katatype', $value);
		$result->bindValue(':judge', $_POST["idJudge"]);
		$result->execute();
	}
	?>
	<script type='text/javascript'>
	parent.$.fancybox.close();
	</script>
	<?php
	die;
}

$sql="SELECT * FROM judge WHERE idJudge = :idJudge";
$result = $db->prepare($sql);
$result->bindValue(':idJudge', $_GET["idJudge"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>

<form method='post'>
	<label for="name">name</label>
	<input type='text' name='name' value="<?php echo $row["name"]; ?>"/>
	<label for="country">country</label>
	<input type='text' name='country' value="<?php echo $row["country"]; ?>"/>
	<input type='hidden' name='idJudge' value="<?php echo $row["idJudge"]; ?>" size='3' />
	
	<br><br>
	qualifications
	<br>
	<?php
	$sql="SELECT * FROM katatype";
	$result = $db->query($sql);
	while($row = $result->fetch(PDO::FETCH_ASSOC)){
		$sql="SELECT COUNT(*) AS conteggio FROM ability WHERE katatype = :katatype AND judge = :judge";
		$resultChecked = $db->prepare($sql);
		$resultChecked->bindValue(':katatype', $row["idKatatype"]);
		$resultChecked->bindValue(':judge', $_GET["idJudge"]);
		$resultChecked->execute();
		$rowChecked = $resultChecked->fetch(PDO::FETCH_ASSOC);
		if($rowChecked["conteggio"] > 0 )
			$checked = "checked='checked'";
		else
			$checked = "";
		echo "<input $checked type='checkbox' name='ability[]' value=\"".$row["idKatatype"]."\">".$row["name"]."<br>";
	}
	?>
	<br><br>
	<input type='submit' name='save' value='save'/>
</form>

<input type='button' name='cancel' value='cancel' onclick='parent.$.fancybox.close();'>
</body>
</html>
