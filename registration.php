<!DOCTYPE HTML>
<?php
session_start();
require_once "session.inc.php";
require_once "config.inc.php";
require_once "function.php";
if(isset($_POST["add"]))
{
	require_once "session.admin.inc.php";
	
	$sql="INSERT INTO judoka (namesurname, country ,tournament,katatype) VALUES (:namesurname, :country, :tournament, :katatype)";
	$result = $db->prepare($sql);
	$result->bindValue(':namesurname', $_POST["namesurname"]);
	$result->bindValue(':country', strtoupper($_POST["country"]));
	$result->bindValue(':tournament', $_SESSION["idTournament"]);
	$result->bindValue(':katatype', $_GET["idKatatype"]);
	$result->execute();
}
if(isset($_POST["delete"]))
{
	require_once "session.admin.inc.php";
	$sql="DELETE FROM judoka WHERE idJudoka = :idJudoka";
	$result = $db->prepare($sql);
	$result->bindValue(':idJudoka', $_POST["delete"]);
	$result->execute();
}
if(isset($_POST["enableDisableFlag"]))
{
	$sql="SELECT enableFlag FROM judoka WHERE idJudoka = :idJudoka";
	$result = $db->prepare($sql);
	$result->bindValue(':idJudoka', $_POST["enableDisableFlag"]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	if($row["enableFlag"]==1) $value=0;
	else $value=1;
	
	$sql="UPDATE judoka SET enableFlag = :enableFlag WHERE idJudoka = :idJudoka";
	$result = $db->prepare($sql);
	$result->bindValue(':enableFlag', $value);
	$result->bindValue(':idJudoka', $_POST["enableDisableFlag"]);
	$result->execute();
}
if(isset($_POST["saveseed"]))
{
	require_once "session.admin.inc.php";
	$idJudoka = $_POST['seedOrder'];
	$seed = $_POST['seed'];
    for($i=0; $i < count($idJudoka); $i++)
    {
    	$tmpseed = $seed[$i];
    	if($tmpseed=="")
			$tmpseed=null;
    	$sql="UPDATE judoka SET seed = :seed WHERE idJudoka = :idJudoka";
    	$result = $db->prepare($sql);
		$result->bindValue(':seed', $tmpseed);
		$result->bindValue(':idJudoka', $idJudoka[$i]);
		$result->execute();
    }
}
if(isset($_POST["selectCompetitionMode"]))
{
	require_once "session.admin.inc.php";
    $sql="UPDATE poule SET mode = :mode WHERE katatype = :katatype AND tournament = :idTournament";
    $result = $db->prepare($sql);
	$result->bindValue(':mode', $_POST['selectCompetitionMode']);
	$result->bindValue(':katatype', $_GET["idKatatype"]);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
}
?>

<html>
<head>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<!--fancybox-->
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script type="text/javascript" src="registration.js"></script>
<script type="text/javascript" src="searchFlag.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<form method="post">
<?php
require_once "top.php";
require_once "banner.php";

$sql="SELECT * FROM katatype WHERE idKatatype = :idKatatype";
$result = $db->prepare($sql);
$result->bindValue(':idKatatype', $_GET["idKatatype"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
echo $row["name"];

//determino se l'iscrizione è statta chiusa o no
$sql="SELECT * FROM judoka 
INNER JOIN pair ON judoka.idJudoka=pair.judoka 
INNER JOIN poule ON pair.poule=poule.idPoule
WHERE judoka.katatype = :idKatatype AND judoka.tournament = :idTournament
GROUP BY type";
$resultPoule = $db->prepare($sql);
$resultPoule->bindValue(':idKatatype', $_GET["idKatatype"]);
$resultPoule->bindValue(':idTournament', $_SESSION["idTournament"]);
$resultPoule->execute();

$editable=false;
if($resultPoule->rowCount()==0)
	$editable=true;

?>

	<table border='0'>
	<tr>
		<td align='center'></td>
		<td width='400' align='center'>judokas</td>
		<td colspan='3' align='center'>country</td>
		<td align='center'>seed</td>
		
		<?php if($editable and $_SESSION["user_level"]=="1") echo "<td align='center'></td>"; ?>
	</tr>

	<?php

	$cont=1;
	$sql="SELECT * FROM judoka INNER JOIN katatype ON judoka.katatype=katatype.idKatatype WHERE idKatatype = :idKatatype AND tournament = :idTournament";
	$result = $db->prepare($sql);
	$result->bindValue(':idKatatype', $_GET["idKatatype"]);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
	
		echo "<tr>";
		echo "<td align='center'><b>".$cont++."</b></td>";
		echo "<td>".$row["namesurname"]."<a class='editJudokas' href='edit/editJudokas.php?idJudoka=".$row["idJudoka"]."'><img align='right' src='image/edit-icon.png' width='15' height='15'></a></td>";
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
		echo "<td width='30' align='center'><button type='submit' name='enableDisableFlag' value='".$row["idJudoka"]."'>$buttonflag</button></td>";
		//////
	
		if($editable and $_SESSION["user_level"]=="1")
		{
			echo "<td align='center'><input type='text' name='seed[]' value='".$row["seed"]."' size='2'/><input type='hidden' name='seedOrder[]' value='".$row["idJudoka"]."'/></td>";
			echo "<td><button type='submit' name='delete' value='".$row["idJudoka"]."' onclick=\"return confirm('Confirm delete?')\">delete</button></td>";
		}
		else
			echo "<td align='center'>".$row["seed"]."</td>";
		
		echo "</tr>";
	}
	?>

	</table>
	<?php 
	if($editable and $_SESSION["user_level"]=="1")
	{
		?>
		<input type="submit" name="saveseed" value="save seed"/>
		<p>
		name: <input type="text" name="namesurname" size='50'/>
		country: <input type='text' name='country' id='country' onkeyup='searchFlag(this.value)' size='3'>
		<img id='flagImage' src='' width='26' height='26' style='vertical-align:middle'>
		<input type="submit" name="add" value="add"/>
		</p>
		<?php
	}
	?>
	</form>
<?php
?>
</body>
</form>
</html>