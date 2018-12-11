<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/ProcessosView.php';

class TiProcessosView extends ProcessosView{
	
	
	public function listar(){
		
		
		$listaProcessos = $_REQUEST['LISTA_PROCESSOS'];
		
?>		
		
		<div id='resultado' class='col-md-12 table-responsive' style='overflow: auto; width: 100%; height: 300px;'>
			
			
			<div id='carregando' class='carregando'><i class='fa fa-refresh spin' aria-hidden='true'></i> <span>Carregando dados...</span></div>
			
			
			<center>
				<font color='green'><?php echo $_REQUEST['FRASE']; ?></font><br><br>
				
				<h5>
					<div id='qtde'>Total: <?php echo sizeof($listaProcessos) . " " ?>
						<button onclick='javascript: exportar();' class='btn btn-sm btn-success' name='submit' value='Send'>Exportar</button>
					</div>
					
				</h5>				
			</center>
		
			<table class='table table-hover tabela-dados'>
				<thead>
					<tr>
						<th>Número</th>
						<th>Servidor</th>
						<th>Setor</th>
						<th>Prazo</th>
						<th>Status</th>
						<th>Situação</th>
						<th>Dias</th>
						<th>Recebido</th>
						<th>Ação</th>
					</tr>	
				</thead>
				<tbody>
						
					<?php 
					
						foreach($listaProcessos as $processo){ 
						
						
						if($processo['BL_URGENCIA']){ ?>
				
						<tr style='background-color:#f1c40f;'>
					
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
								
								<a href="/processos/visualizar/<?php echo $processo['ID'] ?>">
									<button type='button' class='btn btn-secondary btn-sm' title='Visualizar'>
										<i class='fa fa-eye' aria-hidden='true'></i>
									</button>
								</a>
								
							</td>
						</tr>
				  <?php } ?>		
				</tbody>
			</table>
		</div>
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
		
		$listaServidores = $_REQUEST['LISTA_SERVIDORES'];
		
		$listaPodemSerResponsaveis = $_REQUEST['LISTA_PODEM_SER_RESPONSAVEIS'];
		
		$listaProcessosApensar = $_REQUEST['LISTA_APENSAR']; 

		

		if($ativo){
			
			if($lista['BL_URGENCIA']){	?>						

				<div class='alert alert-warning'>&#9888; ESTE PROCESSO É URGENTE!</div>
 
<?php		} 
			
			
			if($lista['BL_SOBRESTADO']){ ?>

				<div class='alert alert-warning'>&#9888; ESTE PROCESSO ESTÁ EM SOBRESTADO!: <?php echo $lista['DS_JUSTIFICATIVA'] ?></div>
					
<?php   	} 
			
			
			if((!$apensado)){
						
?>						
						<div class='row linha-modal-processo'>

<?php	
							if(!$lista['BL_SOBRESTADO']){
?>
								
								<a href="/editar/processo/sobrestado/<?php echo $lista['ID'] ?>/1"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Marcar sobrestado&nbsp;&nbsp;&nbsp;<i class='fa fa-warning' aria-hidden='true'></i></button></a>
							
<?php	
							}else{
?>
								
								<a href="/editar/processo/sobrestado/<?php echo $lista['ID'] ?>/0"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Desmarcar sobrestado&nbsp;&nbsp;&nbsp;<i class='fa fa-warning' aria-hidden='true'></i></button></a>
							
<?php	
							}
							
							if(!$lista['BL_URGENCIA']){
?>
								
								<a href="/editar/processo/urgencia/<?php echo $lista['ID'] ?>/1"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-urgencia'>Marcar como urgente&nbsp;&nbsp;&nbsp;<i class='fa fa-warning' aria-hidden='true'></i></button></a>
							
<?php	
							}else{
?>
								
								<a href="/editar/processo/urgencia/<?php echo $lista['ID'] ?>/0"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-urgencia'>Desmarcar urgência&nbsp;&nbsp;&nbsp;<i class='fa fa-warning' aria-hidden='true'></i></button></a>
							
<?php	
							}
?>
								
								<a href="/processo/editar/<?php echo $lista['ID'] ?>"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Editar&nbsp;&nbsp;&nbsp;<i class='fa fa-pencil' aria-hidden='true'></i></button></a>
						
								
								<a href="/excluir/processo/<?php echo $lista['ID'] ?>"><button type='submit' onclick="return confirm('Você tem certeza que deseja apagar este processo?');" class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Excluir&nbsp;&nbsp;&nbsp;<i class='fa fa-trash' aria-hidden='true'></i></button></a>
							
						</div>

						<div class='row linha-modal-processo'>

<?php 						
							if($lista['DS_STATUS']=='EM ANDAMENTO'){
								
								
?>								
								<a href="/editar/processo/status/<?php echo $lista['ID'] ?>/FINALIZADO PELO SETOR"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Finalizar em nome do setor&nbsp;&nbsp;&nbsp;<i class='fa fa-calendar-check-o' aria-hidden='true'></i></button></a>	
<?php	
							}
							
							if($lista['DS_STATUS']=='FINALIZADO PELO SETOR'){
?>
									
								<a href="/editar/processo/status/<?php echo $lista['ID'] ?>/FINALIZADO PELO GABINETE"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Finalizar em nome do gabinete&nbsp;&nbsp;&nbsp;<i class='fa fa-calendar-check-o' aria-hidden='true'></i></button></a>
								
								
								<a href="/editar/processo/desfazerstatus/<?php echo $lista['ID'] ?>/EM ANDAMENTO"><button type='submit' class='btn btn-sm btn-success pull-left' name='submit' value='Send' id='botao-dar-saida'>Desfazer finalização do setor&nbsp;&nbsp;<i class='fa fa-external-link-square' aria-hidden='true'></i></button></a>	
								
<?php	
							}
					
							if($lista['DS_STATUS']=='FINALIZADO PELO GABINETE'){
?>
								
								<a href="/editar/processo/desfazerstatus/<?php echo $lista['ID'] ?>/FINALIZADO PELO SETOR"><button type='submit' class='btn btn-sm btn-success pull-left'name='submit' value='Send' id='botao-dar-saida'>Desfazer finalização do gabinete&nbsp;&nbsp;<i class='fa fa-external-link-square' aria-hidden='true'></i></button></a>
								
								
								<a href="/editar/processo/status/<?php echo $lista['ID'] ?>/SAIU"><button type='submit' class='btn btn-sm btn-success pull-left' name='submit' value='Send' id='botao-dar-saida'>Dar saída&nbsp;&nbsp;<i class='fa fa-external-link-square' aria-hidden='true'></i></button></a>						
<?php	
							}if($lista['DS_STATUS']=='FINALIZADO PELO GABINETE' || $lista['DS_STATUS']=='FINALIZADO PELO SETOR'){
?>								
								
								<a href="/editar/processo/status/<?php echo $lista['ID'] ?>/ARQUIVADO"><button type='submit' class='btn btn-sm btn-warning pull-left' name='submit' value='Send' id='botao-arquivar'>Arquivar&nbsp;&nbsp;<i class='fa fa-folder' aria-hidden='true'></i></button></a>	
<?php
							}

?>					</div>
								
<?php			
			}
		
		
		}elseif(!$apensado){
					
					
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
	
<?php		} 
		}
?>				
				<div class='row linha-modal-processo'>
					
					<div class='col-md-12'>
						
						STATUS: <?php echo $lista['DS_STATUS'] ?><br><br>
						
						Está com: <?php echo $lista['NOME_SERVIDOR'] ?><br>
						
						No Setor: <?php echo $lista['NOME_SETOR'] ?><br>

						Assunto: <?php echo $lista['NOME_ASSUNTO'] ?><br>
						
						Detalhes: <?php echo $lista['DS_DETALHES'] ?><br><br>
						
						Órgão interessado: <?php echo $lista['NOME_ORGAO'] ?><br>
						
						Nome do interessado: <?php echo $lista['DS_INTERESSADO'] ?><br><br>
						
						Dias no órgão: <?php echo $lista['NR_DIAS'] ?><br>
							
						Dias em sobrestado: <?php echo $lista['NR_DIAS_SOBRESTADO'] ?><br>	
												
						Data de entrada: <?php echo $lista['DT_ENTRADA'] ?><br>
						
						Prazo: <?php echo $lista['DT_PRAZO'] ?><br>
						
						Data de saída: <?php echo $lista['DT_SAIDA'] ?>	
						
						<br><br>
						
						
						Responsáveis: 
							
<?php 					foreach($listaResponsaveis as $responsavel){
																		
							echo $responsavel['NOME_SERVIDOR'];
							
							
							if($ativo){ ?>										
								<a href="/editar/processo/removerresponsavel/<?php echo $lista['ID'] ?>/<?php echo $responsavel['ID_SERVIDOR'] ?>" title='remover responsável'><i class='fa fa-remove' aria-hidden='true'></i></a>,
								
<?php							}
								
						} ?>							
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
<?php 						foreach($listaApensados as $processoApensado){ ?>
							
								<a href='/processos/visualizar/<?php echo $processoApensado['ID_PROCESSO_APENSADO'] ?>'><?php echo $processoApensado['DS_NUMERO'] ?></a>
							
<?php							if($ativo){ ?>

									<a href="/editar/processo/removerapenso/<?php echo $lista['ID'] ?>/<?php echo $processoApensado['ID_PROCESSO_APENSADO'] ?>" title='remover apenso'><i class='fa fa-remove' aria-hidden='true'></i></a>,
								
<?php							}
							} ?>
							<br>
						
						
						Processo mãe:
							<a href='/processos/visualizar/<?php echo $lista['ID_PROCESSO_MAE'] ?>'><?php echo $lista['NUMERO_PROCESSO_MAE'] ?></a><br><br>
					</div>
				
				</div>
				
				
				<div class='row linha-modal-processo'>
					
					<b>Documentos do processo</b>:<br>
					
					<table class='table table-hover tabela-dados'>
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
									<td>
										<a href="/_registros/anexos/<?php echo $documento['DS_ANEXO'] ?>" title="<?php echo $documento['DS_ANEXO']; ?>" download><?php echo substr($documento['DS_ANEXO'], 0, 20) . "..." ; ?>
										</a>
									</td>
									<td>
<?php 									
										if($ativo){
?> 							
											<a href="/editar/processo/excluirdocumento/<?php echo $lista['ID'] ?>/<?php echo $documento['ID'] ?>">Excluir</a>
											
<?php									}
							} ?>
									</td>
								</tr>
						</tbody>
					</table>
				</div>
				
<?php 			
				
