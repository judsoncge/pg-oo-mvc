function exportar(){
	
	var filtroservidor = $('#filtroservidor').val();

	var filtrosetor = $('#filtrosetor').val();

	var filtrosituacao = $('#filtrosituacao').val();

	var filtrosobrestado = $('#filtrosobrestado').val();
	
	var filtrorecebido = $('#filtrorecebido').val();
	
	var filtroprocesso = $('#filtroprocesso').val();
	
	window.open("/index.php?acao=exportar&modulo=Processos&filtroservidor="+filtroservidor+"&filtrosetor="+filtrosetor+"&filtrosituacao="+filtrosituacao+"&filtrosobrestado="+filtrosobrestado+"&filtrorecebido="+filtrorecebido+"&filtroprocesso="+filtroprocesso+"",'_blank');
	
}