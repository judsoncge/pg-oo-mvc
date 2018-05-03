<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/BaseView.php';

class ServidoresView extends BaseView{
	
	private $listaServidores;
	
	public function setListaServidores($listaServidores){
		
		$this->listaServidores = $listaServidores;
	}
	
	public function carregarLista(){ ?>
		
		<div class="col-md-12 table-responsive" style="overflow: auto; width: 100%; height: 300px;">
			<table class="table table-hover tabela-dados">
				<thead>
					<tr>
						<th><center>CPF</center></th>
						<th><center>Nome</center></th>
						<th><center>Setor</center></th>
						<th><center>Função</center></th>
						<th><center>Ação</center></th>
					</tr>	
				</thead>
				<tbody>
					<?php foreach($this->lista as $servidor){ ?>
					
						<tr>
							<td>
								<center>
									<?php echo $servidor['DS_CPF']; ?>
								</center>
							</td>
							<td>
								<center>
									<?php echo $servidor['DS_NOME']; ?>
								</center>
							</td>
							<td>
								<center>
									<?php echo $servidor['CD_SETOR']; ?>
								</center>
							</td>
							<td>
								<center>
									<?php echo $servidor['DS_FUNCAO']; ?>
								</center>
							</td>										
							<td>
								<center>
									
									<a href="editar.php?id=<?php echo $servidor['ID'] ?>">
										<button type='button' class='btn btn-secondary btn-sm' title="Editar">
											<i class="fa fa-pencil" aria-hidden="true"></i>
										</button>
									</a>
								
									<a href="/controller/servidores/editar.php?operacao=status&status=INATIVO&id=<?php echo $servidor['ID'] ?>">		
										<button type='button' class='btn btn-secondary btn-sm' title="Inativar">
											<i class="fa fa-minus-square-o" aria-hidden="true"></i>
										</button>
									</a>
									
								</center>
							</td>
						</tr>
				<?php } ?>		
				</tbody>
			</table>
		</div>
<?php 
	
	}
	
	public function carregarCadastrar(){ ?>
	
		<form method='POST' action='/arquivos/cadastrar/' enctype='multipart/form-data'>	
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
									<?php echo $servidor['DS_NOME']; ?>
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