<!DOCTYPE HTML>
<?php
session_start();
require_once "session.inc.php";
require_once "config.inc.php";
require_once "function.php";

if(isset($_POST["savemode"]))
{
								
	require_once "session.admin.inc.php";
	if($_POST["selectMode"]!='')
	{
		$sql="UPDATE poule SET mode = :mode, numJudges = :numJudges WHERE katatype = :katatype AND tournament = :idTournament";
		$result = $db->prepare($sql);
		$result->bindValue(':mode', $_POST["selectMode"]);
		$result->bindValue(':numJudges', $_POST["selectNumJudges"]);
		$result->bindValue(':katatype', $_GET["idKatatype"]);
		$result->bindValue(':idTournament', $_SESSION["idTournament"]);
		$result->execute();
	}
}

?>

<html>
<head>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<!--fancybox-->
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>

<?php
require_once "top.php";
require_once "banner.php";

$sql="SELECT * FROM katatype WHERE idKatatype = :katatype";
$result = $db->prepare($sql);
$result->bindValue(':katatype', $_GET["idKatatype"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
echo "<p>".$row["name"]."</p>";

//seleziono metodo di gara
$sql="SELECT mode, numJudges FROM poule WHERE katatype = :katatype AND tournament = :idTournament GROUP BY katatype";
$result = $db->prepare($sql);
$result->bindValue(':katatype', $_GET["idKatatype"]);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
$mode=$row["mode"];
$numJudges=$row["numJudges"];

//guardo se posso cambiare il modo
$canIChange=true;
$sql="SELECT * FROM form
	INNER JOIN pair ON form.pair=pair.idPair
	INNER JOIN poule ON pair.poule=poule.idPoule
	WHERE katatype = :katatype AND tournament = :idTournament";
$result = $db->prepare($sql);
$result->bindValue(':katatype', $_GET["idKatatype"]);
$result->bindValue(':idTournament', $_SESSION["idTournament"]);
$result->execute();
$cont=$result->rowCount();
if($cont>0)
	$canIChange=false;


if($_SESSION["user_level"]=="1")
{
	?>
	<form method='post'>
	mode
	<select name='selectMode'>
		<option value=''>-</option>
		<option value='F' <?php if($mode=='F') echo "selected";?>>F</option>
		<option value='AF' <?php if($mode=='AF') echo "selected";?>>AF</option>
		<option value='ABF' <?php if($mode=='ABF') echo "selected";?>>ABF</option>
	</select>
	judges
	<select name='selectNumJudges'>
		<option value='5' <?php if($numJudges==5) echo "selected";?>>5</option>
		<option value='3' <?php if($numJudges==3) echo "selected";?>>3</option>
	</select>

	<?php

	if($mode=='' or $canIChange) //devo farli selezionare un modo
	{
		echo "<input type='submit' name='savemode' value='save mode'/>";
	}
}
if($mode!='') //mostro il suo link
{
	switch($mode)
	{
		case "F":
			echo "ONLY FINAL ";
			echo "<a href='draw/drawOnlyFinal.php?idKatatype=".addslashes($_GET['idKatatype'])."'>draw</a>";
			break;
		case "AF":
			echo "AF ";
			echo "<a href='draw/drawA.php?idKatatype=".addslashes($_GET['idKatatype'])."'>drawA</a> ";
			echo "<a href='draw/drawAF.php?idKatatype=".addslashes($_GET['idKatatype'])."'>drawF</a> ";
			break;
		case "ABF":
			echo "ABF ";
			echo "<a href='draw/drawAB.php?idKatatype=".addslashes($_GET['idKatatype'])."'>drawAB</a> ";
			echo "<a href='draw/drawABF.php?idKatatype=".addslashes($_GET['idKatatype'])."'>drawF</a> ";
			break;
	}
}

?>
</form>

</body>
</form>
</html>