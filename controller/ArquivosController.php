<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class ArquivosController extends Controller{
	
	function __construct(){
		
		$this->arquivosModel   = new ArquivosModel();
		$this->arquivosView    = new ArquivosView();
		$this->servidoresModel = new ServidoresModel();
		
	}
	
	public function carregarCadastro(){
		
		$this->servidoresModel->setStatus('ATIVO');
		
		$listaServidores = $this->servidoresModel->getListaServidoresStatus();
		
		$_REQUEST['LISTA_SERVIDORES'] = $listaServidores;
		
		$this->arquivosView->setTitulo('ARQUIVOS > CADASTRAR');
		
		$this->arquivosView->setConteudo('cadastro');
		
		$this->arquivosView->carregar();
	}
	
	public function listar($status){
		
		$this->arquivosModel->setStatus($status);
		
		$this->arquivosModel->setServidorCriacao($_SESSION['ID']);
		
		$listaArquivos = $this->arquivosModel->getListaArquivosStatus();
		
		$titulo = ($status=='ATIVO') ? 'Meus Arquivos Ativos' : 'Meus Arquivos Inativos';
		
		$this->arquivosView->setTitulo($titulo);
		
		$this->arquivosView->setConteudo('lista');
		
		$_REQUEST['LISTA_ARQUIVOS'] = $listaArquivos;
		
		$this->arquivosView->carregar();
		
	}
	
	public function cadastrar(){
		
		$tipo = $_POST['tipo'];
		
		$servidorDestino = $_POST['servidor'];
		
		$anexo = $_FILES['arquivo_anexo'];
		
		$this->arquivosModel->setTipo($tipo);
		
		$this->arquivosModel->setServidorDestino($servidorDestino);
		
		$this->arquivosModel->setAnexo($anexo);
		
		$_REQUEST['RESULTADO_OPERACAO'] = $this->arquivosModel->cadastrar();
		
		$_REQUEST['MENSAGEM'] = $this->arquivosModel->getMensagemResposta();
		
		if($_REQUEST['RESULTADO_OPERACAO']){
			$this->listar('ATIVO');
		}else{
			$this->carregarCadastro();
		}
		
	}	
	
	public function editar(){
		
		$tipo =            (isset($_POST['tipo']))           ? $_POST['tipo']           : NULL;
		
		$servidorDestino = (isset($_POST['servidor']))       ? $_POST['servidor']       : NULL;
		
		$anexo =           (isset($_FILES['arquivo_anexo'])) ? $_FILES['arquivo_anexo'] : NULL;
		
		$status =          (isset($_GET['status']))          ? $_GET['status']          : NULL;
		
		$id =              (isset($_GET['id']))              ? $_GET['id']              : NULL;
		
		$this->arquivosModel->setTipo($tipo);
		
		$this->arquivosModel->setServidorDestino($servidorDestino);
		
		$this->arquivosModel->setAnexo($anexo);
		
		$this->arquivosModel->setStatus($status);
		
		$this->arquivosModel->setID($id);
		
		$_REQUEST['RESULTADO_OPERACAO'] = $this->arquivosModel->editar();
		
		$_REQUEST['MENSAGEM'] = $this->arquivosModel->getMensagemResposta();
	
		$this->listar('ATIVO');
	
	}
	
	public function excluir(){
		
		$this->arquivosModel->setID($_GET['id']);
		
		$this->arquivosModel->setAnexo($_GET['anexo']);
		
		$_REQUEST['RESULTADO_OPERACAO'] = $this->arquivosModel->excluir();
		
		$_REQUEST['MENSAGEM'] = $this->arquivosModel->getMensagemResposta();
	
		$this->listar('ATIVO');
	
	}
	
}

?>