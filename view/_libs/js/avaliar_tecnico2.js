
function media(){
	var ass1 = parseInt(document.getElementById('ass1').value, 10);
	var ass2 = parseInt(document.getElementById('ass2').value, 10);
	var cum1 = parseInt(document.getElementById('cum1').value, 10);
	var cum2 = parseInt(document.getElementById('cum2').value, 10);




	var assiduidade;
	var cumprimento_de_prazo;
	

	if (Number.isNaN(ass1)){
		ass1=0;
	}

	if (Number.isNaN(ass2)){
		ass2=0;
	}
	

	assiduidade = ((ass2 / ass1) * 10).toFixed(1);
	parseFloat(assiduidade);
	document.getElementById('ass_result').value = assiduidade;	


	if (Number.isNaN(cum1)){
		cum1=0;
	}

	if (Number.isNaN(cum2)){
		cum2=0;
	}


	cumprimento_de_prazo = (cum1 / (cum1 + cum2) * 10).toFixed(1);
	parseFloat(cumprimento_de_prazo);
	document.getElementById('cum_result').value = cumprimento_de_prazo;	





	var media = (assiduidade + cumprimento_de_prazo);
	alert(media);
	//document.getElementById('nota-final').innerHTML = media;


}