<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class ProcessosView extends View{
	
	public function adicionarScripts(){ 
	
		if($this->conteudo == 'lista' or $this->conteudo == 'visualizar'){
	
	?>		
	
			<script src='/view/_libs/js/receber.js'></script>
			<script src='/view/_libs/js/filtros.js'></script>
			<script src='/view/_libs/js/exportar.js'></script>
			<link rel='stylesheet' type='text/css' href='/view/_libs/css/multiple-select.css'>
			<script type='text/javascript' src='/view/_libs/js/multiple-select.js'></script>
			<script type='text/javascript'>
				window.onload = function(){
					$('#responsaveis').multipleSelect();
					$('#apensos').multipleSelect();
					
				}
			</script>
		
<?php	
		}
	}
	
	public function carregarFiltro(){
		
		$listaServidores = $_REQUEST['LISTA_SERVIDORES']; 
		
		$listaSetores = $_REQUEST['LISTA_SETORES']; 

?>	

		<div class='well'>
			<form>
				<div class='row'>						
					<div class='col-md-4'>
						<div class='form-group'>
							<label class='control-label' for='exampleInputEmail1'>Filtro de servidor</label><br>
							<select id='filtroservidor' name='filtroservidor' >
								<option value='<?php echo $_SESSION['ID'] ?>'><?php echo $_SESSION['NOME'] ?></option>
								<option value='%'>Todos</option>
								<?php foreach($listaServidores as $servidor){ ?>
										<option value='<?php echo $servidor['ID'] ?>'>
											<?php echo $servidor['DS_NOME']; ?>
										</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class='col-md-2'>
						<div class='form-group'>
							<label class='control-label' for='exampleInputEmail1'>Filtro de setor</label><br>
								<select id='filtrosetor' name='filtrosetor' >
									<option value='<?php echo $_SESSION['SETOR'] ?>'><?php echo $_SESSION['NOME_SETOR'] ?></option>
									<option value='%'>Todos</option>
									<?php foreach($listaSetores as $setor){ ?>
										<option value='<?php echo $setor['ID'] ?>'>
											<?php echo $setor['DS_ABREVIACAO']; ?>
										</option>
									<?php } ?>
								</select>
						</div>
					</div>
					<div class='col-md-2'>
						<div class='form-group'>
							<label class='control-label' for='exampleInputEmail1'>Filtro de situação</label><br>
								<select id='filtrosituacao' name='filtrosituacao' >
									<option value='%'>Todos</option>
									<option value='0'>NO PRAZO</option>
									<option value='1'>ATRASADO</option>
								</select>
						</div>
					</div>
					<div class='col-md-2'>
						<div class='form-group'>
							<label class='control-label' for='exampleInputEmail1'>Sobrestado</label><br>
							<select id='filtrosobrestado' name='filtrosobrestado' >
								<option value='%'>Todos</option>
								<option value='0'>NÃO</option>
								<option value='1'>SIM</option>
							</select>
						</div>
					</div>
					<div class='col-md-2'>
						<div class='form-group'>
							<label class='control-label' for='exampleInputEmail1'>Recebido</label><br>
							<select id='filtrorecebido' name='filtrorecebido' >
								<option value='%'>Todos</option>
								<option value='0'>NÃO</option>
								<option value='1'>SIM</option>
							</select>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='col-md-12'>
						<div class='form-group'>
							<div class='input-group margin-bottom-sm'>
								<span class='input-group-addon'><i class='fa fa-search fa-fw'></i></span> <input type='text' class='input-search form-control' alt='tabela-dados' placeholder='Busque pelo numero do processo' id='filtroprocesso' name='filtroprocesso' autofocus='autofocus' />
							</div>
						</div>	
					</div>
				</div>
			</form>
		</div>
		
		

<?php
	}
	
	public function listar(){
		
		$listaProcessos = $_REQUEST['LISTA_PROCESSOS'];
		
?>		
		<div id="resultado" class="col-md-12 table-responsive" style="overflow: auto; width: 100%; height: 300px;">
			
		<div id="carregando" class="carregando"><i class="fa fa-refresh spin" aria-hidden='true'></i> <span>Carregando dados...</span></div>	
		
		
			<h5>
				<div id='qtde'>Total: <?php echo sizeof($listaProcessos) . " " ?>
					<button onclick="javascript: exportar();" class='btn btn-sm btn-success' name='submit' value='Send'>Exportar</button>
				</div>
			</h5>
		
		
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
					
						foreach($listaProcessos as $processo){ 
						
						//se o processo for urgente, a linha fica amarela
						if($processo['BL_URGENCIA']){ ?>
				
						<tr style="background-color:#f1c40f;">
					
						<?php }else{ ?>
					
						<tr>
					
					    <?php } ?>
							<td><?php echo $processo['DS_NUMERO'] ?></td>
							<td id="servidorLocalizacao<?php echo $processo['ID'] ?>"><?php echo $processo['NOME_SERVIDOR'] ?></td>
							<td><?php echo $processo['NOME_SETOR']  ?></td>
							<td><?php echo $processo['DT_PRAZO'] ?></td>
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
												
										<a href='/editar/processo/devolver/<?php echo $processo['ID'] ?>'>DEVOLVER</a>
								
								<?php } else{ ?>
									
										<a href="/processos/visualizar/<?php echo $processo['ID'] ?>">
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
	
	public function exportar(){
		
		include($_SERVER['DOCUMENT_ROOT'].'/view/_libs/mpdf60/mpdf.php');
		
		$listaProcessos = $_REQUEST['LISTA_PROCESSOS'];
		
		$html = "<style type='text/css'>
		#customers {
		font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;
		border-collapse: collapse;
		width: 100%;
		}

		#customers td, #customers th {
			border: 1px solid #ddd;
			padding: 8px;
		}

		#customers tr:nth-child(even){background-color: #f2f2f2;}

		#customers tr:hover {background-color: #ddd;}

		#customers th {
			padding-top: 12px;
			padding-bottom: 12px;
			text-align: left;
			background-color: #4CAF50;
			color: white;
		}
		</style>
		<table id='customers'>
			<thead>
				<tr>
					<th>Número  </th>
					<th>Servidor</th>
					<th>Setor</th>
					<th>Prazo   </th>
					<th>Status  </th>
					<th>Situação</th>
					<th>Dias    </th>
					<th>Recebido</th>
				</tr>	
			</thead>";
			
		foreach($listaProcessos as $processo){
			
			$atrasado = ($processo['BL_ATRASADO']) ? "ATRASADO" : "DENTRO DO PRAZO";

			$recebido = ($processo['BL_RECEBIDO']) ? "SIM" : "NÃO";
			
			$html .= 
		 "<tr> 
			<td>
				
					".$processo['DS_NUMERO']."
				
			</td>
			<td>
				
					".$processo['NOME_SERVIDOR']."
				
			</td>
			<td>
				
					".$processo['NOME_SETOR']."
				
			</td>
			<td>
				
					".$processo['DT_PRAZO']."
				
			</td>
			<td>
				
					".$processo['DS_STATUS']."
				
			</td>
			<td>
				
					".$atrasado."
				
			</td>
			<td>
				
					".$processo['NR_DIAS']."
				
			</td>
			<td>
				
					".$recebido."
				
			</td>				
		</tr>";

		}
		
		$html .= "  </tbody>	
		</table>";
				
		$mpdf=new mPDF();
		$mpdf->WriteHTML($html);   
		$mpdf->Output();
		exit();
		
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
		
		$lista = $_REQUEST['DADOS_PROCESSO'];
		
		$listaDocumentos = $_REQUEST['DOCUMENTOS_PROCESSO'];
		
		$listaResponsaveis = $_REQUEST['RESPONSAVEIS_PROCESSO'];
		
		$listaApensados = $_REQUEST['PROCESSOS_APENSADOS'];
		
		$historico = $_REQUEST['HISTORICO_PROCESSO'];
		
		$ativo = $_REQUEST['ATIVO'];
		
		$apensado = $_REQUEST['APENSADO'];
		
?>		
	
		<div class='container'>

<?php 
				if($ativo and !$apensado and !$lista['BL_RECEBIDO']){
?>
					<div class='row linha-modal-processo'>
						
								<div class='alert alert-warning'>O processo físico foi recebido?
								
									<a href='/editar/processo/devolver/<?php echo $lista['ID'] ?>'>Sim</a>
									/
									<a href='/editar/processo/devolver/<?php echo $lista['ID'] ?>'>Não</a>
							
								</div>
						
					</div>
<?php 
					exit();
				} 
			
?>
		</div>
		
				
<?php 
		
				if($ativo){
					
					if($lista["BL_URGENCIA"]){							
?>
						<div class="alert alert-warning">&#9888; ESTE PROCESSO É URGENTE!</div>
<?php 
					} 
					
					if($lista["BL_SOBRESTADO"]){ 
					
?>

						<div class="alert alert-warning">&#9888; ESTE PROCESSO ESTÁ EM SOBRESTADO!</div>
					
<?php   
			
					} 
					
					if(($lista["BL_RECEBIDO"] and !$apensado)){
						
?>						
						<div class='row linha-modal-processo'>

<?php	
							if(!$lista["BL_SOBRESTADO"]){
?>
							
								<a href="/editar/processo/sobrestado/<?php echo $lista['ID'] ?>/1"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Marcar sobrestado&nbsp;&nbsp;&nbsp;<i class="fa fa-warning" aria-hidden='true'></i></button></a>
							
<?php	
							}else{
?>
							
								<a href="/editar/processo/sobrestado/<?php echo $lista['ID'] ?>/0"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Desmarcar sobrestado&nbsp;&nbsp;&nbsp;<i class="fa fa-warning" aria-hidden='true'></i></button></a>
							
<?php	
							}
							
							if(!$lista["BL_URGENCIA"]){
?>
							
								<a href="/editar/processo/urgencia/<?php echo $lista['ID'] ?>/1"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-urgencia'>Marcar como urgente&nbsp;&nbsp;&nbsp;<i class="fa fa-warning" aria-hidden='true'></i></button></a>
							
<?php	
							}else{
?>
							
								<a href="/editar/processo/urgencia/<?php echo $lista['ID'] ?>/0"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-urgencia'>Desmarcar urgência&nbsp;&nbsp;&nbsp;<i class="fa fa-warning" aria-hidden='true'></i></button></a>
							
<?php	
							}
?>
							
								<a href="#"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Editar&nbsp;&nbsp;&nbsp;<i class="fa fa-pencil" aria-hidden='true'></i></button></a>
						
								
								<a href="/excluir/processo/<?php echo $lista['ID'] ?>"><button type='submit' onclick="return confirm('Você tem certeza que deseja apagar este processo?');" class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Excluir&nbsp;&nbsp;&nbsp;<i class="fa fa-trash" aria-hidden='true'></i></button></a>
							
						</div>

						<div class='row linha-modal-processo'>

<?php 
							if($lista['DS_STATUS']=='EM ANDAMENTO'){
								
								
?>
								<a href="/editar/processo/status/<?php echo $lista['ID'] ?>/FINALIZADO PELO SETOR"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Finalizar em nome do setor&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar-check-o" aria-hidden='true'></i></button></a>	
<?php	
							}
							
							if($lista['DS_STATUS']=='FINALIZADO PELO SETOR'){
?>
									
								<a href="/editar/processo/status/<?php echo $lista['ID'] ?>/FINALIZADO PELO GABINETE"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Finalizar em nome do gabinete&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar-check-o" aria-hidden='true'></i></button></a>
								
								<a href="/editar/processo/desfazerstatus/<?php echo $lista['ID'] ?>/EM ANDAMENTO"><button type='submit' class='btn btn-sm btn-success pull-left' name='submit' value='Send' id='botao-dar-saida'>Desfazer finalização do setor&nbsp;&nbsp;<i class="fa fa-external-link-square" aria-hidden='true'></i></button></a>	
								
<?php	
							}
					
							if($lista['DS_STATUS']=='FINALIZADO PELO GABINETE'){
?>
								
								<a href="/editar/processo/desfazerstatus/<?php echo $lista['ID'] ?>/FINALIZADO PELO SETOR"><button type='submit' class='btn btn-sm btn-success pull-left'name='submit' value='Send' id='botao-dar-saida'>Desfazer finalização do gabinete&nbsp;&nbsp;<i class='fa fa-external-link-square' aria-hidden='true'></i></button></a>

								<a href="/editar/processo/status/<?php echo $lista['ID'] ?>/SAIU"><button type='submit' class='btn btn-sm btn-success pull-left' name='submit' value='Send' id='botao-dar-saida'>Dar saída&nbsp;&nbsp;<i class='fa fa-external-link-square' aria-hidden='true'></i></button></a>						
<?php	
							}if($lista['DS_STATUS']=='FINALIZADO PELO GABINETE' || $lista['DS_STATUS']=='FINALIZADO PELO SETOR'){
?>
								<a href="/editar/processo/status/<?php echo $lista['ID'] ?>/ARQUIVADO"><button type='submit' class='btn btn-sm btn-warning pull-left' name='submit' value='Send' id='botao-arquivar'>Arquivar&nbsp;&nbsp;<i class="fa fa-folder" aria-hidden='true'></i></button></a>	
<?php
							}

?>					
						</div>
								
<?php			
					}
					
				}else{
					
					
					if($lista['DS_STATUS'] == 'SAIU'){ 
					
?>		
						<div class='row linha-modal-processo'>
							
							<a href="/editar/processo/voltar/<?php echo $lista['ID'] ?>"><button type='submit' class='btn btn-sm btn-success pull-left'name='submit' value='Send' id='botao-dar-saida'>Voltar processo&nbsp;&nbsp;<i class='fa fa-external-link-square' aria-hidden='true'></i></button></a>
							
						</div>
								
<?php

					}elseif($lista['DS_STATUS'] == 'ARQUIVADO'){

?>
						<div class='row linha-modal-processo'>
							
							<a href="/editar/processo/desarquivar/<?php echo $lista['ID'] ?>"><button type='submit' class='btn btn-sm btn-success pull-left' name='submit' value='Send' id='botao-dar-saida'>Desarquivar&nbsp;&nbsp;<i class='fa fa-external-link-square' aria-hidden='true'></i></button></a>

						</div>
	
<?php		
				
					} 
				}
?>
				<div class='row linha-modal-processo'>
					
					<div class='col-md-12'>
						
						STATUS: <?php echo $lista["DS_STATUS"] ?><br><br>
						
						Está com: <?php echo $lista["NOME_SERVIDOR"] ?><br>
						
						No Setor: <?php echo $lista["NOME_SETOR"] ?><br>

						Assunto: <?php echo $lista["NOME_ASSUNTO"] ?><br>
						
						Detalhes: <?php echo $lista["DS_DETALHES"] ?><br><br>
						
						Órgão interessado: <?php echo $lista["NOME_ORGAO"] ?><br>
						
						Nome do interessado: <?php echo $lista["DS_INTERESSADO"] ?><br><br>
						
						Dias no órgão: <?php echo $lista["NR_DIAS"] ?><br>
							
						Dias em sobrestado: <?php echo $lista["NR_DIAS_SOBRESTADO"] ?><br>	
												
						Data de entrada: <?php echo $lista["DT_ENTRADA"] ?><br>
						
						Prazo: <?php echo $lista["DT_PRAZO"] ?><br>
						
						Data de saída: <?php echo $lista["DT_SAIDA"] ?><br><br>
						
						Responsáveis: 
							
<?php 
							foreach($listaResponsaveis as $responsavel){
																			
								echo $responsavel['NOME_SERVIDOR'];
								
								if($ativo){
									
?>												
									<a href="#" title='remover responsável'><i class='fa fa-remove' aria-hidden='true'></i></a>,
									
<?php												
								}
								
							} 

?>
							
						<br>
						
						Responsável líder:      
<?php                                 
							
							foreach($listaResponsaveis as $responsavel){

								if($responsavel['BL_LIDER']){
									
									echo $responsavel['NOME_SERVIDOR'];
									
								}

							}
							
?>
						<br><br>
						
						Processos apensados:
<?php 
															
							foreach($listaApensados as $processoApensado){
?>											
							
								<a href='/processos/visualizar/<?php echo $processoApensado['ID_PROCESSO_APENSADO'] ?>'><?php echo $processoApensado['DS_NUMERO'] ?></a>
							
<?php
								if($ativo){
?>			
									<a href='#' title='remover apenso'><i class='fa fa-remove' aria-hidden='true'></i></a>,
								
<?php							
								}
								
									
							} 
								
?>
							<br>
						
						Processo mãe:
							
							<a href='/processos/visualizar/<?php echo $lista['ID_PROCESSO_MAE'] ?>'><?php echo $lista['NUMERO_PROCESSO_MAE'] ?></a><br><br>
						
					</div>
				</div>
				
				
				<div class='row linha-modal-processo'>
					
					<b>Documentos do processo</b>:<br>
					
					<table class="table table-hover tabela-dados">
						<thead>
							<tr>
								<th>Tipo</th>
								<th>Criador</th>
								<th>Data de criação</th>
								<th>Baixar</th>
								<th>Ação</th>
							</tr>	
						</thead>
						<tbody>
<?php 
							
							foreach($listaDocumentos as $documento){
								
?>
								<tr>
									<td><?php echo $documento['DS_TIPO']; ?></td>
									<td><?php echo $documento['NOME_CRIADOR']; ?></td>
									<td><?php echo $documento['DT_CRIACAO']; ?></td>
									<td><a href="<?php echo $_SERVER['DOCUMENT_ROOT'].'/_registros/anexos/'.$documento['DS_ANEXO'] ?>" title="<?php echo $documento['DS_ANEXO']; ?>" download><?php echo substr($documento['DS_ANEXO'], 0, 20) . "..." ; ?></a></td>
									<td>
<?php 								
										if($ativo){
?> 							
											<a href="#">Excluir</a>
											
<?php								 
										}
							}

?>
									</td>
								</tr>
						</tbody>
					</table>
				</div>
				
<?php 			$this->carregarHistorico($historico);
				
		if($ativo){
					
			$this->carregarEnviarMensagem('processo', $lista['ID']);
				
				
?>
				
				<div class='row linha-modal-processo'>
					<label class="control-label" for="exampleInputEmail1"><b>Solicitar Sobrestado:</b></label>
					<form method='POST' action='#' enctype='multipart/form-data'>	
						<div class="col-md-10">
							<input class="form-control" id="justificativa" name="justificativa" placeholder="Digite aqui a sua justificativa (Máximo de 50 caracteres)" type="text" maxlength="50" required />	
						</div>
						<div class='col-md-2'>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar' onclick="play()">Solicitar &nbsp;&nbsp;<i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
						</div>
					</form>
				</div>	

				<div class='row linha-modal-processo'>
					<form method='POST' action='#' enctype='multipart/form-data'>	
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label" for="exampleInputEmail1"><b>Anexar documento:</b></label>
									<?php $this->carregarSelectTiposDocumento(); ?>
							</div>  
						</div>
						<div class="col-md-4">
									<div class="form-group">
										<label class="control-label" for="exampleInputEmail1">Enviar anexo</label><br>
										<input type="file" class="" name="arquivo_anexo" id="arquivo_anexo"/>
									</div>
								</div>	
						<div class="col-md-2">
							<br>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar'>Anexar &nbsp;&nbsp;<i class="fa fa-arrow-circle-right"  aria-hidden="true"></i></button>
						</div>
					</form>	
				</div>
				
				<div class='row linha-modal-processo'>
					<form method='POST' action='#' enctype='multipart/form-data'>	
						<div class='col-md-10'>
							<label class='control-label' for='exampleInputEmail1'><b>Defina os responsáveis</b>:</label><br>
							<select multiple id='responsaveis' name='responsaveis[]' style='width: 96%;' required>
								<?php 
								
								//$lista3 = 
								
								//retorna_podem_ser_responsaveis_processo($informacoes['ID'], $conexao_com_banco);
								
								//while($r3 = mysqli_fetch_object($lista3)){ ?>
								
									<option value="<?php //echo $r3->ID ?>">
										<?php //echo "  " . $r3->NM_SERVIDOR; ?>
									</option>
								
								<?php //} ?>
							</select>
						</div>
						<div class='col-md-2'>
							<br>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar'>Definir &nbsp;&nbsp;<i class='fa fa-arrow-circle-right' aria-hidden='true'></i></button>
						</div>
					</form>	
				</div>
				
				<form name='teste' method='POST' action='#' enctype='multipart/form-data'>
					<div class='row linha-modal-processo'>
						<div class='col-md-10'>
							<label class='control-label' for='exampleInputEmail1'><b>Defina o responsável líder</b>:</label><br>
							<select class='form-control' id='lider' name='lider' required />
								
								<option value=''>Líder atual: </option>
<?php 
								//$lista2 = retorna_lista_nao_lideres_processo($id, $conexao_com_banco);
								
								//while($r2 = mysqli_fetch_object($lista2)){ 
								
?>	
									<option value="<?php //echo $r2->ID_SERVIDOR ?>"><?php //echo $r2->NM_SERVIDOR; ?></option>
									
<?php 							
								//} 
?>
							</select>
						</div>
						<div class='col-md-2'>
							<br>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar'>Definir &nbsp;&nbsp;<i class='fa fa-arrow-circle-right' aria-hidden='true'></i></button>
						</div>
					</div>
				</form>
				
				<div class='row linha-modal-processo'>
					<form method='POST' action='#' enctype='multipart/form-data'>	
						<div class='col-md-10'>
							<label class='control-label' for='exampleInputEmail1'><b>Defina os Apensos</b>:</label><br>
							<select multiple id='apensos' name='apensos[]' style='width: 96%;' required>
								<?php //$lista3 = retorna_processos_apensar($id, $conexao_com_banco);
								//'while($r3 = mysqli_fetch_object($lista3)){ ?>
								<option value="<?php //echo $r3->ID ?>"><?php //echo $r3->CD_PROCESSO ?></option><?php //} ?>
							</select>
						</div>
						<div class='col-md-2'>
							<br>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar'>Apensar &nbsp;&nbsp;<i class='fa fa-arrow-circle-right'  aria-hidden='true'></i></button>
						</div>
					</form>	
				</div>
				
				<form name='teste' method='POST' action='logica/editar.php?operacao=tramitar&id=<?php echo $informacoes['ID'] ?>' enctype='multipart/form-data'>	
					<div class='row linha-modal-processo'>
						<div class='col-md-10'>
							<select class='form-control' id='tramitar' name='tramitar' required/>
								<option value=''>Selecione o servidor para tramitar</option>
								
								<?php 
								
									//$lista2 = retorna_servidores_tramitar($conexao_com_banco);
									
									//while($r2 = mysqli_fetch_object($lista2)){ 
								
								?>
								
									<option value='<?php //echo $r2->ID ?>'><?php //echo $r2->NM_SERVIDOR; ?></option>
									
								<?php //} ?>
							</select>
						</div>
						
						<div class='col-md-2'>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar'>Tramitar &nbsp;&nbsp;<i class='fa fa-arrow-circle-right' aria-hidden='true'></i></button>
						</div>
					</div>
				</form>
<?php
		}
	}	
	
}