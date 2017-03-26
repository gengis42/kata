<!DOCTYPE HTML>
<?php
session_start();
require_once "../config.inc.php";

$type="1";
if($_GET["type"]=='AB')
	$type = "(poule.type='A' OR poule.type='B')";
elseif($_GET["type"]=='F')
	$type = "(poule.type='F')";
$sql="SELECT idPoule,idKatatype,name FROM poule
	INNER JOIN katatype ON poule.katatype=katatype.idKatatype
	INNER JOIN pair ON pair.poule = poule.idPoule
	WHERE tournament = :idTournament AND $type
	GROUP BY katatype";

$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	$vetKatatype[]=$row["idKatatype"];
}
?>

<html>
<head>
<script type="text/javascript" src="../jquery-1.7.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="../style.css">
<script type="text/javascript" src="result.js"></script>

<script type="text/javascript">
var vetKatatype = new Array();
<?php
for($i=0; $i<count($vetKatatype); $i++)
{
	echo "vetKatatype.push('".$vetKatatype[$i]."');";
}
?>
var type='<?php echo $_GET["type"]; ?>';
var time='<?php echo $_GET["time"]*1000; ?>';

var count=0;
updateLiveCircleResult(vetKatatype[count],type);
count++;
if(count==vetKatatype.length)
	count=0;

setInterval(function() {
	updateLiveCircleResult(vetKatatype[count],type);
	count++;
	if(count==vetKatatype.length)
		count=0;
}, time);

</script>
</head>
<body>

<div id="liveresult">

<div>

</body>
</html>
