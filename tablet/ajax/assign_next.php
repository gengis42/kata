<?php
session_start();
require_once "../../config.inc.php";
require_once "../../function.php";

if($_POST["validate"] == "true")
{
	//validate
	$sql="SELECT pair.idPair FROM form
	INNER JOIN pair ON form.pair = pair.idPair
	INNER JOIN judoka ON pair.judoka = judoka.idJudoka
	INNER JOIN tgroup ON pair.poule = tgroup.poule
	WHERE tgroup.idTgroup = :tgroup AND form.status = '2' AND pair.scoreTot IS NULL
	GROUP BY pair.idPair ORDER BY numOrder DESC";
	$result = $db->prepare($sql);
	$result->bindValue(':tgroup', $_POST["idGroup"]);
	$result->execute();

	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		validatePair($row["idPair"]);
		updateAndSavePoulePlace($_POST["idPoule"]);
		break;
	}
}

//next
$sql="SELECT pair.idPair FROM form
INNER JOIN pair ON form.pair = pair.idPair
INNER JOIN judoka ON pair.judoka = judoka.idJudoka
INNER JOIN tgroup ON pair.poule = tgroup.poule
WHERE tgroup.idTgroup = :tgroup AND form.status = '0' GROUP BY pair.idPair ORDER BY numOrder";
$result = $db->prepare($sql);
$result->bindValue(':tgroup', $_POST["idGroup"]);
$result->execute();

while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	$arrayForms = array();
	$sql = "SELECT idForm FROM form
		WHERE form.pair = :pair
		ORDER BY idForm";
	$resultForm = $db->prepare($sql);
	$resultForm->bindValue(':pair', $row["idPair"]);
	$resultForm->execute();
	while($rowForm = $resultForm->fetch(PDO::FETCH_ASSOC)){
		//echo $rowForm["idForm"];
		$arrayForms[] = $rowForm["idForm"];
	}

	$count = 0;
	//$sql = "SELECT * FROM tablet WHERE tablet.tgroup = :tgroup AND judge IS NOT NULL AND grouporder = :num";
	$sql = "SELECT * FROM tablet WHERE tablet.tgroup = :tgroup AND judge IS NOT NULL ORDER BY grouporder";
	$resultTablet = $db->prepare($sql);
	$resultTablet->bindValue(':tgroup', $_POST["idGroup"]);
	//$resultTablet->bindValue(':num', $numForm);
	$resultTablet->execute();
	while($rowTablet = $resultTablet->fetch(PDO::FETCH_ASSOC))
	{
		//echo $rowTablet["name"]. " ". $rowTablet["idTablet"]. " ". $rowTablet["judge"];
		$sql="UPDATE form SET tablet = :tablet, status = '1' WHERE idForm = :idForm";
		$resultUpdate = $db->prepare($sql);
		//$resultUpdate->bindValue(':idForm', $rowForm["idForm"]);
		$resultUpdate->bindValue(':idForm', $arrayForms[$count]);
		$resultUpdate->bindValue(':tablet', $rowTablet["idTablet"]);
		$resultUpdate->execute();

		$sql="UPDATE form SET judge = :judge WHERE idForm = :idForm AND judge IS NULL";
		$resultUpdate = $db->prepare($sql);
		//$resultUpdate->bindValue(':idForm', $rowForm["idForm"]);
		$resultUpdate->bindValue(':idForm', $arrayForms[$count]);
		$resultUpdate->bindValue(':judge', $rowTablet["judge"]);
		$resultUpdate->execute();

		$count++;
	}
	


	break;
}


/*
$sql="SELECT pair.idPair FROM pair
INNER JOIN judoka ON pair.judoka = judoka.idJudoka
INNER JOIN tgroup ON pair.poule = tgroup.poule
WHERE tgroup.idTgroup = :tgroup AND pair.scoreTot IS NULL ORDER BY numOrder";
$result = $db->prepare($sql);
$result->bindValue(':tgroup', $_POST["idGroup"]);
$result->execute();
$count = 0;
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	if($count == 0) {
		if($_POST["validate"] == "true")
		{
			validatePair($row["idPair"]);
			updateAndSavePoulePlace($_POST["idPoule"]);
		}
	}
	else if($count == 1) {
		$numForm = 1;
		$sql = "SELECT idForm FROM form
		WHERE form.pair = :pair
		ORDER BY idForm";
		$resultForm = $db->prepare($sql);
		$resultForm->bindValue(':pair', $row["idPair"]);
		$resultForm->execute();
		while($rowForm = $resultForm->fetch(PDO::FETCH_ASSOC)){
			//echo $rowForm["idForm"];

			$sql = "SELECT * FROM tablet
			WHERE tablet.tgroup = :tgroup AND judge IS NOT NULL AND grouporder = :num";
			$resultTablet = $db->prepare($sql);
			$resultTablet->bindValue(':tgroup', $_POST["idGroup"]);
			$resultTablet->bindValue(':num', $numForm);
			$resultTablet->execute();
			if($rowTablet = $resultTablet->fetch(PDO::FETCH_ASSOC))
			{
				//echo $rowTablet["name"]. " ". $rowTablet["idTablet"]. " ". $rowTablet["judge"];
				$sql="UPDATE form SET tablet = :tablet, status = '1' WHERE idForm = :idForm";
				$resultUpdate = $db->prepare($sql);
				$resultUpdate->bindValue(':idForm', $rowForm["idForm"]);
				$resultUpdate->bindValue(':tablet', $rowTablet["idTablet"]);
				$resultUpdate->execute();

				$sql="UPDATE form SET judge = :judge WHERE idForm = :idForm AND judge IS NULL";
				$resultUpdate = $db->prepare($sql);
				$resultUpdate->bindValue(':judge', $rowTablet["judge"]);
				$resultUpdate->bindValue(':idForm', $rowForm["idForm"]);
				$resultUpdate->execute();
			}

			$numForm++;
		}
	}else {
		break;
	}
	$count ++;
}
*/

?>
