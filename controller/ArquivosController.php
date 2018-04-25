<?php 

include $_SERVER['DOCUMENT_ROOT'].'/model/ArquivosModel.php';
include $_SERVER['DOCUMENT_ROOT'].'/view/ArquivosView.php';

class ArquivosController{
	
	public function mostrarListagem($status){
		
		$arquivoModel = new ArquivosModel();
		
		$listaArquivos = $arquivoModel->getListaArquivosStatus($_SESSION['ID'], $status);
		
		$arquivoView = new ArquivosView();
		
		$titulo = ($status=='ATIVO') ? "Meus Arquivos Ativos" : "Meus Arquivos Inativos";
		
		$arquivoView->carregar($titulo, $listaArquivos);
		
	}
	
}

?>