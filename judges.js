$(document).ready(function() {
	$(".editJudge").fancybox({
		'width'				: '75%',
		'height'			: '75%',
		'autoScale'			: true,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe',
		'onClosed': function()
		{
			//window.location.reload( false );
			window.location = window.location.href;
		}
	});
	
});
