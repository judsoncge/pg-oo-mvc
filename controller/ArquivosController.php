<?php 

include $_SERVER['DOCUMENT_ROOT'].'/model/ArquivosModel.php';
include $_SERVER['DOCUMENT_ROOT'].'/view/ArquivosView.php';

class ArquivosController{
	
	public function mostrarListagem($status){
		
		$arquivoModel = new ArquivosModel();
		
		$listaArquivos = $arquivoModel->getListaArquivosStatus($_SESSION['ID'], $status);
		
		$titulo = ($status=='ATIVO') ? "Meus Arquivos Ativos" : "Meus Arquivos Inativos";
		
		$arquivosView = new ArquivosView($titulo, "listagem", $listaArquivos);
		
		$arquivosView->carregar();
		
	}
	
	public function mostrarCadastrar(){
		
		$arquivoModel = new ArquivosModel();
		
		$titulo = "Cadastrar um Arquivo";
		
		$arquivosView = new ArquivosView($titulo, "cadastrar", NULL);
		
		$arquivosView->carregar();
		
	}
	
}

?>