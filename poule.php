<!DOCTYPE HTML>
<?php
session_start();
require_once "session.inc.php";
require_once "config.inc.php";
require_once "function.php";
if(isset($_POST["validatePair"]))
{
	validatePair($_POST["validatePair"]);
}
if(isset($_POST["invalidatePair"]))
{
	invalidatePair($_POST["invalidatePair"]);
}
if(isset($_POST["autoPlace"]))
{
	updateAndSavePoulePlace($_GET["idPoule"]);
}
if(isset($_POST["manualPlace"]))
{
	
	$idPair= $_POST['placeOrder'];
	$places= $_POST['place'];
	
	$sql="UPDATE pair SET place = :place WHERE idPair = :idPair";
    $result = $db->prepare($sql);
    for($i=0; $i < count($places); $i++)
    {
    	if($places[$i]=="")
    		$result->bindValue(':place', '99');
    	else
			$result->bindValue(':place', $places[$i]);
		$result->bindValue(':idPair', $idPair[$i]);
		$result->execute();
    }
}

/****************/

$sql="SELECT * FROM poule INNER JOIN katatype ON poule.katatype=katatype.idKatatype WHERE idPoule = :idPoule";
$result = $db->prepare($sql);
$result->bindValue(':idPoule', $_GET["idPoule"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
$numJudges=$row["numJudges"];
$stringKataName = $row["name"]." - <b>".$row["type"]."</b>";

?>

<html>
<head>
<title><?php echo $row["name"]." - ".$row["type"]; ?></title>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<!--fancybox-->
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script type="text/javascript" src="poule.js"></script>
<script type="text/javascript" src="searchFlag.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<?php
require_once "top.php";
require_once "banner.php";
//echo "<form method='post'>";
echo $stringKataName;
//echo "</form>";
?>

<form method="post">
<table border='0'>
<tr>
	<td width='400' align='center'>judokas</td>
	<td colspan='2' align='center'>country</td>
	<td align='center'>judges</td>
	<td width='30' align='center'>1</td>
	<td width='30' align='center'>2</td>
	<td width='30' align='center'>3</td>
	<?php
	if($numJudges=='5')
	{
		echo "<td width='30' align='center'>4</td>
		<td width='30' align='center'>5</td>";
	}
	?>
	<td width='30' align='center'>tot</td>
	<td width='30' align='center'>ranking</td>
	<td colspan='5'></td>
</tr>

<?php

$sql="SELECT * FROM pair INNER JOIN judoka ON pair.judoka=judoka.idJudoka WHERE poule = :poule ORDER BY numOrder";
$result = $db->prepare($sql);
$result->bindValue(':poule', $_GET["idPoule"]);
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
		if($rs['iso2']==null) $src="flag/blank.png";
		else $src="flag/".$rs['iso2'].".png";
		$buttonflag="x";
	}
	else
	{
		$src="flag/noflag.png";
		$buttonflag="-";
	}
	echo "<td width='30' align='center'><img src='$src' width='24' height='24' style='vertical-align:middle'></td>";
	//////link ai form
	echo "<td>";
	$sql="SELECT idForm,num,fcr, judge FROM form WHERE pair = :pair";
	$resultPair = $db->prepare($sql);
	$resultPair->bindValue(':pair', $row["idPair"]);
	$resultPair->execute();
	while($rowPair = $resultPair->fetch(PDO::FETCH_ASSOC))
	{
		//segno quelli già fatti
		if($rowPair["fcr"]!="" and $rowPair["judge"]!="") //non è ancora stato validato
			$link = "<span id='span".$rowPair["idForm"]."' style='color: #0F0;'>[".$rowPair["num"]."]</span>";
		else
			$link = "<span id='span".$rowPair["idForm"]."' style='color: #F00;'>[".$rowPair["num"]."]</span>";
		echo "<a href='form.php?idForm=".$rowPair["idForm"]."' target='_blank' onMouseOver='checkValidated(".$rowPair["idForm"].")'>$link</a> ";
	}
	echo "</td>";
	//////
	echo "<td align='center'>".$row["score1"]."</td>";
	echo "<td align='center'>".$row["score2"]."</td>";
	echo "<td align='center'>".$row["score3"]."</td>";
	if($numJudges=="5")
	{
		echo "<td align='center'>".$row["score4"]."</td>";
		echo "<td align='center'>".$row["score5"]."</td>";
	}
	echo "<td align='center'>".$row["scoreTot"]."</td>";
	if($row["place"]=="99")
		$place="";
	else
		$place=$row["place"];
	echo "<td align='center'><input type='text' name='place[]' value='".$place."' size='2'/><input type='hidden' name='placeOrder[]' value='".$row["idPair"]."'/></td>";
	echo "<td><a class='tablet' href='tablet/assign.php?idPair=".$row["idPair"]."'><img src='image/tablet.png' width='40'></a></td>";
	echo "<td><a target='_blank' href='print/printJudgeErrorForm.php?idPair=".$row["idPair"]."'><img src='image/print.png' width='30'></a></td>";
	echo "<td><a target='_blank' href='log/print_pair_log.php?idPair=".$row["idPair"]."'>Log</a></td>";
	echo "<td><button type='submit' name='validatePair' value='".$row["idPair"]."'>validate</button></td>";
	echo "<td><button type='submit' name='invalidatePair' value='".$row["idPair"]."' onclick='return confirm(\"sure?\")'>invalidate</button></td>";
	echo "</tr>";
}
?>

</table>

<p>

<input type="submit" name="manualPlace" value="manual ranking"/>
<input type="submit" name="autoPlace" value="auto ranking"/>

</form>
<a href="print/printAllPouleJudgeErrorForm.php?idPoule=<?php echo $_GET["idPoule"]; ?>" target='_blank'>print all completed forms</a>
<a href="phpexcel/exportKataPoule.php?idPoule=<?php echo $_GET["idPoule"]; ?>" target='_blank'>export to excel</a>

</body>
</form>
</html>