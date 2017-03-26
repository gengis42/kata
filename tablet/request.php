<?php
require_once "../config.inc.php";

if(isset($_REQUEST["androidmac"]))
{
	$sql="SELECT * FROM tablet
	INNER JOIN form ON tablet.idTablet=form.tablet
	WHERE mac = :mac";
	$result = $db->prepare($sql);
	$result->bindValue(':mac', $_REQUEST["androidmac"]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	if($row != null)
	{
		//estraggo nome torneo
		$sql="SELECT * FROM form
		INNER JOIN pair ON form.pair=pair.idPair
		INNER JOIN poule ON pair.poule=poule.idPoule
		INNER JOIN tournament ON poule.tournament=tournament.idTournament
		WHERE idForm = :idForm";
		$resultTournament = $db->prepare($sql);
		$resultTournament->bindValue(':idForm', $row["idForm"]);
		$resultTournament->execute();
		$rowTournament = $resultTournament->fetch(PDO::FETCH_ASSOC);
		
		//estraggo info kata
		$sql="SELECT * FROM form
		INNER JOIN pair ON form.pair=pair.idPair
		INNER JOIN poule ON pair.poule=poule.idPoule
		INNER JOIN katatype ON poule.katatype=katatype.idKatatype
		WHERE idForm = :idForm";
		$resultKata = $db->prepare($sql);
		$resultKata->bindValue(':idForm', $row["idForm"]);
		$resultKata->execute();
		$rowkata = $resultKata->fetch(PDO::FETCH_ASSOC);
		
		//estraggo nome giudice
		$sql="SELECT * FROM form
		INNER JOIN judge ON form.judge=judge.idJudge
		WHERE idForm = :idForm";
		$resultjudge = $db->prepare($sql);
		$resultjudge->bindValue(':idForm', $row["idForm"]);
		$resultjudge->execute();
		$rowjudge = $resultjudge->fetch(PDO::FETCH_ASSOC);
		
		//estraggo nome coppia
		$sql="SELECT * FROM form
		INNER JOIN pair ON form.pair=pair.idPair
		INNER JOIN judoka ON pair.judoka=judoka.idJudoka
		WHERE idForm = :idForm";
		$resultjudoka = $db->prepare($sql);
		$resultjudoka->bindValue(':idForm', $row["idForm"]);
		$resultjudoka->execute();
		$rowjudoka = $resultjudoka->fetch(PDO::FETCH_ASSOC);

		
		$a1 = array(
		"tname" => $rowTournament["name"], 
		"kname" => $rowkata["name"], 
		"nform" => $rowkata["num"], 
		"jname" => $rowjudge["name"], 
		"pname" => $rowjudoka["namesurname"]." : ".$rowjudoka["country"], 
		"ntech" => (int)$rowkata["numTechniques"]
		);
		
		$at = array();
		$as = array();
		$ap = array();
		//stampo tutte le tecniche
		for($i=0; $i<$rowkata["numTechniques"]; $i++)
		{
			$at[] = $rowkata["t".($i+1)];
			//echo ":";
			$as[] = $rowkata["s".($i+1)];
			//echo ":";
			$ap[] = $rowkata["p".($i+1)];
			//echo "\n";
		}
		$af;
		if($row["fcr"]=="")
			$af = -1;
		else
			$af = (int)$row["fcr"];
		/*if($row["fcr"]=="")
			echo "nofcr\n";
		else
			echo $row["fcr"]."\n";
			* */
		echo json_encode(array(
		"i" => 1,
		"m" => $a1,
		"t" => $at,
		"s" => $as,
		"p" => $ap,
		"f" => $af,
		));
	}
	else
	{
		//echo "not associated";
		echo json_encode(array("i" => 0));
	}
}
?>
