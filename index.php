<!DOCTYPE HTML>
<?php
session_start();
require_once "config.inc.php";
require_once "timefunction.php";

if(isset($_POST["add"]))
{
	require_once "session.admin.inc.php";
	$sql="INSERT INTO tournament (name, place, date, numTatami) VALUES (:name, :place, :date, :numTatami)";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':name', $_POST["name"]);
	$stmt->bindValue(':place', $_POST["place"]);
	$stmt->bindValue(':date', $_POST["date"]);
	$stmt->bindValue(':numTatami', $_POST["numtatami"]);
	$stmt->execute();
	
}
if(isset($_POST["delete"]))
{
	require_once "session.admin.inc.php";
	$idTournament=$_POST["delete"];
	$sql="SELECT idPoule FROM poule WHERE tournament= :idTournament";	
	$resultPoule = $db->prepare($sql);
	$resultPoule->bindValue(':idTournament', $idTournament);
	$resultPoule->execute();
	while($rowPoule = $resultPoule->fetch(PDO::FETCH_ASSOC))
	{
		$sql="SELECT idPair,judoka FROM pair WHERE poule = :idPoule";
		$resultPair = $db->prepare($sql);
		$resultPair->bindValue(':idPoule', $rowPoule["idPoule"]);
		$resultPair->execute();
		while($rowPair = $resultPair->fetch(PDO::FETCH_ASSOC))
		{
			//elimino form
			$sql="DELETE FROM form WHERE pair = :idPair";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':idPair', $rowPair["idPair"]);
			$stmt->execute();
			
			$sql="DELETE FROM pair WHERE idPair = :idPair";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':idPair', $rowPair["idPair"]);
			$stmt->execute();
		}
	}
	$sql="DELETE FROM poule WHERE tournament = :idTournament";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':idTournament', $idTournament);
	$stmt->execute();
	
	//elimino abilitazioni giudici
	$sql="DELETE FROM ability WHERE judge IN (SELECT idJudge FROM judge WHERE tournament = :idTournament)";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':idTournament', $idTournament);
	$stmt->execute();
	
	//disassocio tutto i tablet
	$sql="UPDATE tablet SET judge = null WHERE judge IN (SELECT idJudge FROM judge WHERE tournament = :idTournament)";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':idTournament', $idTournament);
	$stmt->execute();
	
	//elimino judge
	$sql="DELETE FROM judge WHERE tournament = :idTournament";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':idTournament', $idTournament);
	$stmt->execute();
	
	//elimino i judoka
	$sql="DELETE FROM judoka WHERE tournament = :idTournament";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':idTournament', $idTournament);
	$stmt->execute();
	
	//elimino la gara
	$sql="DELETE FROM tournament WHERE idTournament = :idTournament";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':idTournament', $idTournament);
	$stmt->execute();
}
if(isset($_POST["select"]))
{
	$_SESSION["idTournament"] = $_POST["select"];

}

?>

<html>
<head>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<!--fancybox-->
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<link rel="stylesheet" type="text/css" href="style.css">
<script type='text/javascript'>
$(document).ready(function() {
	$(".editTournament").fancybox({
		'width'				: '75%',
		'height'			: '75%',
		'autoScale'			: true,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe',
		'onClosed': function()
		{
			//window.location.reload( false );
			window.location = window.location.href;
		}
	});
	
});
</script>

</head>
<body>
<?php
require_once "top.php";
?>

<center><h2>kata tournament manager</h2></center>


<?php

if(isset($_SESSION['login']))
{
	?>

	<form method="post">
	<table class='standard'>
	<tr>
		<td>name</td>
		<td>place</td>
		<td>date</td>
		<td>tatami</td>
		<td></td>
	</tr>

	<?php

	$sql="SELECT * FROM tournament ORDER BY idTournament DESC";
	$result = $db->query($sql);
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		if($row["idTournament"] == $_SESSION["idTournament"])
			$style = "background-color: #0000FF;";
		else
			$style = "";
			
		echo "<tr style='$style'>";
		//echo "<td><a href='tournament.php?idTournament=".$row["idTournament"]."'>".$row["name"]."</a></td>";
		echo "<td>".$row["name"];
		if($_SESSION["user_level"]=="1")
			echo "<a class='editTournament' href='edit/editTournament.php?idTournament=".$row["idTournament"]."'><img align='right' src='image/edit-icon.png' width='15' height='15'></a>";
		echo "</td>";
		echo "<td>".$row["place"]."</td>";
		echo "<td>".inputdataformat($row["date"])."</td>";
		echo "<td>".$row["numTatami"]."</td>";
		//echo "<td><button type='submit' name='open' value='".$row["idTournament"]."'>open</button>";
		//echo "<button type='submit' name='result' value='".$row["idTournament"]."'>live results</button>";
		echo "<td>";
		echo "<button type='submit' name='select' value='".$row["idTournament"]."'>select</button>";
		if($_SESSION["user_level"]=="1")
		{
			//echo "<button type='submit' name='settings' value='".$row["idTournament"]."'>settings</button>";
			echo "<button type='submit' name='delete' value='".$row["idTournament"]."' onclick=\"return confirm('Confirm delete?')\">delete</button></td>";
		}
		echo "</td>";
		echo "</tr>";
	}

	if($_SESSION["user_level"]=="1")
	{
		?>
		<tr>
			<td><input type="text" name="name"/></td>
			<td><input type="text" name="place"/></td>
			<td><input type="date" name="date"/></td>
			<td>
				<select name="numtatami">
				<?php
				for($i=1; $i<=12; $i++)
					echo "<option value='$i'>$i</option>";
				?>
				</select>
			</td>
			
			<td><input type="submit" name="add" value="add"/></td>
		</tr>
		<?php
	}
	?>
	</table>
	</form>
	
<?php
}
?>

<?php
include("logos.php");
?>
</body>
</html>
