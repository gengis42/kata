function checkDraw(katatype)
{
	var num;
	if(katatype==null)
	{
		num = 'all';
		var x=document.getElementsByName("draw");
		var id;
		var idString;
		for(var i=0; i<x.length; i++)
		{
			idString = x.item(i).id;
			id = idString.substring(4,idString.length);
			dadoAjax(id);
		}
	}
	else
	{
		num = parseInt(katatype);
		dadoAjax(num);
	}	
}

function dadoAjax(num)
{
	$.ajax({
		async: "false",
		type: "GET",
		url: "ajax/checkDraw.php",
		data: "q="+num,
		success: function(response){
			$("#draw"+num).attr("src",response);
		}
	});
}
