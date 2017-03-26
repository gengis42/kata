<!DOCTYPE HTML>
<?php
session_start();
require_once "../session.admin.inc.php";
$inputFileName = "judges.xlsx";
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
	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		
	$i = 4;
	//parto dalla quarta riga
	$row = $sheetData[$i];
	while(trim($row["B"])!="") {
		
		//print_r($row);
		
		$namesurname = trim($row["B"]);
		$country = trim($row["C"]);
		
		//inserisco giudice
		$sql="INSERT INTO judge (name, tournament, country) VALUES (:name, :tournament, :country)";
		$result = $db->prepare($sql);
		$result->bindValue(':name', $namesurname);
		$result->bindValue(':tournament', $_SESSION["idTournament"]);
		$result->bindValue(':country', strtoupper($country));
		$result->execute();
		//echo $sql."<br>";
		$idJudge = $db->lastInsertId(); //ultimo id appena inserito
		
		//inserisco abilitazioni
		if(trim($row["E"]) != "") { //Nage
			$sql="INSERT INTO ability (katatype, judge) VALUES ('1', :idJudge);";
			$result = $db->prepare($sql);
			$result->bindValue(':idJudge', $idJudge);
			$result->execute();
		}
		if(trim($row["F"]) != "") { //Katame
			$sql="INSERT INTO ability (katatype, judge) VALUES ('2', :idJudge);";
			$result = $db->prepare($sql);
			$result->bindValue(':idJudge', $idJudge);
			$result->execute();
		}
		if(trim($row["G"]) != "") { //Kime
			$sql="INSERT INTO ability (katatype, judge) VALUES ('3', :idJudge);";
			$result = $db->prepare($sql);
			$result->bindValue(':idJudge', $idJudge);
			$result->execute();
		}
		if(trim($row["H"]) != "") { //Ju
			$sql="INSERT INTO ability (katatype, judge) VALUES ('4', :idJudge);";
			$result = $db->prepare($sql);
			$result->bindValue(':idJudge', $idJudge);
			$result->execute();
		}
		if(trim($row["I"]) != "") { //Koshiki
			$sql="INSERT INTO ability (katatype, judge) VALUES ('5', :idJudge);";
			$result = $db->prepare($sql);
			$result->bindValue(':idJudge', $idJudge);
			$result->execute();
		}
		if(trim($row["J"]) != "") { //Kodokan
			$sql="INSERT INTO ability (katatype, judge) VALUES ('6', :idJudge);";
			$result = $db->prepare($sql);
			$result->bindValue(':idJudge', $idJudge);
			$result->execute();
		}
		if(trim($row["K"]) != "") { //Itsuzu
			$sql="INSERT INTO ability (katatype, judge) VALUES ('7', :idJudge);";
			$result = $db->prepare($sql);
			$result->bindValue(':idJudge', $idJudge);
			$result->execute();
		}
		if(trim($row["L"]) != "") { //3Nage
			$sql="INSERT INTO ability (katatype, judge) VALUES ('8', :idJudge);";
			$result = $db->prepare($sql);
			$result->bindValue(':idJudge', $idJudge);
			$result->execute();
		}
		if(trim($row["M"]) != "") { //3Katame
			$sql="INSERT INTO ability (katatype, judge) VALUES ('9', :idJudge);";
			$result = $db->prepare($sql);
			$result->bindValue(':idJudge', $idJudge);
			$result->execute();
		}
		if(trim($row["N"]) != "") { //3Kodokan
			$sql="INSERT INTO ability (katatype, judge) VALUES ('10', :idJudge);";
			$result = $db->prepare($sql);
			$result->bindValue(':idJudge', $idJudge);
			$result->execute();
		}
		
		//echo "<hr>";
		
		$row = $sheetData[++$i];
	}

	echo "<span style='color:green;'>+".($i-4)." judges</span><br>";

	//elimino file
	unlink($inputFileName);
}

?>
<body>
</html>
