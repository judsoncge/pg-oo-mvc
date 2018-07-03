<?php

//esta e a classe que contem o head, body e footer padrao do sistema. portanto e chamada de view e todas as views herdam dela
class View{
	
	//toda página terá um título e um conteúdo a ser mostrado
	protected $titulo;
	protected $conteudo;	
	
	public function setTitulo($titulo){
		
		$this->titulo = $titulo; 
	
	}
	
	public function setConteudo($conteudo){
		
		$this->conteudo = $conteudo; 
	
	}
	
	//toda página html tem seu head, body e footer. Desta forma, toda vez que uma view for carregada, seu head, body e footer serão carregados
	public function carregar(){
		
		$this->carregarHead();
		$this->carregarBody();
		$this->carregarFooter();
	
	}
	
	//este é o head padrão do sistema, todas as páginas terão este head
	public function carregarHead(){ ?>
	
		<html>
		<head>
			<meta charset='utf-8'>
			<meta name='interfaceport' content='width=device-width, initial-scale=1'>
			<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
			<meta http-equiv='Content-Language' content='pt-br'>
			<meta name='keywords' content='cge, controladoria geral do estado, estado de alagoas, alagoas'>
			<meta name='description' content='cge, controladoria geral do estado de alagoas'>
			<link rel='shortcut icon' href='/view/_libs/img/shortcut.ico'>
			<meta name='interfaceport' content='width=device-width, initial-scale=1.0'>
			<meta name='author' content='Judson Bandeira'>
			<meta name='author' content='Denys Rocha'>
			<meta name='author' content='Romero Malaquias'>
			<meta name='author' content='Vilker Tenório'>

			<title>Painel de Gestão - CGE</title>
			
			<script src='/view/_libs/js/jquery.js'></script>
			<script src='/view/_libs/js/utils.js'></script>
			<script src='/view/_libs/js/tether.js'></script>
			<script type='text/javascript' src='/view/_libs/js/bootstrap.js'></script>
			<script type='text/javascript' src='/view/_libs/js/submenu.js'></script>	
			<script type='text/javascript' src='/view/_libs/js/jquery.quicksearch.js'></script>
			<script type='text/javascript' src='/view/_libs/js/temporizadores.js'></script>
			<script type='text/javascript' src='/view/_libs/js/jquery.maskedinput.js'></script>
			<script type='text/javascript' src='/view/_libs/js/util.js'></script>
			<link rel='stylesheet' type='text/css' href='/view/_libs/css/font-awesome.min.css' >
			<link rel='stylesheet' type='text/css' href='/view/_libs/css/bootstrap.css'>
			<link rel='stylesheet' type='text/css' href='/view/_libs/css/simple-sidebar.css'>
			<link rel='stylesheet' type='text/css' href='/view/_libs/css/estilo.css'>
			
			<?php 
				//algumas páginas precisam ter scripts adicionais. assim, em seu carregamento, elas chamam essa função passando seus scripts e eles serão adicionados ao head
				$this->adicionarScripts(); 
			?>
		
		</head>	
<?php 
	}
	
	//o head padrão já carrega seus scripts padrão. As páginas que herdarão dela, caso necessitem ter algum script padrão, serão adicionados dentro desta função, sobrescrevendo-a
	public function adicionarScripts(){ 
		
	}
	