				$this->carregarHistorico($historico);
				
		if($ativo){
											
				
				$this->carregarEnviarMensagem('processo', $lista['ID']); ?>
				
				
				<div class='row linha-modal-processo'>
					<form method='POST' action="/editar/processo/anexardocumento/<?php echo $lista['ID'] ?>" enctype='multipart/form-data'>	
						<div class='col-md-6'>
							<div class='form-group'>
								<label class='control-label' for='exampleInputEmail1'><b>Anexar documento:</b></label>
									
									<?php $this->carregarSelectTiposDocumento(); ?>
							</div>  
						</div>
						<div class='col-md-4'>
							<div class='form-group'>
								<label class='control-label' for='exampleInputEmail1'>Enviar anexo</label><br>
								<input type='file' class='' name='arquivoAnexo' id='arquivoAnexo'/>
							</div>
						</div>	
						<div class='col-md-2'>
							<br>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar'>Anexar &nbsp;&nbsp;<i class='fa fa-arrow-circle-right'  aria-hidden='true'></i></button>
						</div>
					</form>	
				</div>
				
<?php 		
			if(!$apensado){ 
				
				
				if(!$lista['BL_SOBRESTADO']){
			
?>					
					<div class='row linha-modal-processo'>
						<label class='control-label' for='exampleInputEmail1'><b>Solicitar Sobrestado:</b></label>
						<form method='POST' action="/editar/processo/solicitarsobrestado/<?php echo $lista['ID']?>" enctype='multipart/form-data'>	
							<div class='col-md-10'>
								<input class='form-control' id='justificativa' name='justificativa' placeholder='Digite aqui a sua justificativa (Máximo de 100 caracteres)' type='text' maxlength='100' required />	
							</div>
							<div class='col-md-2'>
								<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar' >Solicitar &nbsp;&nbsp;<i class='fa fa-arrow-circle-right' aria-hidden='true'></i></button>
							</div>
						</form>
					</div>	
<?php 		
				}
	
?>
				
				<div class='row linha-modal-processo'>
					<form method='POST' action="/editar/processo/definirresponsaveis/<?php echo $lista['ID'] ?>" enctype='multipart/form-data'>	
						<div class='col-md-10'>
							<label class='control-label' for='exampleInputEmail1'><b>Defina os responsáveis</b>:</label><br>
							<select multiple id='responsaveis' name='responsaveis[]' style='width: 96%;' required>
<?php 								
									foreach($listaPodemSerResponsaveis as $podeSerResponsavel){			
?>
										<option value="<?php echo $podeSerResponsavel['ID'] ?>">
											<?php echo "  " .$podeSerResponsavel['DS_NOME']; ?>
										</option>	
<?php 
									} 
?>
							</select>
						</div>
						<div class='col-md-2'>
							<br>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar'>Definir &nbsp;&nbsp;<i class='fa fa-arrow-circle-right' aria-hidden='true'></i></button>
						</div>
					</form>	
				</div>
				
<?php 			
				if(count($listaResponsaveis) > 1){
?>				
					<form name='teste' method='POST' action="/editar/processo/definirlider/<?php echo $lista['ID'] ?>" enctype='multipart/form-data'>
						<div class='row linha-modal-processo'>
							<div class='col-md-10'>
								<label class='control-label' for='exampleInputEmail1'><b>Defina o responsável líder</b>:</label><br>
								<select class='form-control' id='lider' name='lider' required >
									<option value=''>Selecione</option>
<?php									foreach($listaResponsaveis as $responsavel){ ?>	
										
											<option value="<?php echo $responsavel['ID_SERVIDOR'] ?>"><?php echo $responsavel['NOME_SERVIDOR']; ?></option>
										
<?php 									} 
?>								</select>
							</div>
							<div class='col-md-2'>
								<br>
								<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar'>Definir &nbsp;&nbsp;<i class='fa fa-arrow-circle-right' aria-hidden='true'></i></button>
							</div>
						</div>
					</form>
				
<?php 							
				} 
?>
				
				<div class='row linha-modal-processo'>
					<form method='POST' action="/editar/processo/apensar/<?php echo $lista['ID'] ?>" enctype='multipart/form-data'>	
						<div class='col-md-10'>
							<label class='control-label' for='exampleInputEmail1'><b>Defina os Apensos</b>:</label><br>
							<select multiple id='apensos' name='apensos[]' style='width: 96%;' required>
<?php 							
								foreach($listaProcessosApensar as $processo){
?>
									<option value="<?php echo $processo['ID'] ?>"><?php echo $processo['DS_NUMERO'] ?></option>
								
<?php 							} 
?>
							</select>
						</div>
						<div class='col-md-2'>
							<br>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar'>Apensar &nbsp;&nbsp;<i class='fa fa-arrow-circle-right'  aria-hidden='true'></i></button>
						</div>
					</form>	
				</div>
				
				
				<form name='teste' method='POST' action='/editar/processo/tramitar/<?php echo $lista['ID']?>/' enctype='multipart/form-data'>	
					<div class='row linha-modal-processo'>
						<div class='col-md-10'>
							<select class='form-control' id='tramitar' name='tramitar' required />
								<option value=''>Selecione o servidor para tramitar</option>
<?php 
									foreach($listaServidores as $servidor){
?>	
										<option value='<?php echo $servidor['ID'] ?>'><?php echo $servidor['DS_NOME'] ?></option>		
										
<?php									
									}
?>
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
}