<!DOCTYPE HTML>
<?php
session_start();
require_once "../session.inc.php";
require_once "../config.inc.php";
require_once "../function.php";

if(isset($_POST["closedraw"]))
{	
	require_once "../session.admin.inc.php";
	//estraggo gli id della finale
	$sql="SELECT idPoule FROM poule WHERE katatype = :katatype AND tournament = :idTournament AND type = :type";
	$result = $db->prepare($sql);
	$result->bindValue(':katatype', $_GET["idKatatype"]);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->bindValue(':type', 'F');
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	$idPouleF=$row["idPoule"];
	
	$vetJudoka=null;
	$vetNumOrder=null;
	$countRandomNum = $_POST["countRandomNum"];
	for($i=0; $i<$countRandomNum; $i++)
	{
		$vetJudoka[]=$_POST["idJudoka".$i];
		$vetNumOrder[]=$_POST["randomNum".$i];
	}
	
	$sql="INSERT INTO pair (judoka,poule,numorder,place) VALUES(:judoka, :poule, :numorder, :place)";
	$result = $db->prepare($sql);
	for($i=0; $i<count($vetJudoka); $i++)
	{
		$result->bindValue(':judoka', $vetJudoka[$i]);
		$result->bindValue(':poule', $idPouleF);
		$result->bindValue(':numorder', $vetNumOrder[$i]);
		$result->bindValue(':place', '99');
		$result->execute();
	}
	
	//aggiungo le form
	//inserisco le 3 o 5 schede
	//$sql="SELECT numJudges FROM tournament WHERE idTournament = :idTournament";
	$sql="SELECT numJudges FROM poule WHERE idPoule = :idPoule";
	$result = $db->prepare($sql);
	$result->bindValue(':idPoule', $idPouleF);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	$numJudges=$row["numJudges"];
	//estraggo tutti gli id delle pair
	$sql="SELECT idPair FROM pair 
	INNER JOIN poule ON pair.poule=poule.idPoule
	INNER JOIN katatype ON poule.katatype=katatype.idKatatype
	WHERE katatype = :katatype AND tournament = :idTournament AND type = :type
	ORDER BY numOrder";
	$result = $db->prepare($sql);
	$result->bindValue(':katatype', $_GET["idKatatype"]);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->bindValue(':type', 'F');
	$result->execute();
	//echo $sql;
	$sql="INSERT INTO form (num,pair) VALUES(:num, :pair)";
	$resultInsert = $db->prepare($sql);
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		for($i=1; $i<=$numJudges; $i++)
		{
			$resultInsert->bindValue(':num', $i);
			$resultInsert->bindValue(':pair', $row["idPair"]);
			$resultInsert->execute();
		}
	}
}
if(isset($_POST["deletedrawrequest"]))
{	
	require_once "../session.admin.inc.php";
	//non serve il controllo
	$sql="SELECT idForm FROM form
	INNER JOIN pair ON form.pair=pair.idPair
	INNER JOIN poule ON pair.poule=poule.idPoule
	WHERE katatype = :katatype AND tournament = :idTournament AND type = :type";
	$result = $db->prepare($sql);
	$result->bindValue(':katatype', $_GET["idKatatype"]);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->bindValue(':type', 'F');
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		$sql="DELETE FROM form WHERE idForm = :idForm";
		$resultDelete = $db->prepare($sql);
		$resultDelete->bindValue(':idForm', $row["idForm"]);
		$resultDelete->execute();
	}
	 
	//estraggo gli id dela finale
	$sql="SELECT idPoule FROM poule WHERE katatype = :katatype AND tournament = :idTournament AND type = :type";
	$result = $db->prepare($sql);
	$result->bindValue(':katatype', $_GET["idKatatype"]);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->bindValue(':type', 'F');
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);

	$idPoule = $row["idPoule"];
	
	//elimino
	$sql="DELETE FROM pair WHERE poule = :poule";
	$resultDelete = $db->prepare($sql);
	$resultDelete->bindValue(':poule', $idPoule);
	$resultDelete->execute();
	
	echo "DELETED FINAL";
}

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../style.css">
<script type="text/javascript" src="draw.js"></script>
</head>
<body onload='initCrono();'>


