<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/ChamadosView.php';

class SupChamadosView extends ChamadosView{
	
	//pagina de visualizacao de um determinado chamado
	public function visualizar(){
		
		//as listas sao solicitadas ao chamado controller
		$lista = $_REQUEST['DADOS_CHAMADO'];
		
		$historico = $_REQUEST['HISTORICO_CHAMADO'];
		
?>		
		<!-- caixa que mostra as informações gerais do chamado -->
		<div class='row linha-modal-processo'>
			<div class='col-md-12'>
				<b>Status</b>: <?php echo $lista['DS_STATUS'] ?><br><br>	
				<b>Data de abertura  </b>: <?php echo $lista['DT_ABERTURA'] ?><br> 
				<b>Data de fechamento  </b>: 
					<?php 
						
						$data = ($lista['DT_FECHAMENTO'] == '00/00/0000 às 00:00:00') 
							? 'Sem data' 
							: $lista['DT_FECHAMENTO'];
						
						echo $data;
						
					?>
				<br> 
				<b>Data de encerramento  </b>: 
					<?php 
						
						$data = ($lista['DT_ENCERRAMENTO'] == '00/00/0000 às 00:00:00') 
							? 'Sem data'
							: $lista['DT_ENCERRAMENTO'];
						
						echo $data;
						
					?>
				<br>  
				<b>Requisitante</b>: <?php echo $lista['DS_NOME_REQUISITANTE'] ?><br>
				<b>Problema</b>: <?php echo $lista['DS_PROBLEMA'] ?><br> 
				<b>Natureza</b>: <?php echo $lista['DS_NATUREZA'] ?>	
			</div>
		</div>
<?php 
			//carrega o historico do chamado. a funcao esta definida na classe mae. a lista passada foi recebida la em cima
			$this->carregarHistorico($historico); 
			
			//so pode enviar mensagem enquanto o chamado ainda nao for encerrado
			if($lista['DS_STATUS'] != 'ENCERRADO'){
			
				//a funcao esta definida na classe mae
				$this->carregarEnviarMensagem('chamado', $lista['ID']);
			
			}
			
			//abre o select de avaliação. ele abre quando o chamado é fechado pelo profissional de ti. para que possa ser encerrado, o solicitante precisa avaliar o atendimento antes
			if($lista['DS_AVALIACAO'] == 'SEM AVALIAÇÃO' and $lista['DS_STATUS'] == 'FECHADO'){
				
?>
				<div class='row linha-modal-processo'>
					<form name='cadastro' method='POST' action="/editar/chamado/avaliar/<?php echo $lista['ID'] ?>/" enctype='multipart/form-data'>
						<div class='col-md-10'>
							<select class='form-control' id='avaliacao' name='avaliacao' required/>
								<option value=''>Avalie o atendimento</option>
								<option value='PÉSSIMO'>PÉSSIMO</option>
								<option value='RUIM'>RUIM</option>
								<option value='REGULAR'>REGULAR</option>
								<option value='BOM'>BOM</option>
								<option value='EXCELENTE'>EXCELENTE</option>
							</select>
						</div>
						<div class='col-md-2'>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-dar-saida'>Avaliar &nbsp;&nbsp;<i class='fa fa-arrow-circle-right' aria-hidden='true'></i></button>
						</div>
					</form>			
				</div>
<?php
			
			}	
	}

}

?>