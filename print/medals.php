<!DOCTYPE HTML>
<html>
<head>
</head>
<body onload="window.print(); //window.close();">
<?php
session_start();
require_once "../config.inc.php";

//trovo tutte le nazioni che hanno partecipato
$sql="SELECT country FROM judoka
	INNER JOIN pair ON judoka.idJudoka=pair.judoka
	INNER JOIN poule ON pair.poule=poule.idPoule
	INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
	WHERE judoka.tournament = :idTournament
	GROUP BY country
	ORDER BY country";
$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	$arrayAllCountry[]=$row["country"];
}

//scorro tutte le nazioni e segno le medaglie 1|2|3|4|5|6
$sql="SELECT count(*) AS cont FROM judoka
INNER JOIN pair ON judoka.idJudoka=pair.judoka
INNER JOIN poule ON pair.poule=poule.idPoule
INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
WHERE judoka.tournament = :idTournament AND poule.type = :type AND place = :place AND country = :country
GROUP BY country";
$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->bindValue(':type', 'F');
foreach($arrayAllCountry as $country)
{
	$str="";
	
	$result->bindValue(':country', $country);
	
	for($i=1; $i<=6; $i++)
	{
		$result->bindValue(':place', $i);
		
		$result->execute();
		$row = $result->fetch(PDO::FETCH_ASSOC);
		if($row==null)
			$str.= "0";
		else
			$str.= $row["cont"];
		if($i!=6)
			$str.= "|";
	}
	$arrayMedalAll[]=$str;
}

//ordino tutto
for($i=0; $i<count($arrayMedalAll)-1; $i++)
{
	for($j=$i+1; $j<count($arrayMedalAll); $j++)
	{
		if(strcmp($arrayMedalAll[$i],$arrayMedalAll[$j])<0)
		{
			//scambio medaglie
			$temp=$arrayMedalAll[$i];
			$arrayMedalAll[$i]=$arrayMedalAll[$j];
			$arrayMedalAll[$j]=$temp;
			
			//scambio nazioni
			$temp=$arrayAllCountry[$i];
			$arrayAllCountry[$i]=$arrayAllCountry[$j];
			$arrayAllCountry[$j]=$temp;
		}
	}
}

//stampo
echo "<table>";
echo "<tr>";
echo "<td> </td>";
echo "<td width='50' align='center'>1°</td>";
echo "<td width='50' align='center'>2°</td>";
echo "<td width='50' align='center'>3°</td>";
echo "<td width='50' align='center'>4°</td>";
echo "<td width='50' align='center'>5°</td>";
echo "<td width='50' align='center'>6°</td>";
echo "</tr>";
for($i=0; $i<count($arrayMedalAll); $i++)
{
	//echo $arrayAllCountry[$i]." ".$arrayMedalAll[$i]."<br>";
	$vetMedals=explode("|",$arrayMedalAll[$i]);
	echo "<tr>";
	echo "<td>".$arrayAllCountry[$i]."</td>";
	echo "<td align='center'>".$vetMedals[0]."</td>";
	echo "<td align='center'>".$vetMedals[1]."</td>";
	echo "<td align='center'>".$vetMedals[2]."</td>";
	echo "<td align='center'>".$vetMedals[3]."</td>";
	echo "<td align='center'>".$vetMedals[4]."</td>";
	echo "<td align='center'>".$vetMedals[5]."</td>";
	echo "</tr>";
}
echo "</table>";
?>

</body>
</html>
