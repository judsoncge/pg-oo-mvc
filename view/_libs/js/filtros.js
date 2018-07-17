$(document).ready(function(){

	//submetendo o formulario que o select esta dentro
		$('form').submit(function(){
			
			//pegando os dados que vem do form
			var dados = $(this).serialize();
			
			//quando pegar os dados, chama um php
			$.ajax({
				
				//chamo o php que faz a query baseado no que o usuario escolheu no select
				url: '/processos/ativos/1',
				type: 'POST',
				dataType: 'html',
				data: dados,
				
				//se a funcao tiver sucesso...
				success: function(data){
					
					//a tabela principal é limpada e insere os dados de resultado da busca
					$('#resultado').empty();
					
					$('#resultado').html(data);
					
					//esconde o gif de carregando
					$('#carregando').hide();
					
				}
				
			});
			
			//return false pq nao quero que execute um submit comum de formulario
			return false;
			
		});
	
	//quando o usuario escolher alguém no select, chama a função
	$('#filtroservidor, #filtrosetor, #filtrosituacao, #filtrosobrestado, #filtrorecebido, #filtroprocesso, #filtrodias').bind("keyup change", function(){
		
		//o gif de carregando vai aparecer até a busca concluir
		$('#carregando').show();
			
		//chamando o evento de submit
		$('form').trigger('submit');

	});
	


});