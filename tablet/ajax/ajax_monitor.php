<?php
require_once "../../config.inc.php";
?>

<table border='0'>
<tr>
	<?php
	
	$array = array();
	if(isset($_GET["a"]) and $_GET["a"] != null)
		$array = str_split($_GET["a"]);

	$sql="SELECT DISTINCT judoka.namesurname FROM judoka
		INNER JOIN pair ON judoka.idJudoka = pair.judoka
		INNER JOIN form ON pair.idPair = form.pair
		INNER JOIN tablet ON form.tablet = tablet.idTablet
		WHERE tablet.tgroup = :tgroup";
	$resultTgroup = $db->prepare($sql);

	$sql = "SELECT katatype.name, poule.type, poule.numJudges, poule.idPoule FROM katatype
		INNER JOIN poule ON katatype.idKatatype = poule.katatype
		INNER JOIN tgroup ON poule.idPoule = tgroup.poule
		WHERE tgroup.idTgroup = :tgroup";
	$resultKataPoule = $db->prepare($sql);
	
	$arrayIdPoule = array();
	$indexArrayIdPoule = 0;
	
	foreach($array as $group)
	{
		$resultTgroup->bindValue(':tgroup', $group);
		$resultTgroup->execute();
		$rowTgroup = $resultTgroup->fetch(PDO::FETCH_ASSOC);

		$resultKataPoule->bindValue(':tgroup', $group);
		$resultKataPoule->execute();
		$rowKataPoule = $resultKataPoule->fetch(PDO::FETCH_ASSOC);
		
		$arrayIdPoule[] = $rowKataPoule["idPoule"];
		
		echo "<td>";
		echo "<div style='text-align: center;'>".$group."</div>";
		echo "<a class='iframe' href='dragJudges.php?group=".$group."&numJudges=".$rowKataPoule["numJudges"]."'>judges</a>";
		echo " - ";
		echo "<a class='iframe' href='dragPoule.php?group=".$group."'>kata</a>";
		echo "<hr>";
		echo $rowKataPoule["name"] . " <b>" . $rowKataPoule["type"]."</b>";
		echo "<hr>";
		echo "<span style='font-size:8pt'>";
		//kata e tipo
		//echo $rowTgroup["name"]." - <b>".$rowTgroup["type"]."</b>";
		//echo "<br>";
		echo $rowTgroup["namesurname"];
		echo "</span></td>";
	}
	?>

</tr>
	
<tr>
<?php

