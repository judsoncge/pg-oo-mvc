<?php

//esta e a classe que contem o head, body e footer padrao do sistema. portanto e chamada de "view base" e todas as views herdam dela
class View{
	
	protected $titulo;
	protected $tipo;
	protected $lista;
	protected $mensagem;
	protected $resultadoOperacao;
	protected $listaSetores;
	protected $listaServidores;
	
	public function setTitulo($titulo){
		
		$this->titulo = $titulo; 
	
	}
	
	public function setTipo($tipo){
		
		$this->tipo = $tipo; 
	
	}
	
	
	public function setLista($lista){
		
		$this->lista = $lista; 
	
	}
	
	public function setMensagem($mensagem){
		
		$this->mensagem = $mensagem; 
		
	}
	
	public function setResultadoOperacao($resultadoOperacao){
		
		$this->resultadoOperacao = $resultadoOperacao; 
		
	}
	
	public function setListaSetores($listaSetores){
		
		$this->listaSetores = $listaSetores;

	}
	
	public function setListaServidores($listaServidores){
		
		$this->listaServidores = $listaServidores;

	}
	
	//esta funcao carrega a pagina de home, pegando o head, body e footer da classe mae e carrega o seu conteudo
	public function carregar(){
		
		$this->carregarHead();
		$this->carregarBody();
		$this->carregarFooter();
	
	}
	
	//esta funcao carrega o head padrao do sistema
	public function carregarHead(){ ?>
	
		<html>
		<head>
			<meta charset='utf-8'>
			<meta name='interfaceport' content='width=device-width, initial-scale=1'>
			<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
			<meta http-equiv='Content-Language' content='pt-br'>
			<meta name='keywords' content='cge, controladoria geral do estado, estado de alagoas, alagoas'>
			<meta name='description' content='cge, controladoria geral do estado de alagoas'>
			<link rel='shortcut icon' href='/view/libs/img/shortcut.ico'>
			<meta name='interfaceport' content='width=device-width, initial-scale=1.0'>
			<meta name='author' content='Judson Bandeira'>
			<meta name='author' content='Denys Rocha'>
			<meta name='author' content='Romero Malaquias'>
			<meta name='author' content='Vilker Tenório'>

			<title>Painel de Gestão - CGE</title>
			
			<?php $this->adicionarScripts(); ?>
			
			<link rel='stylesheet' type='text/css' href='/view/libs/css/font-awesome.min.css' >
			<link rel='stylesheet' type='text/css' href='/view/libs/css/bootstrap.css'>
			<link rel='stylesheet' type='text/css' href='/view/libs/css/simple-sidebar.css'>
			<link rel='stylesheet' type='text/css' href='/view/libs/css/estilo.css'>
		</head>	
<?php 
	}

	public function adicionarScripts(){ ?>
		
			<script src='/view/libs/js/jquery.js'></script>
			<script src="/view/libs/js/tether.js"></script>
			<script type='text/javascript' src='/view/libs/js/bootstrap.js'></script>
			<script type='text/javascript' src='/view/libs/js/submenu.js'></script>	
			<script type="text/javascript" src="/view/libs/js/jquery.quicksearch.js"></script>
			<script type="text/javascript" src="/view/libs/js/temporizadores.js"></script>
			<script type='text/javascript' src='/view/libs/js/jquery.maskedinput.js'></script>
			<script type='text/javascript' src='/view/libs/js/util.js'></script>
		
<?php
	}
	
