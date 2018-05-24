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
	
	public function listar(){
		
		$this->arquivosModel->setStatus($_GET['status']);
		
		$this->arquivosModel->setServidorCriacao($_SESSION['ID']);
		
		$listaArquivos = $this->arquivosModel->getListaArquivosStatus();

		$_REQUEST['LISTA_ARQUIVOS'] = $listaArquivos;
		
		$titulo = ($_GET['status']=='ATIVO') ? 'ARQUIVOS > ATIVOS' : 'ARQUIVOS > INATIVOS';
		
		$this->arquivosView->setTitulo($titulo);
		
		$this->arquivosView->setConteudo('lista');
		
		$this->arquivosView->carregar();
		
	}
	
	public function cadastrar(){
		
		$tipo = $_POST['tipo'];
		
		$servidorDestino = $_POST['servidor'];
		
		$anexo = $_FILES['arquivo_anexo'];
		
		$this->arquivosModel->setTipo($tipo);
		
		$this->arquivosModel->setServidorDestino($servidorDestino);
		
		$this->arquivosModel->setAnexo($anexo);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->arquivosModel->cadastrar();
		
		$_SESSION['MENSAGEM'] = $this->arquivosModel->getMensagemResposta();
		
		if($_SESSION['RESULTADO_OPERACAO']){
			Header('Location: /arquivos/ativos/');
		}else{
			Header('Location: /arquivos/cadastrar/');
		}
		
	}	
	
	public function editar(){
		
		$id = (isset($_GET['id'])) ? $_GET['id'] : NULL;
		
		switch($_GET['operacao']){
			
			case 'status':
				
				$status = (isset($_GET['status'])) ? $_GET['status'] : NULL;
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->arquivosModel->editarStatus('arquivos', $status, $id);
				
				break;
				
			case 'info': 
			
				$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : NULL;
		
				$servidorDestino = (isset($_POST['servidor'])) ? $_POST['servidor'] : NULL;
		
				$anexo = (isset($_FILES['arquivo_anexo'])) ? $_FILES['arquivo_anexo'] : NULL;
				
				$this->arquivosModel->setTipo($tipo);
		
				$this->arquivosModel->setServidorDestino($servidorDestino);
		
				$this->arquivosModel->setAnexo($anexo);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->arquivosModel->editar();
				
				break;
			
		}
		
		$_SESSION['MENSAGEM'] = $this->arquivosModel->getMensagemResposta();
	
		Header('Location: /arquivos/ativos/');
		
	}
	
	public function excluir(){
		
		$this->arquivosModel->setAnexo($_GET['anexo']);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->arquivosModel->excluir('tb_arquivos', $_GET['id']);
		
		$_SESSION['MENSAGEM'] = $this->arquivosModel->getMensagemResposta();
		
		Header('Location: /arquivos/ativos/');
	
	}
	
}

?>