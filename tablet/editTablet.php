<!DOCTYPE HTML>
<?php
session_start();
//require_once "../session.admin.inc.php";
require_once "../config.inc.php";
require_once "../timefunction.php";

if(isset($_POST["save"]))
{
	$judge=$_POST["judge"];
	if($judge=="")
		$judge=null;
	else
		$judge=$_POST["judge"];
		
	$group=$_POST["group"];
	if($group=="")
		$group=null;
	else
		$group=$_POST["group"];
	
	$order=$_POST["grouporder"];
	if($order=="")
		$order=null;
	else
		$order=$_POST["grouporder"];
	

	$sql="UPDATE tablet SET name = :name, mac = :mac, description = :description, judge = :judge, tgroup = :tgroup, grouporder = :grouporder WHERE idTablet = :idTablet";
	$result = $db->prepare($sql);
	$result->bindValue(':name', $_POST["name"]);
	$result->bindValue(':mac', $_POST["mac"]);
	$result->bindValue(':description', $_POST["description"]);
	$result->bindValue(':judge', $judge);
	$result->bindValue(':tgroup', $group);
	$result->bindValue(':grouporder', $order);
	$result->bindValue(':idTablet', $_POST["idTablet"]);
	$result->execute();
	?>
	<script type='text/javascript'>
	parent.$.fancybox.close();
	</script>
	<?php
	die;
}

$sql="SELECT * FROM tablet WHERE idTablet = :idTablet";
$result = $db->prepare($sql);
$result->bindValue(':idTablet', $_GET["idTablet"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>

<form method='post'>
	<table>
		<tr><td colspan='2'>tablet</td></tr>
		<tr><td>mac</td><td><input type="text" name="mac" value='<?php echo $row["mac"]; ?>'/></td></tr>
		<tr><td>name</td><td><input type="text" name="name" value='<?php echo $row["name"]; ?>'/></td></tr>
		<tr><td>description</td><td><input type="text" name="description" value='<?php echo $row["description"]; ?>'/></td></tr>
		
		<tr><td>judge</td><td><select name="judge">
		<option value=''></option>
			<?php
			$sql="SELECT * FROM judge WHERE tournament = :idTournament";
			$resultJudge = $db->prepare($sql);
			$resultJudge->bindValue(':idTournament', $_SESSION["idTournament"]);
			$resultJudge->execute();
			while($rowJudge = $resultJudge->fetch(PDO::FETCH_ASSOC))
			{
				if($rowJudge["idJudge"]==$row["judge"])
					$selected='selected';
				else
					$selected='';
				
				echo "<option $selected value='".$rowJudge["idJudge"]."'>".$rowJudge["name"]."</option>";
			}
			?>
			</select></td></tr>
		<tr><td>group</td><td><select name="group">
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
			</select></td></tr>
		<tr><td>order</td><td><input type="text" name="grouporder" value='<?php echo $row["grouporder"]; ?>'/></td></tr>
	</table>
	
	
	
	<input type='hidden' name='idTablet' value='<?php echo $row["idTablet"]; ?>'/>
	<input type='submit' name='save' value='save'/>
</form>

<input type='button' name='cancel' value='cancel' onclick='parent.$.fancybox.close();'>
</body>
</html>
