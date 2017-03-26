<!DOCTYPE HTML>

<html>
<head>
<script type="text/javascript" src="../jquery-1.7.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="../style.css">
<script type="text/javascript" src="result.js"></script>

<script type="text/javascript">

var time='<?php
if(isset($_GET["time"]))
	echo $_GET["time"]*1000;
else
	echo 1000;
?>';

updateClientResult();

var timer = setInterval(function() {
	updateClientResult();
}, time);

</script>
</head>
<body>

<div id="liveresult">

<div>

</body>
</html>
