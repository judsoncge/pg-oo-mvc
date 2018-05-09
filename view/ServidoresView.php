<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class ServidoresView extends View{
	
	public function listar(){ ?>
		
		<div class="col-md-12 table-responsive" style="overflow: auto; width: 100%; height: 300px;">
			<table class="table table-hover tabela-dados">
				<thead>
					<tr>
						<th>CPF</th>
						<th>Nome</th>
						<th>Setor</th>
						<th>Função</th>
						<th>Ação</th>
					</tr>	
				</thead>
				<tbody>
					<?php 
					
						$lista = $_REQUEST['LISTA_SERVIDORES'];
						
						foreach($lista as $servidor){ 
					
					?>
							<tr>
								<td><?php echo $servidor['DS_CPF']; ?></td>
								<td><?php echo $servidor['DS_NOME']; ?></td>
								<td><?php echo $servidor['DS_ABREVIACAO']; ?></td>
								<td><?php echo $servidor['DS_FUNCAO']; ?></td>										
								<td>
									<a href="/servidores/editar/<?php echo $servidor['ID'] ?>">
										<button type='button' class='btn btn-secondary btn-sm' title="Editar">
											<i class="fa fa-pencil" aria-hidden="true"></i>
										</button>
									</a>
								
									<a href="/controller/servidores/editar.php?operacao=status&status=INATIVO&id=<?php echo $servidor['ID'] ?>">		
										<button type='button' class='btn btn-secondary btn-sm' title="Inativar">
											<i class="fa fa-minus-square-o" aria-hidden="true"></i>
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
	
	public function cadastrar(){

		$this->carregarFormulario();	
	
	}
	
	public function editar(){
		
		$this->carregarFormulario();
	
	}
	
	public function carregarFormulario(){ 
				
			$listaDados = ($this->conteudo == 'edicao') ? $_REQUEST['DADOS_SERVIDOR'] : NULL;
			
			$action = ($this->conteudo == 'edicao') 
				? "/editar/servidor/".$listaDados['ID']."/". $listaDados['DS_CPF']."/"
				: '/cadastrar/servidor/';
				
			$nomeBotao = ($this->conteudo == 'edicao') ? 'Editar' : 'Cadastrar';

?>
		
		<form name="cadastro" method="POST" action="<?php echo $action; ?>" enctype="multipart/form-data"> 
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="exampleInputEmail1">Nome</label>
						<input class="form-control" id="nome" name="nome" placeholder="Digite o nome (somente letras)" type="text" maxlength="255" minlength="4" pattern="[a*A*-z*Z*]*+" value="<?php if(isset($listaDados)){echo $listaDados['DS_NOME'];} ?>" required />
					</div> 
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label" for="exampleInputEmail1">CPF</label>
						<input class="form-control" id="CPF" name="CPF" placeholder="Digite o CPF" type="text" value="<?php if(isset($listaDados)){echo $listaDados['DS_CPF'];} ?>" required />				  
					</div>				
				</div>
			</div>
			<div class="row"> 
				
				<?php $this->carregarSelectSetores(); ?>
				
				<?php $this->carregarSelectFuncoes(); ?>
				
			</div>
			<div class="row" id="cad-button">
				<div class="col-md-12">
					<button type="submit" class="btn btn-default" name="submit" value="Send" id="submit"><?php echo $nomeBotao; ?></button>
				</div>
			</div>
		</form>
		
<?php		
		
	}

}

?>