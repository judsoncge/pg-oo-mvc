<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class ProcessosView extends View{
	
	public function adicionarScripts(){ ?>		
		
		<script src='/view/_libs/js/receber.js' ?>'></script>
		<script src='/view/_libs/js/filtros.js'  ?>'></script>
		<script src='/view/_libs/js/exportar.js' ?>'></script>	

<?php	
	
	}
	
	public function carregarFiltro(){
		
		$listaServidores = $_REQUEST['LISTA_SERVIDORES']; 
		
		$listaSetores = $_REQUEST['LISTA_SETORES']; 

?>	

		<div class="well">
			<form>
				<div class="row">						
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label" for="exampleInputEmail1">Filtro de servidor</label><br>
							<select id="filtroservidor" name="filtroservidor" >
								<option value="%">Todos</option>
								<?php foreach($listaServidores as $servidor){ ?>
										<option value="<?php echo $servidor['ID'] ?>">
											<?php echo $servidor['DS_NOME']; ?>
										</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label" for="exampleInputEmail1">Filtro de setor</label><br>
								<select id="filtrosetor" name="filtrosetor" >
									<option value="%">Todos</option>
									<?php foreach($listaSetores as $setor){ ?>
										<option value="<?php echo $setor['ID'] ?>">
											<?php echo $setor['DS_NOME']; ?>
										</option>
									<?php } ?>
								</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label" for="exampleInputEmail1">Filtro de situação</label><br>
								<select id="filtrosituacao" name="filtrosituacao" >
									<option value="%">Todos</option>
									<option value="0">DENTRO DO PRAZO</option>
									<option value="1">ATRASADO</option>
								</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label" for="exampleInputEmail1">Sobrestado</label><br>
							<select id="filtrosobrestado" name="filtrosobrestado" >
								<option value="%">Todos</option>
								<option value="0">Não</option>
								<option value="1">Sim</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<div class="input-group margin-bottom-sm">
								<span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span> <input type="text" class="input-search form-control" alt="tabela-dados" placeholder="Busque pelo numero do processo" id="filtroprocesso" name="filtroprocesso" autofocus="autofocus" />
							</div>
						</div>	
					</div>
				</div>
			</form>
		</div>
		
		

<?php
	
	}
	
	public function listar(){

		$this->carregarTabela();			
	
	}
	
	public function carregarTabela(){
		
		$listaProcessos = $_REQUEST['LISTA_PROCESSOS'];
		
?>		
		<div id="resultado" class="col-md-12 table-responsive" style="overflow: auto; width: 100%; height: 300px;">
			
		<div id="carregando" class="carregando"><i class="fa fa-refresh spin" aria-hidden="true"></i> <span>Carregando dados...</span></div>	
			<table class="table table-hover tabela-dados">
				<thead>
					<tr>
						<th>Número  </th>
						<th>Servidor</th>
						<th>Setor   </th>
						<th>Prazo   </th>
						<th>Status  </th>
						<th>Situação</th>
						<th>Dias    </th>
						<th>Recebido</th>
						<th>Ação    </th>
					</tr>	
				</thead>
				<tbody>
					<?php 
						
						$l = sizeof($listaProcessos);
					?>	
						<center>
							<h5>
								<div id='qtde'>Total: <?php echo $l . " " ?>
									<button onclick="javascript: exportar();" class="btn btn-sm btn-success" name="submit" value="Send">Exportar</button>
								</div>
							</h5>
						</center>
						
					<?php 
					
						foreach($listaProcessos as $processo){ 
						
						//se o processo for urgente, a linha fica amarela
						if($processo['BL_URGENCIA']){ ?>
				
						<tr style="background-color:#f1c40f;">
					
						<?php }else{ ?>
					
						<tr>
					
					    <?php } ?>
							<td><?php echo $processo['DS_NUMERO'] ?></td>
							<td><?php echo $processo['NOME_SERVIDOR'] ?></td>
							<td><?php echo $processo['NOME_SETOR']  ?></td>
							<td><?php echo date_format(new DateTime($processo['DT_PRAZO']), 'd/m/Y') ?></td>
							<td><?php echo $processo['DS_STATUS'] ?></td>
							<td><?php 
									if($processo['BL_ATRASADO']){
										echo "<font color='red'>ATRASADO</font>";
									}else{
										echo "<font color='green'>DENTRO DO PRAZO</font>";
									} 
								?>
							</td>
							
							<td><?php echo $processo['NR_DIAS'] ?></td>
							
							<td id="statusRecebido<?php echo $processo['ID'] ?>">
								<?php 
									if($processo['BL_RECEBIDO']){
										echo 'SIM';
									}else{ 
										echo 'NÃO';
									} 
								?>
							</td>				
							
							<td id="recebido<?php echo $processo['ID'] ?>">
								
								<?php if(!$processo['BL_RECEBIDO']){ ?>
									
										<a id="receber<?php echo $processo['ID'] ?>" onclick="receber(<?php echo $processo['ID'] ?>)" href='javascript:void(0);'>RECEBER</a>
										
										<br> 
												
										<a href='#'>DEVOLVER</a>
								
								<?php } else{ ?>
									
										<a href="/processos/visualizar/<?php echo $id ?>">
											<button type='button' class='btn btn-secondary btn-sm' title='Visualizar'>
												<i class='fa fa-eye' aria-hidden='true'></i>
											</button>
										</a>

							  <?php } ?>
							</td>
						</tr>
				  <?php } ?>		
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