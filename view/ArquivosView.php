<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/BaseView.php';

class ArquivosView extends BaseView{
	
	private $listaServidores;
	
	public function setListaServidores($listaServidores){
		
		$this->listaServidores = $listaServidores;
	}
	
	public function carregarLista(){ ?>
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
									<?php echo $arquivo['NM_TIPO'] ?>
								</center>
							</td>
							<td>
								<center>
									<?php echo $arquivo['CRIACAO'] ?>
								</center>
							</td>
							<td>
								<center>
									<?php echo $arquivo['ENVIADO'] ?>
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
									<a href='<?php echo "/_registros/anexos/". $arquivo['NM_ANEXO'] ?>' title='<?php echo $arquivo['NM_ANEXO'] ?>' download>
										<?php echo substr($arquivo['NM_ANEXO'], 0, 20) . "..." ?>
									</a>
								</center> 
							</td>
							<td>
								<?php 
									//so quem pode editar ou excluir é quem criou o arquivo
									if($_SESSION['ID'] == $arquivo['ID_SERVIDOR_CRIACAO']){ ?> 
										<center> 
											<a href=''>
												Inativar
											</a> 
											
											ou 			
											
											<a href=''>
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
	
	public function carregarCadastrar(){ ?>
	
		<form method='POST' action='cadastrar/arquivo/' enctype='multipart/form-data'>	
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label" for="exampleInputEmail1">Selecione o tipo</label>
						<select class="form-control" id="tipo" name="tipo" required/>
							<option value="">Selecione o tipo de arquivo</option>
							<option value="APRESENTAÇÃO">APRESENTAÇÃO</option>
							<option value="AQUISIÇÃO">AQUISIÇÃO</option>
							<option value="CERTIFICADO">CERTIFICADO</option>
							<option value="CHECKLIST">CHECKLIST</option>
							<option value="COTAÇÃO DE PREÇO">COTAÇÃO DE PREÇO</option>
							<option value="CERTIDÃO NEGATIVA">CERTIDÃO NEGATIVA</option>
							<option value="DESPACHO">DESPACHO</option>
							<option value="MEMORANDO">MEMORANDO</option>
							<option value="OFÍCIO">OFÍCIO</option>
							<option value="PARECER">PARECER</option>
							<option value="PUBLICAÇÃO NO DIÁRIO">PUBLICAÇÃO NO DIÁRIO</option>
							<option value="RELATÓRIO">RELATÓRIO</option>
							<option value="RESPOSTA AO INTERESSADO">RESPOSTA AO INTERESSADO</option>
							<option value="TERMO DE REFERÊNCIA">TERMO DE REFERÊNCIA</option>
						</select>	
					</div>  
				</div>
				<div class="col-md-4">
					<label class="control-label" for="exampleInputEmail1">Escolha o servidor para enviar</label><br>
					<select class="form-control" id="enviar" name="enviar" required />
						<option value="">Selecione o servidor para enviar</option>
						
						<?php foreach($this->listaServidores as $servidor){ ?>
							
								<option value="<?php echo $servidor['ID'] ?>">
									<?php echo $servidor['NM_SERVIDOR']; ?>
								</option>
							
					  <?php } ?>
					</select>
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