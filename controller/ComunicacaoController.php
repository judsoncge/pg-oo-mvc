<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class ComunicacaoController extends Controller{

	function __construct(){
		
		$this->comunicacaoView = new ComunicacaoView();
		$this->comunicacaoModel = new ComunicacaoModel();
		
	}
	
	public function carregarCadastro(){
		
		$this->comunicacaoView->setTitulo('CHAMADOS > CADASTRAR COMUNICAÇÃO');
		
		$this->comunicacaoView->setConteudo('cadastro');
	
		$this->comunicacaoView->carregar();
		
	}
	
	public function cadastrar(){
		
		$natureza = (isset($_POST['natureza'])) ? $_POST['natureza'] : NULL;
		
		$problema = (isset($_POST['problema'])) ? $_POST['problema'] : NULL;
		
		$servidorRequisitante = $_SESSION['ID'];
		
		$this->comunicacaoModel->setNatureza($natureza);
		
		$this->comunicacaoModel->setProblema($problema);
		
		$this->comunicacaoModel->setServidorRequisitante($servidorRequisitante);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->comunicacaoModel->cadastrar();
		
		$_SESSION['MENSAGEM'] = $this->comunicacaoModel->getMensagemResposta();
		
		if($_SESSION['RESULTADO_OPERACAO']){
			Header('Location: /chamados/ativos/');
		}else{
			Header('Location: /chamados/cadastrar/');
		}
		
	}	
	
	public function editar(){
		
		$id = (isset($_GET['id'])) ? $_GET['id'] : NULL;
		
		$this->comunicacaoModel->setId($id);
		
		switch($_GET['operacao']){
			
			case 'status':
		
				$status = (isset($_GET['status'])) ? $_GET['status'] : NULL;
				
				$this->comunicacaoModel->setStatus($status);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->comunicacaoModel->editarStatus('chamados', $status, $id);
				
				break;
				
			case 'avaliar':
				
				$avaliacao = (isset($_POST['avaliacao'])) ? $_POST['avaliacao'] : NULL;

				$this->comunicacaoModel->setAvaliacao($avaliacao);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->comunicacaoModel->avaliar();
				
				break;
				
			case 'mensagem': 
				
				$mensagem = (isset($_POST['mensagem'])) ? $_POST['mensagem'] : NULL;
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->comunicacaoModel->cadastrarHistorico('chamados', $id, 'DISSE: ' . $mensagem, $_SESSION['ID'], 'MENSAGEM');
		
				break;
		
		}
		
		$_SESSION['MENSAGEM'] = $this->comunicacaoModel->getMensagemResposta();
	
		Header('Location: /chamados/visualizar/'.$id);
		
	}
	
	public function excluir(){
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->comunicacaoModel->excluir('tb_chamados', $_GET['id']);
		
		$_SESSION['MENSAGEM'] = $this->comunicacaoModel->getMensagemResposta();
		
		Header('Location: /chamados/ativos/');
		
	}
	
	public function listar(){
		
		$this->comunicacaoModel->setStatus($_GET['status']);
		
		$lista = $this->comunicacaoModel->getListaComunicacaoStatus();
		
		$_REQUEST['LISTA_COMUNICACAO'] = $lista;
		
		$titulo = ($_GET['status']=='ATIVO') ? 'COMUNICAÇÃO > ATIVOS' : 'COMUNICAÇÃO > INATIVOS';
		
		$this->comunicacaoView->setTitulo($titulo);
		
		$this->comunicacaoView->setConteudo('lista');
		
		$this->comunicacaoView->carregar();
		
	}
	
	public function visualizar(){
		
		$id = $_GET['id'];
		
		$this->comunicacaoModel->setID($id);
		
		$listaDados = $this->comunicacaoModel->getDadosID();
		
		$historico  = $this->comunicacaoModel->getHistorico('chamados', $id);
		
		$this->comunicacaoView->setTitulo("CHAMADOS > ".$listaDados['ID']." > VISUALIZAR");
		
		$this->comunicacaoView->setConteudo('visualizar');
		
		$_REQUEST['DADOS_CHAMADO'] = $listaDados;
		
		$_REQUEST['HISTORICO_CHAMADO'] = $historico;
		
		$this->comunicacaoView->carregar();
		
	}
	

}

?>