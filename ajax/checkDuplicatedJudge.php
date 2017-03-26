<?php
require_once "../config.inc.php";
$f = trim($_GET["f"]);
$j = trim($_GET["j"]);
if ($j=="") return;

// find pair
$sql = "SELECT judge, pair FROM form WHERE idForm = :idForm";
$result = $db->prepare($sql);
$result->bindValue(':idForm', $f);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);

// keep all judges
$sql = "SELECT num FROM form WHERE pair = :pair AND judge = :judge AND idForm != :idForm";
$result = $db->prepare($sql);
$result->bindValue(':pair', $row["pair"]);
$result->bindValue(':judge', $j);
$result->bindValue(':idForm', $f);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
if($row != null)
{
	echo $row["num"];
}	
?>
