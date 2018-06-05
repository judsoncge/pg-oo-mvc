<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class ProcessosController extends Controller{

	function __construct(){
		
		$this->processosView    = new ProcessosView();
		$this->processosModel   = new ProcessosModel();
		$this->servidoresModel  = new ServidoresModel();
		$this->setoresModel     = new SetoresModel();
		
	}
	
	public function carregarCadastro(){
		
		$_REQUEST['LISTA_ASSUNTOS'] = $this->processosModel->getListaAssuntos();
		
		$_REQUEST['LISTA_ORGAOS'] = $this->processosModel->getListaOrgaos();
		
		$this->processosView->setTitulo('PROCESSOS > ABRIR PROCESSO');
		
		$this->processosView->setConteudo('cadastro');
	
		$this->processosView->carregar();
		
	}
	
	public function cadastrar(){
		
		$numeroParte1 = (isset($_POST['numeroParte1'])) ? $_POST['numeroParte1'] : NULL;
		
		$numeroParte2 = (isset($_POST['numeroParte2'])) ? $_POST['numeroParte2'] : NULL;
		
		$numeroParte3 = (isset($_POST['numeroParte3'])) ? $_POST['numeroParte3'] : NULL;
		
		$numero = $numeroParte1 . ' ' . $numeroParte2 . '/' . $numeroParte3;
		
		$assunto = (isset($_POST['assunto'])) ? $_POST['assunto'] : NULL;
		
		$orgao = (isset($_POST['orgao'])) ? $_POST['orgao'] : NULL;
		
		$interessado = (isset($_POST['interessado'])) ? $_POST['interessado'] : NULL;
		
		$detalhes = (isset($_POST['detalhes'])) ? $_POST['detalhes'] : NULL;
		
		$servidorLocalizacao = $_SESSION['ID'];
		
		$this->processosModel->setNumero($numero);
		
		$this->processosModel->setAssunto($assunto);
		
		$this->processosModel->setOrgao($orgao);
		
		$this->processosModel->setInteressado($interessado);
		
		$this->processosModel->setDetalhes($detalhes);
		
		$this->processosModel->setServidorLocalizacao($servidorLocalizacao);

		$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->cadastrar();
		
		$_SESSION['MENSAGEM'] = $this->processosModel->getMensagemResposta();
		
		if($_SESSION['RESULTADO_OPERACAO']){
			Header('Location: /processos/cadastrar/');
		}else{
			Header('Location: /processos/cadastrar/');
		}
		
	}	
	
	public function editar(){
		
		$id = (isset($_GET['id'])) ? $_GET['id'] : NULL;
		
		$this->processosModel->setId($id);
		
		switch($_GET['operacao']){
			
			case 'status':
		
				$status = (isset($_GET['status'])) ? $_GET['status'] : NULL;
				
				$this->processosModel->setStatus($status);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->editarStatus('chamados', $status, $id);
				
				break;
				
			case 'avaliar':
				
				$avaliacao = (isset($_POST['avaliacao'])) ? $_POST['avaliacao'] : NULL;

				$this->processosModel->setAvaliacao($avaliacao);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->avaliar();
				
				break;
				
			case 'mensagem': 
				
				$mensagem = (isset($_POST['mensagem'])) ? $_POST['mensagem'] : NULL;
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->cadastrarHistorico('chamados', $id, 'DISSE: ' . $mensagem, $_SESSION['ID'], 'MENSAGEM');
		
				break;
		
		}
		
		$_SESSION['MENSAGEM'] = $this->processosModel->getMensagemResposta();
	
		Header('Location: /chamados/visualizar/'.$id);
		
	}
	
	public function excluir(){
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->excluir('tb_chamados', $_GET['id']);
		
		$_SESSION['MENSAGEM'] = $this->processosModel->getMensagemResposta();
		
		Header('Location: /chamados/ativos/');
		
	}
	
	public function listar(){
		
		$this->processosModel->setStatus($_GET['status']);
		
		$this->processosModel->setServidorLocalizacao($_SESSION['ID']);
		
		$this->servidoresModel->setStatus($_GET['status']);
		
		$_REQUEST['LISTA_SERVIDORES'] = $this->servidoresModel->getListaServidoresStatus();
		
		$_REQUEST['LISTA_SETORES'] = $this->setoresModel->getIDNomeSetores();
		
		$_REQUEST['LISTA_PROCESSOS'] = $this->processosModel->getListaProcessosStatus();
		
		$titulo = ($_GET['status']=='ATIVO') ? 'PROCESSOS > ATIVOS' : 'PROCESSOS > INATIVOS';
		
		$this->processosView->setTitulo($titulo);
		
		$this->processosView->setConteudo('lista');
		
		$this->processosView->carregar();
		
	}
	
	public function visualizar(){
		
		$id = $_GET['id'];
		
		$this->processosModel->setID($id);
		
		$listaDados = $this->processosModel->getDadosID();
		
		$historico  = $this->processosModel->getHistorico('chamados', $id);
		
		$this->processosView->setTitulo("CHAMADOS > ".$listaDados['ID']." > VISUALIZAR");
		
		$this->processosView->setConteudo('visualizar');
		
		$_REQUEST['DADOS_CHAMADO'] = $listaDados;
		
		$_REQUEST['HISTORICO_CHAMADO'] = $historico;
		
		$this->processosView->carregar();
		
	}
	

}

?>