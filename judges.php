<!DOCTYPE HTML>
<?php
session_start();
require_once "session.inc.php";
require_once "config.inc.php";

if(isset($_POST["addJudge"]))
{
	require_once "session.admin.inc.php";
	$sql="INSERT INTO judge (name, tournament, country) VALUES (:name, :idTournament, :country)";
	$result = $db->prepare($sql);
	$result->bindValue(':name', $_POST["name"]);
	$result->bindValue(':country', strtoupper($_POST["country"]));
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
	
	//lo abilito in tutto
	//estraggo id del giudice
	$idJudge = $db->lastInsertId();
	$sql="SELECT * FROM katatype";
	$result = $db->query($sql);
	while($row = $result->fetch(PDO::FETCH_ASSOC)){
		$sql="INSERT INTO ability (katatype, judge) VALUES (:katatype, :judge)";
		$resultInsert = $db->prepare($sql);
		$resultInsert->bindValue(':katatype', $row["idKatatype"]);
		$resultInsert->bindValue(':judge', $idJudge);
		$resultInsert->execute();
	}
}
if(isset($_POST["removeJudge"]))
{
	require_once "session.admin.inc.php";
	$sql="DELETE FROM judge WHERE idJudge = :idJudge";
	$result = $db->prepare($sql);
	$result->bindValue(':idJudge', $_POST["removeJudge"]);
	$result->execute();
}


?>

<html>
<head>
<title>Judges</title>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<!--fancybox-->
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="searchFlag.js"></script>
<script type="text/javascript" src="judges.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<!--<body onload="checkDraw()" onFocus="checkDraw(); window.location.href=window.location.href">-->
<!--<body onload="checkDraw()">-->

<body>

<?php
require_once "top.php";
require_once "banner.php";
?>


	<p>
		<b>judges list</b>
		<?php
		if($_SESSION["user_level"]=="1")
		{
			?>
			<a target='_blank' href='phpexcel/importJudges.php'>import from excel</a>
			<?php
		}
		?>
		
	</p>
	<form method='post'>
	<table border='1'>
	<tr>
		<td width='250'>name</td>
		<td colspan='2'>country</td>
		<?php
		//stampo i tipi di kata
		$sql="SELECT * FROM katatype ORDER BY idKatatype";
		$result = $db->query($sql);
		$arrayIdKatatype = array();
		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			echo "<td style='font-size:8pt;' width='40'>".$row["name"]."</td>";
			$arrayIdKatatype[] = $row["idKatatype"];
		}
		
		if($_SESSION["user_level"]=="1")
		{
			?>
			<td></td>
			<?php
		}
		?>
	</tr>
	<?php
	$sql="SELECT * FROM judge WHERE tournament = :idTournament ORDER BY name";
	$result = $db->prepare($sql);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		echo "<tr>";
		echo "<td>".$row["name"]."</td>";
		echo "<td width='40' align='center'>".$row["country"]."</td>";
		////stampo bandiera
		$sql = "SELECT LOWER(iso2) AS iso2 FROM country_t WHERE ioc = :ioc";
		$rsd = $db->prepare($sql);
		$rsd->bindValue(':ioc', strtoupper($row["country"]));
		$rsd->execute();
		$rs = $rsd->fetch(PDO::FETCH_ASSOC);
		
		if($rs['iso2']==null) $src="flag/blank.png";
		else $src="flag/".$rs['iso2'].".png";
		$buttonflag="x";

		echo "<td width='40' align='center'><img src='$src' width='24' height='24' style='vertical-align:middle'></td>";
		
		foreach($arrayIdKatatype as $id){
			$sql="SELECT COUNT(*) AS conteggio FROM ability WHERE katatype = :katatype AND judge = :judge";
			$resultChecked = $db->prepare($sql);
			$resultChecked->bindValue(':katatype', $id);
			$resultChecked->bindValue(':judge', $row["idJudge"]);
			$resultChecked->execute();
			$rowChecked = $resultChecked->fetch(PDO::FETCH_ASSOC);
			if($rowChecked["conteggio"] > 0 )
				$checked = "x";
			else
				$checked = "";
			echo "<td align='center'>$checked</td>";
		}
		if($_SESSION["user_level"]=="1")
			echo "<td><a class='editJudge' href='edit/editJudge.php?idJudge=".$row["idJudge"]."'><img align='right' src='image/edit-icon.png' width='15' height='15'></a>
		<button type='submit' name='removeJudge' value='".$row["idJudge"]."' onclick=\"return confirm('Confirm delete?')\">remove</button></td>";
		echo "</tr>";
	}
	
	if($_SESSION["user_level"]=="1")
	{
		?>
		<tr>
			<td><input type='text' name='name'/></td>
			<td colspan='2'>
				<input type='text' name='country' id='country' onkeyup='searchFlag(this.value)' size='3'>
				<img id='flagImage' src='' width='26' height='26' style='vertical-align:middle'>

			</td>
			
			<td colspan='<?php echo count($arrayIdKatatype) +1; ?>'><input type='submit' name='addJudge' value='add'/></td>
		</tr>
	<?php
	}
	?>

	</table>
	</form>
	
	ranking judges <a href="judge/rankingjudges.php" target='_blank'>AB</a> <a href="judge/rankingjudges.php?type=F" target='_blank'>F</a><br>

</body>
</html>