	//este é o body padrão do sistema, todas as páginas terão este body
	public function carregarBody(){ ?>
		
		<body>
			
			<!-- Menu em azul da parte de cima da página -->
			<div class='menu-superior'>
				
				<!-- Imagem gestão CGE -->
				<div>
					<a href='#menu-toggle' class='btn btn-default' id='menu-toggle'><i class='fa fa-bars' aria-hidden='true'></i></a>
					<img src='/view/_libs/img/gestao-cge.png' id='logo-home'>
				</div>
				
				<!-- gif que fica girando enquanto a página não carrega completamente -->
				<div>
					<div class='loader' id='preloader'></div>
				</div>
				
				<!-- botão de logoff -->
				<div class='container-icone'>
					<div>
						<a href='logoff' alt='Logoff'><i class='fa fa-sign-out fa-lg' aria-hidden='true' id='sair-icone'></i></a>
					</div>	
				</div>	
			</div>
			
			<!-- Menu que fica ao lado -->
			<div id='wrapper'>
				<div id='sidebar-wrapper'>
					<ul class='sidebar-nav'>
						<li class='sidebar-brand'>
							<div id='usuario'>
								
								<!-- Foto do usuário -->
								<div id='box-imagem'>
									<img src='/_registros/fotos/<?php echo $_SESSION['FOTO'] ?>' id='imagem'>
								</div>
								
								<!-- Opções de alterar senha e foto -->
								<div id='mensagem'>
									<center>
										<a href='/servidores/senha/' id='alterar-senha'>
											<i class='fa fa-edit' aria-hidden='true'></i>  
											Alterar senha
										</a>
										<a href='/servidores/foto/' id='alterar-foto'>
											<i class='fa fa-edit' aria-hidden='true'></i> 
											Alterar foto
										</a>
									</center>
								</div>
							</div>
						</li>
						<hr>
						<!-- Botão início, que redireciona para a página home -->
						<li>
							<a href='/home'><i class='fa fa-home icone-menu' aria-hidden='true'></i>Início</a>
						</li>
						
						<!-- Menu arquivos -->
						<li id='arquivos'>
							<a href='#'><i class='fa fa-file-archive-o icone-menu' aria-hidden='true'></i>Arquivos</a>
						</li>	
							<!-- Botão cadastrar -->
							<li class='arquivos-subitem'>
								<a href='/arquivos/cadastrar/'><i class='fa fa-file-archive-o icone-menu' aria-hidden='true'></i>Cadastrar</a>
							</li>
							<!-- Botão para listar os arquivos ativos -->
							<li class='arquivos-subitem'>
								<a href='/arquivos/ativos/'><i class='fa fa-file-archive-o icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							<!-- Botão para listar os arquivos inativos -->
							<li class='arquivos-subitem'>
								<a href='/arquivos/inativos/'><i class='fa fa-file-archive-o icone-menu' aria-hidden='true'></i>Inativos</a>
							</li>
						<!-- Menu chamados -->
						<li id='chamados'>
							<a href='#'><i class='fa fa-headphones icone-menu' aria-hidden='true'></i>Chamados</a>
						</li>
							<!-- Botão cadastrar -->
							<li class='chamados-subitem'>
								<a href='/chamados/cadastrar/'><i class='fa fa-headphones icone-menu' aria-hidden='true'></i>Abrir Chamado</a>
							</li>
							<!-- Botão para listar os chamados ativos -->
							<li class='chamados-subitem'>
								<a href='/chamados/ativos/'><i class='fa fa-headphones icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							<!-- Botão para listar os chamados inativos -->
							<li class='chamados-subitem'>
								<a href='/chamados/inativos/' ><i class='fa fa-headphones icone-menu' aria-hidden='true'></i>Inativos</a>
							</li>
							
						<!-- Menu Comunicação -->
						<li id='comunicacao'>
							<a href='#'><i class='fa fa-volume-up icone-menu' aria-hidden='true'></i>Comunicação</a>
						</li>
							<!-- Botão cadastrar -->
							<li class='comunicacao-subitem'>
								<a href='/comunicacao/cadastrar/'><i class='fa fa-volume-up icone-menu' aria-hidden='true'></i>Cadastrar</a>
							</li>
							<!-- Botão para listar as notícias ativas -->
							<li class='comunicacao-subitem'>
								<a href='/comunicacao/ativos/'><i class='fa fa-volume-up icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							<!-- Botão para listar as notícias inativas -->
							<li class='comunicacao-subitem'>
								<a href='/comunicacao/inativos/' ><i class='fa fa-volume-up icone-menu' aria-hidden='true'></i>Inativos</a>
							</li>
						<!-- Menu Processos -->
						<li id='processos'>
							<a href='#'><i class='fa fa-exchange icone-menu' aria-hidden='true'></i>Processos</a>
						</li>
							<!-- Botão cadastrar -->
							<li class='processos-subitem'>
								<a href='/processos/cadastrar/'><i class='fa fa-exchange icone-menu' aria-hidden='true'></i>Cadastrar</a>
							</li>
							<!-- Botão para listar os processos ativos -->
							<li class='processos-subitem'>
								<a href='/processos/ativos/0'><i class='fa fa-exchange icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							<!-- Botão para ir a página de consultar processos -->
							<li class='processos-subitem'>
								<a href='/processos/consulta' ><i class='fa fa-exchange icone-menu' aria-hidden='true'></i>Consultar</a>
							</li>
							<!-- Botão para ir a página de relatório de processos -->
							<li class='processos-subitem'>
								<a href='/processos/relatorio/' ><i class='fa fa-exchange icone-menu' aria-hidden='true'></i>Relatório</a>
							</li>
						<!-- Menu servidores -->
						<li id='servidores'>
							<a href='#'><i class='fa fa-user icone-menu' aria-hidden='true'></i>Servidores</a>
						</li>	
							<!-- Botão cadastrar -->
							<li class='servidores-subitem'>
								<a href='/servidores/cadastrar/'><i class='fa fa-user icone-menu' aria-hidden='true'></i>Cadastrar</a>
							</li>
							<!-- Botão para listar os servidores ativos -->
							<li class='servidores-subitem'>
								<a href='/servidores/ativos/'><i class='fa fa-user icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							<!-- Botão para listar os servidores inativos -->
							<li class='servidores-subitem'>
								<a href='/servidores/inativos/'><i class='fa fa-user icone-menu' aria-hidden='true'></i>Inativos</a>
							</li>
						<!-- Página sobre -->
						<li>
							<a href=''><i class='fa fa-info-circle icone-menu' aria-hidden='true'></i>Sobre</a>
						</li>
					</ul>
				</div>
				
			<!-- Script que faz o menu aparecer e desaparecer (os três tracinhos no menu superior) -->
			<script type='text/javascript'>
				$('#menu-toggle').click(function(e) {
					e.preventDefault();
					$('#wrapper').toggleClass('toggled');
				});
			</script>
			
			<div id='page-content-wrapper'>
				<div class='container titulo-pagina'>
					<!-- Mostra o título da página -->
					<p><?php echo $this->titulo ?></p>
				</div>
				
				<?php 
				
				//aqui é carregada uma mensagem que o sistema manda após ser executada alguma ação (ex: processo cadastrado com sucesso!)
				$this->carregarMensagem(); 
				
				?>

				<div class='container caixa-conteudo'>
					<div class='row'>
						<div class='col-lg-12'>
							<div class='container'>
							<!-- até este ponto, foi carregado o body que é comum a todas as páginas. a partir daqui (exceto o fechamendo do body no final), vem o conteúdo da página, que muda de acordo com o que foi solicitado -->
							
							
								<?php 
								
								//dentro do body vem o conteúdo da página. O controller define que tipo de conteúdo a página terá
								switch($this->conteudo){
									
									//caso seja home, chama a função listar
									case 'home':
									
										$this->listar();
										break;
										
									//caso seja lista, o módulo em questão chamará seu método listar, que é uma página com uma tabela com seus registros. cada módulo tem a sua implementação de listar
									case 'lista':
										
										//chama também um filtro que busca por qualquer termo da tabela
										$this->carregarFiltro();
										$this->listar();
										$this->carregarScriptFiltro();
										break;
										
									//caso seja cadastro, o módulo em questão chamará seu método cadastrar, que é um formulário de cadastro. cada módulo tem a sua implementação de cadastrar
									case 'cadastro':
									
										$this->cadastrar();
										break;
									
									//caso seja edicao, o módulo em questão chamará seu método editar, que é um formulário de edição de um registro. cada módulo tem a sua implementação de editar
									case 'edicao':
									
										$this->editar();
										break;
									
									//caso seja visualizar, o módulo em questão chamará seu método visualizar, que é uma página mostrando os detalhes daquele registro e alguns botões de ação. cada módulo tem a sua implementação de visualizar
									case 'visualizar':
									
										$this->visualizar();
										break;
									
									//caso seja consulta, o módulo em questão chamará o método consulta, que é uma págona com um formulário para que sejam digitados os termos de busca. 							
									case 'consulta':
									
										$this->consulta();
										break;
									
									//caso seja consultar, o módulo em questão chamará o método consultar, que mostra os resultados dos dados de consulta que o usuário fez na página do método consulta()
									case 'consultar':
									
										$this->consultar();
										break;
									
									//caso seja relatório, o módulo em questão o método carregarRelatorio, que mostra a página de relatório									
									case 'relatorio':
									
										$this->carregarRelatorio();
										break;
								}
								
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</body>
<?php	
	} 
	
