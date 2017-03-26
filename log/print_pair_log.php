<!DOCTYPE HTML>
<?php
session_start();
require_once "../session.inc.php";
require_once "../config.inc.php";

?>

<html>
<head>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="../style.css">

</head>
<body>

<?php

$sql="SELECT idForm FROM form WHERE pair = :pair";
$resultPair = $db->prepare($sql);
$resultPair->bindValue(':pair', $_GET["idPair"]);
$resultPair->execute();
while($rowPair = $resultPair->fetch(PDO::FETCH_ASSOC))
{
	//nome del kata
	$sql="SELECT * FROM form INNER JOIN pair ON form.pair=pair.idPair INNER JOIN poule ON pair.poule=poule.idPoule INNER JOIN katatype ON poule.katatype=katatype.idKatatype WHERE  idForm = :idForm";
	$result = $db->prepare($sql);
	$result->bindValue(':idForm', $rowPair["idForm"]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	echo "<p><b>".$row["num"]."</b> ".$row["name"]." - <b>".$row["type"]."</b></p>";
	$point=$row["p1"];
	$idKatatype = $row["idKatatype"];
	$total=$row["tot"];

	//nome della coppia
	$sql="SELECT namesurname FROM form INNER JOIN pair ON form.pair=pair.idPair INNER JOIN judoka ON pair.judoka=judoka.idJudoka WHERE idForm = :idForm";
	$result = $db->prepare($sql);
	$result->bindValue(':idForm', $rowPair["idForm"]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	echo "pairs: ".$row["namesurname"];

	?>
	<br>
	<?php
	$sql="SELECT judge.name AS name, judge.country FROM judge INNER JOIN form ON judge.idJudge=form.judge WHERE idForm = :idForm";
	$result = $db->prepare($sql);
	$result->bindValue(':idForm', $rowPair["idForm"]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	echo "judge: ".$row["name"]." ".$row["country"];
	?>

	<table id="score" name="score">
	<tr>
		<td align='center' style='font-size:9px;'>technique</td>
		<td align='center' style='font-size:9px;'>score</td>
		<td align='center' style='font-size:9px;'>time</td>
		<td align='center' style='font-size:9px;'>mac</td>
		
	</tr>
	<?php
	
	$sql="SELECT * FROM log WHERE form = :idForm";
	$result = $db->prepare($sql);
	$result->bindValue(':idForm', $rowPair["idForm"]);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		//$id=$row['idForm'];
		if($row["technique"] == 0)
			$technique = "fcr";
		else
			$technique = $row["technique"];

		echo "<tr>";
		echo "<td>".$technique."</td>";
		echo "<td>".$row["score"]."</td>";
		echo "<td>".$row["time"]."</td>";
		echo "<td>".$row["mac"]."</td>";
		echo "</tr>";
	}

	?>

	</table>
	
	<div style='page-break-before: always'></div>
	<?php
}
?>

</body>

</html>
