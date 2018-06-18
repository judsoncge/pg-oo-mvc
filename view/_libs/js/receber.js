function receber(idProcesso){
	
	$.ajax({
				
		//chamo o php que faz a query baseado no que o usuario escolheu no select
		url: "/editar/processo/receber/"+idProcesso+"/",
		type: 'GET',
		dataType: 'html',
		//data: dados,
		
		//se a funcao tiver sucesso...
		success: function(){
			
			$("#servidorLocalizacao"+idProcesso).empty();
			
			$("#servidorLocalizacao"+idProcesso).html('Agora está com você');
			
			$("#statusRecebido"+idProcesso).empty();
			
			$("#statusRecebido"+idProcesso).html('SIM');
			
			$("#recebido"+idProcesso).empty();
			
			$("#recebido"+idProcesso).html("<a href='/processos/visualizar/"+idProcesso+"'>"+
											"<button type='button' class='btn btn-secondary btn-sm' title='Visualizar'>"+
												"<i class='fa fa-eye' aria-hidden='true'></i>"+
											"</button>"+
										"</a>");
			
		}
		
	});
	
	//return false pq nao quero que execute um submit comum de formulario
	return false;

}