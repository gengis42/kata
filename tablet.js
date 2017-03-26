$(document).ready(function() {
	$(".editTablet").fancybox({
		'width'				: '75%',
		'height'			: '75%',
		'autoScale'			: true,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe',
		'onClosed': function()
		{
			window.location.reload( false );
		}
	});
	
	$(".reset").fancybox({
		'width'				: '75%',
		'height'			: '75%',
		'autoScale'			: true,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe',
		'onClosed': function()
		{
			window.location.reload( false );
		}
	});
	
});
