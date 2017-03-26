<?php
session_start();
require_once "../../config.inc.php";
$idPoule=$_GET["idPoule"];

$sql="SELECT numJudges FROM poule WHERE idPoule = :idPoule";
$result = $db->prepare($sql);
$result->bindValue(':idPoule', $idPoule);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
$numJudges=$row["numJudges"];
?>

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
