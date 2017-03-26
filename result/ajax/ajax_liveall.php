<?php
session_start();
require_once "../../config.inc.php";
$idKatatype=$_GET["idKatatype"];
$type=$_GET["type"];

$sql="SELECT idPoule,idKatatype,name FROM poule
	INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
	WHERE tournament = :idTournament
	GROUP BY katatype";
$resultLive = $db->prepare($sql);
$resultLive->bindValue(':idTournament', $_SESSION["idTournament"]);
$resultLive->execute();
while($rowLive = $resultLive->fetch(PDO::FETCH_ASSOC))
{
	if($type=="AB")
	{
		//$type=" AND (poule.type='A' OR poule.type='B') ";
		$sql="SELECT idPoule,idKatatype,name,type,numJudges FROM pair
		INNER JOIN poule ON pair.poule=poule.idPoule
		INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
		WHERE tournament = :idTournament AND idKatatype = :idKatatype AND (poule.type='A' OR poule.type='B')
		GROUP BY idPoule
		ORDER BY type";
	}
	elseif($type=="F")
	{
		//$type=" AND (poule.type='F') ";
		$sql="SELECT idPoule,idKatatype,name,type,numJudges FROM pair
		INNER JOIN poule ON pair.poule=poule.idPoule
		INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
		WHERE tournament = :idTournament AND idKatatype = :idKatatype AND poule.type='F'
		GROUP BY idPoule
		ORDER BY type";
	}
	else //AB+F
	{
		//$type="";
		$sql="SELECT idPoule,idKatatype,name,type,numJudges FROM pair
		INNER JOIN poule ON pair.poule=poule.idPoule
		INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
		WHERE tournament = :idTournament AND idKatatype = :idKatatype
		GROUP BY idPoule
		ORDER BY type";
	}

	$result = $db->prepare($sql);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->bindValue(':idKatatype', $rowLive["idKatatype"]);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		$numJudges=$row["numJudges"];
		//stampo la tabella
		echo $row["name"]." ".$row["type"]."<br>";
		?>
		<table>
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
		$sqlPair="SELECT * FROM pair INNER JOIN judoka ON judoka.idJudoka=pair.judoka WHERE poule = :poule ORDER BY place, numOrder";
		$resultPair = $db->prepare($sqlPair);
		$resultPair->bindValue(':poule', $row["idPoule"]);
		$resultPair->execute();
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
			echo "<td width='30' align='center'><img src='$src' width='24' height='24' style='vertical-align:middle'></td>";
			//////
			echo "<td align='center'>".$rowPair["score1"]."</td>";
			echo "<td align='center'>".$rowPair["score2"]."</td>";
			echo "<td align='center'>".$rowPair["score3"]."</td>";
			if($numJudges=="5")
			{
				echo "<td align='center'>".$rowPair["score4"]."</td>";
				echo "<td align='center'>".$rowPair["score5"]."</td>";
			}
			echo "<td align='center'>".$rowPair["scoreTot"]."</td>";
			if($rowPair["place"]=="99")
				$place="";
			else
				$place=$rowPair["place"];
			echo "<td align='center'>".$place."</td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "<br>";
	}
}

?>
