<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class HomeController extends Controller{
	
	function __construct(){
		
		$this->comunicacaoModel = new comunicacaoModel();
		$this->homeView         = new homeView();
		
	}

	public function carregarHome(){
		
		$listaComunicacao = $this->comunicacaoModel->getCincoNoticiasMaisAtuais();
		
		//$this->homeView = new LoginView();
		
		$this->homeView->setTitulo("Bem vindo(a) ao Painel de Gestão, " . $_SESSION['NOME']);
		
		$this->homeView->setLista($listaComunicacao);
		
		$this->homeView->carregar();
		
	}

}

?>