	//esta função carrega uma mensagem que o sistema manda após ser executada alguma ação (ex: processo cadastrado com sucesso!)
	public function carregarMensagem(){
		
		//verifica se teve alguma operação executada, se sim...
		if(isset($_SESSION['RESULTADO_OPERACAO'])){
			
			//se foi com sucesso, ou seja, se o resultado foi 1, mostra o aviso em cor verde
			if($_SESSION['RESULTADO_OPERACAO']){
				
				echo "<div class='alert alert-success' role='alert' id='mensagem_sucesso'>".$_SESSION['MENSAGEM']."</div>";
			
			//se foi com falha, ou seja, se o resultado foi 0, mostra o aviso em cor vermelha
			}else{
				
				echo "<div class='alert alert-danger' role='alert' id='mensagem_erro'>".$_SESSION['MENSAGEM']."</div>";
			
			}
		
		}
		
		//as variáveis são excluídas para que não fiquem sendo mostradas em toda página que for acessada
		unset($_SESSION['RESULTADO_OPERACAO']);
		unset($_SESSION['MENSAGEM']);

	}
	
	//esta função carrega o filtro nas páginas de listagem 
	public function carregarFiltro(){ ?>
	
		<div class='well'>	
			<div class='row'>
				<div class='col-sm-12'>
					<div class='input-group margin-bottom-sm'>
						<span class='input-group-addon'><i class='fa fa-search fa-fw'></i></span> <input type='text' class='input-search form-control' alt='tabela-dados' placeholder='Busque por qualquer termo da tabela' id='search' autofocus='autofocus' />
					</div>
				</div>
			</div>
		</div>
<?php		
	}
	
