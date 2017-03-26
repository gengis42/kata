<?php
require_once "../config.inc.php";
$q = trim($_GET["q"]);
if (!$q) return;

// find poule
$sql = "SELECT * FROM form WHERE idForm = :idForm";
$rsd = $db->prepare($sql);
$rsd->bindValue(':idForm', $q);
$rsd->execute();
$rs = $rsd->fetch(PDO::FETCH_ASSOC);

if($rs["fcr"]!="" and $rs["judge"]!="")
	echo "color: #0F0;";
else
	echo "color: #F00;";
?>
