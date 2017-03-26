<!DOCTYPE HTML>

<?php
session_start();
require_once "../session.inc.php";
require_once "../config.inc.php";
?>

<html>
<head>
<script type="text/javascript" src="../jquery-1.7.2.min.js"></script>
<!--fancybox-->
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<link rel="stylesheet" type="text/css" href="../style.css">

 <style>
	.verticaltext
	{
		padding-top:100px;
		text-align: center;
		vertical-align:middle;
	}
	.rotate_text
	{
		white-space: nowrap;
		display:block;
		text-align:center;
		width:20px;
		position:relative;
		
		transform: rotate(-90deg);
		/*
		-moz-transform: rotate(-90deg);
		writing-mode: tb-rl;
		filter: flipv fliph;
*/
	}
   </style>
</head>
<body>
<?php
require_once "../banner.php";
require_once "judge.php";
require_once "../function.php";

require_once("../pChart/pChart/pData.class");
require_once("../pChart/pChart/pChart.class");

if($_GET["type"]=="F")
	$type=" (poule.type='F') ";
else
	$type=" (poule.type='A' OR poule.type='B') ";


//conto quanti giudici ci sono
/*$sql="SELECT numJudges FROM tournament WHERE idTournament = :idTournament";
$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
$numJudges=$row["numJudges"];
*/
//scorro tutti i kata
$sql="SELECT idPoule,idKatatype,name, numTechniques, numJudges FROM poule
	INNER JOIN katatype ON poule.katatype=katatype.idKatatype 
	WHERE tournament = :idTournament
	GROUP BY katatype";
$resultKata = $db->prepare($sql);
$resultKata->bindValue(':idTournament', $_SESSION["idTournament"]);
$resultKata->execute();

