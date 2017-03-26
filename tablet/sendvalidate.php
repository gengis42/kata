<?php
require_once "../config.inc.php";
if(isset($_REQUEST["mac"]))
{
	//estraggo idForm
	$sql="SELECT idTablet, tgroup, grouporder FROM tablet WHERE mac = :mac";
	$result = $db->prepare($sql);
	$result->bindValue(':mac', $_REQUEST["mac"]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	
	$idTablet = $row["idTablet"];
	$position = $row["tgroup"]."".$row["grouporder"];

	if(isset($_REQUEST["fluidity"]))
	{
		$sql="UPDATE form SET fcr = :fcr WHERE tablet = :tablet";
		$result = $db->prepare($sql);
		$result->bindValue(':fcr', $_REQUEST["value"]);
		$result->bindValue(':tablet', $idTablet);
		$res = $result->execute();
	}
	else
	{
		$sql="UPDATE form SET p".($_REQUEST["pos"]+1)." = :p WHERE tablet = :tablet";
		$result = $db->prepare($sql);
		$result->bindValue(':p', $_REQUEST["value"]);
		$result->bindValue(':tablet', $idTablet);
		$res = $result->execute();
	}
	
	//log
	if($res == 1){

		echo "updated";

		$mac = $_REQUEST["mac"];

		if(isset($_REQUEST["fluidity"]))
			$technique = 0;
		else
			$technique = $_REQUEST["pos"] + 1;

		$score = $_REQUEST["value"];
		

		$sql="SELECT idForm FROM form WHERE tablet = :tablet";
		$result = $db->prepare($sql);
		$result->bindValue(':tablet', $idTablet);
		$res = $result->execute();
		$row = $result->fetch(PDO::FETCH_ASSOC);

		$form = $row["idForm"];

		$sql="INSERT INTO log (score, technique, mac, form, position) VALUES (:score, :technique, :mac, :form, :position)";
		$result = $db->prepare($sql);
		$result->bindValue(':score', $score);
		$result->bindValue(':technique', $technique);
		$result->bindValue(':mac', $mac);
		$result->bindValue(':form', $form);
		$result->bindValue(':position', $position);
		$res = $result->execute();
	}
}
?>
