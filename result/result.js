function updateClientResult()
{	
	$.get("ajax/ajax_clientresult.php", function(data) {
		$('#liveresult').html(data);
	});
}

function updateLiveAll(type)
{
	$.get("ajax/ajax_liveall.php?type="+type, function(data) {
		$('#liveresult').html(data);
	});
}

function updateLivePouleResult(idPoule)
{
	$.get("ajax/ajax_livepouleresult.php?idPoule="+idPoule, function(data) {
		$('#liveresult').html(data);
	});
}

function updateLiveCircleResult(idKatatype,type)
{
	$.get("ajax/ajax_livecircleresult.php?idKatatype="+idKatatype+"&type="+type, function(data) {
		$('#liveresult').html(data);
	});
}
