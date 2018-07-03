<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class ChamadosController extends Controller{

	function __construct(){
		
		$this->chamadosView    = new ChamadosView();
		$this->chamadosModel   = new ChamadosModel();
		
		$this->chamadosModel->setTabela('tb_chamados');
		$this->chamadosModel->setTabelaHistorico('tb_historico_chamados');
		
	}
	
	public function carregarCadastro(){
		
		$this->chamadosView->setTitulo('CHAMADOS > ABRIR CHAMADO');
		
		$this->chamadosView->setConteudo('cadastro');
	
		$this->chamadosView->carregar();
		
	}
	
	public function cadastrar(){
		
		$natureza = (isset($_POST['natureza'])) ? $_POST['natureza'] : NULL;
		
		$problema = (isset($_POST['problema'])) ? $_POST['problema'] : NULL;
		
		$servidorSessao = $_SESSION['ID'];
		
		$this->chamadosModel->setNatureza($natureza);
		
		$this->chamadosModel->setProblema($problema);
		
		$this->chamadosModel->setServidorSessao($servidorSessao);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->chamadosModel->cadastrar();
		
		$_SESSION['MENSAGEM'] = $this->chamadosModel->getMensagemResposta();
		
		if($_SESSION['RESULTADO_OPERACAO']){
			Header('Location: /chamados/ativos/');
		}else{
			Header('Location: /chamados/cadastrar/');
		}
		
	}	
	
	public function editar(){
		
		$id = (isset($_GET['id'])) ? $_GET['id'] : NULL;
		
		$this->chamadosModel->setId($id);
		
		$this->chamadosModel->setServidorSessao($_SESSION['ID']);
		
		switch($_GET['operacao']){
			
			case 'status':
		
				$status = (isset($_GET['status'])) ? $_GET['status'] : NULL;
				
				$this->chamadosModel->setStatus($status);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->chamadosModel->editarStatus('chamados', $status, $id);
				
				break;
				
			case 'avaliar':
				
				$avaliacao = (isset($_POST['avaliacao'])) ? $_POST['avaliacao'] : NULL;

				$this->chamadosModel->setAvaliacao($avaliacao);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->chamadosModel->avaliar();
				
				break;
				
			case 'mensagem': 
				
				$mensagem = (isset($_POST['mensagem'])) ? $_POST['mensagem'] : NULL;
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->chamadosModel->enviarMensagem($mensagem);
		
				break;
		
		}
		
		$_SESSION['MENSAGEM'] = $this->chamadosModel->getMensagemResposta();
	
		Header('Location: /chamados/visualizar/'.$id);
		
	}
	
	public function excluir(){
		
		$this->chamadosModel->setID($_GET['id']);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->chamadosModel->excluir();
		
		$_SESSION['MENSAGEM'] = $this->chamadosModel->getMensagemResposta();
		
		Header('Location: /chamados/ativos/');
		
	}
	
	public function listar(){
		
		$this->chamadosModel->setStatus($_GET['status']);
		
		$servidorSessao = ($_SESSION['FUNCAO'] == 'TI') ? NULL : $_SESSION['ID'];
		
		$this->chamadosModel->setServidorSessao($servidorSessao);
		
		$listaChamados = $this->chamadosModel->getListaChamadosStatus();
		
		$titulo = ($_GET['status']=='ATIVO') ? 'CHAMADOS > ATIVOS' : 'CHAMADOS > INATIVOS';
		
		$this->chamadosView->setTitulo($titulo);
		
		$this->chamadosView->setConteudo('lista');
		
		$_REQUEST['LISTA_CHAMADOS'] = $listaChamados;
		
		$this->chamadosView->carregar();
		
	}
	
	public function visualizar(){
		
		$id = $_GET['id'];
		
		$this->chamadosModel->setID($id);
		
		$listaDados = $this->chamadosModel->getDadosID();
		
		$_REQUEST['HISTORICO_CHAMADO']  = $this->chamadosModel->getHistorico();
		
		$this->chamadosView->setTitulo("CHAMADOS > ".$listaDados['ID']." > VISUALIZAR");
		
		$this->chamadosView->setConteudo('visualizar');
		
		$_REQUEST['DADOS_CHAMADO'] = $listaDados;
		
		$this->chamadosView->carregar();
		
	}
	

}

?>