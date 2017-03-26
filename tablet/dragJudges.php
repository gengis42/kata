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
  
  #sortable1, #sortable2, #sortable3, #sortable4, #sortable5
  {
    list-style-type: none;
    margin: 0;
    border-style:dashed;
    border-color:#ccc;
    float: left;
    margin-right:10px;
    background: #eee;
    padding: 10px;
    width: 143px;
  }
  
  #sortable1 li, #sortable2 li, #sortable3 li, #sortable4 li, #sortable5 li
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
  
  function remote_update(isChecked){
	  
	var array = [];
	var num = parseInt($("#countJudges").val());
	for(var i=0; i<num;i++){
		if ($("#sortable"+(i+1)).children()[0] != null) {
			array[i] = $("#sortable"+(i+1)).children()[0].id
		}else{
			array[i] = null;
		}
	}
	//$("#monitor").text(array[0] + " " + array[1] + " " +array[2] + " " +array[3] + " " +array[4]);
	
	var get = <?php echo json_encode($_GET); ?>;
	
	$.post( "ajax/ajax_updateDragJudges.php", { jud: JSON.stringify(array), group: get['group'], writeOnForms: isChecked})
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
  
<table>
  <tr>

    <?php
    //trovo numero di giudici
    if(isset($_GET["numJudges"]) and $_GET["numJudges"] != null)
        $numJudges = (int)$_GET["numJudges"];
    else
        $numJudges = 5;
        
    //prendo i nomi già assegnati
    $sql="SELECT judge, grouporder FROM tablet WHERE tgroup = :tgroup ORDER BY grouporder";
    $result = $db->prepare($sql);
    $result->bindValue(':tgroup', $_GET["group"]);
    $result->execute();
    $array = array();
    $count = 0;
    while($row = $result->fetch(PDO::FETCH_ASSOC) and ($count+1) == ((int)$row["grouporder"])){
        //$array[((int)$row["grouporder"])] = ((int)$row["judge"]);
        echo "<td><ul id='sortable".($count + 1)."' class='unico'>";
        if($row["judge"] != null){
            $sql="SELECT name FROM judge WHERE idJudge = :idJudge AND judge.tournament = :idTournament";
            $resultJudge = $db->prepare($sql);
            $resultJudge->bindValue(':idTournament', $_SESSION["idTournament"]);
            $resultJudge->bindValue(':idJudge', $row["judge"]);
            $resultJudge->execute();
            $rowJudge = $resultJudge->fetch(PDO::FETCH_ASSOC);
            if($rowJudge["name"] != null)
				echo '<li id="'.$row["judge"].'" class="ui-state-default">'.$rowJudge["name"].'</li>';
        }
        echo "</ul></td>";
        
        $count++;
    }
    ?>
    
  </tr>
</table>

<input id='countJudges' type="hidden" value="<?php echo $count; ?>"/>
 
<ul id="sortable" class="droptrue">
  <?php
  //trovo tutti gli altri
    $sql="SELECT idJudge, name FROM judge WHERE idJudge NOT IN (SELECT judge FROM tablet WHERE tgroup = :tgroup AND judge IS NOT null) AND judge.tournament = :idTournament";
    $result = $db->prepare($sql);
    $result->bindValue(':idTournament', $_SESSION["idTournament"]);
    $result->bindValue(':tgroup', $_GET["group"]);
    $result->execute();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        echo '<li id="'.$row["idJudge"].'" class="ui-state-default">'.$row["name"].'</li>';
    }
  ?>
</ul>

<button onclick="remote_update($('#checkboxWriteOnForms').is(':checked'));">update</button>

<label><input type="checkbox" name="checkboxWriteOnForms" id="checkboxWriteOnForms" value="yes"> write on forms</label>
 
</body>
</html>
