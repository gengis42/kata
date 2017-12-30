function checkDuplicatedJudge(idForm, idJudge)
{
	$.ajax({
		type: "GET",
		url: "ajax/checkDuplicatedJudge.php",
		data: "f="+idForm+"&j="+idJudge,
		success: function(response){
			if(response!=""){
				alert("Judge is on form "+response);
			}
		}
	});

}

function keyboardEvents(e)
{
	e = e || event;
	if(e.keyCode==38)
	{
		//alert('su');
		if(index>1)
		{
			$("#tr_"+index).css('background-color', '');
			index--;
			$("#tr_"+index).css('background-color', '#0066FF');
		}

	}
	else if(e.keyCode==40)
	{
		//alert('giu');
		if(index<maxindex)
		{
			$("#tr_"+index).css('background-color', '');
			index++;
			$("#tr_"+index).css('background-color', '#0066FF');
		}
	}
	//updateScoreboard();
	else
	{
		switch(e.keyCode)
		{
			case 49: //1
				if($("#point1_"+index).val()==1)
				{
					$("#point1_"+index).val(0);
					$("#img1_"+index).attr("src",'image/correct.png');
				}
				else
				{
					$("#point1_"+index).val(1);
					$("#img1_"+index).attr("src",'image/wrong.png');
				}
				break;
			case 50: //2
				if($("#point2_"+index).val()==1)
				{
					$("#point2_"+index).val(0);
					$("#img2_"+index).attr("src",'image/correct.png');
				}
				else
				{
					$("#point2_"+index).val(1);
					$("#img2_"+index).attr("src",'image/wrong.png');
				}
				break;
			case 51: //3
				if($("#point3_"+index).val()==1)
				{
					$("#point3_"+index).val(0);
					$("#img3_"+index).attr("src",'image/correct.png');
				}
				else
				{
					$("#point3_"+index).val(1);
					$("#img3_"+index).attr("src",'image/wrong.png');
				}
				break;
			case 52: //4
				if($("#point4_"+index).val()==1)
				{
					$("#point4_"+index).val(0);
					$("#img4_"+index).attr("src",'image/correct.png');
				}
				else
				{
					$("#point4_"+index).val(1);
					$("#img4_"+index).attr("src",'image/wrong.png');
				}
				break;
			case 53: //5
				if($("#point5_"+index).val()==1)
				{
					$("#point5_"+index).val(0);
					$("#img5_"+index).attr("src",'image/correct.png');
				}
				else
				{
					$("#point5_"+index).val(1);
					$("#img5_"+index).attr("src",'image/wrong.png');
				}
				break;

            case 81: //q
                $("#ph_"+index).val(0.5);
                $("#divh_"+index).text("+0.5");
                break;
            case 65: //a
                $("#ph_"+index).val(0.0);
                $("#divh_"+index).text("0.0");
                break;
            case 90: //z
                $("#ph_"+index).val(-0.5);
                $("#divh_"+index).text("-0.5");
                break;
		}
	}
	validateRow(index);
	updateCont();
}

function validateRow(index) {
	var errors = [];
	var images = $("[id^=img][id$=_"+index+"]");
	for (var i = 0; i < images.length; i++)
		errors.push(images[i].src.indexOf('wrong') !== -1);
	if (!errors[0] && !errors[1] && !errors[2] && !errors[3] && !errors[4]) { //on perfect no up
		if ($("#ph_"+index).val() == 0.5) {
			$("#ph_"+index).val(0.0);
			$("#divh_"+index).text("0.0");
		}
	}
	if (errors[0] && errors[1] && errors[2] && errors[3]) { //on special reset halved
			$("#ph_"+index).val(0.0);
			$("#divh_"+index).text("0.0");
	}
	if (errors[4]) { //on forgotten reset other errors and halved
		for (var j = 0; j < images.length - 1; j++) {
			images[j].src = 'image/correct.png';
			$("#point"+(j+1)+"_"+index).val(0);
		}
		$("#ph_"+index).val(0.0);
		$("#divh_"+index).text("0.0");
	}
}

function updateCont()
{

	var contSmall=0;
	var contMedium=0;
	var contBig=0;
	var contForgotten=0;

	var all=document.getElementsByTagName("input");
	//unfocus di fcr
	var fcr=document.getElementById("fcr");
	fcr.blur();
  	var i;
  	var name;
  	var val; //valore corrent
  	var p1, p2, p3, p4, p5, ph;

  	points = new Array();

  	for(i=0; i<((all.length -1)/6); i++)
  	{
  		p1=all[i*6 + 0].value;
  		p2=all[i*6 + 1].value;
  		p3=all[i*6 + 2].value;
  		p4=all[i*6 + 3].value;
  		p5=all[i*6 + 4].value;
        ph=all[i*6 + 5].value;

  		val = 10 - p1 - p2 - 3*p3 - 5*p4;
  		if(p1==1 && p2==1 && p3==1 && p4==1)
  			val = 1.0;
  		if(p5==1)
  			val=0.0;
  		else {
  			val += 1.0*ph;
		}
  		points[i]=val;
  		$("#pt_"+ (i+1)).html(val);
  	}

  	for (i=0; i<all.length; i++)
  	{
  		col=all[i].name.substr(7,1);
  		name=all[i].name.substr(0,6);
  		val=all[i].value;
  		if(val==1)
  		{
	  		switch(name)
	  		{
	  			case 'point1':
	  			case 'point2':
	  				contSmall++;
	  			break;
	  			case 'point3':
	  				contMedium++;
	  			break;
	  			case 'point4':
	  				contBig++;
	  			break;
	  			case 'point5':
	  				contForgotten++;
	  			break;
	  		}
	  	}
  	}

  	$("#contSmall").html(contSmall);
  	$("#contMedium").html(contMedium);
  	$("#contBig").html(contBig);
  	$("#contForgotten").html(contForgotten);


  	var punteggio = 0.0;
  	for(i=0; i<points.length; i++)
  		punteggio += points[i];

			console.log(punteggio);
  	if(contForgotten>0) {
  		punteggio = punteggio / 2;
  	} else {
  		punteggio = parseFloat(punteggio) + parseFloat(fcr.value);
  	}

  	$("#total").html(punteggio);
}

function alertJudge()
{
	var judge = document.getElementById("judge").value;
	if(judge==0)
  		$("#alertJudge").html(' <= select judge');
  	else
  		$("#alertJudge").html('');
}
