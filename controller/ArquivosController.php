<?php 

include $_SERVER['DOCUMENT_ROOT'].'/model/ArquivosModel.php';
include $_SERVER['DOCUMENT_ROOT'].'/model/ServidoresModel.php';
include $_SERVER['DOCUMENT_ROOT'].'/view/ArquivosView.php';

class ArquivosController{
	
	private $arquivosModel;
	private $arquivosView;
	private $servidoresModel;
	
	function __construct(){
		
		$this->arquivosModel   = new ArquivosModel();
		$this->arquivosView    = new ArquivosView();
		$this->servidoresModel = new ServidoresModel();
		
	}
	
	public function carregarLista($status){
		
		$this->arquivosModel->setStatus($status);
		
		$this->arquivosModel->setServidorCriacao($_SESSION['ID']);
		
		$listaArquivos = $this->arquivosModel->getListaArquivosStatus();
		
		$titulo = ($status=='ATIVO') ? "Meus Arquivos Ativos" : "Meus Arquivos Inativos";
		
		$this->arquivosView->setTitulo($titulo);
		
		$this->arquivosView->setTipo("listagem");
		
		$this->arquivosView->setLista($listaArquivos);
		
		$this->arquivosView->carregar();
		
	}
	
	public function carregarCadastrar(){
		
		$listaServidores = $this->servidoresModel->getListaServidoresStatus('ATIVO');
		
		$this->arquivosView->setTitulo("Cadastrar um Arquivo");
		
		$this->arquivosView->setTipo("cadastrar");
		
		$this->arquivosView->setListaServidores($listaServidores);
		
		$this->arquivosView->carregar();
		
	}
	
	public function cadastrar(){
		
		$tipo = $_POST['tipo'];
		
		$servidorEnviar = $_POST['enviar'];
		
		$anexo = $_FILES['arquivo_anexo'];
		
		$this->arquivosModel->setTipo($tipo);
		
		$this->arquivosModel->setServidorEnviar($servidorEnviar);
		
		$this->arquivosModel->setAnexo($anexo);
		
		$this->arquivosModel->cadastrar();
		
	}	
	
}

?>