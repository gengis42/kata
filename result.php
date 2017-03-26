<!DOCTYPE HTML>

<?php
session_start();
require_once "session.inc.php";
require_once "config.inc.php";
?>

<html>
<head>
	<title>Results</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
require_once "top.php";
require_once "banner.php";


$sql="SELECT idPoule,idKatatype,name FROM poule
	INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
	WHERE tournament = :idTournament
	GROUP BY katatype";
$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	echo "<p>";
	echo $row["name"];
	$sqlPoule="SELECT idPoule,UPPER(type) AS type FROM poule WHERE katatype = :katatype AND tournament = :idTournament ORDER BY type";
	$resultPoule = $db->prepare($sqlPoule);
	$resultPoule->bindValue(':katatype', $row["idKatatype"]);
	$resultPoule->bindValue(':idTournament', $_SESSION["idTournament"]);
	$resultPoule->execute();
	while($rowPoule = $resultPoule->fetch(PDO::FETCH_ASSOC))
	{
		echo " <a href='result/livepouleresult.php?idPoule=".$rowPoule["idPoule"]."' target='_blank'>".$rowPoule["type"]."</a>";
	}
	echo "</p>";
}
?>

<hr>

<p>
<form action="result/client.php" target="_blank">
seconds: <input type='text' name="time" value='10'/ size='3'>
<input type='submit' name='start' value='start client'/>
</form>
<br>
<a href='result/server.php' target='_blank'>server</a>
</p>

<hr>

<p>

<form action="result/livecircleresult.php" target="_blank">
circle live results<br>
<select name="type">
	<option value="AB">A - B</option>
	<option value="F">FINAL</option>
	<option value="ABF">all</option>
</select>
seconds: <input type='text' name="time" value='20'/ size='3'>
<input type='submit' name='start' value='start'/>
</form>
</p>

<hr>

<p>
live all 
<a href='result/liveall.php?type=AB' target='_blank'>A - B</a>
<a href='result/liveall.php?type=F' target='_blank'>FINAL</a>
<a href='result/liveall.php?type=ABF' target='_blank'>AB+FINAL</a>
</p>

<hr>

<p>
<a href='result/medals.php' target='_blank'>medals</a>
</p>
</body>
</html>
