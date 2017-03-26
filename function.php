<?php

//require_once "config.inc.php";


function getNumTechniquesFromIdForm($idF)
{
	global $db;
	$sql="SELECT numTechniques FROM 
	form INNER JOIN pair ON form.pair=pair.idPair
	INNER JOIN poule ON pair.poule=poule.idPoule
	INNER JOIN katatype ON poule.katatype=katatype.idKatatype
	WHERE idForm = :idForm";
	$result = $db->prepare($sql);
	$result->bindValue(':idForm', $idF);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	return $row["numTechniques"];
}

function convertStringZerotoPoint($srt)
{
	if(strlen($srt)==5)
	{
		$pen1=substr($srt,0,1);
		$pen2=substr($srt,1,1);
		$pen3=substr($srt,2,1);
		$pen4=substr($srt,3,1);
		$pen5=substr($srt,4,1);
	}
	else
	{
		$pen1=$pen2=$pen3=$pen4=$pen5=0;
	}
	
	
	$p=10-$pen1-$pen2-3*$pen3-5*$pen4;
	if($pen1 == 1 and $pen2 == 1 and $pen3 == 1 and $pen4 == 1)
		$p=1;
	if($pen5==1)
		$p=0;	
	return $p;
}

function countAndSaveFormPoint($idForm)
{
	global $db;
	$numMaxTechniques=getNumTechniquesFromIdForm($idForm);
	$countSmall=0;
	$countMedium=0;
	$countWrong=0;
	$countForgotten=0;
	
	$p=null;
	
	$sql="SELECT * FROM form WHERE idForm = :idForm";
	$result = $db->prepare($sql);
	$result->bindValue(':idForm', $idForm);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		$fcr=$row["fcr"];
		for($id=1; $id<=$numMaxTechniques; $id++)
		{
			$vetPen=$row['p'.$id];
			if(strlen($vetPen)==5)
			{
				$pen1=substr($vetPen,0,1);
				$pen2=substr($vetPen,1,1);
				$pen3=substr($vetPen,2,1);
				$pen4=substr($vetPen,3,1);
				$pen5=substr($vetPen,4,1);
			}
			else
			{
				$pen1=$pen2=$pen3=$pen4=$pen5=0;
			}
			
			if($pen5==1)
				$p[]=0;
			elseif($pen1 == 1 and $pen2 == 1 and $pen3 == 1 and $pen4 == 1)
				$p[] = 1;
			else
				$p[]=10-$pen1-$pen2-3*$pen3-5*$pen4;
				
			if($pen1==1) $countSmall++;
			if($pen2==1) $countSmall++;
			if($pen3==1) $countMedium++;
			if($pen4==1) $countWrong++;
			if($pen5==1) $countForgotten++;
		}
	}
	
	$tot=0;
	if($countForgotten==0)
	{
		for($i=0; $i<$numMaxTechniques; $i++)
			$tot+=$p[$i];
		$tot+=$fcr;
	}
	else
	{
		for($i=0; $i<$numMaxTechniques; $i++)
			$tot+=$p[$i];
		$tot=$tot/2;
	}
	
	$sql="UPDATE form SET totSmall = :totSmall, totMedium = :totMedium, totWrong = :totWrong, totForgotten = :totForgotten, tot = :tot WHERE idForm = :idForm";
	$result = $db->prepare($sql);
	$result->bindValue(':totSmall', $countSmall);
	$result->bindValue(':totMedium', $countMedium);
	$result->bindValue(':totWrong', $countWrong);
	$result->bindValue(':totForgotten', $countForgotten);
	$result->bindValue(':tot', $tot);
	$result->bindValue(':idForm', $idForm);
	$result->execute();
	return $tot;
}

function fluidityIsEnable()
{
	global $db;
	$enableFcr = false;
	$sql="SELECT fluidity FROM tournament WHERE idTournament = :idTournament";
	$result = $db->prepare($sql);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
	if($row = $result->fetch(PDO::FETCH_ASSOC)){
		if($row["fluidity"] == "1")
			$enableFcr = true;
	}

	return $enableFcr;
}

function invalidatePair($idPair)
{
	global $db;

	$sql="UPDATE pair SET score1 = NULL, score2 = NULL, score3 = NULL, score4 = NULL, score5 = NULL, scoreTot = NULL, place = '99'
		WHERE idPair = :pair";
	$result = $db->prepare($sql);
	$result->bindValue(':pair', $idPair);
	$result->execute();
}