$count=0;
while($rowKata = $resultKata->fetch(PDO::FETCH_ASSOC))
{
	$numJudges=$rowKata["numJudges"];
	echo "<h3><b>".$rowKata["name"]."</b></h3>";
	$numTechniques = $rowKata["numTechniques"]; ///////////////////////////////////////////////////////////////////////////7
	//pero ogni kata trovo le form da valutare estraggo i judici che ci hanno partecipato
	$vetJudge=null;
	$sql="SELECT form.judge, judge.name FROM judge
	INNER JOIN form ON judge.idJudge=form.judge
	INNER JOIN pair ON form.pair=pair.idPair
	INNER JOIN poule ON pair.poule=poule.idPoule
	WHERE poule.katatype = :katatype AND poule.tournament = :idTournament AND $type AND judge IS NOT NULL
	GROUP BY form.judge";
	$result = $db->prepare($sql);
	$result->bindValue(':katatype', $rowKata["idKatatype"]);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
		$vetJudge[]= new Judge($row["judge"],$row["name"]);
	
	//trovo tutte le coppie da valutare che sono state già validate
	
	$sql="SELECT idPair FROM pair 
	INNER JOIN poule ON pair.poule=poule.idPoule
	WHERE poule.katatype = :katatype AND poule.tournament = :idTournament AND $type
	AND scoreTot IS NOT NULL"; //solo quelle validate
	$resultPair = $db->prepare($sql);
	$resultPair->bindValue(':katatype', $rowKata["idKatatype"]);
	$resultPair->bindValue(':idTournament', $_SESSION["idTournament"]);
	$resultPair->execute();
	while($rowPair = $resultPair->fetch(PDO::FETCH_ASSOC))
	{
		//tiro fuori i 5 giudici
		$vj=null;
		$vjnome=null; //serve per stampare la tabella
		$sql="SELECT judge, name FROM form LEFT JOIN judge ON form.judge=judge.idJudge WHERE pair = :pair AND judge IS NOT NULL";
		$resultForm = $db->prepare($sql);
		$resultForm->bindValue(':pair', $rowPair["idPair"]);
		$resultForm->execute();
		while($rowForm = $resultForm->fetch(PDO::FETCH_ASSOC))
		{
			$vj[]=$rowForm["judge"];
			$vjnome[]=$rowForm["name"];
		}
		if(count($vj)!=$numJudges)
		{
			echo "<H1>FORM SENZA GIUDICI</H1>";
			break;
		}
		//prendo coppia per coppia i suoi punteggi
		$vetPoint=null;
		for($i=1; $i<=$numTechniques; $i++)
		{
			$vp=null;
			$sql="SELECT p$i,judge FROM form WHERE pair = :pair";
			$resultForm = $db->prepare($sql);
			$resultForm->bindValue(':pair', $rowPair["idPair"]);
			$resultForm->execute();
			while($rowForm = $resultForm->fetch(PDO::FETCH_ASSOC))
			{
				$vp[]=convertStringZerotoPoint($rowForm["p$i"]);
			}
			$vetPoint[]=new JudgeMatrix($numJudges,$vp[0],$vp[1],$vp[2],$vp[3],$vp[4],$vp[5]);
		}
		
		//fcr
		$vp=null;
		$sql="SELECT fcr,judge FROM form WHERE pair = :pair";
		$resultForm = $db->prepare($sql);
		$resultForm->bindValue(':pair', $rowPair["idPair"]);
		$resultForm->execute();
		while($rowForm = $resultForm->fetch(PDO::FETCH_ASSOC))
		{
			$vp[]=($rowForm["fcr"]);
		}
		$vetPoint[]=new JudgeMatrix($numJudges,$vp[0],$vp[1],$vp[2],$vp[3],$vp[4],$vp[5]);
		
		/*foreach($vj as $val)
		{
			echo $val." " ;
		}*/
		
echo "<table>";
echo "<tr class='normal'>";
echo "<td>";
		echo "<table>";
		$spacechar=8;
		$dimspace=0;
		//trovo il nome più lungo
		for($i=0; $i<count($vjnome); $i++)
		{
			$tempdim = strlen($vjnome[$i]) * $spacechar;
			if($tempdim>$dimspace)
				$dimspace = $tempdim;
		}
		if($numJudges==3)
			echo "<tr><td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[0]."</div></td>
			<td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[1]."</div></td>
			<td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[2]."</div></td></tr>";
		else
			echo "<tr><td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[0]."</div></td>
			<td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[1]."</div></td>
			<td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[2]."</div></td>
			<td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[3]."</div></td>
			<td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[4]."</div></td></tr>";
		foreach($vetPoint as $val)
		{
			echo $val->printMatrix();
		}
		echo "</table>";
echo "</td>";
echo "<td>";
		//trovo i punteggi sballati e li carico
		echo "<table>";
		if($numJudges==3)
			echo "<tr><td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[0]."</div></td>
			<td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[1]."</div></td>
			<td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[2]."</div></td></tr>";
		else
			echo "<tr><td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[0]."</div></td>
			<td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[1]."</div></td>
			<td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[2]."</div></td>
			<td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[3]."</div></td>
			<td class='verticaltext' style='padding-top:". $dimspace ."px'><div class='rotate_text'>".$vjnome[4]."</div></td></tr>";
		foreach($vetPoint as $riga)
		{
			echo "<tr align='center'>";
			$c=null;
			$c[] = $riga->getP1();
			$c[] = $riga->getP2();
			$c[] = $riga->getP3();
			$c[] = $riga->getP4();
			$c[] = $riga->getP5();
			
			$a = $riga->getAverage();
			
			for($i=0; $i<$numJudges; $i++)
			{
				echo "<td >";
				$j=null;
				if($c[$i]-$a>=0.75)
				{
					$j=findJudge($vetJudge,$vj[$i]);
					if($j>=0)
					{
						$vetJudge[$j]->addPlus();
					}
					//echo "+";
					echo "<b><span style='color: DarkGreen'>+</span></b>";
				}
				elseif($c[$i]-$a<=-0.75)
				{
					$j=findJudge($vetJudge,$vj[$i]);
					if($j>=0)
					{
						$vetJudge[$j]->addMinus();
					}
					//echo "-";
					echo "<b><span style='color: red'>-</span></b>";
				}
				else
				{
					echo "&deg;";
					//echo " ";
				}
				echo "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<br>";
	}


	//riordino
	usort($vetJudge, "cmpJudge");
	$arrayPlus=null;
	$arrayMinus=null;
	$arrayName=null;
	foreach($vetJudge as $val)
	{
		//echo $val->printJudge();
		$arrayPlus[]=$val->getPlus();
		$arrayMinus[]=$val->getMinus();
		$arrayName[]=$val->getName();
		echo $val->printJudge();
	}

	//stampo grafico
	if(count($arrayPlus)>0)
	{
		/*
		// Dataset definition 
		$DataSet = new pData;
		//$DataSet->AddPoint(array(1,4,-3,2,-3,3,2,1,0,7,4,-3,2,-3,3,5,1,0),"Plus");
		//$DataSet->AddPoint(array(0,-3,-4,1,-2,2,1,0,-1,6,3,-4,1,-4,2,4,0,-1),"Minus");
		$DataSet->AddPoint($arrayPlus,"s1");
		$DataSet->AddPoint($arrayMinus,"s2");
		//$DataSet->AddPoint($arrayName,"Name");
		$DataSet->AddAllSeries();
		$DataSet->RemoveSerie("Name");
		
		//$DataSet->SetAbsciseLabelSerie("Name");
		
		$DataSet->SetSerieName("Plus","s1");
		$DataSet->SetSerieName("Minus","s2");
		*/
		$DataSet = new pData;
		$DataSet->AddPoint($arrayPlus,"Serie1");
		$DataSet->AddPoint($arrayMinus,"Serie2");
		$DataSet->AddPoint($arrayName,"Serie3");
		$DataSet->AddAllSeries();
		$DataSet->RemoveSerie("Serie3");
		$DataSet->SetAbsciseLabelSerie("Serie3");
		$DataSet->SetSerieName("Plus","Serie1");
		$DataSet->SetSerieName("Minus","Serie2");
		//$DataSet->SetYAxisName("Temperature");
		//$DataSet->SetYAxisUnit("°C");
		//$DataSet->SetXAxisUnit("h");
			 // Initialise the graph
			 
		/*
		$Test = new pChart(700,230);
		$Test->drawGraphAreaGradient(132,173,131,50,TARGET_BACKGROUND);

		$Test->setFontProperties("pChart/Fonts/tahoma.ttf",8);
		$Test->setGraphArea(120,20,675,190);
		$Test->drawGraphArea(213,217,221,FALSE);
		$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_ADDALL,213,217,221,TRUE,0,2,TRUE);
		$Test->drawGraphAreaGradient(163,203,167,50);
		$Test->drawGrid(4,TRUE,230,230,230,20);

		// Draw the bar chart
		$Test->drawStackedBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),70);

		// Draw the title
		$Title = "  Average Temperatures during\r\n  the first months of 2008  ";
		$Test->drawTextBox(0,0,50,230,$Title,90,255,255,255,ALIGN_BOTTOM_CENTER,TRUE,0,0,0,30);

		// Draw the legend
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->drawLegend(610,10,$DataSet->GetDataDescription(),236,238,240,52,58,82);

		// Render the picture
		$Test->addBorder(2);
		* */
		// Initialise the graph
		$Test = new pChart(700,400);
		 
		$Test->setFontProperties("../pChart/Fonts/tahoma.ttf",10);
		$Test->setGraphArea(50,30,585,200);
		$Test->drawFilledRoundedRectangle(7,7,693,393,5,240,240,240);
		$Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);
		$Test->drawGraphArea(255,255,255,TRUE);
		$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,50,50,50,TRUE,90,2,TRUE);
		$Test->drawGrid(4,TRUE,200,200,200,50);

		// Draw the 0 line
		$Test->setFontProperties("../pChart/Fonts/tahoma.ttf",6);
		$Test->drawTreshold(0,143,55,72,TRUE,TRUE);

		// Draw the bar graph
		$Test->drawOverlayBarGraph($DataSet->GetData(),$DataSet->GetDataDescription());
		 
		// Finish the graph
		$Test->setFontProperties("../pChart/Fonts/tahoma.ttf",8);
		$Test->drawLegend(600,30,$DataSet->GetDataDescription(),255,255,255);
		$Test->setFontProperties("../pChart/Fonts/tahoma.ttf",10);
		$Test->drawTitle(50,22,$rowKata["name"],50,50,50,585);

		$Test->Render("../tmpChart/". $count . ".png");
		echo "<img src='"."../tmpChart/". $count . ".png"."'>";
	}
	echo "<br><hr>";
	
	$count++;
}


?>

</body>
</html>
