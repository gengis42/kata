<?php
require_once "../config.inc.php";
if(isset($_REQUEST["mac"]) and isset($_REQUEST["battery"]))
{
	$sql="UPDATE tablet SET battery = :battery WHERE mac = :mac";
	$result = $db->prepare($sql);
	$result->bindValue(':battery', $_REQUEST["battery"]);
	$result->bindValue(':mac', $_REQUEST["mac"]);
	$res = $result->execute();
	
	if($res == 1)
		echo "updated";
}
?>
