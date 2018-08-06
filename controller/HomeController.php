<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';
require_once $_SESSION['PATH_VIEW'].'HomeView.php';


class HomeController extends Controller{
	
	function __construct(){
		
		$this->comunicacaoModel = new comunicacaoModel();
		
		$tipoView = $_SESSION['TYPE_VIEW'];
		$tipoView .= 'HomeView';
		$this->homeView = new $tipoView();
		
	}

	public function carregarHome(){
				
		$_REQUEST['LISTA_NOTICIAS'] = $this->comunicacaoModel->getCincoNoticiasMaisAtuais();
		
		if(isset($_GET['404'])){
			
			$_SESSION['RESULTADO_OPERACAO'] = 0;
			$_SESSION['MENSAGEM'] = 'Página não encontrada';
			
		}
		
		$this->homeView->setTitulo("<center>Bem vindo(a) ao Painel de Gestão, <br>" . $_SESSION['NOME'] . "</center>");

		$this->homeView->setConteudo('home');
		
		$this->homeView->carregar();
		
	}

}

?>