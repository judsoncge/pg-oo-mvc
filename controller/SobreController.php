<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';
require_once $_SESSION['PATH_VIEW'].'SobreView.php';

class SobreController extends Controller{

	function __construct(){

		$tipoView = $_SESSION['TYPE_VIEW'];
		$tipoView .= 'SobreView';
		$this->sobreView = new $tipoView();
		
	}
	
	public function visualizar(){
		
		$this->sobreView->setTitulo('Sobre o Painel de Controle da Transparência CGE');
		
		$this->sobreView->setConteudo('visualizar');
		
		$this->sobreView->carregar();
		
	}

}

?>