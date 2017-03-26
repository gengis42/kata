<?php
include_once "timefunction.php";
include_once "function.php";
//session_start();

if(isset($_SESSION["idTournament"]))
	$idTournament = $_SESSION["idTournament"];
else {
	
	echo "<h1>select a tournament</h1>";
	die;
}

?>
<table width='100%' class='banner'>
<tr class='banner'>
	<td class='banner' align='center' width='1%'><?php
	$sql="SELECT * FROM tournament WHERE idTournament = :idTournament";
	$result = $db->prepare($sql);
	$result->bindValue(':idTournament', $idTournament);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	
	$i=0;
	$dir="image/tournamentlogos/";
	do
	{
		$filelogoname = find($dir,$row["idTournament"].".*");
		$dir="../".$dir;
		
	}while($i++<3 and count($filelogoname)==0);
	//$filelogoname = find("../image/tournamentbanner/",$row["idTournament"].".*");
	if(count($filelogoname)>0)
		echo "<img src='".$filelogoname[0]."' height='80px'>";
	else
		echo "<img src='' height='80px'>";
	?>
	</td>
	<td class='banner' align='center'><?php
	
	echo "<h1 class='banner' align='center'>".$row["name"]."</h1>";
	echo "<h3 class='banner' align='center'>".$row["place"]." - ".inputdataformat($row["date"])."</h3>";
	?></td>
</tr>
</table>
<hr>
