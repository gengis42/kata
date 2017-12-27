<!DOCTYPE HTML>
<?php
session_start();
require_once "session.inc.php";
require_once "config.inc.php";
require_once "function.php";

if(isset($_POST["validate"]))
{
	if($_POST["judge"]=="")
		$judgeId = null;
	else
		$judgeId = $_POST["judge"];

	$str=null;
	for($i=1; $i<=23; $i++)
	{
		if(isset($_POST["point1_$i"])) {
            $score = "".$_POST["point1_$i"].$_POST["point2_$i"].$_POST["point3_$i"].$_POST["point4_$i"].$_POST["point5_$i"];
            if ($_POST["ph_$i"] == 0.5)
                $score .= "p";
            else if ($_POST["ph_$i"] == -0.5)
                $score .= "m";
            else
                $score .= "e";

            $str[] = $score;
        } else
			$str[] = null;
	}

	$sql="UPDATE form SET p1 = :p1, p2 = :p2, p3 = :p3, p4 = :p4, p5 = :p5, p6 = :p6, p7 = :p7, p8 = :p8, p9 = :p9, p10 = :p10, p11 = :p11, p12 = :p12, p13 = :p13,
	p14 = :p14, p15 = :p15, p16 = :p16, p17 = :p17, p18 = :p18, p19 = :p19, p20 = :p20, p21 = :p21, p22 = :p22, p23 = :p23, fcr = :fcr, judge = :judge
	WHERE idForm = :idForm";
	$result = $db->prepare($sql);
	$result->bindValue(':p1', $str[0]);
	$result->bindValue(':p2', $str[1]);
	$result->bindValue(':p3', $str[2]);
	$result->bindValue(':p4', $str[3]);
	$result->bindValue(':p5', $str[4]);
	$result->bindValue(':p6', $str[5]);
	$result->bindValue(':p7', $str[6]);
	$result->bindValue(':p8', $str[7]);
	$result->bindValue(':p9', $str[8]);
	$result->bindValue(':p10', $str[9]);
	$result->bindValue(':p11', $str[10]);
	$result->bindValue(':p12', $str[11]);
	$result->bindValue(':p13', $str[12]);
	$result->bindValue(':p14', $str[13]);
	$result->bindValue(':p15', $str[14]);
	$result->bindValue(':p16', $str[15]);
	$result->bindValue(':p17', $str[16]);
	$result->bindValue(':p18', $str[17]);
	$result->bindValue(':p19', $str[18]);
	$result->bindValue(':p20', $str[19]);
	$result->bindValue(':p21', $str[20]);
	$result->bindValue(':p22', $str[21]);
	$result->bindValue(':p23', $str[22]);
	$result->bindValue(':fcr', $_POST["fcr"]);
	$result->bindValue(':judge', $judgeId);
	$result->bindValue(':idForm', $_GET["idForm"]);
	$result->execute();
}
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>

<?php
$numTechniques=getNumTechniquesFromIdForm($_GET["idForm"]);
?>
<script type="text/javascript">
//warning!!!
var index=1;
var maxindex=<?php echo $numTechniques; ?>;

function initForm()
{
	$('#tr_'+index).css('background-color', '#0066FF');
	checkDuplicatedJudge('<?php echo $_GET["idForm"]; ?>', document.getElementById('judge').value);
}

</script>
<script type="text/javascript" src="form.js"></script>

