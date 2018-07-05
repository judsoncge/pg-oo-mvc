<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class HomeController extends Controller{

	/*
	.inicia o model do modulo comunicacao pois precisa das noticias para carregar a pagina de home
	.
	.inicia o view de home
	*/
	function __construct(){
		
		$this->comunicacaoModel = new comunicacaoModel();
		$this->homeView = new homeView();
		
	}
	
	/*
	.esta funcao solicita que a view carregue a pagina de listagem
	.
	.para isso, necessita da lista de 5 comunicacoes mais atuais para que a view imprima as noticias e solicita ao model
	.
	.a funcao também define o titulo (de acordo com o status) e o conteudo da pagina e pede para que a view carregue a pagina
	*/
	public function listar(){
		
		$_REQUEST['LISTA_NOTICIAS'] = $this->comunicacaoModel->getCincoNoticiasMaisAtuais();
		
		$this->homeView->setTitulo("Bem vindo(a) ao Painel de Gestão, " . $_SESSION['NOME']);

		$this->homeView->setConteudo('home');
		
		$this->homeView->carregar();
		
	}

}

?>