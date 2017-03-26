<!DOCTYPE HTML>

<?php
session_start();
require_once "../session.inc.php";
require_once "../config.inc.php";
?>

<html>
<head>
</head>
<body>
<?php


//seleziono tutti i kata della gara
$sql="SELECT idPoule,idKatatype,name FROM poule
		INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
		WHERE tournament = :idTournament
		GROUP BY katatype";
$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	echo "<table border='0'>";
	echo "<th colspan='4'>".$row["name"]."</th>";
	//seleziono il podio
	$sql="SELECT * FROM judoka
	INNER JOIN pair ON judoka.idJudoka=pair.judoka
	INNER JOIN poule ON pair.poule=poule.idPoule
	WHERE poule.type='F' AND poule.tournament = :idTournament AND poule.katatype = :katatype AND place<='3'
	ORDER BY place";
	$resultPodium = $db->prepare($sql);
	$resultPodium->bindValue(':idTournament', $_SESSION["idTournament"]);
	$resultPodium->bindValue(':katatype', $row["idKatatype"]);
	$resultPodium->execute();
	while($rowPodium = $resultPodium->fetch(PDO::FETCH_ASSOC))
	{
		echo "<tr>";
		echo "<td>".$rowPodium["place"]."</td>";
		echo "<td>".$rowPodium["namesurname"]."</td>";
		$sql="SELECT anthem FROM country_t WHERE ioc = :ioc";
		$resultAnthems = $db->prepare($sql);
		$resultAnthems->bindValue(':ioc', $rowPodium["country"]);
		$resultAnthems->execute();
		$rowAnthems = $resultAnthems->fetch(PDO::FETCH_ASSOC);

		echo "<td>".$rowPodium["country"]."</td>";
		echo "<td>";
		if($rowPodium["place"]=='1')
			echo "<audio src='../anthems/".$rowAnthems["anthem"]."' controls>  
			<p>Your browser does not support the audio element.</p>  
			</audio>";
		echo "</td>";
		echo "</tr>";
	}
	echo "</table><br>";
}

echo "<br><hr>";

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

//scorro tutte le nazioni e segno le medaglie 1|2|3
foreach($arrayAllCountry as $country)
{
	$str="";
	for($i=1; $i<=6; $i++)
	{
		$sql="SELECT count(*) AS cont FROM judoka
		INNER JOIN pair ON judoka.idJudoka=pair.judoka
		INNER JOIN poule ON pair.poule=poule.idPoule
		INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
		WHERE judoka.tournament = :idTournament AND poule.type='F' AND place='$i' AND country = :country
		GROUP BY country";
		$result = $db->prepare($sql);
		$result->bindValue(':idTournament', $_SESSION["idTournament"]);
		$result->bindValue(':country', $country);
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
echo "<br><br>";
echo "<table>";
echo "<tr>";
echo "<td> </td>";
echo "<td>1°</td>";
echo "<td>2°</td>";
echo "<td>3°</td>";
echo "<td>4°</td>";
echo "<td>5°</td>";
echo "<td>6°</td>";
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
	$sql="SELECT anthem FROM country_t WHERE ioc = :ioc";
	$result = $db->prepare($sql);
	$result->bindValue(':ioc', $arrayAllCountry[$i]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	echo "<td><audio src='../anthems/".$row["anthem"]."' controls>  
		<p>Your browser does not support the audio element.</p>  
		</audio></td>";
	echo "</tr>";
}
echo "</table>";
echo "<br><hr>";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//estraggo i punti
$sql="SELECT * FROM tournament WHERE idTournament = :idTournament";
$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
for($i=0; $i<$row["numCalculateClassPoint"]; $i++)
{
	$arrayConstPoint[(int)$i]=$row["classPoint".($i+1)];
}

//scorro tutte le nazioni e segno i punti
foreach($arrayAllCountry as $country)
{
	$val=0;
	$sql="SELECT place,count(*) AS cont FROM judoka
	INNER JOIN pair ON judoka.idJudoka=pair.judoka
	INNER JOIN poule ON pair.poule=poule.idPoule
	INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
	WHERE judoka.tournament = :idTournament AND poule.type='F' AND country = :country AND place < '99'
	GROUP BY country,place";
	$result = $db->prepare($sql);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->bindValue(':country', $country);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		$val += $row["cont"] * ($arrayConstPoint[(int)(($row["place"])-1)]);
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
echo "<br>";
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
