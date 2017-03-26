<!DOCTYPE HTML>
<?php
session_start();
require_once "session.inc.php";
require_once "config.inc.php";

if(isset($_POST["add"]))
{
	require_once "session.admin.inc.php";

	$sql="INSERT INTO poule (type, katatype, tournament) VALUES (:type, :katatype, :idTournament)";
	$result = $db->prepare($sql);
	$result->bindValue(':type', "A");
	$result->bindValue(':katatype', $_POST["katatype"]);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
	
	$sql="INSERT INTO poule (type, katatype, tournament) VALUES (:type, :katatype, :idTournament)";
	$result = $db->prepare($sql);
	$result->bindValue(':type', "B");
	$result->bindValue(':katatype', $_POST["katatype"]);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
	
	$sql="INSERT INTO poule (type, katatype, tournament) VALUES (:type, :katatype, :idTournament)";
	$result = $db->prepare($sql);
	$result->bindValue(':type', "F");
	$result->bindValue(':katatype', $_POST["katatype"]);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
	
}
if(isset($_POST["delete"]))
{
	require_once "session.admin.inc.php";
	//controllo che non ci siano iscritti
	//è il katatype
	$sql="SELECT COUNT(*) AS count FROM judoka WHERE katatype = :katatype AND tournament = :idTournament";
	$result = $db->prepare($sql);
	$result->bindValue(':katatype', $_POST["delete"]);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	if($row["count"]==0)
	{
		//$sql="DELETE FROM kata WHERE idKata='".$_POST["delete"]."'";
		$sql="DELETE FROM poule WHERE katatype = :katatype AND tournament = :idTournament";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':katatype', $_POST["delete"]);
		$stmt->bindValue(':idTournament', $_SESSION["idTournament"]);
		$stmt->execute();
	}
	else
	{
		?>
		<script type="text/javascript">
		alert('Poule not empty!\nDelete registrations');
		</script>
		<?php
	}
}
?>

<html>
<head>
<title>Kata</title>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<!--fancybox-->
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="searchFlag.js"></script>
<script type="text/javascript" src="kata.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">

</head>

<body onload="checkDraw()" onFocus="checkDraw();">

<?php
require_once "top.php";
require_once "banner.php";
?>
	<p>
		<b>kata list</b>
		<?php
		if($_SESSION["user_level"]=="1")
		{
			?>
			<a target='_blank' href='phpexcel/importPreRegistered.php'>import from excel</a>
			<?php
		}
		?>
	</p>
	<form method="post">
	<table>

	<tr>
		<td width='150'>name</td>
		<td align='center' colspan='2'>registration</td>
		<td align='center'>draw</td>
		<td colspan='3' align='center'>form</td>
		<?php
		if($_SESSION["user_level"]=="1") {
			?>
			<td></td>
			<?php
		}
		?>
	</tr>

	<?php

	$sql="SELECT idPoule,idKatatype,name FROM poule
		INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
		WHERE tournament = :idTournament
		GROUP BY katatype";
	$result = $db->prepare($sql);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
	
		echo "<tr>";
		echo "<td>".$row["name"]."</td>";
		$sqlCountJudoka="SELECT COUNT(*) AS cont FROM judoka WHERE katatype = :idKatatype AND tournament = :idTournament";
		$resultCountJudoka = $db->prepare($sqlCountJudoka);
		$resultCountJudoka->bindValue(':idKatatype', $row["idKatatype"]);
		$resultCountJudoka->bindValue(':idTournament', $_SESSION["idTournament"]);
		$resultCountJudoka->execute();
		$rowCountJudoka = $resultCountJudoka->fetch(PDO::FETCH_ASSOC);
		
		echo "<td align='center'>".$rowCountJudoka["cont"]."</td>";
		echo "<td align='center'><a href='registration.php?idKatatype=".$row["idKatatype"]."'><img src='image/list.png' title='registration' height='25' ></a></td>";
		//echo "<td align='center'><a href='drawPreliminary.php?idKatatype=".$row["idKatatype"]."' target='_blank'><img src='image/dadoAB.png' title='preliminary' height='25'></a></td>";
		//echo "<td align='center'><a href='drawFinal.php?idKatatype=".$row["idKatatype"]."' target='_blank'><img src='image/dadoF.png' title='final' height='25'></a></td>";
		echo "<td align='center'><a href='draw.php?idKatatype=".$row["idKatatype"]."' onMouseOver='checkDraw(".$row["idKatatype"].")'><img src='image/dado.png' id='draw".$row["idKatatype"]."' name='draw' title='draw' height='25'></a></td>";
		
		$sqlPoule="SELECT idPoule,UPPER(type) AS type, mode FROM poule WHERE katatype = :idKatatype AND tournament = :idTournament ORDER BY type";
		$resultPoule = $db->prepare($sqlPoule);
		$resultPoule->bindValue(':idKatatype', $row["idKatatype"]);
		$resultPoule->bindValue(':idTournament', $_SESSION["idTournament"]);
		$resultPoule->execute();
		while($rowPoule = $resultPoule->fetch(PDO::FETCH_ASSOC))
		{
			//echo "<td><a id='linkPoule".$rowPoule["idPoule"]."' href='poule.php?idPoule=".$rowPoule["idPoule"]."' >".$rowPoule["type"]."</a></td>";
			if($rowPoule["mode"] == 'F' and ($rowPoule["type"] == 'A' or $rowPoule["type"] == 'B'))
				echo "<td>&nbsp;&nbsp;</td>";
			elseif($rowPoule["mode"] == 'AF' and ($rowPoule["type"] == 'B'))
				echo "<td>&nbsp;&nbsp;</td>";
			else
				echo "<td><a id='linkPoule".$rowPoule["idPoule"]."' href='poule.php?idPoule=".$rowPoule["idPoule"]."' >".$rowPoule["type"]."</a></td>";
		}
		if($_SESSION["user_level"]=="1")
			echo "<td><button type='submit' name='delete' value='".$row["idKatatype"]."' onclick=\"return confirm('Confirm delete?')\">delete</button></td>";
		echo "</tr>";
	}
	?>

	</table>

	<?php
	if($_SESSION["user_level"]=="1")
	{
		?>
		<select name="katatype">
				<?php
				$sql="
				SELECT * FROM katatype WHERE idKatatype
				NOT IN (
				SELECT idKatatype FROM katatype
				INNER JOIN poule ON poule.katatype=katatype.idKatatype 
				WHERE tournament = :idTournament
				GROUP BY katatype)";
			
				$result = $db->prepare($sql);
				$result->bindValue(':idTournament', $_SESSION["idTournament"]);
				$result->execute();
				while($row = $result->fetch(PDO::FETCH_ASSOC))
					echo "<option value='".$row["idKatatype"]."'>".$row["name"]."</option>";
				?>
		</select>
		<input type="submit" name="add" value="add"/>
		<?php
	}
	?>
	</form>

</body>
</html>
