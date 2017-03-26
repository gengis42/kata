<?php
session_start();
include_once "../../config.inc.php";

$sql="SELECT indexLiveResult, liveResult FROM tournament WHERE idTournament = :idTournament";
$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);

$jsonArray = $row["liveResult"];
$phparray = json_decode($jsonArray);

if(count($phparray) == 0)
	die;

$index = $row["indexLiveResult"];

foreach($phparray[$index] as $poule) {
	
	$sql="SELECT name,type,numJudges FROM pair
		INNER JOIN poule ON pair.poule=poule.idPoule
		INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
		WHERE tournament = :idTournament AND idPoule = :idPoule
		GROUP BY idPoule
		ORDER BY type";
	$result = $db->prepare($sql);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->bindValue(':idPoule', $poule);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	$numJudges=$row["numJudges"];
	
	//$sqlPair="SELECT * FROM pair WHERE poule='".$row["idPoule"]."' ORDER BY place";
	$sqlPair="SELECT * FROM pair INNER JOIN judoka ON judoka.idJudoka=pair.judoka WHERE poule = :poule ORDER BY place, numOrder";
	$resultPair = $db->prepare($sqlPair);
	$resultPair->bindValue(':poule', $poule);
	$resultPair->execute();

	if($resultPair->rowCount() > 0)
	{
	
		echo $row["name"]." <b>".$row["type"]."</b>";
		?>
		<table>
		<tr>
			<td width='400' align='center'>judokas</td>
			<td colspan='2' align='center' width='70'>country</td>
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
		
		while($rowPair = $resultPair->fetch(PDO::FETCH_ASSOC))
		{
			echo "<tr>";
			echo "<td>".$rowPair["namesurname"]."</td>";
			echo "<td width='30' align='center'>".$rowPair["country"]."</td>";
			////stampo bandiera
			if($rowPair["enableFlag"]=="1")
			{
				$sql = "SELECT LOWER(iso2) AS iso2 FROM country_t WHERE ioc = :ioc";
				$rsd = $db->prepare($sql);
				$rsd->bindValue(':ioc', strtoupper($rowPair["country"]));
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
			echo "<td width='30' align='center' style='padding:2px'><img src='$src' width='24' height='20' style='vertical-align:middle;'></td>";
			//////
			echo "<td width='30' align='center'>".$rowPair["score1"]."</td>";
			echo "<td width='30' align='center'>".$rowPair["score2"]."</td>";
			echo "<td width='30' align='center'>".$rowPair["score3"]."</td>";
			if($numJudges=="5")
			{
				echo "<td width='30' align='center'>".$rowPair["score4"]."</td>";
				echo "<td width='30' align='center'>".$rowPair["score5"]."</td>";
			}
			echo "<td width='30' align='center'>".$rowPair["scoreTot"]."</td>";
			if($rowPair["place"]=="99")
				$place="";
			else
				$place=$rowPair["place"];
			echo "<td width='30' align='center'>".$place."</td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "<br>";
	}
}

//aggiorno index
$l = count($phparray) - 1;

if($index >= $l)
	$index = 0;
else
	$index++;

$sql="UPDATE tournament SET indexLiveResult = :indexLiveResult WHERE idTournament = :idTournament";
$result = $db->prepare($sql);
$result->bindValue(':indexLiveResult', $index);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();

?>
