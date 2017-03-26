<!DOCTYPE HTML>
<html>
<head>
<script type="text/javascript" src="../jquery-1.7.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="../style.css">
<script type="text/javascript" src="result.js"></script>

<script type="text/javascript">
setInterval("updateLivePouleResult(<?php echo $_GET["idPoule"] ?>);", 2000);
</script>
</head>
<body>

<?php
require_once "../config.inc.php";

$sql="SELECT * FROM poule INNER JOIN katatype ON poule.katatype=katatype.idKatatype WHERE idPoule = :idPoule";
$result = $db->prepare($sql);
$result->bindValue(':idPoule', $_GET["idPoule"]);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);

echo "<p>".$row["name"]." - <b>".$row["type"]."</b></p>";

?>
<table id="liveresult">

<table>

</body>
</html>