	//esta função carrega o script que faz o filtro funcionar
	public function carregarScriptFiltro(){ ?>
	
		<script>
		  if ($('input#search').length){
				$('input#search').quicksearch('table tbody tr');
		  }  
		</script>
<?php		
	}
	
	//algumas páginas utilizam valores de select box em comum, por exemplo, o select de servidores, é utilizado em mais de uma página.
	public function carregarSelectServidores(){
		
		//pega a lista de servidores desejada (que pode mudar dependendo da situação, e quem faz essa mudança é o controller e model)
		$lista = $_REQUEST['LISTA_SERVIDORES']; 
		
?>
		
		<select class='form-control' id='servidor' name='servidor' required >
			<option value=''>Selecione o servidor para enviar</option>
			
			<?php foreach($lista as $servidor){ ?>
				
					<option value="<?php echo $servidor['ID'] ?>">
						<?php echo $servidor['DS_NOME']; ?>
					</option>
				
		  <?php } ?>
		</select>
	
	
<?php	
	}
	
	//algumas páginas utilizam valores de select box em comum, por exemplo, o select de setores, é utilizado em mais de uma página.
	public function carregarSelectSetores(){ 
		
		//pega a lista de setores
		$lista = $_REQUEST['LISTA_SETORES'];
		
		//caso o conteudo seja de edição, o valor do registro aparece como primeiro da lista. caso seja cadastro, não tem nenhum valor
		$id   = ($this->conteudo == 'edicao') ? $_REQUEST['DADOS_SERVIDOR']['ID_SETOR'] : '';
		
		$nome = ($this->conteudo == 'edicao') ? $_REQUEST['DADOS_SERVIDOR']['NOME_SETOR'] : 'Selecione';
?>
	
		<div class='col-md-6'>
			<div class='form-group'>
				<label class='control-label' for='exampleInputEmail1'>Setor</label>
				<select class='form-control' id='setor' name='setor' required />
					<option value='<?php echo $id ?>'><?php echo $nome ?></option>
					<?php foreach($lista as $setor){ ?>
						<option value='<?php echo $setor['ID'] ?>'><?php echo $setor['DS_NOME']; ?></option>
					<?php } ?>
				</select>
			</div> 
		</div>
		
<?php 
	}
	
	//algumas páginas utilizam valores de select box em comum, por exemplo, o select de tipos de documento, é utilizado em mais de uma página.
	public function carregarSelectTiposDocumento(){ ?>
		
		<select class='form-control' id='tipo' name='tipo' required >
			<option value=''>Selecione o tipo</option>
			<option value='ANEXOS AO LAUDO'>ANEXOS AO LAUDO</option>
			<option value='ANEXOS AO RELATÓRIO'>ANEXOS AO RELATÓRIO</option>
			<option value='APRESENTAÇÃO'>APRESENTAÇÃO</option>
			<option value='AQUISIÇÃO'>AQUISIÇÃO</option>
			<option value='CERTIFICADO'>CERTIFICADO</option>
			<option value='CHECKLIST'>CHECKLIST</option>
			<option value='COTAÇÃO DE PREÇO'>COTAÇÃO DE PREÇO</option>
			<option value='CERTIDÃO NEGATIVA'>CERTIDÃO NEGATIVA</option>
			<option value='DESPACHO'>DESPACHO</option>
			<option value='MEMORANDO'>MEMORANDO</option>
			<option value='OFÍCIO'>OFÍCIO</option>
			<option value='PARECER'>PARECER</option>
			<option value='PUBLICAÇÃO NO DIÁRIO'>PUBLICAÇÃO NO DIÁRIO</option>
			<option value='RAC'>RAC</option>
			<option value='RELATÓRIO'>RELATÓRIO</option>
			<option value='RESPOSTA AO INTERESSADO'>RESPOSTA AO INTERESSADO</option>
			<option value='TERMO DE REFERÊNCIA'>TERMO DE REFERÊNCIA</option>
			<option value='LAUDO PERICIAL'>LAUDO PERICIAL</option>		
		</select>
		
<?php
		
	}
	
