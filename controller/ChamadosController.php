<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class ChamadosController extends Controller{

	function __construct(){
		
		$this->chamadosView    = new ChamadosView();
		$this->chamadosModel   = new ChamadosModel();
		
	}
	
	public function carregarCadastro(){
		
		$this->chamadosView->setTitulo('CHAMADOS > ABRIR CHAMADO');
		
		$this->chamadosView->setConteudo('cadastro');
	
		$this->chamadosView->carregar();
		
	}
	
	public function cadastrar(){
		
		$natureza = (isset($_POST['natureza'])) ? $_POST['natureza'] : NULL;
		
		$problema = (isset($_POST['problema'])) ? $_POST['problema'] : NULL;
		
		$servidorRequisitante = $_SESSION['ID'];
		
		$this->chamadosModel->setNatureza($natureza);
		
		$this->chamadosModel->setProblema($problema);
		
		$this->chamadosModel->setServidorRequisitante($servidorRequisitante);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->chamadosModel->cadastrar();
		
		$_SESSION['MENSAGEM'] = $this->chamadosModel->getMensagemResposta();
		
		if($_SESSION['RESULTADO_OPERACAO']){
			Header('Location: /chamados/ativos/');
		}else{
			Header('Location: /chamados/cadastrar/');
		}
		
	}	
	
	public function editar(){
		
		$status = (isset($_GET['status'])) ? $_GET['status'] : NULL;

		$avaliacao = (isset($_POST['avaliacao'])) ? $_POST['avaliacao'] : NULL;
		
		$id = $_GET['id'];

		$this->chamadosModel->setStatus($status);
		
		$this->chamadosModel->setAvaliacao($avaliacao);
		
		$this->chamadosModel->setId($id);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->chamadosModel->editar();
		
		$_SESSION['MENSAGEM'] = $this->chamadosModel->getMensagemResposta();
		
		if($_SESSION['RESULTADO_OPERACAO']){
			Header('Location: /chamados/ativos/');
		}else{
			Header('Location: /chamados/editar/'.$id);
		}
		
	}
	
	public function listar(){
		
		$this->chamadosModel->setStatus($_GET['status']);
		
		$listaChamados = $this->chamadosModel->getListaChamadosStatus();
		
		$titulo = ($_GET['status']=='ATIVO') ? 'CHAMADOS > ATIVOS' : 'CHAMADOS > INATIVOS';
		
		$this->chamadosView->setTitulo($titulo);
		
		$this->chamadosView->setConteudo('lista');
		
		$_REQUEST['LISTA_CHAMADOS'] = $listaChamados;
		
		$this->chamadosView->carregar();
		
	}
	
	public function detalhar(){
		
		$id = $_GET['id'];
		
		$this->chamadosModel->setID($id);
		
		$listaDados = $this->chamadosModel->getDadosID();
		
		$historico  = $this->chamadosModel->getHistorico('chamados', $id);
		
		$this->chamadosView->setTitulo("CHAMADOS > ".$listaDados['ID']." > DETALHES");
		
		$this->chamadosView->setConteudo('detalhes');
		
		$_REQUEST['DADOS_CHAMADO']     = $listaDados;
		
		$_REQUEST['HISTORICO_CHAMADO'] = $historico;
		
		$this->chamadosView->carregar();
		
	}
	

}

?>