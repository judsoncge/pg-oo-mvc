<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class ArquivosView extends View{
	
	
	public function listar(){ ?>
		
		<div class='col-md-12 table-responsive' style='overflow: auto; width: 100%; height: 300px;'>
			<table class='table table-hover tabela-dados'>
				<thead>
					<tr>
						<th>Tipo</th>
						<th>Criado por</th>
						<th>Enviado para</th>
						<th>Data de criação</th>
						<th>Status</th>
						<th>Baixar</th>
						<th>Ação</th>
					</tr>	
				</thead>
				<tbody>
					<?php 
					
					
					$lista = $_REQUEST['LISTA_ARQUIVOS'];
						
					foreach($lista as $arquivo){ 
					
					?>
					
						<tr>
							<td><?php echo $arquivo['DS_TIPO'] ?></td>
							<td><?php echo $arquivo['NOME_SERVIDOR_CRIACAO'] ?></td>
							<td><?php echo $arquivo['NOME_SERVIDOR_DESTINO'] ?></td>
							<td><?php echo date_format(new DateTime($arquivo['DT_CRIACAO']), 'd/m/Y'); ?></td>
							<td><?php echo $arquivo['DS_STATUS'] ?></td>
							
							<td><a href='<?php echo "/_registros/anexos/". $arquivo['DS_ANEXO'] ?>' title='<?php echo $arquivo['DS_ANEXO'] ?>' download><?php echo substr($arquivo['DS_ANEXO'], 0, 20) . "..." ?></a></td>
							<td>
								<?php 
										
										if($arquivo['DS_STATUS'] == 'ATIVO'){
										
								?>
											<a href='/editar/arquivo/status/<?php echo $arquivo['ID'] ?>/APROVADO'>
												<button type='button' class='btn btn-secondary btn-sm' title='Aprovar'>
													<i class='fa fa-check' aria-hidden='true'></i>
												</button>
											</a>
								
								<?php
										}
										
										
										if($arquivo['DS_STATUS'] == 'APROVADO'){
								?>
											<a href='/editar/arquivo/status/<?php echo $arquivo['ID'] ?>/INATIVO'>
												<button type='button' class='btn btn-secondary btn-sm' title='Inativar'>
													<i class='fa fa-minus-square-o' aria-hidden='true'></i>
												</button>
											</a>
										
								<?php
										}	
										
								?>		
										<a href='/excluir/arquivo/<?php echo $arquivo['ID'] ?>/<?php echo $arquivo['DS_ANEXO'] ?>'>
											<button type='button' class='btn btn-secondary btn-sm' onclick="return confirm('Você tem certeza que deseja apagar este arquivo?');" title='Excluir'>
												<i class='fa fa-trash' aria-hidden='true'></i>
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
	
	
	public function cadastrar(){ ?>
	
		<form method='POST' action='/cadastrar/arquivo/' enctype='multipart/form-data'>	
			<div class='row'>
				<div class='col-md-4'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Selecione o tipo</label>
						
						<?php $this->carregarSelectTiposDocumento(); ?>
									
					</div>  
				</div>
				<div class='col-md-4'>
					<label class='control-label' for='exampleInputEmail1'>Escolha o servidor para enviar</label><br>
						
						<?php $this->carregarSelectServidores(); ?>

				</div>
				
				<div class='col-md-4'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Escolher anexo</label><br>
						<input type='file' name='arquivoAnexo' id='arquivoAnexo'/>
					</div>
				</div>	
			</div>
			<div class='row' id='cad-button'>
				<div class='col-md-12'>
					<button type='submit' class='btn btn-default' name='submit' value='Send' id='submit'>Cadastrar e enviar</button>
				</div>
			</div>
		</form>	

<?php	
	}

}

?>