<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/ProcessosView.php';

class TacProcessosView extends ProcessosView{
	
	//carrega a visualizaçao do processo. aqui, além das informações gerais de um processo, são carregadas também várias outras funcionalidades.
	public function visualizar(){
		
		//pegando dados do processo com o processos controller
		$lista = $_REQUEST['DADOS_PROCESSO'];
		
		$listaDocumentos = $_REQUEST['DOCUMENTOS_PROCESSO'];
		
		$listaResponsaveis = $_REQUEST['RESPONSAVEIS_PROCESSO'];
		
		$listaApensados = $_REQUEST['PROCESSOS_APENSADOS'];
		
		$historico = $_REQUEST['HISTORICO_PROCESSO'];
		
		//recebe do processos controller a informação de que o processo está ativo ou inativo (arquivado ou saiu)
		$ativo = $_REQUEST['ATIVO'];
		
		//recebe do processos controller a informação de que o processo é apenso a outro processo
		$apensado = $_REQUEST['APENSADO'];
		
		$listaServidores = $_REQUEST['LISTA_SERVIDORES'];
		
		$listaPodemSerResponsaveis = $_REQUEST['LISTA_PODEM_SER_RESPONSAVEIS'];
		
		$listaProcessosApensar = $_REQUEST['LISTA_APENSAR']; ?>	
	
		<!-- se o processo nao for recebido e mesmo assim o servidor conseguir entrar na página de visualizar, é perguntado se o processo foi recebido e logo após o carregamento da página é interrompido. -->
		<div class='container'>
			
			<?php if($ativo and !$lista['BL_RECEBIDO']){ ?>
			
					<div class='row linha-modal-processo'>
						<div class='alert alert-warning'>O processo físico foi recebido?
							<a href='/editar/processo/receber/<?php echo $lista['ID'] ?>/'>Sim</a>
							/
							<a href='/editar/processo/devolver/<?php echo $lista['ID'] ?>/'>Não</a>
						</div>
					</div>
 
		<?php		// carregamento da página é interrompido		
					exit();
				} ?>
		</div>
		
				
<?php 	//caso o processo esteja ativo e ele seja urgente, aparece um aviso na página.

		if($ativo){
			
			if($lista['BL_URGENCIA']){	?>						

				<div class='alert alert-warning'>&#9888; ESTE PROCESSO É URGENTE!</div>
 
<?php		} 
			//caso o processo esteja em ativo e ele esteja em sobrestado, aparece um aviso na página.
			
			if($lista['BL_SOBRESTADO']){ ?>

				<div class='alert alert-warning'>&#9888; ESTE PROCESSO ESTÁ EM SOBRESTADO!: <?php echo $lista['DS_JUSTIFICATIVA'] ?></div>
					
<?php   	} ?>
			
				<!-- informações do processo -->
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
						
						<!-- lista de responsáveis do processo. a lista de responsáveis (que foi recebida acima) é iterada mostrando o nome dos responsáveis do processo em questão -->
						Responsáveis: 
							
<?php 					foreach($listaResponsaveis as $responsavel){
																		
							echo $responsavel['NOME_SERVIDOR'];
								
						} 
?>							
						<br>
						
						<!-- mostra o responsavel lider do processo -->
						Responsável líder:      
<?php                                 
							foreach($listaResponsaveis as $responsavel){

								if($responsavel['BL_LIDER']){
									
									echo $responsavel['NOME_SERVIDOR'];
									
								}

							}
							
?>
						<br><br>
						
						<!-- lista de processos apensados. mesma lógica dos responsaveis de processo -->
						Processos apensados:
<?php 						foreach($listaApensados as $processoApensado){ 
?>
							
								<a href='/processos/visualizar/<?php echo $processoApensado['ID_PROCESSO_APENSADO'] ?>'><?php echo $processoApensado['DS_NUMERO'] ?></a>
							
<?php						} 
?>
							<br>
						
						<!-- mostra o processo mae do processo em questão, caso haja. -->
						Processo mãe:
							<a href='/processos/visualizar/<?php echo $lista['ID_PROCESSO_MAE'] ?>'><?php echo $lista['NUMERO_PROCESSO_MAE'] ?></a><br><br>
					</div>
				
				</div>
				
				<!-- tabela que mostra os documentos do processo em questão -->
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
							//iterando a lista de documentos que foi recebida la em cima
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
<?php 									//so pode deletar um documento do processo caso ele esteja ativo
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
				//carrega o historico do processo passando o array recebido la em cima. o metodo esta definido na classe mae
				$this->carregarHistorico($historico);
				
		if($ativo){
											
				//carrega o input para enviar mensagem, passando os parametros necessarios. o metodo esta definido na classe mae
				$this->carregarEnviarMensagem('processo', $lista['ID']); ?>
				
				<!-- formulario para anexar um documento ao processo -->
				<div class='row linha-modal-processo'>
					<form method='POST' action="/editar/processo/anexardocumento/<?php echo $lista['ID'] ?>" enctype='multipart/form-data'>	
						<div class='col-md-6'>
							<div class='form-group'>
								<label class='control-label' for='exampleInputEmail1'><b>Anexar documento:</b></label>
									<!-- carrega o select dos tipos de documento. o metodo esta definido na classe mae -->
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
				
<?php 		//muitas funcionalidades nao sao permitidas serem executadas quando o processo é apensado a outro
			if(!$apensado){
?>
				<!-- select multiple box para o usuário definir apensos ao processo em questão. a lista de processos para apensar é recebida pelo processos controller lá em cima -->
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
				
				<!-- select para o usuário escolher um outro usuário para enviar o processo. a lista de servidores é recebida do processos controller lá em cima -->
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