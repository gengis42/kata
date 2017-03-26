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


//estraggo i punti
$sql="SELECT * FROM tournament WHERE idTournament = :idTournament";
$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
for($i=0; $i<$row["numCalculateClassPoint"]; $i++)
{
	$arrayConstPoint[(int)$i]=(int)$row["classPoint".($i+1)];
}

//scorro tutte le nazioni e segno i punti
$sql="SELECT place,count(*) AS cont FROM judoka
INNER JOIN pair ON judoka.idJudoka=pair.judoka
INNER JOIN poule ON pair.poule=poule.idPoule
INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
WHERE judoka.tournament = :idTournament AND poule.type = :type AND country = :country AND place < :minPlace
GROUP BY country,place";
$result = $db->prepare($sql);
foreach($arrayAllCountry as $country)
{
	$val=0;
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->bindValue(':type', 'F');
	$result->bindValue(':country', $country);
	$result->bindValue(':minPlace', '99');
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		$val = $val + $row["cont"] * ($arrayConstPoint[(int)(($row["place"])-1)]);
	}
	
	$arrayPoint[]=$val;
}

//ordino tutto
for($i=0; $i<count($arrayPoint)-1; $i++)
{
	for($j=$i+1; $j<count($arrayPoint); $j++)
	{
		if($arrayPoint[$i] < $arrayPoint[$j])
		{
			//scambio punti
			$temp=$arrayPoint[$i];
			$arrayPoint[$i]=$arrayPoint[$j];
			$arrayPoint[$j]=$temp;
			
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
echo "<td>Point</td>";
echo "</tr>";
for($i=0; $i<count($arrayAllCountry); $i++)
{
	//echo $arrayAllCountry[$i]." ".$arrayMedalAll[$i]."<br>";
	echo "<tr>";
	echo "<td>".$arrayAllCountry[$i]."</td>";
	echo "<td align='center'>".$arrayPoint[$i]."</td>";
}
echo "</table>";
?>

</body>
</html>
