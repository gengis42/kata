<!DOCTYPE HTML>
<?php
session_start();
require_once "../config.inc.php";
require_once "../function.php";
/** Error reporting */
error_reporting(E_ALL);

//date_default_timezone_set('Europe/Rome');

/** Include PHPExcel */
require_once 'Classes/PHPExcel.php';

/*$sql="SELECT numJudges FROM tournament WHERE idTournament = :idTournament";
$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
$numJudges=$row["numJudges"];
*/
		
// Create new PHPExcel object
echo date('H:i:s') , " Create new PHPExcel object" , PHP_EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
echo date('H:i:s') , " Set document properties" , PHP_EOL;
$objPHPExcel->getProperties()->setCreator("Palazen")
							 ->setLastModifiedBy("")
							 ->setTitle("export")
							 ->setSubject("")
							 ->setDescription("")
							 ->setKeywords("")
							 ->setCategory("");


// Add some data
/*echo date('H:i:s') , " Add some data" , PHP_EOL;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');

// Rename worksheet
echo date('H:i:s') , " Rename worksheet" , PHP_EOL;
$objPHPExcel->getActiveSheet()->setTitle('Simple');
*/

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$sql="SELECT * FROM poule INNER JOIN katatype ON poule.katatype=katatype.idKatatype WHERE idPoule = :idPoule";
$result = $db->prepare($sql);
$result->bindValue(':idPoule', $_GET["idPoule"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
$numTechniques=$row["numTechniques"];
$numJudges=$row["numJudges"];
//echo "<form method='post'>";
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "TECHNIQUE");

for($i=1; $i<=$numTechniques; $i++)
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i + 1, $row["t".$i]);
}

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row["numTechniques"] + 2, "FLUIDITY, COURSE, RHYTHM");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row["numTechniques"] + 3, "TOTAL");


//inserisco prima colonna
$sql="SELECT * FROM pair INNER JOIN judoka ON pair.judoka=judoka.idJudoka WHERE poule = :poule ORDER BY numOrder";
$result = $db->prepare($sql);
$result->bindValue(':poule', $_GET["idPoule"]);
$result->execute();
$r=0;
$c=0;
$count=0;
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	$r=1;
	$c=$count*($numJudges + 1) + 1;
	
	//numeri in alto
	for($i=0; $i<$numJudges; $i++)
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c+$i, 1, ($count+1)."-".($i+1));
	
	
	$vet1=null;
	$vet2=null;
	$vet3=null;
	$vet4=null;
	$vet5=null;
	
	$sql="SELECT * FROM form WHERE pair = :pair";
	$resultPair = $db->prepare($sql);
	$resultPair->bindValue(':pair', $row["idPair"]);
	$resultPair->execute();
	$n=0;
	while($rowPair = $resultPair->fetch(PDO::FETCH_ASSOC))
	{
		$name="vet".($n+1);
		$temp=null;
		for($i=0; $i<$numTechniques; $i++)
		{
			$point=convertStringZerotoPoint($rowPair["p".($i+1)]);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c+$n, $i+2, $point);
			$temp[]=$point;
		}
		$temp[]=$rowPair["fcr"];
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c+$n, $i+2, $rowPair["fcr"]);
		$$name=$temp;
		$n++;
	}
	
	//totali
	for($n=0; $n<$numJudges; $n++)
	{
		$col=PHPExcel_Cell::stringFromColumnIndex($c+$n);
		$str="=SUM(".$col."2:".$col.($numTechniques+2) . ")";
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c+$n, $numTechniques+3, $str);
	}
	
	//tot-max e min
	for($i=0; $i<count($temp) + 1; $i++)
	{
		$colA=PHPExcel_Cell::stringFromColumnIndex($c);
		$colB=PHPExcel_Cell::stringFromColumnIndex($c+$numJudges-1);
		$str="=SUM(".$colA.($i+2).":".$colB.($i+2).") - MAX(".$colA.($i+2).":".$colB.($i+2).") - MIN(".$colA.($i+2).":".$colB.($i+2).")";
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c+$numJudges, $i+2, $str);
	}
	
	/*
	//faccio i totali
	for($n=0; $n<$numJudges; $n++)
	{
		$name="vet".($n+1);
		$temp=$$name;
		$tot=0;
		for($i=0; $i<count($temp); $i++)
			$tot+=$temp[$i];
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c+$n, $numTechniques+3, $tot);
	}
	
	//tolgo i max e min
	for($i=0; $i<count($temp); $i++)
	{
		if($numJudges==3)
		{
			$sum=$vet1[$i]+$vet2[$i]+$vet3[$i];
		}
		else
		{
			$sum=$vet1[$i]+$vet2[$i]+$vet3[$i]+$vet4[$i]+$vet5[$i];
			$sum-=max($vet1[$i],$vet2[$i],$vet3[$i],$vet4[$i],$vet5[$i]);
			$sum-=min($vet1[$i],$vet2[$i],$vet3[$i],$vet4[$i],$vet5[$i]);
		}
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c+$numJudges, $i+2, $sum);
	}
	*/
	$count++;
}

//imposto larghezza automatica a tutte le colonne
$sheet = $objPHPExcel->getActiveSheet();
$toCol = PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn());
for($i = $fromCol; $i <= $toCol; $i++)
	$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setAutoSize(true);
	


// Save Excel 2007 file
echo date('H:i:s') , " Write to Excel2007 format" , PHP_EOL;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', __FILE__) , PHP_EOL;


// Echo memory peak usage
echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , PHP_EOL;

// Echo done
echo date('H:i:s') , " Done writing file" , PHP_EOL;