<?php
require_once "../top.php";
require_once "../banner.php";
?>
<form method='post'>
<?php

//stampo nome kata
$sql="SELECT * FROM katatype WHERE idKatatype = :idKatatype";
$result = $db->prepare($sql);
$result->bindValue(':idKatatype', $_GET["idKatatype"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
echo $row["name"]."<br>";

$validated=false;
$sql="SELECT * FROM form
INNER JOIN pair ON form.pair=pair.idPair
INNER JOIN poule ON pair.poule=poule.idPoule
WHERE katatype = :katatype AND tournament = :idTournament AND type = :type
GROUP BY type";
$resultValidate = $db->prepare($sql);
$resultValidate->bindValue(':katatype', $_GET["idKatatype"]);
$resultValidate->bindValue(':idTournament', $_SESSION["idTournament"]);
$resultValidate->bindValue(':type', 'F');
$resultValidate->execute();

if($resultValidate->rowCount()!=0)
	$validated=true;

if($_SESSION["user_level"]=="1")
{
	if(!$validated)
		echo "<input type='submit' name='closedraw' value='close draw'/>";
	else
		echo "<input type='submit' name='deletedrawrequest' value='delete draw' onclick=\"return confirm('Confirm delete?')\"/>";
}

if(!$validated)
{
	?>
	<table border='1'>
	<tr>
		<td width='400' align='center'>judokas</td>
		<td align='center' colspan='2'>country</td>
		<td align='center'></td>
	</tr>
	<?php
	if(isset($_POST["manualAdd"]))
	{
		echo "MANUAL";
		if($_POST["selection"]!="")
			$vetIdJudoka=explode(",",$_POST["selection"]);
		if($_POST["addManualId"]!="")
			$vetIdJudoka[]=$_POST["addManualId"];
	}
	elseif(isset($_POST["manualDelete"]))
	{
		echo "MANUAL";
		$vetIdJudoka=explode(",",$_POST["selection"]);
		$indice=$_POST["manualDelete"];
		$old=$vetIdJudoka;
		$vetIdJudoka=null;
		
		for($i=0; $i<count($old); $i++)
		{
			if($i!=$indice)
				$vetIdJudoka[]=$old[$i];
		}
	}
	else
	{
		$vetIdJudoka=null;
		//carico su array
		$sql="SELECT * FROM judoka 
		INNER JOIN pair ON judoka.idJudoka=pair.judoka
		INNER JOIN poule ON pair.poule=poule.idPoule
		WHERE poule.katatype = :katatype AND poule.tournament = :idTournament AND type = :type
		ORDER BY place
		LIMIT 6";
		$result = $db->prepare($sql);
		$result->bindValue(':katatype', $_GET["idKatatype"]);
		$result->bindValue(':idTournament', $_SESSION["idTournament"]);
		$result->bindValue(':type', 'A');
		$result->execute();
		while($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$vetIdJudoka[]=$row["idJudoka"];
			$lastplace=$row["place"];
			$lastPoint=$row["scoreTot"];
		}
		//prendo l'ultimo e lo confronto con il 7° se hanno lo stesso punteggio lo aggiungo
		$sql="SELECT * FROM judoka
		INNER JOIN pair ON judoka.idJudoka=pair.judoka
		INNER JOIN poule ON pair.poule=poule.idPoule
		WHERE poule.katatype = :katatype AND poule.tournament = :idTournament AND type = :type AND place > :place AND scoreTot = :scoreTot
		ORDER BY place
		LIMIT 1";
		$result = $db->prepare($sql);
		$result->bindValue(':katatype', $_GET["idKatatype"]);
		$result->bindValue(':idTournament', $_SESSION["idTournament"]);
		$result->bindValue(':type', 'A');
		$result->bindValue(':place', $lastplace);
		$result->bindValue(':scoreTot', $lastPoint);
		$result->execute();
		while($row = $result->fetch(PDO::FETCH_ASSOC))
			$vetIdJudoka[]=$row["idJudoka"];
	}
	$i=0;
	$sql="SELECT * FROM judoka WHERE idJudoka = :idJudoka";
	$result = $db->prepare($sql);
	foreach($vetIdJudoka as $id)
	{
		$result->bindValue(':idJudoka', $id);
		$result->execute();
		$row = $result->fetch(PDO::FETCH_ASSOC);
		echo "<tr>";
		echo "<td>".$row["namesurname"]."</td>";
		echo "<td align='center'>".$row["country"]."</td>";
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
			$src="../flag/noflag.png";
		echo "<td><img src='$src'></td>";
		echo "<td><input type='hidden' size='3' name='idJudoka".($i)."' value='".$row["idJudoka"]."'/>
		<input type='text' align='center' size='3' name='randomNum".($i)."' id='randomNum".($i)."' value='".($i+1)."'/>
		<button type='submit' name='manualDelete' value='".$i."' >delete</button>
		</td>";
		echo "</tr>";
		$i++;
		
	}
	//non ho teste di serie
	echo "</table>";
	echo "<input type='hidden' name='countRandomNum' id='countRandomNum' value='$i'/>";
	echo "<input type='hidden' name='countTotalNum' id='countRandomNum' value='$i'/>";
	
	$stringid="";
	$iddanascondere="";
	for($i=0; $i<count($vetIdJudoka)-1; $i++)
	{
		$stringid.=$vetIdJudoka[$i].",";
		$iddanascondere.="idJudoka!='".$vetIdJudoka[$i]."' AND ";
	}
	if(count($vetIdJudoka)>0)
	{
		$stringid.=$vetIdJudoka[$i];
		$iddanascondere.="idJudoka!='".$vetIdJudoka[$i]."' ";
	}
	
	//se il vettore è vuoto metto $iddanascondere = 1
	if(count($vetIdJudoka)==0)
		$iddanascondere="1";
	
	echo "<select name='addManualId'>";
	$sql="SELECT * FROM judoka 
		INNER JOIN pair ON judoka.idJudoka=pair.judoka
		INNER JOIN poule ON pair.poule=poule.idPoule
		WHERE poule.katatype = :katatype AND poule.tournament = :idTournament AND type = :type AND ($iddanascondere)
		ORDER BY place";
		
	$result = $db->prepare($sql);
	$result->bindValue(':katatype', $_GET["idKatatype"]);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->bindValue(':type', 'A');
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
		echo "<option value='".$row["idJudoka"]."'>".$row["namesurname"]."</option>";
	echo "</select>";
	echo "<input type='submit' name='manualAdd' value='add' />";
	echo "<input type='hidden' name='selection' value='".$stringid."' />";
	
	echo "<br><br><input type='button' id='startStopButton' onclick='startStopCrono()' value='start' />";
}
else
{
	?>
	<table border='1'>
	<tr>
		<td width='400' align='center'>judokas</td>
		<td align='center' colspan='2'>country</td>
		<td align='center'>print</td>
	</tr>
	<?php
	$sql="SELECT * FROM judoka 
	INNER JOIN pair ON judoka.idJudoka=pair.judoka
	INNER JOIN poule ON pair.poule=poule.idPoule
	WHERE poule.katatype = :katatype AND poule.tournament = :idTournament AND type = :type
	ORDER BY numOrder";
	//stampo le tabelle in base alla poule
	$result = $db->prepare($sql);
	$result->bindValue(':katatype', $_GET["idKatatype"]);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->bindValue(':type', 'F');
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{

		echo "<tr>";
		echo "<td>".$row["namesurname"]."</td>";
		echo "<td align='center'>".$row["country"]."</td>";
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
			$src="../flag/noflag.png";
		echo "<td><img src='$src'></td>";
		echo "<td><a href='../print/printCompilatedForm.php?idPair=".$row["idPair"]."' target='_blank'><img valign='middle' src='../image/print.png'></a></td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "<br><br>print all forms <a href='../print/printAllCompilatedForm.php?type=F&idKatatype=".$_GET["idKatatype"]."' target='_blank'><img valign='middle' src='../image/print.png'></a>";
}

?>
</form>

</body>
</html>
