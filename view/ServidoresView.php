<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/BaseView.php';

class ServidoresView extends BaseView{
	
	private $listaSetores;
	
	public function setListaSetores($listaSetores){
		
		$this->listaSetores = $listaSetores;
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
									<?php echo $servidor['DS_ABREVIACAO']; ?>
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
	
		<form name="cadastro" method="POST" action="/servidores/cadastrar/" enctype="multipart/form-data"> 
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="exampleInputEmail1">Nome</label>
						<input class="form-control" id="nome" name="nome" placeholder="Digite o nome (somente letras)" 
						type="text" maxlength="255" minlength="4" pattern="[a*A*-z*Z*]*+" required/>
					</div> 
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="exampleInputEmail1">CPF</label>
						<input class="form-control" id="CPF" name="CPF" placeholder="Digite o CPF" type="text" required/>				  
					</div>				
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="exampleInputEmail1">Setor</label>
						<select class="form-control" id="setor" name="setor" required/>
							<option value="">Selecione</option>
							
							<?php foreach($this->listaSetores as $setor){ ?>
							
								<option value="<?php echo $setor['ID'] ?>">
								
								<?php echo $setor['DS_NOME']; ?>
								
								</option>
								
							<?php } ?>
						</select>
					</div> 
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="exampleInputEmail1">Função no sistema</label>
						<select class="form-control" id="funcao" name="funcao" required />
							
							<option value="">Selecione</option>
							
							<option value="PROTOCOLO">PROTOCOLO	</option>
							<option value="SUPERINTENDENTE">SUPERINTENDENTE</option>
							<option value="ASSESSOR TÉCNICO">ASSESSOR TÉCNICO</option>
							<option value="TÉCNICO ANALISTA">TÉCNICO ANALISTA</option>
							<option value="GABINETE">GABINETE</option>
							<option value="CONTROLADOR">CONTROLADOR</option>
							<option value="TI">TI</option>
							<option value="COMUNICAÇÃO">COMUNICAÇÃO</option>
							<option value="CHEFE DE GABINETE">CHEFE DE GABINETE</option>
						
						</select>
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

}

?>