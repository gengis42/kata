<!DOCTYPE HTML>
<html>
<head>
<title>Monitor</title>
<script type="text/javascript" src="../jquery-1.7.2.min.js"></script>

<!--fancybox-->
<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<link rel="stylesheet" type="text/css" href="../style.css">
<script type="text/javascript" src="monitor.js"></script>

<script type="text/javascript">
//setInterval("updateMonitor();", 1000);
</script>
</head>

<body onload="">

<?php
require_once "../config.inc.php";
$sql = "SELECT * FROM tgroup ORDER BY idTgroup";
$result = $db->query($sql);
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	echo "<input type='checkbox' class='group' name='group[]' value='".$row["idTgroup"]."'/>".$row["idTgroup"]." ";
}
?>

<div id="monitor">
	
<div>

</body>
</html>
