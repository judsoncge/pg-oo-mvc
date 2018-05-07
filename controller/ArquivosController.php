<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class ArquivosController extends Controller{
	
	function __construct(){
		
		$this->arquivosModel   = new ArquivosModel();
		$this->arquivosView    = new ArquivosView();
		$this->servidoresModel = new ServidoresModel();
		
	}
	
	public function listar($status){
		
		$this->arquivosModel->setStatus($status);
		
		$this->arquivosModel->setServidorCriacao($_SESSION['ID']);
		
		$listaArquivos = $this->arquivosModel->getListaArquivosStatus();
		
		$titulo = ($status=='ATIVO') ? "Meus Arquivos Ativos" : "Meus Arquivos Inativos";
		
		$this->arquivosView->setTitulo($titulo);
		
		$this->arquivosView->setTipo("listagem");
		
		$this->arquivosView->setLista($listaArquivos);
		
		$this->arquivosView->carregar();
		
	}
	
	public function cadastrar(){
		
		$tipo = $_POST['tipo'];
		
		$servidorEnviado = $_POST['enviar'];
		
		$anexo = $_FILES['arquivo_anexo'];
		
		$this->arquivosModel->setTipo($tipo);
		
		$this->arquivosModel->setServidorEnviado($servidorEnviado);
		
		$this->arquivosModel->setAnexo($anexo);
		
		$resultado = $this->arquivosModel->cadastrar();
		
		header("Location: /arquivos/ativos/".$resultado);
		
	}	
	
	public function alterarStatus($id, $status){
		
		$this->arquivosModel->setID($id);
		
		$this->arquivosModel->setStatus($status);
		
		$resultado = $this->arquivosModel->alterarStatus();
		
		header("Location: /arquivos/ativos/".$resultado);
		
	}
	
	public function excluir($id, $anexo){
		
		$this->arquivosModel->setID($id);
		
		$this->arquivosModel->setAnexo($anexo);
		
		$resultado = $this->arquivosModel->excluir();
		
		header("Location: /arquivos/ativos/".$resultado);
	
	}
	
}

?>