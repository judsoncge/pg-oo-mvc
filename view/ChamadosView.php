<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class ChamadosView extends View{
	
	private $tipoEdicao;
	
	public function setTipoEdicao($tipoEdicao){
		
		$this->tipoEdicao = $tipoEdicao;
		
	}
	
	public function listar(){ ?>
		
		<div class="col-md-12 table-responsive" style="overflow: auto; width: 100%; height: 300px;">
			<table class="table table-hover tabela-dados">
				<thead>
					<tr>
						<th>Abertura            </th>
						<th>Natureza do problema</th>
						<th>Solicitante         </th>
						<th>Status              </th>
						<th>Avaliação           </th>
						<th>Ação                </th>
					</tr>	
				</thead>
				<tbody>
					<?php 
						while($r = mysqli_fetch_object($lista)){
							if($_SESSION['funcao'] == 'TI' && $r->NM_STATUS == 'RESOLVIDO' && $r->NM_AVALIACAO != "SEM AVALIAÇÃO"){
								echo "<tr style='background-color:#f1c40f;'>";
							
							}elseif($_SESSION['funcao'] != 'TI' && $r->NM_STATUS == 'RESOLVIDO' && $r->NM_AVALIACAO == "SEM AVALIAÇÃO"){ 
								echo "<tr style='background-color:#f1c40f;'>";
				
							}else{ 
								echo "<tr>";
							
							} 

					?>
								<td><?php echo date_format(new DateTime($r->DT_ABERTURA), 'd/m/Y H:i:s') ?></td>
								<td><?php echo $r -> NM_NATUREZA ?></td>
								<td><?php echo retorna_nome_servidor($r -> ID_SERVIDOR_REQUISITANTE, $conexao_com_banco)?></td>
								<td><?php echo $r -> NM_STATUS ?></td>
								<td><?php echo $r -> NM_AVALIACAO ?></td>
								<td>
									<a href="detalhes.php?id=<?php echo $id ?>">
										<button type='button' class='btn btn-secondary btn-sm' title='Detalhes e operações'>
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
	
	public function cadastrar(){

		$this->carregarFormulario();	
	
	}
	
	public function editar(){
		
		switch($this->tipoEdicao){
			
			case 'info':
				$this->carregarFormulario();
				break;
			case 'senha':
				$this->carregarEdicaoSenha();
				break;
			case 'foto':
				$this->carregarEdicaoFoto();
				break;
			
			
		}
	
	}
	
	public function carregarFormulario(){ 
				
			$listaDados = ($this->conteudo == 'edicao') ? $_REQUEST['DADOS_SERVIDOR'] : NULL;
			
			$action = ($this->conteudo == 'edicao') 
				? "/editar/servidor/".$listaDados['ID']."/ATIVO"
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
	

	public function carregarEdicaoSenha(){
		
?>
		
	<form name="cadastro" method="POST" action="/editar/servidor/<?php echo $_SESSION['ID'] ?>/ATIVO" enctype="multipart/form-data"> 
		<div class="row">
			<div class="col-md-5">
				<div class="form-group">
					<label class="control-label" for="exampleInputEmail1">Nova senha</label>
					<input class="form-control" type='password' id='nova_senha' name='senha'/>
				</div>	
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<label class="control-label" for="exampleInputEmail1">Confirme a nova senha</label>
					<input class="form-control" type='password' id='confirmaSenha' name='confirmaSenha'/>
				</div>	
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<button type="submit" class="btn btn-sm btn-success" name="submit" value="Send" style="margin-top:32px;">
						Alterar senha
					</button>
				</div>	
			</div>
		</div>
	</form>


<?php 
	
	}
	
	public function carregarEdicaoFoto(){
		
?>	

	<form name="cadastro" method="POST" action="/editar/servidor/<?php echo $_SESSION['ID'] ?>/ATIVO" enctype="multipart/form-data"> 
		<div class="row">
			<div class="col-md-10">
				<div class="form-group">
					<label class="control-label" for="exampleInputEmail1">Selecione a nova foto</label>
					<input class="form-control" type='file' id='arquivoFoto' name='arquivoFoto' enctype="multipart/form-data"/>
				</div>	
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<button type="submit" class="btn btn-sm btn-success" name="submit" value="Send" style="margin-top:32px;">
						Alterar foto
					</button>
				</div>	
			</div>
		</div>
	</form>
		
<?php 

	}

}

?>