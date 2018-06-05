function receber(id_processo, id_tramitacao){
	
	$.ajax({
				
		//chamo o php que faz a query baseado no que o usuario escolheu no select
		url: "logica/editar.php?id="+id_processo+"&operacao=recebido&tramitacao="+id_tramitacao,
		type: 'GET',
		dataType: 'html',
		//data: dados,
		
		//se a funcao tiver sucesso...
		success: function(){
			
			$("#statusRecebido"+id_processo).empty();
			
			$("#statusRecebido"+id_processo).html("<center>SIM</center>");
			
			$("#recebido"+id_processo).empty();
			
			$("#recebido"+id_processo).html("<center>"+
										"<a href='detalhes.php?id="+id_processo+"'>"+
											"<button type='button' class='btn btn-secondary btn-sm' title='Detalhes e operações'>"+
												"<i class='fa fa-eye' aria-hidden='true'></i>"+
											"</button>"+
										"</a>"+
									"</center>");
			
		}
		
	});
	
	//return false pq nao quero que execute um submit comum de formulario
	return false;

}