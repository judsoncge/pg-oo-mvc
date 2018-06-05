function exportar(){
	
	var filtroservidor = $('#filtroservidor').val();

	var filtrosetor = $('#filtrosetor').val();

	var filtrosituacao = $('#filtrosituacao').val();

	var filtrosobrestado = $('#filtrosobrestado').val();
	
	window.open("js/pdf.php?filtroservidor="+filtroservidor+"&filtrosetor="+filtrosetor+"&filtrosituacao="+filtrosituacao+"&filtrosobrestado="+filtrosobrestado+"",'_blank');
	
}