$sql="SELECT idTablet FROM tablet INNER JOIN form ON tablet.idTablet = form.tablet WHERE tgroup = :tgroup ORDER BY idForm";
$resultIdTablet = $db->prepare($sql);
//while($rowTgroup = $resultTgroup->fetch(PDO::FETCH_ASSOC))
foreach($array as $group)
{
	
	//prendo i tablet del gruppo
	$vetTablet = array();
	//$sql="SELECT idTablet FROM tablet LEFT JOIN judge ON tablet.judge = judge.idJudge WHERE tgroup='".$rowTgroup["tgroup"]."'";
	//$sql="SELECT idTablet FROM tablet WHERE tgroup = :tgroup AND form IS NOT NULL";
	
	//$resultIdTablet->bindValue(':tgroup', $rowTgroup["tgroup"]);
	$resultIdTablet->bindValue(':tgroup', $group);
	$resultIdTablet->execute();
	while($rowIdTablet = $resultIdTablet->fetch(PDO::FETCH_ASSOC))
	{
		$vetTablet[] = $rowIdTablet["idTablet"];
	}
	
	?>
	<td VALIGN="top">

	<?php

	if(count($vetTablet))
	{

	?>
	<table border='1' align="">
		<tr>
		<?php
		
		//stampo nomi giudici
		foreach($vetTablet as $id)
		{
			$sql="SELECT  MAX(numTechniques) AS num FROM tablet
			INNER JOIN form ON tablet.idTablet = form.tablet
			INNER JOIN pair ON form.pair=pair.idPair
			INNER JOIN poule ON pair.poule=poule.idPoule
			INNER JOIN katatype ON poule.katatype=katatype.idKatatype
			WHERE tablet.idTablet = :idTablet";
			$result = $db->prepare($sql);
			$result->bindValue(':idTablet', $id);
			$result->execute();
			$row = $result->fetch(PDO::FETCH_ASSOC);
			
			$numTechniques = $row["num"];
			
			
			$sql="SELECT judge.name AS name, tablet.battery FROM tablet INNER JOIN judge ON tablet.judge=judge.idJudge WHERE idTablet = :idTablet";
			$result = $db->prepare($sql);
			$result->bindValue(':idTablet', $id);
			$result->execute();
			$row = $result->fetch(PDO::FETCH_ASSOC);
			echo "<td><span style='font-size:8pt'>" . $row["name"] . "</span><br>" . $row["battery"]."%" . "</td>";
		}

		?>
		</tr>
		
		<tr>
		<?php

		foreach($vetTablet as $id)
		{
			$sql="SELECT * FROM tablet INNER JOIN form ON tablet.idTablet = form.tablet WHERE idTablet = :idTablet";
			$result = $db->prepare($sql);
			$result->bindValue(':idTablet', $id);
			$result->execute();
			$row = $result->fetch(PDO::FETCH_ASSOC);
			echo "<td style='font-size:8pt'>";
			
			$flag = false;
			for($i=0; $i<$numTechniques; $i++)
			{
				$flag = true;
				
				echo "<span style='color:grey'>";
				if($i+1 <10) echo "0";
				echo ($i+1)."] ";
				echo "</span>";
				
				if($row["p".($i+1)] != null)
				{
					$p = $row["p".($i+1)];
					if((int)substr($p,-2) > 0)
						echo "<span style='color:red'>$p</span>";
					else
						echo $p;
				}
				echo "<br>";
			}
			
			//fluidità
			if($flag)
			{
				if($row["fcr"] != null)
					echo "<span style='color:grey'>fcr: </span>".$row["fcr"];
				else
					echo "<span style='color:grey'>fcr:</span>";
			}
			echo "</td>";
		}
		
		

		?>
		</tr>
	</table>
	<?php

	}
	else{

		echo "<div id='div_next_".$group."'>";
		//echo "<button id='btnValidatePlusNext_".$group."' onclick='validate_plus_next(\"".$group."\", ".$rowKataPoule["idPoule"].")'>validate + next</button>";
		//echo "<button id='btnAssignNext_".$group."' onclick='assign_next(\"".$group."\", ".$rowKataPoule["idPoule"].")'>next</button>";
		echo "<br>";
		echo "<a style='color: blue;' id='btnValidatePlusNext_".$group."' onclick='validate_plus_next(\"".$group."\", ".$arrayIdPoule[$indexArrayIdPoule].")'>[validate + next]</a>";
		echo "<br>";
		echo "<br>";
		echo "<hr>";
		echo "<br>";
		echo "<a style='color: blue;' id='btnAssignNext_".$group."' onclick='assign_next(\"".$group."\", ".$arrayIdPoule[$indexArrayIdPoule].")'>[next]</a>";
		echo "<br>";
		echo "<br>";
		echo "<hr>";
		echo "<br>";
		

		//validate
		$sql="SELECT judoka.namesurname, form.status, pair.idPair, pair.scoreTot FROM form
		INNER JOIN pair ON form.pair = pair.idPair
		INNER JOIN judoka ON pair.judoka = judoka.idJudoka
		INNER JOIN tgroup ON pair.poule = tgroup.poule
		WHERE tgroup.idTgroup = :tgroup AND form.status = '2' AND pair.scoreTot IS NULL
		GROUP BY pair.idPair ORDER BY numOrder DESC";
		$result = $db->prepare($sql);
		$result->bindValue(':tgroup', $group);
		$result->execute();

		while($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			//first is the next
			echo "validate: ".$row["namesurname"]."<br>";
			break;

		}

		//next
		$sql="SELECT judoka.namesurname, form.status, pair.idPair FROM form
		INNER JOIN pair ON form.pair = pair.idPair
		INNER JOIN judoka ON pair.judoka = judoka.idJudoka
		INNER JOIN tgroup ON pair.poule = tgroup.poule
		WHERE tgroup.idTgroup = :tgroup AND form.status = '0' GROUP BY pair.idPair ORDER BY numOrder";
		$result = $db->prepare($sql);
		$result->bindValue(':tgroup', $group);
		$result->execute();

		while($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			//first is the next
			echo "next: ".$row["namesurname"]."<br>";
			break;
		}

		echo "</div>";
	}
	
	
	
	//echo $arrayIdPoule[$indexArrayIdPoule];
	
	$indexArrayIdPoule++;
	?>
	</td>
<?php
}

?>
</tr>
</table>
