<!DOCTYPE HTML>
<html>
<head>
<style>

.columnNum1
{
	padding:5px;
	text-align: center;
}
.columnNum2
{
	padding:5px;
	text-align: center;
	vertical-align:middle;
}
.verticalDiv
{
	white-space: nowrap;
	display:block;
	text-align:center;
	width:20px;
	position:relative;
	
	-webkit-transform: rotate(-90deg);
	-moz-transform: rotate(-90deg);
    /*IE*/
    writing-mode: tb-rl;
    filter: flipv fliph;
}
.columnNum3
{
	text-align: right;
}
.hidden
{
	border: 0px;
}

td
{
	border: 1px solid black;
	padding:8px 5px 8px 5px;
	font-size:11px;
}
table
{
	border-collapse:collapse;
}
.normal
{
	border: 0px solid white;
	width:auto;
}

</style>
</head>
<body onload="//window.print(); //window.close();">
<?php
session_start();
include "../config.inc.php";

//quanti giudici???

/*$sql="SELECT numJudges FROM tournament WHERE idTournament = :idTournament";
$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
$numJudges=$row["numJudges"];
*/
if($_GET["type"]=='F')
	$type="(type='F')";
else
	$type="(type='A' OR type='B')";
//trovo tutti i judoka da stampare
$sql="SELECT * FROM judoka
INNER JOIN pair ON judoka.idJudoka=pair.judoka
INNER JOIN poule ON pair.poule=poule.idPoule
WHERE poule.katatype = :katatype AND poule.tournament = :idTournament AND $type
ORDER BY type, numOrder";
$result = $db->prepare($sql);
$result->bindValue(':katatype', $_GET["idKatatype"]);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();

while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	$numJudges=$row["numJudges"];
	$namesurname=$row["namesurname"];
	$country=$row["country"];
	$pouletype=$row["type"];
	
	for($i=0; $i<$numJudges; $i++)
	{
		$number=$i+1;
		switch($row["katatype"])
		{
			case "1":
				include "form/nage.php";
			break;
			case "2":
				include "form/katame.php";
			break;
			case "3":
				include "form/kime.php";
			break;
			case "4":
				include "form/juno.php";
			break;
			case "5":
				include "form/koshiki.php";
			break;
			case "6":
				include "form/kodokan.php";
			break;
			case "7":
				include "form/itsuzu.php";
			break;
			
			case "8":
				include "form/3nage.php";
			break;
			case "9":
				include "form/3katame.php";
			break;
			case "10":
				include "form/3kodokan.php";
			break;
		}
		
		if($i<$numJudges-1)
			echo "<p style='page-break-before: always'>";
	}
}
?>

</body>
</html>
