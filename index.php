<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/LoginController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/controller/ArquivosController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/controller/ServidoresController.php';

session_start();

if(isset($_GET['acao'])){
	
	if(isset($_GET['modulo'])){
		
		$classe = $_GET['modulo'];
		
		$classe .= 'Controller';
			
		$controller = new $classe();
		
	}
	
	switch($_GET['acao']){
			
		case 'login':
			
			$controller = new LoginController();
			
			$controller->login();
			
			break;	
			
		case 'logoff':
			
			$controller = new LoginController();
			
			$controller->logoff();
			
			break;	
		
		case 'lista':

			$controller->listar();
			
			break;
			
		case 'cadastro':

			$controller->carregarCadastro();
			
			break;
			
		case 'edicao':

			$controller->carregarEdicao();
			
			break;
		
		case 'detalhes':
			
			$controller->detalhar();
			
			break;
			
			
		case 'cadastrar':
			
			$controller->cadastrar();
			
			break;
			
		case 'editar':
			
			$controller->editar();
			
			break;
			
		case 'excluir':
			
			$controller->excluir();
			
			break;
	}
		

}else{
	
	$view = new loginView();
	
	$view->carregar(); 
	
}

?>