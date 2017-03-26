<!DOCTYPE HTML>
<html>
<head>
<script type="text/javascript" src="../jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="assign.js?n=1"></script>
</head>
<?php
session_start();
require_once "../session.inc.php";
require_once "../config.inc.php";

if(isset($_POST["save"]))
{
	for($i=0; $i<$_POST["numJudges"]; $i++)
	{
		//$sql="UPDATE tablet SET form = :form WHERE idTablet = :idTablet";
		$sql="UPDATE form SET tablet = :tablet, status = '1' WHERE idForm = :idForm";
		$result = $db->prepare($sql);
		$result->bindValue(':idForm', $_POST["form".$i]);
		if( $_POST["device".$i] == "")
			$result->bindValue(':tablet', null);
		else
			$result->bindValue(':tablet', $_POST["device".$i]);
		$result->execute();
		
		//aggiorno il giudice solo se è a null
		$sql="SELECT judge FROM tablet WHERE idTablet = :idTablet";
		$result = $db->prepare($sql);
		$result->bindValue(':idTablet', $_POST["device".$i]);
		$result->execute();
		$row = $result->fetch(PDO::FETCH_ASSOC);
		
		$sql="UPDATE form SET judge = :judge WHERE idForm = :idForm AND judge IS NULL";
		$result = $db->prepare($sql);
		$result->bindValue(':judge', $row["judge"]);
		$result->bindValue(':idForm', $_POST["form".$i]);
		$result->execute();
	}
}

?>

<body>
<form method='post'>
<?php

if(isset($_GET["idPair"]))
{
	?>
	group 
	<select onchange='updateSelect(this.value);'>
		<option value=''></option>
			<?php
			$sql="SELECT * FROM tgroup";
			$resultTgroup = $db->query($sql);
			while($rowTgroup = $resultTgroup->fetch(PDO::FETCH_ASSOC))
			{
				if($rowTgroup["idTgroup"]==$row["tgroup"])
					$selected='selected';
				else
					$selected='';
				
				echo "<option $selected value='".$rowTgroup["idTgroup"]."'>".$rowTgroup["idTgroup"]."</option>";
			}
			?>
	</select>
	<br>
	<?php
	$count=0;
	$sql="SELECT * FROM form WHERE pair = :pair ORDER BY num";
	$result = $db->prepare($sql);
	$result->bindValue(':pair', $_GET["idPair"]);
	$result->execute();
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		echo $row["num"]." ";
		echo "<input type='hidden' name='form".$count."' value='".$row["idForm"]."'/>";
		?>
		<select name='device<?php echo $count; ?>' id='device<?php echo $count; ?>'>
			<option value=''>-</option>
			<?php
			$sql="SELECT * FROM tablet ORDER BY name";
			$resDevice = $db->query($sql);
			while($rowDevice = $resDevice->fetch(PDO::FETCH_ASSOC))
			{
				if($rowDevice["idTablet"]==$row["tablet"])
					$selected='selected';
				else
					$selected='';
					
				echo "<option $selected value='".$rowDevice["idTablet"]."'>".$rowDevice["name"]."</option>";
			}
			?>
		</select>
		<?php
		echo "<br>";
		$count++;
	}
	echo "<input type='hidden' name='numJudges' value='".$count."'/>";
	echo "<input type='submit' name='save' value='save'/>";
}
?>

</form>
</body>
<!--<button onclick='quick();'>asd</button>-->
</html>