	//cada módulo terá a sua página de listagem, sobrescrevendo esta função
	public function listar(){
	
	}
	
	//cada módulo terá a sua página de cadastro, sobrescrevendo esta função
	public function cadastrar(){
	
	}
	
	//cada módulo terá a sua página de edição, sobrescrevendo esta função
	public function editar(){
	
	}
	]
	//cada módulo terá a sua página de visualização, sobrescrevendo esta função
	public function visualizar(){
	
	}
	
	public function carregarHistorico($historico){

?>
		
	<div class='row linha-modal-processo' style='max-height: 200px; overflow: auto;'>
		<div class='col-md-12'>
			<label><b>Histórico</b>:</label>
			<br>	
			<?php
			
				foreach($historico as $hist){ 
				
					switch($hist['DS_ACAO']){
						
						case 'ABERTURA':
						case 'AVALIAÇÃO':
						case 'TRAMITAÇÃO':
						case 'VOLTAR':
						case 'RESPONSÁVEIS':
						case 'REMOVER RESPONSÁVEL':
						case 'CRIAÇÃO DE DOCUMENTO':
						case 'EXCLUSÃO DE DOCUMENTO':
						case 'EDIÇÃO':
						case 'LÍDER':
						case 'APENSAR':
						case 'REMOÇÃO DE APENSO':
							$rgb = 'rgba(46, 204, 113,0.3)';
							break;
							
						case 'MENSAGEM':
							$rgb = 'rgba(243, 156, 18,0.4)';
							break;
							
						case 'FECHAMENTO':
						case 'ENCERRAMENTO':
						case 'CONCLUSÃO':
						case 'FINALIZAÇÃO':
						case 'FINALIZAÇÃO DESFEITA':
						case 'ARQUIVAMENTO':
						case 'DESARQUIVAMENTO':
						case 'SAÍDA':
							$rgb = 'rgba(52,152,219 ,1)';
							break;
							
						case 'URGENTE':
						case 'SOBRESTADO':
							$rgb = 'rgba(231,76,60 ,1)';
							break;
							
						case 'CONFIRMAR PROCESSO':
							$rgb = 'rgba(39,174,96 ,1)';
							break;
							
						case 'RETORNAR PROCESSO':
							$rgb = 'rgba(127,140,141 ,1)';
							break;
					}

			?>
			
					<div style=' border: solid 1px rgba(0,0,0,0.1); box-shadow: 1px 1px 1px rgba(0,0,0,0.3); padding: 5px 0 5px 10px; border-radius: 5px; width:auto; background-color: <?php echo $rgb ?>; margin: 5px 0 5px 5px;'> 
						<img class='foto-mensagem' src="/_registros/fotos/<?php echo $hist['DS_FOTO'] ?>" title='<?php echo $hist['DS_NOME'] ?>'>
						<?php echo '(' . $hist['DT_ACAO'] . '): ' . $hist['TX_MENSAGEM'] ?>
					</div>	

			<?php
			
				}
				
			?>
		</div>
	</div>
<?php	
	
	}
	
	public function carregarEnviarmensagem($modulo, $id){
		
?>
	<div class='row linha-modal-processo'>
		<form method='POST' action="/editar/<?php echo $modulo ?>/mensagem/<?php echo $id ?>/" enctype='multipart/form-data'>	
			<div class='col-md-10'>
				<input class='form-control' name='mensagem' placeholder='Digite aqui a sua mensagem (Máximo de 100 caracteres)' type='text' maxlength='100' required />	
			</div>
			<div class='col-md-2'>
				<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-dar-saida'>Enviar &nbsp;&nbsp;<i class='fa fa-arrow-circle-right' aria-hidden='true'></i></button>
			</div>
		</form>
	</div>

<?php		
		
	}

	public function carregarFooter(){ ?>

		<footer style='display: none;'>		
		</footer>
		</html>
		
<?php }
	
}

?>