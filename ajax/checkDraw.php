<?php
session_start();
require_once "../config.inc.php";
$q = trim($_GET["q"]);
if (!$q) return;

$dado="image/dado.png";

//find poule
$sql = "SELECT * FROM poule WHERE katatype = :katatype AND tournament = :idTournament ORDER BY type";
$rsd = $db->prepare($sql);
$rsd->bindValue(':katatype', $q);
$rsd->bindValue(':idTournament', $_SESSION["idTournament"]);
$rsd->execute();
while($rs = $rsd->fetch(PDO::FETCH_ASSOC)) {
	$sql="SELECT COUNT(*) AS cont FROM pair WHERE poule = :poule";
	$result = $db->prepare($sql);
	$result->bindValue(':poule', $rs["idPoule"]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	if($row["cont"]>0 and ($rs["type"]=='A' or $rs["type"]=='B'))
		$dado="image/dadoAB.png";
	if($row["cont"]>0 and $rs["type"]=='F')
		$dado="image/dadoF.png";
}
echo $dado;
?>
