function searchFlag(flag)
{	
	$.get("ajax/searchFlag.php?q=" + flag, function(data) {
		$('#flagImage').attr("src", data);
	});

}	
