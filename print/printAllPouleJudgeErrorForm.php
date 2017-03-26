<!DOCTYPE HTML>
<?php
session_start();
require_once "../session.inc.php";
require_once "../config.inc.php";
require_once "../function.php";

?>

<html>
<head>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="../style.css">

<?php

 $sql="SELECT * FROM form INNER JOIN pair ON form.pair=pair.idPair INNER JOIN poule ON pair.poule=poule.idPoule INNER JOIN katatype ON poule.katatype=katatype.idKatatype WHERE  idPoule = :idPoule";
        $result = $db->prepare($sql);
        $result->bindValue(':idPoule', $_GET["idPoule"]);
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        echo "<title>".$row["name"]."_".$row["type"]."</title>";
?>

</head>
<body>

<?php

$sql="SELECT idForm FROM form INNER JOIN pair ON form.pair = pair.idPair WHERE poule = :poule ORDER BY place";
$resultPair = $db->prepare($sql);
$resultPair->bindValue(':poule', $_GET["idPoule"]);
$resultPair->execute();
while($rowPair = $resultPair->fetch(PDO::FETCH_ASSOC))
{
	$numTechniques=getNumTechniquesFromIdForm($rowPair["idForm"]);
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
		<td></td>
		<td align='center' style='font-size:9px;'>TECHNIQUES</td>
		<td align='center' style='font-size:9px;' colspan='2' width='100'>Small<br>Mistakes</td>
		<td align='center' style='font-size:9px;' width='50'>Medium<br>Mistakes</td>
		<td align='center' style='font-size:9px;' width='50'>Big / Wrong<br>technique</td>
		<td align='center' style='font-size:9px;' width='50'>Forgotten<br>technique</td>
	</tr>
	<?php
	
	$countSmall = 0;
	$countMedium = 0;
	$countBig = 0;
	$countForgotten = 0;
	
	$arrayNames=getArrayKataFromIdForm($rowPair["idForm"]);
	$sql="SELECT * FROM form WHERE idForm = :idForm";
	$result = $db->prepare($sql);
	$result->bindValue(':idForm', $rowPair["idForm"]);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		//$id=$row['idForm'];
		$fcr=$row["fcr"];
		for($id=1; $id<=$numTechniques; $id++)
		{
			$vetPoint=$row['p'.$id];
			if(strlen($vetPoint)==5)
			{
				$point1=substr($vetPoint,0,1);
				$point2=substr($vetPoint,1,1);
				$point3=substr($vetPoint,2,1);
				$point4=substr($vetPoint,3,1);
				$point5=substr($vetPoint,4,1);
			}
			else
			{
				$point1=$point2=$point3=$point4=$point5=0;
			}
		
			//imposto le immagini in base al punteggio e sommo i punti
			if($point1==0) $image1="../image/correct.png";
			else
			{
				$image1="../image/wrong.png";
				$countSmall++;
			}
			if($point2==0) $image2="../image/correct.png";
			else
			{
				$image2="../image/wrong.png";
				$countSmall++;
			}
			if($point3==0) $image3="../image/correct.png";
			else
			{
				$image3="../image/wrong.png";
				$countMedium++;
			}
			if($point4==0) $image4="../image/correct.png";
			else
			{
				$image4="../image/wrong.png";
				$countBig++;
			}
			if($point5==0) $image5="../image/correct.png";
			else
			{
				$image5="../image/wrong.png";
				$countForgotten++;
			}
		?>
			
			<tr id="tr_<?php echo $id; ?>" class="edit_tr">

			<td class="edit_td">
			<!--<span id="point_<?php echo $id; ?>" class="text"><?php echo $point; ?></span>-->
			<input type="hidden" name="point1_<?php echo $id; ?>" id="point1_<?php echo $id; ?>" class="text" value="<?php echo $point1; ?>"/>
			<input type="hidden" name="point2_<?php echo $id; ?>" id="point2_<?php echo $id; ?>" class="text" value="<?php echo $point2; ?>"/>
			<input type="hidden" name="point3_<?php echo $id; ?>" id="point3_<?php echo $id; ?>" class="text" value="<?php echo $point3; ?>"/>
			<input type="hidden" name="point4_<?php echo $id; ?>" id="point4_<?php echo $id; ?>" class="text" value="<?php echo $point4; ?>"/>
			<input type="hidden" name="point5_<?php echo $id; ?>" id="point5_<?php echo $id; ?>" class="text" value="<?php echo $point5; ?>"/>
			<?php echo $id; ?>
			</td>
			<!--stampo nomi delle tecniche-->
			<td align='right'><?php echo $arrayNames[$id-1]; ?></td>
			<td align='center'><img id="img1_<?php echo $id; ?>" src="<?php echo $image1; ?>"></td>
			<td align='center'><img id="img2_<?php echo $id; ?>" src="<?php echo $image2; ?>"></td>
			<td align='center'><img id="img3_<?php echo $id; ?>" src="<?php echo $image3; ?>"></td>
			<td align='center'><img id="img4_<?php echo $id; ?>" src="<?php echo $image4; ?>"></td>
			<td align='center'><img id="img5_<?php echo $id; ?>" src="<?php echo $image5; ?>"></td>
			<td align='center'><?php echo convertStringZerotoPoint($vetPoint); ?></td>
			</tr>
		<?php
		}
	}

	?>
	<!----------fcr----------------->

	<tr>
	<td></td>
	<td><?php echo $arrayNames[$numTechniques];?></td>
	<td colspan='5' align='right'>
		<?php
		echo $fcr;
		?>
		</select>
	</td>
	</tr>

	<!-------conteggi-------------------->
	<tr>
	<td></td>
	<td align='right'>TOTAL</td>
	<td colspan='2' align='center'><?php echo $countSmall; ?></td>
	<td align='center'><?php echo $countMedium; ?></td>
	<td align='center'><?php echo $countBig; ?></td>
	<td align='center'><?php echo $countForgotten; ?></td>
	</tr>

	<?php
	if($fcr=="") $colorvalidate="background-color:red;";
	else $colorvalidate="background-color:green;";
	?>

	<tr style='<?php echo $colorvalidate;?>'>
		<td colspan='7' align='right'>
			<?php echo $total; ?>
		</td>
	</tr>

	</table>
	
	<div style='page-break-before: always'></div>
	<?php
}
?>

</body>

</html>