	//esta funcao carrega o body padrao do sistema
	public function carregarBody(){ ?>
		
		<body>  
			<!-- menu superior da página -->
			<div class='menu-superior'>
				<div>
					<a href='#menu-toggle' class='btn btn-default' id='menu-toggle'><i class='fa fa-bars' aria-hidden='true'></i></a>
					<img src='/view/libs/img/gestao-cge.png' id='logo-home'>
				</div>
				<div>
					<!-- carregamento da página -->
					<div class='loader' id='preloader'></div>
				</div>
				<div class='container-icone'>
					<div>
						<!-- botão para fazer logoff -->
						<a href='logoff' alt='Logoff'><i class='fa fa-sign-out fa-lg' aria-hidden='true' id='sair-icone'></i></a>
					</div>	
				</div>	
			</div> 

			<!-- menu lateral -->
			<div id='wrapper'>
				<!-- Sidebar -->
				<div id='sidebar-wrapper'>
					<ul class='sidebar-nav'>
						<li class='sidebar-brand'>
							<div id='usuario'>
								<!-- foto do usuário -->
								<div id='box-imagem'>
									<img src='/_registros/fotos/<?php echo $_SESSION['FOTO'] ?>' id='imagem'>
								</div>

								<div id='mensagem'>
									<!-- opcao para editar a senha -->
									<center>
										<a href='' id='alterar-senha'>
											<i class='fa fa-edit' aria-hidden='true'></i>  
											Alterar senha
										</a>
									
									<!-- opcao para editar a foto -->
									<a href='' id='alterar-foto'><i class='fa fa-edit' aria-hidden='true'></i>  Alterar foto</a></center>
								</div>
							</div>
						</li>
						
						<hr>
						
						<!-- aqui inicia a lista de opcoes da barra lateral -->
						
						<!-- opcao home -->
						<li>
							<a href='/home'><i class='fa fa-home icone-menu' aria-hidden='true'></i>Início</a>
						</li>
						
						<!-- opcao arquivos -->
						<li id='arquivos'>
							<a href='#'><i class='fa fa-file-archive-o icone-menu' aria-hidden='true'></i>Arquivos</a>
						</li>	
							
							<!-- sublista -->
							<li class='arquivos-subitem'>
								<a href='/arquivos/cadastro/'><i class='fa fa-file-archive-o icone-menu' aria-hidden='true'></i>Cadastrar</a>
							</li>
							
							<li class='arquivos-subitem'>
								<a href='/arquivos/ativos/'><i class='fa fa-file-archive-o icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							
							<li class='arquivos-subitem'>
								<a href='/arquivos/inativos/'><i class='fa fa-file-archive-o icone-menu' aria-hidden='true'></i>Inativos</a>
							</li>
						
						<!-- opcao chamados -->
						<li id='chamados'>
							<a href='#'><i class='fa fa-headphones icone-menu' aria-hidden='true'></i>Chamados</a>
						</li>
							
							<!-- sublista -->
							<li class='chamados-subitem'>
								<a href=''><i class='fa fa-headphones icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							
							<li class='chamados-subitem'>
								<a href='' ><i class='fa fa-headphones icone-menu' aria-hidden='true'></i>Inativos</a>
							</li>
							
							
						<!-- opcao comunicacao -->
						<li id='comunicacao'>
							<a href='#'><i class='fa fa-volume-up icone-menu' aria-hidden='true'></i>Comunicação</a>
						</li>
						
							<!-- sublista -->
							<li class='comunicacao-subitem'>
								<a href=''><i class='fa fa-volume-up icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							<li class='comunicacao-subitem'>
								<a href='' ><i class='fa fa-volume-up icone-menu' aria-hidden='true'></i>Inativos</a>
							</li>

						<!-- opcao processos -->
						<li id='processos'>
							<a href='#'><i class='fa fa-exchange icone-menu' aria-hidden='true'></i>Processos</a>
						</li>
						
							<!-- sublista -->
							<li class='processos-subitem'>
								<a href=''><i class='fa fa-exchange icone-menu' aria-hidden='true'></i>Cadastrar</a>
							</li>
						
							<li class='processos-subitem'>
								<a href=''><i class='fa fa-exchange icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							
							
							<li class='processos-subitem'>
								<a href='' ><i class='fa fa-exchange icone-menu' aria-hidden='true'></i>Consultar</a>
							</li>
							
							<li class='processos-subitem'>
								<a href='' ><i class='fa fa-exchange icone-menu' aria-hidden='true'></i>Relatório</a>
							</li>
					
						<!-- opcao servidores -->
						<li id='servidores'>
							<a href='#'><i class='fa fa-user icone-menu' aria-hidden='true'></i>Servidores</a>
						</li>	
						
							<!-- sublista -->
							<li class='servidores-subitem'>
								<a href='/servidores/cadastro/'><i class='fa fa-user icone-menu' aria-hidden='true'></i>Cadastrar</a>
							</li>
							
							<li class='servidores-subitem'>
								<a href='/servidores/ativos/'><i class='fa fa-user icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							
							<li class='servidores-subitem'>
								<a href='/servidores/inativos/'><i class='fa fa-user icone-menu' aria-hidden='true'></i>Inativos</a>
							</li>
						<!-- opcao sobre -->
						<li>
							<a href=''><i class='fa fa-info-circle icone-menu' aria-hidden='true'></i>Sobre</a>
						</li>
					</ul>
				</div>
		
			<!-- script que esconde/aparece o menu lateral -->
			<script type='text/javascript'>
				/*fazer menu aparecer e desaparecer*/
				$('#menu-toggle').click(function(e) {
					e.preventDefault();
					$('#wrapper').toggleClass('toggled');
				});
			</script>
			<?php
			
			$this->carregarConteudo(); 
			
			?>
			
		</body>
<?php	
	} 
	
