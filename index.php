<?php 

//incluindo os controllers e o view de login
require_once $_SERVER['DOCUMENT_ROOT'].'/controller/LoginController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/controller/ArquivosController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/controller/ServidoresController.php';

//iniciando a sessao para usar variavel de sessao
session_start();

if(isset($_GET['acao'])){
	
	if(isset($_GET['modulo'])){
		
		$classe = $_GET['modulo'];
		
		$classe .= 'Controller';
			
		$controller = new $classe();
		
	}
		
	//verifica a acao passada para chamar o controller apropriado
	switch($_GET['acao']){
		
		case 'redirecionar':
			$controller = new Controller();
			$controller->redirecionar($_GET['modulo'], $_GET['pagina'], $_GET['titulo']);
			break;
			
		
		case 'login':
			$controller = new LoginController();
			$controller->login();
			break;	
			
		case 'logoff':
			$controller = new LoginController();
			$controller->logoff();
			break;	
		
		case 'listar':

			$controller->listar($_GET['status']);
			
			break;
			
		case 'cadastrar':
			
			$controller->cadastrar();
			
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