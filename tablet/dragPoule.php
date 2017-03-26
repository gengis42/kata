<?php
session_start();
require_once "../config.inc.php";
echo $_GET["group"];
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Sortable - Handle empty lists</title>
  <link rel="stylesheet" href="../jquery-ui.css">
  <!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  -->
  <script type="text/javascript" src="../jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="../jquery-ui.js"></script>
  
  <style>
  #sortable { list-style-type: none; margin: 0; padding: 10px; background-color:red; overflow: hidden; }
  #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; text-align: center; }  
  
  #sortable1
  {
    list-style-type: none;
    margin: 0;
    border-style:dashed;
    border-color:#ccc;
    /*float: left;*/
    margin-right:10px;
    background: #eee;
    padding: 10px;
    width: 143px;
  }
  
  #sortable1 li
  {
    margin: 5px;
    padding: 5px;
    font-size: 1.2em;
    width: 120px;
  }
  </style>
  <script>
  $(function() {
    
    $( "ul.unico" ).sortable({
      connectWith: "ul",
      receive: function(event, ui) {
        // so if > 10
        if ($(this).children().length > 1) {
            //ui.sender: will cancel the change.
            //Useful in the 'receive' callback.
            
            var newitem = $(ui.item);
            var diff = $(this).children().not(newitem).get();
            
            //$(ui.sender).sortable('cancel');
            
            $(ui.sender).append(diff);
            $(ui.sender).sortable('refresh');
        }
        //remote_update();
        
        $("#sortable li").sort(asc_sort).appendTo('#sortable');
      }
    });
    
    $( "ul.droptrue" ).sortable({
      connectWith: "ul",
      receive: function(event, ui) {
        //remote_update();
        $("#sortable li").sort(asc_sort).appendTo('#sortable');
      }
    });
    //$( "#sortable1, #sortable2, #sortable3" ).disableSelection();
  });
  
  function asc_sort(a, b){
    return ($(b).text()) < ($(a).text()) ? 1 : -1;
  }
  
  function remote_update(){
	  
	var idPoule = null;
	var num = parseInt($("#countJudges").val());
	if ($("#sortable1").children()[0] != null) {
		idPoule = $("#sortable1").children()[0].id
	}
	//$("#monitor").text(array[0] + " " + array[1] + " " +array[2] + " " +array[3] + " " +array[4]);
	
	var get = <?php echo json_encode($_GET); ?>;
	
	$.post( "ajax/ajax_updateDragPoule.php", { poule: idPoule, group: get['group']})
	.done(function( data ) {
		if (data != "ok") {
			alert( data );
		}else{
			parent.$.fancybox.close();   
		}
	});
  }
  </script>
</head>
<body>
  
  <div id="monitor"></div>

    <?php
        
    //prendo i nomi già assegnati
    $sql = "SELECT katatype.name, poule.type, poule.idPoule FROM katatype
    INNER JOIN poule ON katatype.idKatatype = poule.katatype
    INNER JOIN tgroup ON poule.idPoule = tgroup.poule
    WHERE tgroup.idTgroup = :tgroup";
    $result = $db->prepare($sql);
    $result->bindValue(':tgroup', $_GET["group"]);
    $result->execute();
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $idPoule = null;
    //$array[((int)$row["grouporder"])] = ((int)$row["judge"]);
    echo "<ul id='sortable1' class='unico'>";
    if($row != null){
		  echo '<li id="'.$row["idPoule"].'" class="ui-state-default">'.$row["name"]." <b>".$row["type"].'</li>';
      $idPoule = $row["idPoule"];
    }
    echo "</ul>";
    ?>
    
<br>
 
<ul id="sortable" class="droptrue">
  <?php
  //trovo tutti gli altri
    $sql="SELECT katatype.name, poule.type, poule.idPoule FROM katatype
    INNER JOIN poule ON katatype.idKatatype = poule.katatype
    WHERE poule.tournament = :idTournament AND
    (
      (poule.type = 'F' AND poule.mode = 'F') OR 
      ((poule.type = 'A' OR poule.type = 'F') AND poule.mode = 'AF') OR 
      ((poule.type = 'A' OR poule.type = 'B' OR poule.type = 'F') AND poule.mode = 'ABF')
    )";

    if($idPoule != null){
      $sql .= " AND poule.idPoule != '$idPoule'";
    }

    $result = $db->prepare($sql);
    $result->bindValue(':idTournament', $_SESSION["idTournament"]);
    $result->execute();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        echo '<li id="'.$row["idPoule"].'" class="ui-state-default">'.$row["name"]." <b>".$row["type"].'</b></li>';
    }
  ?>
</ul>
<br>
<button onclick="remote_update();">update</button>
 
</body>
</html>
