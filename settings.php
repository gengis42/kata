<!DOCTYPE HTML>
<?php
session_start();
require_once "session.inc.php";
require_once "session.admin.inc.php";
require_once "config.inc.php";
require_once "function.php";

if(isset($_POST["saveClassPoint"]))
{
	$sql="UPDATE tournament SET classPoint1 = :classPoint1, classPoint2 = :classPoint2, classPoint3 = :classPoint3, classPoint4 = :classPoint4, classPoint5 = :classPoint5, classPoint6 = :classPoint6 WHERE idTournament = :idTournament";
	$result = $db->prepare($sql);
	$result->bindValue(':classPoint1', $_POST["classPoint1"]);
	$result->bindValue(':classPoint2', $_POST["classPoint2"]);
	$result->bindValue(':classPoint3', $_POST["classPoint3"]);
	$result->bindValue(':classPoint4', $_POST["classPoint4"]);
	$result->bindValue(':classPoint5', $_POST["classPoint5"]);
	$result->bindValue(':classPoint6', $_POST["classPoint6"]);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
}
if(isset($_POST["submitImage"]))
{
	$allowedExts = array("jpg", "jpeg", "gif", "png", "bmp", "JPG", "JPEG", "GIF", "PNG");
	$extension = end(explode(".", $_FILES["file"]["name"]));
	if (($_FILES["file"]["size"] < 5000000)
	&& in_array($extension, $allowedExts))
	{
		if ($_FILES["file"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		}
		else
		{
			//elimino i file con lo stesso nome
			$filelogoname = find("image/tournamentlogos/",$_SESSION["idTournament"].".*");
			foreach($filelogoname as $filename)
				unlink($filename);
			if (file_exists("upload/" . $_FILES["file"]["name"]))
			{
				echo $_FILES["file"]["name"] . " already exists. ";
			}
			else
			{
				//move_uploaded_file($_FILES["file"]["tmp_name"], "image/tournamentlogos/" . $_FILES["file"]["name"]);
				move_uploaded_file($_FILES["file"]["tmp_name"], "image/tournamentlogos/" . $_SESSION["idTournament"] .".". $extension);
				//echo "Stored in: " . "image/tournamentlogos/" . $_FILES["file"]["name"];
			}
		}
	}
	else
	{
		echo $_FILES["file"]["size"];
		echo $_FILES["file"]["type"]."Invalid file";
	}
}


?>

<html>
<head>
<title>Settings</title>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<!--fancybox-->
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script type="text/javascript" src="tournament.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">


</head>
<body>
<?php
require_once "top.php";
require_once "banner.php";
?>
club ranking points
<form method='post'>
<table>
	<tr align='center'>
		<td>1°</td>
		<td>2°</td>
		<td>3°</td>
		<td>4°</td>
		<td>5°</td>
		<td>6°</td>
		<td></td>
	</tr>
	<?php
	$sql="SELECT * FROM tournament WHERE idTournament = :idTournament";
	$result = $db->prepare($sql);
	$result->bindValue(':idTournament', $_SESSION["idTournament"]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	?>
	<tr>
		<td><input type='text' name='classPoint1' style='text-align:center' value='<?php echo $row["classPoint1"]; ?>' size='3'/></td>
		<td><input type='text' name='classPoint2' style='text-align:center' value='<?php echo $row["classPoint2"]; ?>' size='3'/></td>
		<td><input type='text' name='classPoint3' style='text-align:center' value='<?php echo $row["classPoint3"]; ?>' size='3'/></td>
		<td><input type='text' name='classPoint4' style='text-align:center' value='<?php echo $row["classPoint4"]; ?>' size='3'/></td>
		<td><input type='text' name='classPoint5' style='text-align:center' value='<?php echo $row["classPoint5"]; ?>' size='3'/></td>
		<td><input type='text' name='classPoint6' style='text-align:center' value='<?php echo $row["classPoint6"]; ?>' size='3'/></td>
		<td><button type='submit' name='saveClassPoint'>save</button></td>
	</tr>
</table>
</form>

<hr>

logo image
<br>

<?php
$filelogoname = find("image/tournamentlogos/",$row["idTournament"].".*");
if(count($filelogoname)>0)
	echo "<img src='".$filelogoname[0]."' height='100px'>";


?>
<form method="post" enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" /> 
<br />
<input type="submit" name="submitImage" value="load image" />
</form>

</body>
</html>