function validatePair($idPair)
{
	global $db;

	$sql="SELECT numJudges FROM pair INNER JOIN poule ON pair.poule=poule.idPoule WHERE idPair = :pair";
        $result = $db->prepare($sql);
        $result->bindValue(':pair', $idPair);
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $numJudges = $row["numJudges"];

	$enableFcr = fluidityIsEnable();

	$arrayIdForms = array();
	// 1 | 2 | 3 | 4 | 5 | tot | place
	
	//per le 5 schede faccio i conti anche se non servono più
	$sql="SELECT idForm FROM form WHERE pair = :pair";
	$result = $db->prepare($sql);
	$result->bindValue(':pair', $idPair);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC)){
		countAndSaveFormPoint($row["idForm"]);

		$arrayIdForms[] = $row["idForm"];

		$numMaxTechniques=getNumTechniquesFromIdForm($row["idForm"]);
	}


	$arrayScoreForms = array();
	$countforgotten = 0;
	$sql="SELECT * FROM form WHERE idForm = :idForm";
	$result = $db->prepare($sql);
	for($i=0; $i<count($arrayIdForms); $i++){
		
		$tmparray = array();

		$result->bindValue(':idForm', $arrayIdForms[$i]);
		$result->execute();
		while($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			
			$tmparray[] = $row["fcr"];
			for($id=1; $id<=$numMaxTechniques; $id++)
			{
				$number = convertStringZerotoPoint($row['p'.$id]);
				if($number == 0)
					$countforgotten++;

				$tmparray[] = $number;
			}


		}

		$arrayScoreForms[] = $tmparray;
	}

	//converto righe in colonne e viceversa

	$matrix = array();
	for($i=0; $i<=$numMaxTechniques; $i++){

		$tmparray = array();

		for($k=0; $k<count($arrayIdForms); $k++){
			$tmparray[] = $arrayScoreForms[$k][$i];
		}

		$matrix[] = $tmparray;
	}

	
	$sum=0;
	for($i=1; $i<=$numMaxTechniques; $i++){
		if($numJudges == 3)
			$sum += array_sum($matrix[$i]);
		else
			$sum += array_sum($matrix[$i]) - max($matrix[$i]) - min($matrix[$i]);
	}

	if($countforgotten > 0){
		$sum /= 2;
	}
	else{
		// enable disable fcr
		if($enableFcr == true)
			if($numJudges == 3)
				$sum += array_sum($matrix[0]);
			else
				$sum += array_sum($matrix[0]) - max($matrix[0]) - min($matrix[0]);
	}
		
	$score = array();
	$sql="SELECT idForm, num, tot FROM form WHERE pair = :pair ORDER BY num";
	$result = $db->prepare($sql);
	$result->bindValue(':pair', $idPair);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		$score[]=$row["tot"];
	}

	$sql="SELECT numJudges FROM pair INNER JOIN poule ON pair.poule=poule.idPoule WHERE idPair = :pair";
	$result = $db->prepare($sql);
	$result->bindValue(':pair', $idPair);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	if($row["numJudges"] == "5")
	{
		$tot=$score[0]+$score[1]+$score[2]+$score[3]+$score[4];
		$tot-=max($score);
		$tot-=min($score);
	}
	else //3
	{
		$tot=$score[0]+$score[1]+$score[2]+$score[3]+$score[4];
	}
	
	
	$sql="UPDATE pair SET score1 = :score1, score2 = :score2, score3 = :score3, score4 = :score4, score5 = :score5, scoreTot = :tot WHERE idPair = :idPair";
	$result = $db->prepare($sql);
	$result->bindValue(':score1', $score[0]);
	$result->bindValue(':score2', $score[1]);
	$result->bindValue(':score3', $score[2]);
	$result->bindValue(':score4', $score[3]);
	$result->bindValue(':score5', $score[4]);
	//$result->bindValue(':tot', $tot);
	$result->bindValue(':tot', $sum);
	$result->bindValue(':idPair', $idPair);
	$result->execute();
	
}

