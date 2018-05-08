<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class HomeController extends Controller{
	
	function __construct(){
		
		$this->comunicacaoModel = new comunicacaoModel();
		$this->homeView         = new homeView();
		
	}

	public function listar(){
		
		$listaComunicacao = $this->comunicacaoModel->getCincoNoticiasMaisAtuais();
		
		$this->homeView->setConteudo('home');
		
		$this->homeView->setTitulo("Bem vindo(a) ao Painel de Gestão, " . $_SESSION['NOME']);
		
		$_REQUEST['LISTA_NOTICIAS'] = $listaComunicacao;
		
		$this->homeView->carregar();
		
	}

}

?>