<?php
require_once "../../config.inc.php";

$sql="UPDATE tgroup SET poule = :poule WHERE idTgroup = :tgroup";
$result = $db->prepare($sql);
$result->bindValue(':tgroup', $_POST["group"]);
if($_POST["poule"] > 0)
	$result->bindValue(':poule', $_POST["poule"]);
else
	$result->bindValue(':poule', null, PDO::PARAM_NULL);
$ret = $result->execute();

if($ret)
	echo "ok";
else
    echo "errore";

?>
