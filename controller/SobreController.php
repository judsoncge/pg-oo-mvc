<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';
require_once $_SESSION['PATH_VIEW'].'SobreView.php';

class ComunicacaoController extends Controller{

	/*
	.inicia o model e o view do modulo Sobre
	*/
	function __construct(){

		$tipoView = $_SESSION['TYPE_VIEW'];
		$tipoView .= 'SobreView';
		$this->sobreView = new $tipoView();
		
	}

	/*
	.esta funcao solicita que a view carregue a pagina de visualizar
	.
	.a funcao também define o titulo e o conteudo da pagina e pede para que a view carregue a pagina
	*/
	public function visualizar(){
		
		$this->comunicacaoView->setConteudo('visualizar');
		
		$this->comunicacaoView->carregar();
		
	}

}

?>