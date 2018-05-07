<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class ArquivosView extends View{
	
	public function listar(){ ?>
		
		<div class="col-md-12 table-responsive" style="overflow: auto; width: 100%; height: 300px;">
			<table class="table table-hover tabela-dados">
				<thead>
					<tr>
						<th><center>Tipo</center></th>
						<th><center>Criado por</center></th>
						<th><center>Enviado para</center></th>
						<th><center>Data de criação</center></th>
						<th><center>Baixar</center></th>
						<th><center>Ação</center></th>
					</tr>	
				</thead>
				<tbody>
					<?php foreach($this->lista as $arquivo){ ?>
					
						<tr>
							<td>
								<center>
									<?php echo $arquivo['DS_TIPO'] ?>
								</center>
							</td>
							<td>
								<center>
									<?php echo $arquivo['NOME_SERVIDOR_CRIACAO'] ?>
								</center>
							</td>
							<td>
								<center>
									<?php echo $arquivo['NOME_SERVIDOR_DESTINO'] ?>
								</center>
							</td>
							<td>
								<center>
									<?php 
										echo date_format(new DateTime($arquivo['DT_CRIACAO']), 'd/m/Y');
									?>
								</center>
							</td>
							<td>
								<center>
									<a href='<?php echo "/_registros/anexos/". $arquivo['DS_ANEXO'] ?>' title='<?php echo $arquivo['DS_ANEXO'] ?>' download>
										<?php echo substr($arquivo['DS_ANEXO'], 0, 20) . "..." ?>
									</a>
								</center> 
							</td>
							<td>
								<?php 
									//so quem pode editar ou excluir é quem criou o arquivo e quando ele estiver ativo
									if($_SESSION['ID'] == $arquivo['ID_SERVIDOR_CRIACAO'] && $arquivo['DS_STATUS']=='ATIVO'){ ?> 
										<center> 
											<a href='/arquivos/alterar-status/<?php echo $arquivo['ID'] ?>/INATIVO'>
												Inativar
											</a> 
											
											ou 			
											
											<a href='/arquivos/excluir/<?php echo $arquivo['ID'] ?>/<?php echo $arquivo['DS_ANEXO'] ?>'>
												Excluir
											</a>
										</center>
							  <?php } ?>
							</td>									
						</tr>
			  <?php } ?>		
				</tbody>
			</table>
		</div>		
<?php 
	
	}
	
	public function cadastrar(){ ?>
	
		<form method='POST' action='/cadastrar/arquivo/' enctype='multipart/form-data'>	
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label" for="exampleInputEmail1">Selecione o tipo</label>
						
						<?php $this->carregarSelectTiposDocumento(); ?>
									
					</div>  
				</div>
				<div class="col-md-4">
					<label class="control-label" for="exampleInputEmail1">Escolha o servidor para enviar</label><br>
					
						<?php $this->carregarSelectServidores(); ?>

				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label" for="exampleInputEmail1">Escolher anexo</label><br>
						<input type="file" class="" name="arquivo_anexo" id="arquivo_anexo"/>
					</div>
				</div>	
			</div>
			<div class="row" id="cad-button">
				<div class="col-md-12">
					<button type="submit" class="btn btn-default" name="submit" value="Send" id="submit">Cadastrar e enviar</button>
				</div>
			</div>
		</form>	

<?php	
	}

}

?>