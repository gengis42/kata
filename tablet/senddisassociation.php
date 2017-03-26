<?php
require_once "../config.inc.php";
if(isset($_REQUEST["mac"]) and $_REQUEST["disassociation"]=="true")
{
	//estraggo idTablet
	$sql="SELECT idTablet FROM tablet WHERE mac = :mac";
	$result = $db->prepare($sql);
	$result->bindValue(':mac', $_REQUEST["mac"]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	
	$sql="UPDATE form SET tablet = null, status = '2' WHERE tablet = :tablet";
	$result = $db->prepare($sql);
	$result->bindValue(':tablet', $row["idTablet"]);
	$result->execute();
	
	echo "updated";
}
?>