<option value=''>-</option>
<?php
require_once "../../config.inc.php";
$sql="SELECT * FROM tablet WHERE tgroup = :tgroup ORDER BY grouporder";
$result = $db->prepare($sql);
$result->bindValue(':tgroup', $_GET["id"]);
$result->execute();
while($row = $result->fetch(PDO::FETCH_ASSOC))
{
	echo "<option value='".$row["idTablet"]."'>".$row["name"]."</option>";
}
?>
