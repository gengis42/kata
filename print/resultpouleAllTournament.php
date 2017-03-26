<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body onload="window.print(); //window.close();">
<?php
session_start();
require_once "../config.inc.php";
require_once "../function.php";

include_once "../timefunction.php"; //per banner
include_once "../function.php"; //per banner
require_once "../banner.php";


$sql="SELECT * FROM poule INNER JOIN katatype ON poule.katatype=katatype.idKatatype WHERE tournament = :tournament";
$result = $db->prepare($sql);
$result->bindValue(':tournament', $_SESSION["idTournament"]);
$result->execute();

$lastKataName = ""; //ultimo kata, serve a fare il page break
$break = false;
$count = 0;
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	$numJudges=$row["numJudges"];
	$idPoule=$row["idPoule"];

	//$sql="SELECT * FROM pair WHERE poule='".$idPoule."' ORDER BY place";
	$sql="SELECT * FROM pair INNER JOIN judoka ON judoka.idJudoka=pair.judoka WHERE poule = :poule ORDER BY place, numOrder";
	$resultPair = $db->prepare($sql);
	$resultPair->bindValue(':poule', $idPoule);
	$resultPair->execute();
	if($resultPair->rowCount() > 0)
	{
		
		if($count > 0 and $row["name"] != $lastKataName)
			echo "<p style='page-break-before: always'>";
		$lastKataName = $row["name"];
		$count++;
		
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
	}
	?>
<?php
}
?>

</body>
</html>
