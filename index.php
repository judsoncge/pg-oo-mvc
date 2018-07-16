<?php 

//iniciando a sessão do usuário
session_start();

//setando a data/hora em Bahia pois o sistema roda no Nordeste. Funções que registram data/hora precisam pegar a hora local
date_default_timezone_set('America/Bahia');

//a variável ação vem do link. Ela geralmente informa o que o sistema tem que executar. Todas as informações encontram-se no arquivo .htaccess
//aqui o sistema verifica se há uma ação. Se houver, é porque já foi feito o login e o usuário está tentando executar alguma coisa.
if(isset($_GET['acao'])){
	
	//verifica antes se existe a sessão. essa verificacao é importante para quando o tempo de sessao do servidor acaba  (por inutilização do usuario) e ai as variaveis de sessao sao destruidas. assim, leva o usuario novamente para a pagina de login, MENOS quando a acao é de login, pq ainda serão criadas as variáveis de sessão (primeiro acesso)
	if(!isset($_SESSION['PATH_VIEW']) and $_GET['acao'] != 'login'){
		
		require_once $_SERVER['DOCUMENT_ROOT'].'/view/LoginView.php';
	
		$view = new loginView();
	
		$view->carregar(); 
		
	}
	
	//montando o nome da classe do controller com o valor do módulo que vem no link. exemplo: se for chamados, ficará ChamadosController; se for processos, ficará ProcessosController e assim por diante.
	$classe = $_GET['modulo'];
		
	require_once $_SERVER['DOCUMENT_ROOT']."/controller/".$classe."Controller.php";		
	
	$classe .= 'Controller';
			
	$controller = new $classe();
		
	//aqui o sistema verifica que tipo de ação o usuário está tentando fazer
	switch($_GET['acao']){
		
		//caso seja login, é porque o usuário digitou login e senha para tentar logar no sistema
		case 'login':
			
			$controller->login();
			
			break;	
		
		//caso seja logoff, é porque o usuário clicou no botão de efetuar logoff no sistema
		case 'logoff':
			
			$controller->logoff();
			
			break;	
		
		//caso seja consulta, é porque o usuário quer abrir a página de listagem dos registros do módulo em questão	
		case 'lista':
			
			$controller->listar();
		
			break;
		
		//caso seja consulta, é porque o usuário quer abrir a página de cadastro de algum registro do módulo em questão	
		case 'cadastro':

			$controller->carregarCadastro();
			
			break;
		
		//caso seja consulta, é porque o usuário quer abrir a página de edição de algum registro do módulo em questão	
		case 'edicao':

			$controller->carregarEdicao();
			
			break;
		
		//caso seja visualização, é porque o usuário quer ver mais detalhes de um registro do módulo em questão. Assim o controller solicita os dados desse registro e o encaminha para a página mostrando os detalhes
		case 'visualizar':
			
			$controller->visualizar();
			
			break;
		
		//caso seja consulta, é porque o usuário quer abrir a página de relatório	
		case 'relatorio':
		
			$controller->carregarRelatorio();
			
			break;
			
		//caso seja consulta, é porque o usuário quer abrir a página de consulta
		case 'consulta':
			
			$controller->carregarConsulta();
			
			break;
		
		//caso seja cadastrar (verbo no infinitivo), significa a ação de cadastrar (receber dados e inserir no banco)
		case 'cadastrar':
			
			$controller->cadastrar();
			
			break;
		
		//caso seja editar (verbo no infinitivo), significa a ação de editar (receber dados e atualizar no banco)
		case 'editar':
			
			$controller->editar();
			
			break;
		
		//caso seja excluir (verbo no infinitivo), significa a ação de cadastrar (receber dados e inserir no banco)
		case 'excluir':
			
			$controller->excluir();
			
			break;
			
		//caso seja consultar (verbo no infinitivo), significa a ação de consultar (receber dados e procurar no banco)
		case 'consultar':
			
			$controller->consultar();
			
			break;
		
		//caso seja exportar, é porque o usuário quer exportar para PDF uma tabela atual do módulo em questão
		case 'exportar':
		
			$controller->exportar();
			
			break;
			
	}
	
	
		
//caso não exista ação, é porque o usuário ainda não fez login no sistema e ele mostra a página de login. o usuario também pode estar tentando acessar a página sobre, que não envolve nenhuma ação
}else{
	
	//se ja existe uma sessão aberta, leve para a página de home.
	if(isset($_SESSION['ID'])){
	
		Header('Location: /home');
	
	}
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/view/LoginView.php';
	
	$view = new loginView();
	
	$view->carregar(); 
	
}

?>