<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class ChamadosView extends View{
	
	
	public function listar(){ ?>
		
		<div class='col-md-12 table-responsive' style='overflow: auto; width: 100%; height: 300px;'>
			<table class='table table-hover tabela-dados'>
				<thead>
					<tr>
						<th>Abertura</th>
						<th>Natureza do problema</th>
						<th>Solicitante</th>
						<th>Status</th>
						<th>Avaliação</th>
						<th>Ação</th>
					</tr>	
				</thead>
				<tbody>
					<?php 
						
						$lista = $_REQUEST['LISTA_CHAMADOS'];
						
						foreach($lista as $chamado){ 
							
							
							$styleTR = ($chamado['DS_STATUS'] == 'FECHADO' && $chamado['DS_AVALIACAO'] != 'SEM AVALIAÇÃO') 
								? "style='background-color:#f1c40f'" 
								: '';

					?>
							<tr <?php echo $styleTR ?>>
								<td><?php echo $chamado['DT_ABERTURA'] ?></td>
								<td><?php echo $chamado['DS_NATUREZA'] ?></td>
								<td><?php echo $chamado['DS_NOME_REQUISITANTE'] ?></td>
								<td><?php echo $chamado['DS_STATUS'] ?></td>
								<td><?php echo $chamado['DS_AVALIACAO'] ?></td>
								<td>
									<a href="/chamados/visualizar/<?php echo $chamado['ID'] ?>">
										<button type='button' class='btn btn-secondary btn-sm' title='Visualizar'>
											<i class='fa fa-eye' aria-hidden='true'></i>
										</button>
									</a>
								</td>
							</tr>
			      <?php 
						} 
				  ?>	
				</tbody>
			</table>
		</div>
<?php 
	
	}
	
	
	public function cadastrar(){

?>
	
		<form name='cadastro' method='POST' action='/cadastrar/chamado/' enctype='multipart/form-data'>
			<div class='row'>
				<div class='col-md-6'>
					 <div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Natureza do problema:</label>
						<select class='form-control' id='natureza' name='natureza' required />
							<option value=''>Selecione a natureza do problema</option>
							<option value='WORD'>WORD</option>
							<option value='EXCEL'>EXCEL</option>
							<option value='POWER POINT'>POWER POINT</option>
							<option value='TRELLO'>TRELLO</option>
							<option value='SIAFEM'>SIAFEM</option>
							<option value='SIAPI'>SIAPI</option>
							<option value='COMPUTADOR OU PEÇA COM DEFEITO'>COMPUTADOR OU PEÇA COM DEFEITO</option>
							<option value='INTERNET'>INTERNET</option>
							<option value='COMPARTILHAMENTO DE PASTA'>COMPARTILHAMENTO DE PASTA</option>
							<option value='IMPRESSORA'>IMPRESSORA</option>
							<option value='PAINEL DE GESTÃO'>PAINEL DE GESTÃO</option>
							<option value='OUTRO'>OUTRO</option>
						</select>
					</div>
				</div>
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label' for='comment'>Problema: (máx 300 carac.)</label>
						<input type='text' class='form-control' rows='1' id='problema' name='problema' maxlength='300' required></input>	
					</div>	
				</div>
			</div>	
			<div class='row' id='cad-button'>
				<div class='col-md-12'>
					<button type='submit' class='btn btn-default' name='submit' value='Send' id='submit'>Abrir chamado</button>
				</div>
			</div>
		</form>
	
<?php	
	
	}
	
	
	public function visualizar(){
		
		
		$lista = $_REQUEST['DADOS_CHAMADO'];
		
		$historico = $_REQUEST['HISTORICO_CHAMADO'];
		
?>		
		
		<div class='row linha-modal-processo'>
			<div class='col-md-12'>
				
				
				<?php if($lista['DS_STATUS'] =='ABERTO'){ ?>
				
						<a href="/editar/chamado/status/<?php echo $lista['ID'] ?>/FECHADO"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Fechar chamado&nbsp;&nbsp;&nbsp;<i class='fa fa-calendar-check-o' aria-hidden='true'></i></button></a>
				
				<?php } 	
				
				
				if($lista['DS_STATUS']=='FECHADO' and $lista['DS_AVALIACAO'] != 'SEM AVALIAÇÃO'){ ?>
				
						<a href="/editar/chamado/status/<?php echo $lista['ID'] ?>/ENCERRADO"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Encerrar chamado&nbsp;&nbsp;&nbsp;<i class='fa fa-calendar-check-o' aria-hidden='true'></i></button></a>
				<?php } 
				
				
				if($lista['DS_STATUS']=='ABERTO'){ ?>
						
						<a href="/excluir/chamado/<?php echo $lista['ID'] ?>"><button type='submit' onclick="return confirm('Você tem certeza que deseja apagar este chamado?');" class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Excluir&nbsp;&nbsp;&nbsp;<i class='fa fa-trash' aria-hidden='true'></i></button></a>
					
				<?php } ?>
			</div> 
		</div>
		
		
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
			
			$this->carregarHistorico($historico); 
			
			
			if($lista['DS_STATUS'] != 'ENCERRADO'){
			
				
				$this->carregarEnviarMensagem('chamado', $lista['ID']);
			
			}
			
			
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