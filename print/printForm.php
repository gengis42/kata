<!DOCTYPE HTML>
<html>
<head>
<style>

.columnNum1
{
	padding:5px;
	text-align: center;
}
.columnNum2
{
	padding:5px;
	text-align: center;
	vertical-align:middle;
}
.verticalDiv
{
	white-space: nowrap;
	display:block;
	text-align:center;
	width:20px;
	position:relative;
	
	transform: rotate(270deg);
/*
	-moz-transform: rotate(-90deg);
    writing-mode: tb-rl;
    filter: flipv fliph;
*/
}
.columnNum3
{
	text-align: right;
}
.hidden
{
	border: 0px;
}

td
{
	border: 1px solid black;
	padding:7px 5px 7px 5px;
	font-size:12px;
}
table
{
	border-collapse:collapse;
}
.normal
{
	border: 0px solid white;
	width:auto;
}

</style>
</head>
<body onload="window.print(); //window.close();">
<?php
include "../config.inc.php";

switch($_GET["katatype"])
{
	case "nage":
		include "form/nage.php";
	break;
	case "katame":
		include "form/katame.php";
	break;
	case "kime":
		include "form/kime.php";
	break;
	case "juno":
		include "form/juno.php";
	break;
	case "koshiki":
		include "form/koshiki.php";
	break;
	case "kodokan":
		include "form/kodokan.php";
	break;
	case "itsuzu":
		include "form/itsuzu.php";
	break;
	case "3nage1katame":
		include "form/3nage1katame.php";
	break;
	case "3nage1ju":
		include "form/3nage1ju.php";
	break;
	
	
}
?>
</body>
</html>
