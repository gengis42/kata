<!DOCTYPE HTML>

<?php
session_start();
require_once "session.inc.php";
require_once "config.inc.php";
require_once "function.php";
?>
<html>
<head>
	<title>Print</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
require_once "top.php";
require_once "banner.php";
?>
<p>
forms<br>
<a href='print/printForm.php?katatype=nage' target='_blank'>nage</a>
<a href='print/printForm.php?katatype=katame' target='_blank'>katame</a>
<a href='print/printForm.php?katatype=kime' target='_blank'>kime</a>
<a href='print/printForm.php?katatype=juno' target='_blank'>juno</a>
<a href='print/printForm.php?katatype=koshiki' target='_blank'>koshiki</a>
<a href='print/printForm.php?katatype=kodokan' target='_blank'>kodokan</a>
<a href='print/printForm.php?katatype=itsuzu' target='_blank'>itsuzu</a>

<a href='print/printForm.php?katatype=3nage1katame' target='_blank'>3nage+1katame</a>
<a href='print/printForm.php?katatype=3nage1ju' target='_blank'>3nage+1ju</a>
</p>

<hr>

<p>
classification<br>
<a href='print/medals.php' target='_blank'>medals</a>
<a href='print/club.php' target='_blank'>club</a>
</p>

<hr>

<p>
poule<br>
<table border='1'>
<?php
require_once "config.inc.php";
$sql="SELECT idKatatype,name FROM poule
	INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
	WHERE tournament = :idTournament
	GROUP BY katatype";
$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
echo "<tr>";
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	echo "<td>";
	echo $row["name"];
	$arrayIdKataType[]=$row["idKatatype"];
	echo "</td>";
}
echo "</tr>";
echo "<tr>";
foreach($arrayIdKataType as $idKatakype)
{
	echo "<td align='center'>";
	$sqlPoule="SELECT idPoule,type FROM poule WHERE katatype = :katatype AND tournament = :idTournament ORDER BY type";
	$resultPoule = $db->prepare($sqlPoule);
	$resultPoule->bindValue(':katatype', $idKatakype);
	$resultPoule->bindValue(':idTournament', $_SESSION["idTournament"]);
	$resultPoule->execute();
	while($rowPoule = $resultPoule->fetch(PDO::FETCH_ASSOC))
	{
		echo " <a href='print/resultpoule.php?idPoule=".$rowPoule["idPoule"]."' target='_blank'>".$rowPoule["type"]."</a>";
	}
	echo "</td>";
}
echo "</tr>";

echo "<tr>";
$count=0;
foreach($arrayIdKataType as $idKatakype)
{
	echo "<td align='center'>";
	echo "<a href='print/resultpouleABF.php?katatype=".$idKatakype."' target='_blank'>ABF</a>";
	echo "</td>";
	$count++;
}
echo "</tr>";

echo "<tr>";
echo "<td align='center' colspan='$count'>";
echo "<a href='print/resultpouleAllTournament.php' target='_blank'>all tournament</a>";
echo "</td>";
echo "</tr>";
	
//trovo i kata della gara
?>
<table>
</p>
</body>
</html>
