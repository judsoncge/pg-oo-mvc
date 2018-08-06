<?php 

session_start();

date_default_timezone_set('America/Bahia');

if(isset($_GET['acao']) and isset($_GET['modulo'])){
	
	$classe = $_GET['modulo'];

	$classe .= 'Controller';
	
	require_once $_SERVER['DOCUMENT_ROOT']."/controller/$classe.php";		
			
	$controller = new $classe();
	
	$acao = $_GET['acao'];
	
	$controller->$acao();


}else{

	if(isset($_SESSION['ID'])){
	
		Header('Location: /home');
	
	}else{
		
		require_once $_SERVER['DOCUMENT_ROOT'].'/view/LoginView.php';
	
		$view = new loginView();
	
		$view->carregar(); 
	
	}
	
}

?>