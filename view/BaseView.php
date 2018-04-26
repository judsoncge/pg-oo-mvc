<?php

//esta e a classe que contem o head, body e footer padrao do sistema. portanto e chamada de "view base" e todas as views herdam dela
class BaseView{
	
	public $titulo;
	public $tipo;
	public $lista;
	
	function __construct($titulo, $tipo, $lista){
		
		$this->setTitulo($titulo);
		$this->setTipo($tipo);
		$this->setLista($lista);

	}
	
	public function setTitulo($titulo){
		
		$this->titulo = $titulo; 
	
	}
	
	public function setTipo($tipo){
		
		$this->tipo = $tipo; 
	
	}
	
	
	public function setLista($lista){
		
		$this->lista = $lista; 
	
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
									<img src='/registros/fotos/<?php echo $_SESSION['FOTO'] ?>' id='imagem'>
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
								<a href='/arquivos/cadastrar/'><i class='fa fa-file-archive-o icone-menu' aria-hidden='true'></i>Cadastrar</a>
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
								<a href=''><i class='fa fa-user icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							
							<li class='servidores-subitem'>
								<a href=''><i class='fa fa-user icone-menu' aria-hidden='true'></i>Inativos</a>
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
			
			<?php $this->carregarConteudo(); ?>
			
		</body>
<?php	
	} 
	
	//esta funcao carrega o conteudo da pagina, pegando a lista das cinco comunicacoes mais atuais que vem do controller. como toda pagina que vai herdar dessa tera uma implementacao diferente, sobrescrevem
	public function carregarConteudo(){ ?>
		
		<div id="page-content-wrapper">
			<div class="container titulo-pagina">
				<p><?php echo $this->titulo ?></p>
			</div>
			<div class="container caixa-conteudo">
				<div class="row">
					<div class="col-lg-12">
						<div class="container">
							<?php 
							
							switch($this->tipo){
								
								case "listagem":
									$this->carregarLista($this->lista);
									break;
								case "cadastrar":
									$this->carregarCadastrar();
									break;
								case "editar":
									$this->carregarEditar();
									break;
								case "detalhes":
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
	
	public function carregarLista($lista){
	
	}
	
	public function carregarCadastrar(){
	
	}
	
	public function carregarEditar(){
	
	}
	
	public function carregarDetalhes(){
	
	}
	
	//esta funcao carrega o footer padrao do sistema
	public function carregarFooter(){ ?>

		<footer style='display: none;'>
		</footer>
		</html>
		
<?php }
	
}

?>