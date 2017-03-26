<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body onload="window.print(); //window.close();">

<?php
require_once "../config.inc.php";
require_once "../function.php";
session_start();
?>	
<table width='100%' class='logos'>
<tr class='logos'>
	<td class='logos' align='center' width='1%'><?php
	$sql="SELECT * FROM tournament WHERE idTournament = :idTournament";
	$result = $db->prepare($sql);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	$filelogoname = find("../image/tournamentlogos",$row["idTournament"].".*");
	if(count($filelogoname)==1)
		echo "<img src='".$filelogoname[0]."' height='100px'>";
	else
		echo "<img src='' height='100px'>";
	?>
	</td>
	<td class='logos' align='center'><?php
	
	$sql="SELECT * FROM tournament WHERE idTournament = :idTournament";
	$result = $db->prepare($sql);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	echo "<h1>".$row["name"]."</h1>";
	echo "<h2>".$row["place"]."</h2>";
	echo $row["date"];
	?></td>
</tr>
</table>

<?php

$sql="SELECT * FROM poule INNER JOIN katatype ON poule.katatype=katatype.idKatatype WHERE idPoule = :idPoule";
$result = $db->prepare($sql);
$result->bindValue(':idPoule', $_GET["idPoule"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
$numJudges=$row["numJudges"];
echo "<p>".$row["name"]." - <b>".$row["type"]."</b></p>";

?>
<table id="liveresult">
<tr>
	<td width='400' align='center'>judokas</td>
	<td colspan='2' align='center'>country</td>
	<td width='30' align='center'>1</td>
	<td width='30' align='center'>2</td>
	<td width='30' align='center'>3</td>
	<?php
	if($numJudges=="5")
	{
		echo "<td width='30' align='center'>4</td>";
		echo "<td width='30' align='center'>5</td>";
	}
	?>
	<td width='30' align='center'>tot</td>
	<td width='30' align='center'>place</td>
</tr>

<?php

$idPoule=$_GET["idPoule"];

//$sql="SELECT * FROM pair WHERE poule='".$idPoule."' ORDER BY place";
$sql="SELECT * FROM pair INNER JOIN judoka ON judoka.idJudoka=pair.judoka WHERE poule = :poule ORDER BY place, numOrder";
$result = $db->prepare($sql);
$result->bindValue(':poule', $idPoule);
$result->execute();
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	
	echo "<tr>";
	echo "<td>".$row["namesurname"]."</td>";
	echo "<td width='30' align='center'>".$row["country"]."</td>";
	////stampo bandiera
	if($row["enableFlag"]=="1")
	{
		$sql = "SELECT LOWER(iso2) AS iso2 FROM country_t WHERE ioc = :ioc";
		$rsd = $db->prepare($sql);
		$rsd->bindValue(':ioc', strtoupper($row["country"]));
		$rsd->execute();
		$rs = $rsd->fetch(PDO::FETCH_ASSOC);
		if($rs['iso2']==null) $src="../flag/blank.png";
		else $src="../flag/".$rs['iso2'].".png";
	}
	else
	{
		$src="../flag/blank.png";
		$buttonflag="-";
	}
	echo "<td width='30' align='center'><img src='$src' width='24' height='24' style='vertical-align:middle'></td>";
	//////
	echo "<td width='30' align='center'>".$row["score1"]."</td>";
	echo "<td width='30' align='center'>".$row["score2"]."</td>";
	echo "<td width='30' align='center'>".$row["score3"]."</td>";
	if($numJudges=="5")
	{
		echo "<td width='30' align='center'>".$row["score4"]."</td>";
		echo "<td width='30' align='center'>".$row["score5"]."</td>";
	}
	echo "<td width='30' align='center'>".$row["scoreTot"]."</td>";
	if($row["place"]=="99")
		$place="";
	else
		$place=$row["place"];
	echo "<td width='30' align='center'>".$place."</td>";
	echo "</tr>";
}
?>
<table>

</body>
</html>
