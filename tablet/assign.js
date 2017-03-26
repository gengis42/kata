function updateSelect(group)
{
	$.get("ajax/ajax_updateTgroup.php?id="+group, function(data) {
		$('#device0').html(data);
		$("#device0").prop("selectedIndex",1);
		
		$('#device1').html(data);
		$("#device1").prop("selectedIndex",2);
		
		$('#device2').html(data);
		$("#device2").prop("selectedIndex",3);
		
		$('#device3').html(data);
		$("#device3").prop("selectedIndex",4);
		
		$('#device4').html(data);
		$("#device4").prop("selectedIndex",5);
	});
}
	
function quick()
{
	///non è più usata
	/*document.getElementById('device0').selectedIndex = 1;
	document.getElementById('device1').selectedIndex = 2;
	document.getElementById('device2').selectedIndex = 3;
	document.getElementById('device3').selectedIndex = 4;
	document.getElementById('device4').selectedIndex = 5;
	*/
}