</head>
<body onkeydown="keyboardEvents(event)" onload="initForm();">
<?php
//nome del kata
$sql="SELECT * FROM form INNER JOIN pair ON form.pair=pair.idPair INNER JOIN poule ON pair.poule=poule.idPoule INNER JOIN katatype ON poule.katatype=katatype.idKatatype WHERE  idForm = :idForm";
$result = $db->prepare($sql);
$result->bindValue(':idForm', $_GET["idForm"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
echo "<p><b>".$row["num"]."</b> ".$row["name"]." - <b>".$row["type"]."</b></p>";
$point=$row["p1"];
$idKatatype = $row["idKatatype"];

//nome della coppia
$sql="SELECT namesurname FROM form INNER JOIN pair ON form.pair=pair.idPair INNER JOIN judoka ON pair.judoka=judoka.idJudoka WHERE idForm = :idForm";
$result = $db->prepare($sql);
$result->bindValue(':idForm', $_GET["idForm"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
echo "pairs: ".$row["namesurname"];

?>
<form method='post'>
<br>
judge: <select id='judge' name='judge' onchange="checkDuplicatedJudge('<?php echo $_GET["idForm"]; ?>', this.value);alertJudge();this.blur();">
<option value=''>-</option>
<?php
	//leggo se è già stato impostato il judice
	$sql="SELECT * FROM form WHERE idForm = :idForm";
	$result = $db->prepare($sql);
	$result->bindValue(':idForm', $_GET["idForm"]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	$judge=$row["judge"];
	$total=$row["tot"];

	//$sql="SELECT * FROM judge WHERE tournament='".addslashes($_SESSION["idTournament"])."' ORDER BY name";
	$sql="SELECT idJudge, judge.name AS name FROM judge
		INNER JOIN ability ON judge.idJudge = ability.judge
		WHERE tournament = :idTournament AND ability.katatype = :katatype
		ORDER BY name";
	$result = $db->prepare($sql);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->bindValue(':katatype', $idKatatype);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		if($row["idJudge"]==$judge)
			$selected="selected";
		else
			$selected="";
		echo "<option $selected value='".$row["idJudge"]."'>".$row["name"]."</option>";
	}
	?>
</select>
<b><span id='alertJudge' style='color:red;'></span></b>

<table id="score" name="score">
<tr>
	<td></td>
	<td align='center' style='font-size:9px;'>TECHNIQUES</td>
	<td align='center' style='font-size:9px;' colspan='2' width='100'>Small<br>Mistakes</td>
	<td align='center' style='font-size:9px;' width='50'>Medium<br>Mistakes</td>
	<td align='center' style='font-size:9px;' width='50'>Big / Wrong<br>technique</td>
	<td align='center' style='font-size:9px;' width='50'>Forgotten<br>technique</td>
    <td align='center' style='font-size:9px;' width='50'>Halved<br>point</td>
</tr>
<?php

$arrayNames=getArrayKataFromIdForm($_GET["idForm"]);
$sql="SELECT * FROM form WHERE idForm = :idForm";
$result = $db->prepare($sql);
$result->bindValue(':idForm', $_GET["idForm"]);
$result->execute();
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	//$id=$row['idForm'];
	$fcr=$row["fcr"];
	for($id=1; $id<=$numTechniques; $id++)
	{
		$vetPoint=$row['p'.$id];
		if(strlen($vetPoint)==6)
		{
			$point1=substr($vetPoint,0,1);
			$point2=substr($vetPoint,1,1);
			$point3=substr($vetPoint,2,1);
			$point4=substr($vetPoint,3,1);
			$point5=substr($vetPoint,4,1);
            $halved=halvedStringToFloat(substr($vetPoint,5,1));

		}
		else
		{
			$point1=$point2=$point3=$point4=$point5=0;
            $halved = 0.0;
		}

		//imposto le immagini in base al punteggio
		if($point1==0) $image1="image/correct.png";
		else $image1="image/wrong.png";
		if($point2==0) $image2="image/correct.png";
		else $image2="image/wrong.png";
		if($point3==0) $image3="image/correct.png";
		else $image3="image/wrong.png";
		if($point4==0) $image4="image/correct.png";
		else $image4="image/wrong.png";
		if($point5==0) $image5="image/correct.png";
		else $image5="image/wrong.png";
	?>

		<tr id="tr_<?php echo $id; ?>" class="edit_tr">

		<td class="edit_td">
		<!--<span id="point_<?php echo $id; ?>" class="text"><?php echo $point; ?></span>-->
		<input type="hidden" name="point1_<?php echo $id; ?>" id="point1_<?php echo $id; ?>" class="text" value="<?php echo $point1; ?>"/>
		<input type="hidden" name="point2_<?php echo $id; ?>" id="point2_<?php echo $id; ?>" class="text" value="<?php echo $point2; ?>"/>
		<input type="hidden" name="point3_<?php echo $id; ?>" id="point3_<?php echo $id; ?>" class="text" value="<?php echo $point3; ?>"/>
		<input type="hidden" name="point4_<?php echo $id; ?>" id="point4_<?php echo $id; ?>" class="text" value="<?php echo $point4; ?>"/>
		<input type="hidden" name="point5_<?php echo $id; ?>" id="point5_<?php echo $id; ?>" class="text" value="<?php echo $point5; ?>"/>
            <input type="hidden" name="ph_<?php echo $id; ?>" id="ph_<?php echo $id; ?>" class="text" value="<?php echo $halved; ?>"/>
		<?php echo $id; ?>
		</td>
		<!--stampo nomi delle tecniche-->
		<td align='right'><?php echo $arrayNames[$id-1]; ?></td>
		<td align='center'><img id="img1_<?php echo $id; ?>" src="<?php echo $image1; ?>"></td>
		<td align='center'><img id="img2_<?php echo $id; ?>" src="<?php echo $image2; ?>"></td>
		<td align='center'><img id="img3_<?php echo $id; ?>" src="<?php echo $image3; ?>"></td>
		<td align='center'><img id="img4_<?php echo $id; ?>" src="<?php echo $image4; ?>"></td>
		<td align='center'><img id="img5_<?php echo $id; ?>" src="<?php echo $image5; ?>"></td>
        <td align='center'><div id="divh_<?php echo $id; ?>"><?php echo $halved; ?></td>
		<td align='center'><div id="pt_<?php echo $id; ?>"></div></td>
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
	<select id="fcr" name="fcr" autocomplete="off" onchange='updateCont()'>
	<?php
	for($i=10; $i>=0;$i--)
	{
		if($fcr==$i)
			$selected="selected";
		else
			$selected="";
		echo "<option $selected value='$i'>$i</option>";
	}
	?>
	</select>
</td>
</tr>

<!-------conteggi-------------------->
<tr>
<td></td>
<td align='right'>TOTAL</td>
<td colspan='2' align='center'><span id='contSmall'></span></td>
<td align='center'><div id='contMedium'></div></td>
<td align='center'><div id='contBig'></div></td>
<td align='center'><div id='contForgotten'></div></td>
</tr>

<?php
if($fcr=="" || $judge=="") $colorvalidate="background-color:red;";
else $colorvalidate="background-color:green;";
?>

<tr style='<?php echo $colorvalidate;?>'>
	<td colspan='7' align='right'>
		<label id='total'></label>
		<input type="submit" name="validate" value="validate"/>
	</td>
</tr>

</table>

</form>

<script type='text/javascript'>
updateCont();
alertJudge();
</script>

</body>

<p>Usa [1-5] per modificare gli errori e [qaz] per il mezzo punto.</p>

</html>
