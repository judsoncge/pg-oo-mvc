<?php 

//carregando model de login para verificacao de login e o de comunicacao, pois a pagina de home mostra as noticiass
include $_SERVER['DOCUMENT_ROOT'].'/model/ComunicacaoModel.php';
include $_SERVER['DOCUMENT_ROOT'].'/view/HomeView.php';

class HomeController{
	
	private $comunicacaoModel;
	private $homeView;
	
	function __construct(){
		
		$this->comunicacaoModel = new comunicacaoModel();
		$this->homeView         = new homeView();
		
	}

	public function carregarHome(){
		
		$listaComunicacao = $this->comunicacaoModel->getCincoNoticiasMaisAtuais();
		
		$this->homeView = new HomeView();
		
		$this->homeView->setTitulo("Bem vindo(a) ao Painel de Gestão, " . $_SESSION['NOME']);
		
		$this->homeView->setLista($listaComunicacao);
		
		$this->homeView->carregar();
		
	}

}

?>