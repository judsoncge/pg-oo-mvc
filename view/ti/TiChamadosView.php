<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/ChamadosView.php';

class TiChamadosView extends ChamadosView{
	
	//pagina de visualizacao de um determinado chamado
	public function visualizar(){
		
		//as listas sao solicitadas ao chamado controller
		$lista = $_REQUEST['DADOS_CHAMADO'];
		
		$historico = $_REQUEST['HISTORICO_CHAMADO'];
		
?>		
		
		<div class='row linha-modal-processo'>
			<div class='col-md-12'>
				
				<!-- botao que fecha o chamado -->
				<?php if($lista['DS_STATUS'] =='ABERTO'){ ?>
				
						<a href="/editar/chamado/status/<?php echo $lista['ID'] ?>/FECHADO"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Fechar chamado&nbsp;&nbsp;&nbsp;<i class='fa fa-calendar-check-o' aria-hidden='true'></i></button></a>
				
				<?php } 	
				
				//botao que encerra o chamado. ele so pode ser encerrado se o solicitante ja tiver avaliado
				if($lista['DS_STATUS']=='FECHADO' and $lista['DS_AVALIACAO'] != 'SEM AVALIAÇÃO'){ ?>
				
						<a href="/editar/chamado/status/<?php echo $lista['ID'] ?>/ENCERRADO"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Encerrar chamado&nbsp;&nbsp;&nbsp;<i class='fa fa-calendar-check-o' aria-hidden='true'></i></button></a>
				<?php } 
				
				//o chamado so pode ser excluido se ele ainda estiver aberto
				if($lista['DS_STATUS']=='ABERTO'){ ?>
						
						<a href="/excluir/chamado/<?php echo $lista['ID'] ?>"><button type='submit' onclick="return confirm('Você tem certeza que deseja apagar este chamado?');" class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Excluir&nbsp;&nbsp;&nbsp;<i class='fa fa-trash' aria-hidden='true'></i></button></a>
					
				<?php } ?>
			</div> 
		</div>
		
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
	}
}

?>