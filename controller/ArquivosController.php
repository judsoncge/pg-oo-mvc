<?php 

include $_SERVER['DOCUMENT_ROOT'].'/model/ArquivosModel.php';
include $_SERVER['DOCUMENT_ROOT'].'/model/ServidoresModel.php';
include $_SERVER['DOCUMENT_ROOT'].'/view/ArquivosView.php';

class ArquivosController{
	
	public function carregarLista($status){
		
		$arquivosModel = new ArquivosModel();
		
		$listaArquivos = $arquivosModel->getListaArquivosStatus($_SESSION['ID'], $status);
		
		$titulo = ($status=='ATIVO') ? "Meus Arquivos Ativos" : "Meus Arquivos Inativos";
		
		$arquivosView = new ArquivosView();
		
		$arquivosView->setTitulo($titulo);
		
		$arquivosView->setTipo("listagem");
		
		$arquivosView->setLista($listaArquivos);
		
		$arquivosView->carregar();
		
	}
	
	public function carregarCadastrar(){
		
		$servidoresModel = new ServidoresModel();
		
		$listaServidores = $servidoresModel->getListaServidoresStatus('ATIVO');
	
		$arquivosView = new ArquivosView();
		
		$arquivosView->setTitulo("Cadastrar um Arquivo");
		
		$arquivosView->setTipo("cadastrar");
		
		$arquivosView->setListaServidores($listaServidores);
		
		$arquivosView->carregar();
		
	}
	
}

?>