function validatePairOLD($idPair)
{
	// 1 | 2 | 3 | 4 | 5 | tot | place
	global $db;
	$sql="SELECT idForm FROM form WHERE pair = :pair";
	$result = $db->prepare($sql);
	$result->bindValue(':pair', $idPair);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
		countAndSaveFormPoint($row["idForm"]);
		
		
	$str="";
	$sql="SELECT idForm, num, tot FROM form WHERE pair = :pair ORDER BY num";
	$result = $db->prepare($sql);
	$result->bindValue(':pair', $idPair);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		$score[]=$row["tot"];
		$str=$str.$row["tot"]."|";
	}
	//todo
	//$sql="SELECT numJudges FROM tournament WHERE idTournament = :idTournament";
	$sql="SELECT numJudges FROM pair INNER JOIN poule ON pair.poule=poule.idPoule WHERE idPair = :pair";
	$result = $db->prepare($sql);
	$result->bindValue(':pair', $idPair);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	if($row["numJudges"] == "5")
	{
		$tot=$score[0]+$score[1]+$score[2]+$score[3]+$score[4];
		$tot-=max($score);
		$tot-=min($score);
		$str=$str.$tot;
	}
	else //3
	{
		$tot=$score[0]+$score[1]+$score[2]+$score[3]+$score[4];
		//$tot-=max($score);
		//$tot-=min($score);
		$str=$str.$tot;
	}
	
	
	$sql="UPDATE pair SET score1 = :score1, score2 = :score2, score3 = :score3, score4 = :score4, score5 = :score5, scoreTot = :tot WHERE idPair = :idPair";
	$result = $db->prepare($sql);
	$result->bindValue(':score1', $score[0]);
	$result->bindValue(':score2', $score[1]);
	$result->bindValue(':score3', $score[2]);
	$result->bindValue(':score4', $score[3]);
	$result->bindValue(':score5', $score[4]);
	$result->bindValue(':tot', $tot);
	$result->bindValue(':idPair', $idPair);
	$result->execute();
	return $str;
	
}

function getArrayKataFromIdForm($idForm)
{
	global $db;
	//metto su vettore i nomi delle tecniche
	$sql="SELECT katatype.idKatatype FROM 
	form INNER JOIN pair ON form.pair=pair.idPair
	INNER JOIN poule ON pair.poule=poule.idPoule
	INNER JOIN katatype ON poule.katatype=katatype.idKatatype
	WHERE idForm = :idForm";
	$result = $db->prepare($sql);
	$result->bindValue(':idForm', $idForm);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	
	$sql="SELECT * FROM katatype WHERE idKatatype = :idKatatype";
	$result = $db->prepare($sql);
	$result->bindValue(':idKatatype', $row["idKatatype"]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	
	$num=$row["numTechniques"];
	for($i=1; $i<=$num; $i++)
		$name[]=$row["t".$i];
	
	$name[]=$row["fcr"];
	
	return $name;
}

function updateAndSavePoulePlace($idPoule)
{
	global $db;
	$order=null;
	//$sql="SELECT idPair FROM pair WHERE poule='".$idPoule."' AND scoreTot IS NOT NULL ORDER BY scoreTot DESC";
	$sql="SELECT idPair, scoreTot, SUM(totForgotten) AS totForgotten, SUM(totWrong) AS totWrong, SUM(totMedium) AS totMedium, SUM(totSmall) AS totSmall FROM form
	INNER JOIN pair ON form.pair=pair.idPair
	WHERE poule = :poule AND scoreTot IS NOT NULL
	GROUP BY idPair
	ORDER BY scoreTot DESC, totForgotten, totWrong, totMedium, totSmall";
	$result = $db->prepare($sql);
	$result->bindValue(':poule', $idPoule);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		$order[]=$row["idPair"];
	}
	
	//ora ho l'ordine delle coppie
	$sql="UPDATE pair SET place = :place WHERE idPair = :idPair";
	$result = $db->prepare($sql);
	for($i=0; $i<count($order); $i++)
	{
		$result->bindValue(':place', ($i+1));
		$result->bindValue(':idPair', $order[$i]);
		$result->execute();
	}
	
}

function mixArray($vet)
{
	$nrs = $vet;
	$new=null;
	srand((float)microtime() * 1000000);
	shuffle($nrs);
	while (list(, $nr) = each($nrs)) {
	  $new[]=$nr;
	}
	return $new;
}

function find($dir, $pattern){
    // escape any character in a string that might be used to trick
    // a shell command into executing arbitrary commands
    $dir = escapeshellcmd($dir);
    // get a list of all matching files in the current directory
    $files = glob("$dir/$pattern");
    // find a list of all directories in the current directory
    // directories beginning with a dot are also included
    foreach (glob("$dir/{.[^.]*,*}", GLOB_BRACE|GLOB_ONLYDIR) as $sub_dir){
        $arr   = find($sub_dir, $pattern);  // resursive call
        $files = array_merge($files, $arr); // merge array with files from subdirectory
    }
    // return all found files
    return $files;
}
?>