	//esta funcao carrega o conteudo da pagina, pegando a lista das cinco comunicacoes mais atuais que vem do controller. como toda pagina que vai herdar dessa tera uma implementacao diferente, sobrescrevem
	public function carregarConteudo(){ ?>
		<div id="page-content-wrapper">
			<div class="container titulo-pagina">
				<p><?php echo $this->titulo ?></p>
			</div>
			
			<?php $this->carregarMensagem(); ?>
			
			<div class="container caixa-conteudo">
				<div class="row">
					<div class="col-lg-12">
						<div class="container">
							<?php 
							
							switch($this->tipo){
								
								case 'listagem':
								    $this->carregarFiltro();
									$this->carregarLista();
									$this->carregarScriptFiltro();
									break;
								case 'cadastrar':
									$this->carregarFormulario();
									break;
								case 'editar':
									$this->carregarFormulario();
									break;
								case 'detalhes':
									$this->carregarDetalhes();
									break;
							}
							
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	
	public function carregarMensagem(){
		
		if(isset($_GET['resultadoOperacao'])){
			
			if($_GET['resultadoOperacao']){
				echo '<div class="alert alert-success" role="alert" id="mensagem_sucesso">Operação realizada com sucesso!</div>';
			}else{
				echo '<div class="alert alert-danger" role="alert" id="mensagem_erro">Houve alguma falha durante o processo. Por favor, tente novamente ou contate o suporte.</div>';
			}
		
		}

	}
	
	public function carregarFiltro(){ ?>
	
		<div class="well">	
			<div class="row">
				<div class="col-sm-12">
					<div class="input-group margin-bottom-sm">
						<span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span> <input type="text" class="input-search form-control" alt="tabela-dados" placeholder="Busque por qualquer termo da tabela" id="search" autofocus="autofocus" />
					</div>
				</div>
			</div>
		</div>
<?php		
	}
	
	public function carregarScriptFiltro(){ ?>
	
		<script>
		  if ($('input#search').length){
				$('input#search').quicksearch('table tbody tr');
		  }  
		</script>
<?php		
	}
	
	public function carregarLista(){
	
	}
	
	public function carregarFormulario(){
	
	}
	
	public function carregarDetalhes(){
	
	}
	
	public function carregarSelectServidores(){
		
	}
	
	public function carregarSelectSetores($id, $nome){ ?>
	
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label" for="exampleInputEmail1">Setor</label>
				<select class="form-control" id="setor" name="setor" required/>
					<option value="<?php echo $id ?>"><?php if($nome!=''){echo $nome;}else{echo 'Selecione';} ?></option>
					
					<?php foreach($this->listaSetores as $setor){ ?>
					
						<option value="<?php echo $setor['ID'] ?>">
						
						<?php echo $setor['DS_NOME']; ?>
						
						</option>
						
					<?php } ?>
				</select>
			</div> 
		</div>
	
		
<?php 
	}
	
	//esta funcao carrega o footer padrao do sistema
	public function carregarFooter(){ ?>

		<footer style='display: none;'>
		</footer>
		</html>
		
<?php }
	
}

?>