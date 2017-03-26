<!DOCTYPE HTML>
<?php
session_start();
require_once "../session.admin.inc.php";
$inputFileName = "read.xlsx";
//upload del file lo salvo nella stessa cartella
if(isset($_FILES["file"]))
{
	if ($_FILES["file"]["error"] > 0)
	{
		echo "Error: " . $_FILES["file"]["error"] . "<br />";
	}
	else
	{
		//echo "Upload: " . $_FILES["file"]["name"] . "<br />";
		//echo "Type: " . $_FILES["file"]["type"] . "<br />";
		//echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
		//echo "Stored in: " . $_FILES["file"]["tmp_name"];

		//move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" . $_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"],$inputFileName);
	}
}

require_once "../config.inc.php";
error_reporting(E_ALL);
set_time_limit(0);
date_default_timezone_set('Europe/London');


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>import kata</title>

</head>
<body>

<h2>PHPExcel Import</h2>


<!----form per upload del file ---->
<form method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" /> 
<input type="submit" name="import" value="Import" />
</form>



<?php
if(file_exists($inputFileName))
{
	/** Include path **/
	//set_include_path(get_include_path() . PATH_SEPARATOR . '../../../Classes/');

	/** PHPExcel_IOFactory */
	include 'Classes/PHPExcel/IOFactory.php';


	//echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);


	echo '<hr />';


	//var_dump($sheetData);

	/******************************************************************************/
	$sheetCount = $objPHPExcel->getSheetCount();
	//echo 'There ',(($sheetCount == 1) ? 'is' : 'are'),' ',$sheetCount,' WorkSheet',(($sheetCount == 1) ? '' : 's'),' in the WorkBook<br /><br />';

	//leggo tutti i nomi delle schede
	$sheetNames = $objPHPExcel->getSheetNames();
	$countSheet = 0;
	foreach($sheetNames as $sheetIndex => $sheetName) {
		//echo 'WorkSheet #',$sheetIndex,' is named "',$sheetName,'"<br />';
		
		//seleziono sheet
		//$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$sheetData = $objPHPExcel->setActiveSheetIndex($countSheet)->toArray(null,true,true,true);
		
		//leggo prima riga
		$row = $sheetData[1];
		//estraggo id del katatype
		$idKatatype = trim($row["A"]);
		$idKataName = trim($row["B"]);
		
		//controllo se esiste il kata
		
		$sql="SELECT idPoule,UPPER(type) AS type, mode FROM poule WHERE katatype = :katatype AND tournament = :idTournament ORDER BY type";
		$result = $db->prepare($sql);
		$result->bindValue(':katatype', $idKatatype);
		$result->bindValue(':idTournament', $_SESSION["idTournament"]);
		$result->execute();
		if($result->rowCount() > 0)
		{
		
			//controllo che non sia chiusa la categoria
			//determino se l'iscrizione è statta chiusa o no
			$sql="SELECT * FROM judoka 
			INNER JOIN pair ON judoka.idJudoka=pair.judoka 
			INNER JOIN poule ON pair.poule=poule.idPoule
			WHERE judoka.katatype = :katatype AND judoka.tournament = :idTournament
			GROUP BY type";
			$editable=false;
			$resultPoule = $db->prepare($sql);
			$resultPoule->bindValue(':katatype', $idKatatype);
			$resultPoule->bindValue(':idTournament', $_SESSION["idTournament"]);
			$resultPoule->execute();
			
			if($resultPoule->rowCount() == 0)
				$editable=true;
			
			if($editable)
			{
				$i = 4;
				//parto dalla quarta riga
				$row = $sheetData[$i];
				while(trim($row["B"])!="") {
					
					//print_r($row);
					
					$namesurname = trim($row["B"]);
					$country = trim($row["C"]);
					
					$sql="INSERT INTO judoka (namesurname, country ,tournament, katatype) VALUES (:namesurname, :country , :tournament, :katatype)";
					$result = $db->prepare($sql);
					$result->bindValue(':namesurname', $namesurname);
					$result->bindValue(':country', strtoupper($country));
					$result->bindValue(':tournament', $_SESSION["idTournament"]);
					$result->bindValue(':katatype', $idKatatype);
					$result->execute();
					//echo $sql."<br>";
					
					$row = $sheetData[++$i];
				}
				
				echo "<span style='color:green;'>+".($i-4)." ".$idKataName."</span><br>";
			}
			else {
				echo "<span style='color:red;'># ".$idKataName." is closed</span><br>";
			}
		}
		else {
			echo "<span style='color:grey;'>- ".$idKataName." not exist</span><br>";
		}
		$countSheet++;
	}


	//elimino file
	unlink($inputFileName);
}
?>
<body>
</html>
