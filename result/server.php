<!DOCTYPE HTML>

<?php
session_start();
require_once "../session.inc.php";
require_once "../config.inc.php";

if(isset($_POST["save"])) {
	
	$array = array();
	$l = $_POST["countrow"];
	for($i=0; $i<$l; $i++) {
		
		$tmp = array();
		$name = "r".$i;
		foreach($_POST[$name] as $id){
			$tmp[] = $id;
		}
		if(count($tmp) > 0)
			$array[] = $tmp;
	}
	
	$sql="UPDATE tournament SET liveResult = :liveResult WHERE idTournament = :idTournament";
	$result = $db->prepare($sql);
	$result->bindValue(':liveResult', json_encode($array));
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
}

?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>

<form method='post'>
<table>

<tr>
	<td></td>
	<td>A</td>
	<td>B</td>
	<td>F</td>
</tr>

<?php
$sql="SELECT liveResult FROM tournament WHERE idTournament = :idTournament";
$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);

$jsonArray = $row["liveResult"];
$phparray = json_decode($jsonArray);

$arrayValues = array();
foreach($phparray as $set){
	foreach($set as $x)
		$arrayValues[] = $x;
}


$sql="SELECT idPoule,idKatatype,name FROM poule
	INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
	WHERE tournament = :idTournament
	GROUP BY katatype";
$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
$r = 0;
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	echo "<tr>";
	echo "<td>".$row["name"]."</td>";
	$sqlPoule="SELECT idPoule,UPPER(type) AS type FROM poule WHERE katatype = :katatype AND tournament = :idTournament ORDER BY type";
	$resultPoule = $db->prepare($sqlPoule);
	$resultPoule->bindValue(':katatype', $row["idKatatype"]);
	$resultPoule->bindValue(':idTournament', $_SESSION["idTournament"]);
	$resultPoule->execute();
	while($rowPoule = $resultPoule->fetch(PDO::FETCH_ASSOC))
	{
		//echo " <a href='result/livepouleresult.php?idPoule=".$rowPoule["idPoule"]."' target='_blank'>".$rowPoule["type"]."</a>";
		echo "<td>";
		
		if(in_array($rowPoule["idPoule"],$arrayValues))
			$checked="checked";
		else
			$checked="";
		
		echo "<input $checked type='checkbox' name='r".$r."[]' value='".$rowPoule["idPoule"]."'/>";
		echo "</td>";
	}
	echo "</tr>";
	$r++;
}
?>

</table>

<input type='hidden' name='countrow' value='<?php echo $r; ?>'/>
<input type='submit' name='save' value='save'/>
</form>
</body>
</html>
