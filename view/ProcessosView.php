<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class ProcessosView extends View{
	
	public function adicionarScripts(){ ?>		
		
		<script src='<?php echo $_SERVER['DOCUMENT_ROOT'].'/js/receber.js' ?>'></script>
		<script src='<?php echo $_SERVER['DOCUMENT_ROOT'].'/js/filtros.js'  ?>'></script>
		<script src='<?php echo $_SERVER['DOCUMENT_ROOT'].'/js/exportar.js' ?>'></script>	

<?php	
	
	}
	
	public function listar(){ ?>
		
		<div class="col-md-12 table-responsive" style="overflow: auto; width: 100%; height: 300px;">
			<table class="table table-hover tabela-dados">
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
								: "";

					?>
							<tr <?php echo $styleTR ?>>
								<td><?php echo date_format(new DateTime($chamado['DT_ABERTURA']), 'd/m/Y H:i:s') ?></td>
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
		
		$listaAssuntos = $_REQUEST['LISTA_ASSUNTOS'];
		
		$listaOrgaos = $_REQUEST['LISTA_ORGAOS'];

?>
	
		<form name="cadastro" method="POST" action="/cadastrar/processo/" enctype="multipart/form-data"> 
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="exampleInputEmail1">Número do processo</label>
						<div class="row">
							<div class="col-md-4">
								<input class="form-control" id="numeroParte1" name="numeroParte1" placeholder="Órgão" type="text" maxlength="6" required />
							</div>
							<div class="col-md-4">
								<input class="form-control" id="numeroParte2" name="numeroParte2" placeholder="Número" type="text" maxlength="6" required />
							</div>
							<div class="col-md-4">
								<input class="form-control" id="numeroParte3" name="numeroParte3" placeholder="Ano" type="text" maxlength="4" required />
							</div>
						</div>
					</div>  
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="exampleInputEmail1">Assunto</label>
						<select class="form-control" id="assunto" name="assunto" required />
							<option value="">Selecione o assunto</option>
								<?php foreach($listaAssuntos as $assunto){ ?>
									<option value="<?php echo $assunto['ID'] ?>"><?php echo $assunto['DS_NOME'] ?></option> 
								<?php } ?>
						</select>
					</div>  
				</div>
			</div>
			<div class="row">						
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label" for="exampleInputEmail1">Órgão Interessado</label>
						<select class="form-control" id="orgao" name="orgao" required />
							<option value="">Selecione o Órgão Interessado</option>
								<?php foreach($listaOrgaos as $orgao){ ?>
									<option value="<?php echo $orgao['ID'] ?>"><?php echo $orgao['DS_ABREVIACAO'] . " - " . $orgao['DS_NOME'] ?></option> 
								<?php } ?>
						</select>
					</div>  
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="exampleInputEmail1">Nome do Interessado</label>
						<input class="form-control" id="interessado" name="interessado" placeholder="Digite o interessado" type="text" maxlength="255" required />
					</div>  
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="exampleInputEmail1">Detalhes</label>
						<input class="form-control" id="detalhes" name="detalhes" placeholder="Digite os detalhes do processo" type="text" maxlength="255" required />
					</div>  
				</div>
			</div>
			<div class="row" id="cad-button">
				<div class="col-md-12">
					<button type="submit" class="btn btn-default" name="submit" value="Send" id="submit">Cadastrar</button>
				</div>
			</div>
		</form>
	
<?php	
	
	}
	
	public function visualizar(){
		
		$lista = $_REQUEST['DADOS_CHAMADO'];
		
		$historico = $_REQUEST['HISTORICO_CHAMADO'];
		
?>		
	
		<div class="row linha-modal-processo">
			<div class="col-md-12">
				<?php if($lista['DS_STATUS'] =='ABERTO'){ ?>
				
						<a href="/editar/chamado/status/<?php echo $lista['ID'] ?>/FECHADO"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Fechar chamado&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar-check-o" aria-hidden="true"></i></button></a>
				
				<?php } 	
				
				if($lista['DS_STATUS']=='FECHADO' and $lista['DS_AVALIACAO'] != "SEM AVALIAÇÃO"){ ?>
				
						<a href="/editar/chamado/status/<?php echo $lista['ID'] ?>/ENCERRADO"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Encerrar chamado&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar-check-o" aria-hidden="true"></i></button></a>
				<?php } 
				
				if($lista['DS_STATUS']=='ABERTO'){ ?>
						
						<a href="/excluir/chamado/<?php echo $lista['ID'] ?>"><button type='submit' onclick="return confirm('Você tem certeza que deseja apagar este chamado?');" class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Excluir&nbsp;&nbsp;&nbsp;<i class="fa fa-trash" aria-hidden="true"></i></button></a>
					
				<?php } ?>
			</div> 
		</div>
		<div class="row linha-modal-processo">
			<div class="col-md-12">
				<b>Status</b>: <?php echo $lista['DS_STATUS'] ?><br><br>	
				<b>Data de abertura  </b>: <?php echo date_format(new DateTime($lista['DT_ABERTURA']), 'd/m/Y H:i:s') ?><br> 
				<b>Data de fechamento  </b>: 
					<?php 
						
						$data = ($lista['DT_FECHAMENTO'] == NULL) 
							? "Sem data" 
							: date_format(new DateTime($lista['DT_FECHAMENTO']), 'd/m/Y H:i:s');
						
						echo $data;
						
					?>
				<br> 
				<b>Data de encerramento  </b>: 
					<?php 
						
						$data = ($lista['DT_ENCERRAMENTO'] == NULL) 
							? "Sem data" 
							: date_format(new DateTime($lista['DT_ENCERRAMENTO']), 'd/m/Y H:i:s');
						
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
			
			if($lista['DS_AVALIACAO'] == 'SEM AVALIAÇÃO' and $lista['DS_STATUS'] != 'ENCERRADO'){
			
				$this->carregarEnviarMensagem('chamado', $lista['ID']);
			
			}
			
			if($lista['DS_AVALIACAO'] == 'SEM AVALIAÇÃO' and $lista['DS_STATUS'] == 'FECHADO'){
				
		?>
		
				<div class="row linha-modal-processo">
					<form name="cadastro" method="POST" action="/editar/chamado/avaliar/<?php echo $lista['ID'] ?>/" enctype="multipart/form-data">
						<div class="col-md-10">
							<select class="form-control" id="avaliacao" name="avaliacao" required/>
								<option value="">Avalie o atendimento</option>
								<option value="PÉSSIMO">PÉSSIMO</option>
								<option value="RUIM">RUIM</option>
								<option value="REGULAR">REGULAR</option>
								<option value="BOM">BOM</option>
								<option value="EXCELENTE">EXCELENTE</option>
							</select>
						</div>
						<div class='col-md-2'>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-dar-saida'>Avaliar &nbsp;&nbsp;<i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
						</div>
					</form>				
				</div>

		<?php
			
			}
			
		?>

<?php		
	}
}

?>