<!DOCTYPE HTML>
<?php
session_start();
require_once "session.inc.php";
//require_once "session.admin.inc.php";
require_once "config.inc.php";

if(isset($_POST["addTablet"]))
{
	//require_once "session.admin.inc.php";
	$sql="INSERT INTO tablet (mac, name, description) VALUES (:mac, :name, :description)";
	$result = $db->prepare($sql);
	$result->bindValue(':mac', $_POST["mac"]);
	$result->bindValue(':name', $_POST["name"]);
	$result->bindValue(':description', $_POST["description"]);
	$result->execute();
}
if(isset($_POST["delete"]))
{
	//require_once "session.admin.inc.php";
	$sql="DELETE FROM tablet WHERE idTablet = :idTablet";
	$result = $db->prepare($sql);
	$result->bindValue(':idTablet', $_POST["delete"]);
	$result->execute();
}
?>
<html>
<head>
<title>Tablets</title>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<!--fancybox-->
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script type="text/javascript" src="tablet.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">


</head>
<body>
<?php
require_once "top.php";
?>
<p>
<form method='post'>
<table>
	<tr>
		<td>mac</td>
		<td>name</td>
		<td>description</td>
		<td>judge</td>
		<td>form</td>
		<td>group/order</td>
		<td>battery</td>
		<td colspan='2'></td>
	</tr>
<?php
$sql="SELECT * FROM form RIGHT JOIN
tablet ON form.tablet = tablet.idTablet
LEFT JOIN
(SELECT idJudge, name AS jname FROM judge WHERE judge.tournament = :idTournament) AS judge
ON tablet.judge=judge.idJudge
GROUP BY tablet.name";
$result = $db->prepare($sql);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	echo "<tr>";
	echo "<td>".$row["mac"]."</td>";
	echo "<td>".$row["name"]."</td>";
	echo "<td>".$row["description"]."</td>";
	echo "<td>".$row["jname"]."</td>";
	echo "<td>".$row["idForm"]."</td>";
	echo "<td>".$row["tgroup"].$row["grouporder"]."</td>";
	echo "<td>".$row["battery"]."</td>";
	echo "<td><a class='editTablet' href='tablet/editTablet.php?idTablet=".$row["idTablet"]."'><img align='right' src='image/edit-icon.png' width='15' height='15'></a></td>";
	echo "<td><button type='submit' name='delete' value='".$row["idTablet"]."' onclick=\"return confirm('Confirm delete?')\">delete</button></td>";
	echo "</tr>";
}

?>

	<tr>
		<td><input type='text' name='mac'/></td>
		<td><input type='text' name='name'/></td>
		<td><input type='text' name='description'/></td>
		<td colspan='5'><input type='submit' name='addTablet' value='add'/></td>
	</tr>
</table>
</form>

<!--<a href='live/tablet.php' target="_blank">live</a>-->
<a href='tablet/monitor.php' target="_blank">monitor</a>
<a class='reset' href='tablet/reset.php'>reset</a>
</p>

</body>
</html>
