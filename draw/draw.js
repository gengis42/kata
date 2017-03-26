var stop; //0=enable 1=disable
var num; // num of element to shuffle
var numPosMeta; //
var vet; // array from 1 to num
var vetA;
var vetB;
var vetPos;
var mixed;
var mixedA;
var mixedB;
var mixedPos;

shuffle = function(v){
    //for(var j, x, i = v.length; i; j = parseInt(Math.random() * i), x = v[--i], v[i] = v[j], v[j] = x);
    //return v;
    return v.shuffleArray();
    
};

Array.prototype.shuffleArray = function() {
	var ret = new Array();
	while (this[0]) {
		ret.push(this.splice(parseInt(Math.random()*this.length),1)[0])
	}
	while (ret[0]) {
		this.push(ret.shift());
	}
	return this;
}

function initCrono()
{
	stop=1;
	//var theForm = document.getElementById("formRandom");
	//var inputElements = document.forms[0].elements["randomNum[]"];
	//num = inputElements.length;
	num = document.getElementById('countRandomNum').value;
	vet = new Array(num);
	for(var i=0; i<num; i++)
		vet[i]=i+1;
	
	//da qui in giu serve per A e B
	numPosMeta=Math.ceil(num/2);
	
	vetA = new Array(numPosMeta);
	for(var i=0; i<numPosMeta; i++)
		vetA[i]=i+1;
	
	vetB = new Array(num-numPosMeta);
	for(var i=0; i<num-numPosMeta; i++)
		vetB[i]=i+1;
	
	vetPos = new Array(num);
	for(var i=0; i<numPosMeta; i++)
		vetPos[i]='A';
	for(var i=numPosMeta; i<num; i++)
		vetPos[i]='B';
}

function crono()
{
	if (stop==0) {
		mixed = shuffle(vet);
		for (var i = 0; i < mixed.length; i++) {
	  		document.getElementById("randomNum"+i).value=mixed[i];
		}
		setTimeout("crono()", 50);
	}
}

function cronoPlusPosition()
{
	if (stop==0) {
		mixedA = shuffle(vetA);
		mixedB = shuffle(vetB);
		mixedPos = shuffle(vetPos);
		
		var iA=0;
		var iB=0;
		
		for (var i = 0; i < mixedPos.length; i++) {
			document.getElementById("randomPos"+i).value=mixedPos[i];
			
			if(mixedPos[i]=='A')
			{
				document.getElementById("randomNum"+i).value=mixedA[iA];
				iA++;
			}
			else
			{
				document.getElementById("randomNum"+i).value=mixedB[iB];
				iB++;
			}
	  		
		}
		setTimeout("cronoPlusPosition()", 100);
	}
}

function startStopCrono(mode)
{
	if (typeof mode == 'undefined' ) mode = 'num';
	if (stop==1)
	{
		stop=0;
		if(mode=='num')
			crono();
		else
		{
			cronoPlusPosition();
		}
		document.getElementById("startStopButton").value='stop';
	}
	else
	{
		stop=1;
		document.getElementById("startStopButton").value='start';
	}
}




