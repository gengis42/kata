<!DOCTYPE HTML>
<html>
<head>
<script type="text/javascript" src="../jquery-1.7.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="../style.css">
<script type="text/javascript" src="result.js"></script>

<script type="text/javascript">
setInterval("updateLiveAll('<?php echo $_GET["type"]; ?>');", 2000);
</script>
</head>
<body onload="updateLiveAll('<?php echo $_GET["type"]; ?>');">

<div id="liveresult">

<div>

</body>
</html>
