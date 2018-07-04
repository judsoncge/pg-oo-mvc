<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class ServidoresView extends View{
	
	//normalmente os módulos tem somente uma edição. o módulo de servidores possui, além da edição de informações, a edição de senha e de foto
	private $tipoEdicao;
	
	public function setTipoEdicao($tipoEdicao){
		
		$this->tipoEdicao = $tipoEdicao;
		
	}
	
	//esta função carrega o conteúdo da página de listagem, uma tabela com os registros de acordo com o status definido (ativo ou inativo)
	public function listar(){ ?>
		
		<div class='col-md-12 table-responsive' style='overflow: auto; width: 100%; height: 300px;'>
			<table class='table table-hover tabela-dados'>
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
						//a lista é solicitada ao servidores controller para que os registros sejam mostrados na interface
						$lista = $_REQUEST['LISTA_SERVIDORES'];
						
						foreach($lista as $servidor){ 
					
					?>
							<tr>
								<td><?php echo $servidor['DS_CPF']; ?></td>
								<td><?php echo $servidor['DS_NOME']; ?></td>
								<td><?php echo $servidor['DS_ABREVIACAO']; ?></td>
								<td><?php echo $servidor['DS_FUNCAO']; ?></td>										
								<!-- Botão editar -->	
								<td>
									<a href="/servidores/editar/<?php echo $servidor['ID'] ?>">
										<button type='button' class='btn btn-secondary btn-sm' title='Editar'>
											<i class='fa fa-pencil' aria-hidden='true'></i>
										</button>
									</a>
									
									<?php
										//caso a listagem seja de servidores ativos, o botão será de inativar. caso seja de inativo, o botão será de ativar servidor.
										if($servidor['DS_STATUS'] == 'ATIVO'){
											$getStatus = 'INATIVO';
											$title = 'Inativar';
										}else{
											$getStatus = 'ATIVO';
											$title = 'Ativar';
										}
									
									?>
									<!-- Botão ativar/inativar -->	
									<a href='/editar/servidor/status/<?php echo $servidor['ID'] ?>/<?php echo $getStatus ?>'>
										<button type='button' class='btn btn-secondary btn-sm' title='<?php echo $title ?>'>
											<i class='fa fa-minus-square-o' aria-hidden='true'></i>
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
	
	//tanto cadastrar quanto editar informações utilizam o mesmo formulário. para que o mesmo formulario nao seja implementado duas vezes, a função cadastrar chama o método carregarFormulario que lá verifica se o conteudo da pagina é de cadastro ou edição.
	public function cadastrar(){

		$this->carregarFormulario();	
	
	}
	
	//esta funcao primeiro verifica que tipo de edição foi solicitada. caso seja de informações, carrega também, assim como cadastrar, a função carrega o mesmo formulário. caso seja senha ou foto, carrega suas respectivas funções. 
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
	
	//função que carrega o formulario para cadastro/edição de servidor
	public function carregarFormulario(){ 
	
		//pegando a lista de setores com o controller para o carregamento do select de setores
		$listaSetores = $_REQUEST['LISTA_SETORES'];
		
		//verificando o tipo de conteúdo da página. se for edição, solicita a lista de dados do servidor ao servidor controller. caso nao seja edição, é porque é de edição. assim, o array de dados não existirá. o action do formulario também muda de acordo o tipo de edição e o nome do botão de submit do formulário também.
		if($this->conteudo == 'edicao'){
			
			$listaDados = $_REQUEST['DADOS_SERVIDOR'];
			$action = "/editar/servidor/info/".$listaDados['ID']."/";
			$idSetor = $listaDados['ID_SETOR'];
			$nomeSetor = $listaDados['NOME_SETOR'];
			$valueFuncao = $listaDados['DS_FUNCAO'];
			$nomeFuncao = $listaDados['DS_FUNCAO'];
			$nomeBotao = 'Editar';
			
		}else{
			
			$action = '/cadastrar/servidor/';
			$idSetor = '';
			$nomeSetor = 'Selecione';
			$valueFuncao = '';
			$nomeFuncao = 'Selecione';
			$nomeBotao = 'Cadastrar';
		
		}

?>		
		<!-- formulario. no value de cada campo é verificado se o tipo de conteúdo da página é de edição. se sim, carrega o valor do campo do servidor correspondente, que está na lista de dados solicitada acima. caso não, não imprime nada (pois é de cadastro). -->
		<form name='cadastro' method='POST' action='<?php echo $action; ?>' enctype='multipart/form-data'> 
			<div class='row'>
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Nome</label>
						<input class='form-control' id='nome' name='nome' placeholder='Digite o nome (somente letras)' type='text' maxlength='255' minlength='4' pattern='[a*A*-z*Z*]*+' value='<?php if($this->conteudo == 'edicao'){echo $listaDados['DS_NOME'];} ?>' required />
					</div> 
				</div>
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>CPF</label>
						<input class='form-control' id='CPF' name='CPF' placeholder='Digite o CPF' type='text' value='<?php if($this->conteudo == 'edicao'){echo $listaDados['DS_CPF'];} ?>' required />				  
					</div>				
				</div>
			</div>
			<div class='row'> 
				<!-- select de setor que utiliza as variáveis que imprimem o nome do setor do servidor correspondente, caso o conteúdo seja de edição, como primeiro da lista de select e o seu id correspondente. caso o conteúdo seja de cadastro, o value do primeiro option não tem nada e o nome do setor se torna Selecione -->
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Setor</label>
						<select class='form-control' id='setor' name='setor' required />
							<option value='<?php echo $idSetor ?>'><?php echo $nomeSetor ?></option>
							<?php foreach($listaSetores as $setor){ ?>
								<option value='<?php echo $setor['ID'] ?>'><?php echo $setor['DS_NOME']; ?></option>
							<?php } ?>
						</select>
					</div> 
				</div>
				<!-- select de função que utiliza as variáveis que imprimem o nome da função do servidor correspondente, caso o conteúdo seja de edição, como primeiro da lista de select. caso o conteúdo seja de cadastro, o value do primeiro option não tem nada e o nome da função se torna Selecione -->
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Função no sistema</label>
						<select class='form-control' id='funcao' name='funcao' required />
							<option value='<?php echo $valueFuncao ?>'><?php echo $nomeFuncao ?></option>
							<option value='PROTOCOLO'>PROTOCOLO	</option>
							<option value='SUPERINTENDENTE'>SUPERINTENDENTE</option>
							<option value='ASSESSOR TÉCNICO'>ASSESSOR TÉCNICO</option>
							<option value='TÉCNICO ANALISTA'>TÉCNICO ANALISTA</option>
							<option value='GABINETE'>GABINETE</option>
							<option value='CONTROLADOR'>CONTROLADOR</option>
							<option value='TI'>TI</option>
							<option value='COMUNICAÇÃO'>COMUNICAÇÃO</option>
							<option value='CHEFE DE GABINETE'>CHEFE DE GABINETE</option>
						</select>
					</div> 
				</div>
			</div>
			<!-- botao submit do formulario com a variavel que mostra editar ou cadastrar dependendo do conteúdo da página -->
			<div class='row' id='cad-button'>
				<div class='col-md-12'>
					<button type='submit' class='btn btn-default' name='submit' value='Send' id='submit'><?php echo $nomeBotao; ?></button>
				</div>
			</div>
		</form>
		
<?php		
		
	}
	
	//esta função carrega o formulário de edição de senha, caso o tipo de edição seja senha
	public function carregarEdicaoSenha(){
		
?>
		
	<form name='cadastro' method='POST' action="/editar/servidor/senha/<?php echo $_SESSION['ID'] ?>/" enctype='multipart/form-data'> 
		<div class='row'>
			<div class='col-md-5'>
				<div class='form-group'>
					<label class='control-label' for='exampleInputEmail1'>Nova senha</label>
					<input class='form-control' type='password' id='nova_senha' name='senha'/>
				</div>	
			</div>
			<div class='col-md-5'>
				<div class='form-group'>
					<label class='control-label' for='exampleInputEmail1'>Confirme a nova senha</label>
					<input class='form-control' type='password' id='confirmaSenha' name='confirmaSenha'/>
				</div>	
			</div>
			<div class='col-md-2'>
				<div class='form-group'>
					<button type='submit' class='btn btn-sm btn-success' name='submit' value='Send' style='margin-top:32px;'>
						Alterar senha
					</button>
				</div>	
			</div>
		</div>
	</form>


<?php 
	
	}
	
	//esta função carrega o formulário de edição de foto, caso o tipo de edição seja foto
	public function carregarEdicaoFoto(){
		
?>	

	<form name='cadastro' method='POST' action="/editar/servidor/foto/<?php echo $_SESSION['ID'] ?>/" enctype='multipart/form-data'> 
		<div class='row'>
			<div class='col-md-10'>
				<div class='form-group'>
					<label class='control-label' for='exampleInputEmail1'>Selecione a nova foto</label>
					<input class='form-control' type='file' id='arquivoFoto' name='arquivoFoto' enctype='multipart/form-data'/>
				</div>	
			</div>
			<div class='col-md-2'>
				<div class='form-group'>
					<button type='submit' class='btn btn-sm btn-success' name='submit' value='Send' style='margin-top:32px;'>
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