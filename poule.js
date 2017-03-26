$(document).ready(function() {
	$(".tablet").fancybox({
		'width'				: '75%',
		'height'			: '75%',
		'autoScale'			: true,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
	
});

function checkValidated(idForm)
{
	$.ajax({
		type: "GET",
		url: "ajax/checkValidated.php",
		data: "q="+idForm,
		success: function(response){
			$("#span"+idForm).attr("style",response);
		}
	});
	
}
