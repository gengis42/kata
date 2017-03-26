var intervallo = null;

function updateMonitor()
{
	var ar = new Array();
	var i = 0;
	$("input[type='checkbox']:checked").each( 
		function() { 
			ar[i++] = $(this).val();
		} 
	);
	var str ="";
	for(var i=0; i<ar.length; i++)
		str+=ar[i];
	
	$.get("ajax/ajax_monitor.php?a="+str, function(data) {
		$('#monitor').html(data);
		
		$(".iframe").fancybox({
			'width'				: '75%',
			'height'			: '75%',
			'autoScale'			: true,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'				: 'iframe'
		});
	});
}

$(document).ready(function() {
	updateMonitor();
	intervallo = setInterval( function() 
	{
	   updateMonitor()
	}, 1000);
	
	$('.group').click(function() {
		
		clearInterval(intervallo);
		intervallo = setInterval( function() 
		{
		   updateMonitor()
		}, 1000);
	});
});

function validate_plus_next(group, poule)
{

	document.getElementById("div_next_" + group).style.display = 'none';

	$.post( "ajax/assign_next.php", {idGroup: group, idPoule: poule, validate: true});
}

function assign_next(group, poule)
{

	document.getElementById("div_next_" + group).style.display = 'none';

	$.post( "ajax/assign_next.php", {idGroup: group, idPoule: poule, validate: false});
}