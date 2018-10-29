<?php


class View{
	
	
	protected $titulo;
	protected $conteudo;	
	
	public function setTitulo($titulo){
		
		$this->titulo = $titulo; 
	
	}
	
	public function setConteudo($conteudo){
		
		$this->conteudo = $conteudo; 
	
	}
	
	
	public function carregar(){
		
		$this->carregarHead();
		$this->carregarBody();
		$this->carregarFooter();
	
	}
	
	
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
				
				$this->adicionarScripts(); 
			?>
		
		</head>	
<?php 
	}
	
	
	public function adicionarScripts(){ 
		
	}
	
	
	public function carregarBody(){ 
	?>
		
		<body>
			
			<div class='menu-superior'>
				
				
				<div>
					<a href='#menu-toggle' class='btn btn-default' id='menu-toggle'><i class='fa fa-bars' aria-hidden='true'></i></a>
					<img src='/view/_libs/img/gestao-cge.png' id='logo-home'>
				</div>
				
				
				<div>
					<div class='loader' id='preloader'></div>
				</div>
				
				
				<div class='container-icone'>
					<div>
						<a href='logoff' alt='Logoff'><i class='fa fa-sign-out fa-lg' aria-hidden='true' id='sair-icone'></i></a>
					</div>	
				</div>	
			</div>
			
			
			<div id='wrapper'>
				<div id='sidebar-wrapper'>
					<ul class='sidebar-nav'>
						<li class='sidebar-brand'>
							<div id='usuario'>
								
								
								<div id='box-imagem'>
									<img src='/_registros/fotos/<?php echo $_SESSION['FOTO'] ?>' id='imagem'>
								</div>
								
								
								<div id='mensagem'>
									<center>
										<a href='/usuarios/senha/' id='alterar-senha'>
											<i class='fa fa-edit' aria-hidden='true'></i>  
											Alterar senha
										</a>
										<a href='/usuarios/foto/' id='alterar-foto'>
											<i class='fa fa-edit' aria-hidden='true'></i> 
											Alterar foto
										</a>
									</center>
								</div>
							</div>
						</li>
						<hr>
						
						<li>
							<a href='/home'><i class='fa fa-home icone-menu' aria-hidden='true'></i>Início</a>
						</li>
						
						
						<li id='arquivos'>
							<a href='#'><i class='fa fa-file-archive-o icone-menu' aria-hidden='true'></i>Arquivos</a>
						</li>	
							
							<li class='arquivos-subitem'>
								<a href='/arquivos/cadastrar/'><i class='fa fa-file-archive-o icone-menu' aria-hidden='true'></i>Cadastrar</a>
							</li>
							
							<li class='arquivos-subitem'>
								<a href='/arquivos/ativos/'><i class='fa fa-file-archive-o icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							
							<li class='arquivos-subitem'>
								<a href='/arquivos/inativos/'><i class='fa fa-file-archive-o icone-menu' aria-hidden='true'></i>Inativos</a>
							</li>
						
						<li id='chamados'>
							<a href='#'><i class='fa fa-headphones icone-menu' aria-hidden='true'></i>Chamados</a>
						</li>
							
							<li class='chamados-subitem'>
								<a href='/chamados/cadastrar/'><i class='fa fa-headphones icone-menu' aria-hidden='true'></i>Abrir Chamado</a>
							</li>
							
							<li class='chamados-subitem'>
								<a href='/chamados/ativos/'><i class='fa fa-headphones icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							
							<li class='chamados-subitem'>
								<a href='/chamados/inativos/' ><i class='fa fa-headphones icone-menu' aria-hidden='true'></i>Inativos</a>
							</li>
						
						<?php if($_SESSION['FUNCAO'] == 'TI' OR $_SESSION['FUNCAO'] == 'COMUNICAÇÃO'){ ?>	
						
						
						<li id='comunicacao'>
							<a href='#'><i class='fa fa-volume-up icone-menu' aria-hidden='true'></i>Comunicação</a>
						</li>
							
							<li class='comunicacao-subitem'>
								<a href='/comunicacao/cadastrar/'><i class='fa fa-volume-up icone-menu' aria-hidden='true'></i>Cadastrar</a>
							</li>
							
							<li class='comunicacao-subitem'>
								<a href='/comunicacao/ativos/'><i class='fa fa-volume-up icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							
							<li class='comunicacao-subitem'>
								<a href='/comunicacao/inativos/' ><i class='fa fa-volume-up icone-menu' aria-hidden='true'></i>Inativos</a>
							</li>
							
						<?php } ?>
						
						
						<li id='processos'>
							<a href='#'><i class='fa fa-exchange icone-menu' aria-hidden='true'></i>Processos</a>
						</li>
							
							<?php if($_SESSION['FUNCAO'] == 'TI' OR $_SESSION['FUNCAO'] == 'PROTOCOLO'){ ?>	
								<li class='processos-subitem'>
									<a href='/processos/cadastrar/'><i class='fa fa-exchange icone-menu' aria-hidden='true'></i>Cadastrar</a>
								</li>
							<?php } ?>	
							
							<li class='processos-subitem'>
								<a href='/processos/ativos/0'><i class='fa fa-exchange icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							
							<li class='processos-subitem'>
								<a href='/processos/consulta' ><i class='fa fa-exchange icone-menu' aria-hidden='true'></i>Consultar</a>
							</li>
							
							
							<?php if($_SESSION['FUNCAO'] == 'TI' OR $_SESSION['FUNCAO'] == 'CONTROLADOR' OR $_SESSION['FUNCAO'] == 'CHEFE DE GABINETE'){ ?>
							
							<li class='processos-subitem'>
								<a href='/processos/relatorio/' ><i class='fa fa-exchange icone-menu' aria-hidden='true'></i>Relatório</a>
							</li>
							
							<?php } 
							
						if($_SESSION['FUNCAO'] == 'TI'){ ?>
						
						
						<li id='usuarios'>
							<a href='#'><i class='fa fa-user icone-menu' aria-hidden='true'></i>Usuarios</a>
						</li>	
							
							<li class='usuarios-subitem'>
								<a href='/usuarios/cadastrar/'><i class='fa fa-user icone-menu' aria-hidden='true'></i>Cadastrar</a>
							</li>
							
							<li class='usuarios-subitem'>
								<a href='/usuarios/ativos/'><i class='fa fa-user icone-menu' aria-hidden='true'></i>Ativos</a>
							</li>
							
							<li class='usuarios-subitem'>
								<a href='/usuarios/inativos/'><i class='fa fa-user icone-menu' aria-hidden='true'></i>Inativos</a>
							</li>
						<?php } ?> 
						
						
						<li>
							<a href='/sobre/'><i class='fa fa-info-circle icone-menu' aria-hidden='true'></i>Sobre</a>
						</li>
					</ul>
				</div>
				
			
			<script type='text/javascript'>
				$('#menu-toggle').click(function(e) {
					e.preventDefault();
					$('#wrapper').toggleClass('toggled');
				});
			</script>
			
			<div id='page-content-wrapper'>
				<div class='container titulo-pagina'>
					
					<p><?php echo $this->titulo ?></p>
				</div>
				
				<?php 
				
				
				$this->carregarMensagem(); 
				
				?>

				<div class='container caixa-conteudo'>
					<div class='row'>
						<div class='col-lg-12'>
							<div class='container'>
							
							
							
								<?php 
								
								$conteudoPagina = $this->conteudo;
								
								if($this->conteudo == 'listar'){
									
									$this->carregarFiltro();
									$this->listar();
									$this->carregarScriptFiltro();
									
								}else{
									
									$this->$conteudoPagina();
									
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
	
	
	public function carregarMensagem(){
		
		if(isset($_SESSION['RESULTADO_OPERACAO'])){
			
			if($_SESSION['RESULTADO_OPERACAO']){
				
				echo "<div class='alert alert-success' role='alert' id='mensagem_sucesso'>".$_SESSION['MENSAGEM']."</div>";
			
			
			}else{
					
				echo "<div class='alert alert-danger' role='alert' id='mensagem_erro'>".$_SESSION['MENSAGEM']."</div>";
			
			}
		
		}
	
		unset($_SESSION['RESULTADO_OPERACAO']);
		unset($_SESSION['MENSAGEM']);

	}
	
	
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
	
	
	public function carregarScriptFiltro(){ ?>
	
		<script>
		  if ($('input#search').length){
				$('input#search').quicksearch('table tbody tr');
		  }  
		</script>
<?php		
	}
	
	
	public function carregarSelectUsuarios(){
		
		
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
			<option value='OUTROS'>OUTROS</option>	
		</select>
		
<?php
		
	}
	
	
	public function listar(){
	
	}
	
	
	public function cadastrar(){
	
	}
	
	
	public function editar(){
	
	}
	
	
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