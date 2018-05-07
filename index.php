<?php 

//incluindo os controllers e o view de login
include $_SERVER['DOCUMENT_ROOT'].'/controller/LoginController.php';
include $_SERVER['DOCUMENT_ROOT'].'/controller/ArquivosController.php';
include $_SERVER['DOCUMENT_ROOT'].'/controller/ServidoresController.php';

//iniciando a sessao para usar variavel de sessao
session_start();

if(isset($_GET['acao'])){
		
	//verifica a acao passada para chamar o controller apropriado
	switch($_GET['acao']){
		
		case 'login':
			$controller = new LoginController();
			$controller->login();
			break;	
			
		case 'logoff':
			$controller = new LoginController();
			$controller->logoff();
			break;
			
		case 'listar-arquivos':
			$controller = new ArquivosController();
			$controller->carregarLista($_GET['status']);
			break;
			
		case 'cadastro-arquivo':
			$controller = new ArquivosController();
			$controller->carregarFormulario();
			break;
			
		case 'cadastrar-arquivo':
			$controller = new ArquivosController();
			$controller->cadastrar();
			break;
			
		case 'alterar-status-arquivo':
			$controller = new ArquivosController();
			$controller->alterarStatus($_GET['id'], $_GET['status']);
			break;
			
		case 'excluir-arquivo':
			$controller = new ArquivosController();
			$controller->excluir($_GET['id'], $_GET['anexo']);
			break;
			
		case 'listar-servidores':
			$controller = new ServidoresController();
			$controller->carregarLista($_GET['status']);
			break;
			
		case 'cadastro-servidor':
			$controller = new ServidoresController();
			$controller->carregarCadastrar();
			break;
			
		case 'edicao-servidor':
			$controller = new ServidoresController();
			$controller->carregarEditar($_GET['id']);
			break;
			
		case 'cadastrar-servidor':
			$controller = new ServidoresController();
			$controller->cadastrar();
			break;
			
		case 'alterar-status-servidor':
			$controller = new ServidoresController();
			$controller->alterarStatus($_GET['id'], $_GET['status']);
			break;
			
		case 'excluir-servidor':
			$controller = new ServidoresController();
			$controller->excluir($_GET['id'], $_GET['anexo']);
			break;

	}
		
}

//se nao, e pq ninguem fez login ainda. entao mostra a pagina de login
else{
	
	$view = new loginView();
	$view->setTitulo("Painel de Gestão");
	$view->carregar(); 
	
}

?>