<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';
require_once $_SESSION['PATH_VIEW'].'ArquivosView.php';

class ArquivosController extends Controller{
	
	function __construct(){
		
		$this->arquivosModel   = new ArquivosModel();
		$this->servidoresModel = new ServidoresModel();
		$this->arquivosModel->setTabela('tb_arquivos');
		
		$tipoView = $_SESSION['TYPE_VIEW'];
		$tipoView .= 'ArquivosView';
		$this->arquivosView = new $tipoView();
		
	}
	
	public function carregarCadastro(){
		
		$this->servidoresModel->setStatus('ATIVO');
		
		$_REQUEST['LISTA_SERVIDORES'] = $this->servidoresModel->getListaServidoresStatus();
		
		$this->arquivosView->setTitulo('ARQUIVOS > CADASTRAR');
		
		$this->arquivosView->setConteudo('cadastrar');
		
		$this->arquivosView->carregar();
	}
	
	public function cadastrar(){
		
		$tipo = $_POST['tipo'];
		
		$servidorDestino = $_POST['servidor'];
		
		$anexo = $_FILES['arquivoAnexo'];
		
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
		
		$id = $_GET['id'];
		
		$this->arquivosModel->setID($id);
		
		$operacao = $_GET['operacao'];
		
		switch($operacao){
			
			case 'status':
				
				$status = $_GET['status'];
				
				$this->arquivosModel->setStatus($status);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->arquivosModel->editarStatus();
				
				break;
			
		}
		
		$_SESSION['MENSAGEM'] = $this->arquivosModel->getMensagemResposta();

		Header('Location: /arquivos/ativos/');
		
	}

	public function listar(){
		
		$this->arquivosModel->setStatus($_GET['status']);
		
		$this->arquivosModel->setServidorCriacao($_SESSION['ID']);
		
		$_REQUEST['LISTA_ARQUIVOS'] = $this->arquivosModel->getListaArquivosStatus();
		
		$titulo = ($_GET['status']=='ATIVO') ? 'ARQUIVOS > ATIVOS' : 'ARQUIVOS > INATIVOS';
		
		$this->arquivosView->setTitulo($titulo);
		
		$this->arquivosView->setConteudo('listar');
		
		$this->arquivosView->carregar();
		
	}

	public function excluir(){
		
		$this->arquivosModel->setID($_GET['id']);
		
		$this->arquivosModel->setAnexo($_GET['anexo']);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->arquivosModel->excluir();
		
		$_SESSION['MENSAGEM'] = $this->arquivosModel->getMensagemResposta();
		
		Header('Location: /arquivos/ativos/');
	
	}
	
}

?>