<table border='0'>
<tr>
	<?php
	require_once "../../config.inc.php";
	
	$sql="SELECT DISTINCT tgroup FROM tablet WHERE tgroup IS NOT NULL ORDER BY tgroup";
	$resultTgroup = $db->query($sql);
	
	$sql="SELECT DISTINCT katatype.name FROM katatype 
		INNER JOIN poule ON katatype.idKatatype = poule.katatype
		INNER JOIN pair ON poule.idPoule = pair.poule
		INNER JOIN form ON pair.idPair = form.pair
		INNER JOIN tablet ON form.tablet = tablet.idTablet
		WHERE tgroup = :tgroup";
	$resultNomeKata = $db->prepare($sql);
	while($rowTgroup = $resultTgroup->fetch(PDO::FETCH_ASSOC))
	{
		echo "<td>";
		echo $rowTgroup["tgroup"]." ";
		
		$resultNomeKata->bindValue(':tgroup', $rowTgroup["tgroup"]);
		$resultNomeKata->execute();
		$rowNomeKata = $resultNomeKata->fetch(PDO::FETCH_ASSOC);
		echo $rowNomeKata["name"];
		echo "</td>";
	}
	?>

</tr>
	
<tr>
<?php


//prendo i gruppi
$sql="SELECT DISTINCT tgroup FROM tablet WHERE tgroup IS NOT NULL ORDER BY tgroup";
$resultTgroup = $db->query($sql);

$sql="SELECT idTablet FROM tablet INNER JOIN form ON tablet.idTablet = form.tablet WHERE tgroup = :tgroup";
$resultIdTablet = $db->prepare($sql);
while($rowTgroup = $resultTgroup->fetch(PDO::FETCH_ASSOC))
{
	
	//prendo i tablet del gruppo
	$vetTablet = null;
	//$sql="SELECT idTablet FROM tablet LEFT JOIN judge ON tablet.judge = judge.idJudge WHERE tgroup='".$rowTgroup["tgroup"]."'";
	//$sql="SELECT idTablet FROM tablet WHERE tgroup = :tgroup AND form IS NOT NULL";
	
	$resultIdTablet->bindValue(':tgroup', $rowTgroup["tgroup"]);
	$resultIdTablet->execute();
	while($rowIdTablet = $resultIdTablet->fetch(PDO::FETCH_ASSOC))
	{
		$vetTablet[] = $rowIdTablet["idTablet"];
	}
	
	?>
	
	<td VALIGN="top">
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
			
			
			$sql="SELECT judge.name AS name FROM tablet INNER JOIN judge ON tablet.judge=judge.idJudge WHERE idTablet = :idTablet";
			$result = $db->prepare($sql);
			$result->bindValue(':idTablet', $id);
			$result->execute();
			$row = $result->fetch(PDO::FETCH_ASSOC);
			echo "<td>".$row["name"]."</td>";
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
			echo "<td>";
			
			$flag = false;
			for($i=0; $i<$numTechniques; $i++)
			{
				$flag = true;
				
				echo "<span style='color:grey'>";
				if($i+1 <10) echo "0";
				echo ($i+1)."] ";
				echo "</span>";
				
				if($row["p".($i+1)] != null)
					echo $row["p".($i+1)];

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
	</td>
<?php
}

?>
</tr>
</table>
