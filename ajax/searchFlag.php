<?php
require_once "../config.inc.php";
$q = trim($_GET["q"]);
if (!$q) return;

$sql = "SELECT LOWER(iso2) AS iso2 FROM country_t WHERE ioc = :ioc";
$rsd = $db->prepare($sql);
$rsd->bindValue(':ioc', strtoupper($q));
$rsd->execute();
$rs = $rsd->fetch(PDO::FETCH_ASSOC);
if($rs['iso2']==null)
	echo "flag/blank.png";
else
	echo "flag/".$rs['iso2'].".png";
?>
