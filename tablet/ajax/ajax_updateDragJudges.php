<?php
require_once "../../config.inc.php";

$arrayJud = json_decode($_POST["jud"], true);

$sql="UPDATE tablet SET judge = :judge WHERE tgroup = :tgroup AND grouporder = :grouporder";
$result = $db->prepare($sql);
$result->bindValue(':tgroup', $_POST["group"]);


for($i=0; $i<count($arrayJud); $i++){
	if($arrayJud[$i] != null){
		$result->bindValue(':judge', $arrayJud[$i]);
	}else{
		$result->bindValue(':judge', null);
	}
	$result->bindValue(':grouporder', $i+1);
	$result->execute();
}

//se non ci sono errori scrivo nei form
if($_POST["writeOnForms"] == "true"){
	
	
	$sql="SELECT idForm FROM form INNER JOIN tablet ON form.tablet = tablet.idTablet WHERE tablet.tgroup = :tgroup AND tablet.grouporder = :grouporder";
	$result = $db->prepare($sql);
	$result->bindValue(':tgroup', $_POST["group"]);

	for($i=0; $i<count($arrayJud); $i++){
		//if($arrayJud[$i] != null){
			$result->bindValue(':grouporder', $i+1);
			$result->execute();
			$row = $result->fetch(PDO::FETCH_ASSOC);
			if($row["idForm"] != null){
				$sql="UPDATE form SET judge = :judge WHERE idForm = :form";
				$resultUpdate = $db->prepare($sql);
				if($arrayJud[$i] != null)
					$resultUpdate->bindValue(':judge', $arrayJud[$i]);
				else
					$resultUpdate->bindValue(':judge', null);
				$resultUpdate->bindValue(':form', $row["idForm"]);
				$resultUpdate->execute();
			}
		//}
	}
}

if($errore)
    echo "errore";
else
    echo "ok";

?>
