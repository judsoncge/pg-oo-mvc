<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/ProcessosView.php';

class ComProcessosView extends ProcessosView{
	
	
	public function visualizar(){
		
		
		$lista = $_REQUEST['DADOS_PROCESSO'];
		
		$listaDocumentos = $_REQUEST['DOCUMENTOS_PROCESSO'];
		
		$listaResponsaveis = $_REQUEST['RESPONSAVEIS_PROCESSO'];
		
		$listaApensados = $_REQUEST['PROCESSOS_APENSADOS'];
		
		$historico = $_REQUEST['HISTORICO_PROCESSO'];
		
		$ativo = $_REQUEST['ATIVO'];
	
		$apensado = $_REQUEST['APENSADO'];
		
		$listaUsuarios = $_REQUEST['LISTA_SERVIDORES'];
		
		$listaPodemSerResponsaveis = $_REQUEST['LISTA_PODEM_SER_RESPONSAVEIS'];
		
		$listaProcessosApensar = $_REQUEST['LISTA_APENSAR']; ?>	
	
		
		<div class='container'>
			
			<?php if($ativo and !$lista['BL_RECEBIDO']){ ?>
			
					<div class='row linha-modal-processo'>
						<div class='alert alert-warning'>O processo físico foi recebido?
							<a href='/editar/processo/receber/<?php echo $lista['ID'] ?>/'>Sim</a>
							/
							<a href='/editar/processo/devolver/<?php echo $lista['ID'] ?>/'>Não</a>
						</div>
					</div>
 
		<?php		
					exit();
				} ?>
		</div>
		
				
<?php 	

		if($ativo){
			
			if($lista['BL_URGENCIA']){	?>						

				<div class='alert alert-warning'>&#9888; ESTE PROCESSO É URGENTE!</div>
 
<?php		} 
			
			
			if($lista['BL_SOBRESTADO']){ ?>

				<div class='alert alert-warning'>&#9888; ESTE PROCESSO ESTÁ EM SOBRESTADO!: <?php echo $lista['DS_JUSTIFICATIVA'] ?></div>
					
<?php   	} ?>
			
				
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
<?php 						foreach($listaApensados as $processoApensado){ 
?>
							
								<a href='/processos/visualizar/<?php echo $processoApensado['ID_PROCESSO_APENSADO'] ?>'><?php echo $processoApensado['DS_NUMERO'] ?></a>
							
<?php						} 
?>
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
										foreach($listaUsuarios as $servidor){
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
	}
}
