<?php 

//incluindo os controllers e o view de login
include $_SERVER['DOCUMENT_ROOT'].'/controller/LoginController.php';
include $_SERVER['DOCUMENT_ROOT'].'/controller/ArquivosController.php';
include $_SERVER['DOCUMENT_ROOT'].'/view/LoginView.php';

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
			$controller->mostrarListagem($_GET['status']);
			break;
			
		case 'cadastrar-arquivo':
			$controller = new ArquivosController();
			$controller->mostrarCadastrar();
			break;
	
	}
		
}

//se nao, e pq ninguem fez login ainda. entao mostra a pagina de login
else{
	
	$view = new loginView("Painel de Gestão", NULL, NULL);
	$view->carregar(); 
}

?>