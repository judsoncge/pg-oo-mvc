<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/model/ServidoresModel.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/view/ServidoresView.php';

class ServidoresController{
	
	private $servidoresModel;
	private $servidoresView;
	
	function __construct(){
		
		$this->servidoresModel = new ServidoresModel();
		$this->servidoresView  = new ServidoresView();
		
	}
	
	public function carregarLista($status){
		
		$this->servidoresModel->setStatus($status);
		
		$listaServidores = $this->servidoresModel->getListaServidoresStatus();
		
		$titulo = ($status=='ATIVO') ? "Servidores Ativos" : "Servidores Inativos";
		
		$this->servidoresView->setTitulo($titulo);
		
		$this->servidoresView->setTipo("listagem");
		
		$this->servidoresView->setLista($listaServidores);
		
		$this->servidoresView->carregar();
		
	}
	
	public function carregarCadastrar(){
		
		$listaServidores = $this->servidoresModel->getListaServidoresStatus('ATIVO');
		
		$this->servidoresView->setTitulo("Cadastrar um Arquivo");
		
		$this->servidoresView->setTipo("cadastrar");
		
		$this->servidoresView->setListaServidores($listaServidores);
		
		$this->servidoresView->carregar();
		
	}
	
	public function cadastrar(){
		
		$tipo = $_POST['tipo'];
		
		$servidorEnviado = $_POST['enviar'];
		
		$anexo = $_FILES['arquivo_anexo'];
		
		$this->servidoresModel->setTipo($tipo);
		
		$this->servidoresModel->setServidorEnviado($servidorEnviado);
		
		$this->servidoresModel->setAnexo($anexo);
		
		$resultado = $this->servidoresModel->cadastrar();
		
		header("Location: /arquivos/ativos/".$resultado);
		
	}	
	
	public function alterarStatus($id, $status){
		
		$this->servidoresModel->setID($id);
		
		$this->servidoresModel->setStatus($status);
		
		$resultado = $this->servidoresModel->alterarStatus();
		
		header("Location: /arquivos/ativos/".$resultado);
		
	}
	
	public function excluir($id, $anexo){
		
		$this->servidoresModel->setID($id);
		
		$this->servidoresModel->setAnexo($anexo);
		
		$resultado = $this->servidoresModel->excluir();
		
		header("Location: /arquivos/ativos/".$resultado);
	
	}
	
}

?>