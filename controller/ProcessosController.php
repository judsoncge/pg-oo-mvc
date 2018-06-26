<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class ProcessosController extends Controller{

	function __construct(){
		
		$this->processosView    = new ProcessosView();
		$this->processosModel   = new ProcessosModel();
		$this->processosModel->setTabela('tb_processos');
		$this->processosModel->setTabelaHistorico('tb_historico_processos');
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
	
	public function carregarEdicao(){
		
		$id = $_GET['id'];
		
		$this->processosModel->setID($id);
		
		$_REQUEST['LISTA_ASSUNTOS'] = $this->processosModel->getListaAssuntos();
		
		$_REQUEST['LISTA_ORGAOS'] = $this->processosModel->getListaOrgaos();
		
		$listaDados = $this->processosModel->getDadosID();
		
		$this->processosView->setTitulo("PROCESSOS > ".$listaDados['DS_NUMERO']." > EDITAR");
		
		$_REQUEST['DADOS_PROCESSO'] = $listaDados;
		
		$this->processosView->setConteudo('edicao');
	
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
		
		$this->processosModel->setServidorSessao($_SESSION['ID']);

		$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->cadastrar();
		
		$_SESSION['MENSAGEM'] = $this->processosModel->getMensagemResposta();
		
		if($_SESSION['RESULTADO_OPERACAO']){
			Header('Location: /processos/ativos/0');
		}else{
			Header('Location: /processos/cadastrar/');
		}
		
	}	
	
	public function editar(){
		
		
		
		$id = (isset($_GET['id'])) ? $_GET['id'] : NULL;
	
		$this->processosModel->setId($id);
		
		$this->processosModel->setServidorSessao($_SESSION['ID']);
		
		switch($_GET['operacao']){
			
			case 'info':
			
				
			
				$numeroParte1 = (isset($_POST['numeroParte1'])) ? $_POST['numeroParte1'] : NULL;
		
				$numeroParte2 = (isset($_POST['numeroParte2'])) ? $_POST['numeroParte2'] : NULL;
				
				$numeroParte3 = (isset($_POST['numeroParte3'])) ? $_POST['numeroParte3'] : NULL;
				
				$numero = $numeroParte1 . ' ' . $numeroParte2 . '/' . $numeroParte3;
				
				$assunto = (isset($_POST['assunto'])) ? $_POST['assunto'] : NULL;
				
				$orgao = (isset($_POST['orgao'])) ? $_POST['orgao'] : NULL;
				
				$interessado = (isset($_POST['interessado'])) ? $_POST['interessado'] : NULL;
				
				$detalhes = (isset($_POST['detalhes'])) ? $_POST['detalhes'] : NULL;
				
				$this->processosModel->setNumero($numero);
				
				$this->processosModel->setAssunto($assunto);
				
				$this->processosModel->setOrgao($orgao);
				
				$this->processosModel->setInteressado($interessado);
				
				$this->processosModel->setDetalhes($detalhes);
				
				$this->processosModel->setServidorSessao($_SESSION['ID']);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->editar();
				
				break;
			
			case 'receber':
			
				$this->processosModel->setServidorLocalizacao($_SESSION['ID']);
		
				$this->processosModel->receber();
				
				break;
				
			case 'devolver':
			
				$this->processosModel->setServidorLocalizacao($_SESSION['ID']);
		
				$this->processosModel->devolver();
				
				Header('Location: /processos/ativos/0');
		
				die();
				
			case 'sobrestado':
			
				$this->processosModel->setSobrestado($_GET['valor']);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->marcarSobrestado();
				
				break;
				
			case 'urgencia':
				
				$this->processosModel->setUrgencia($_GET['valor']);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->marcarUrgencia();
				
				break;
				
			case 'status':
				
				$this->processosModel->setStatus($_GET['valor']);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->editarStatus();
				
				break;
				
			case 'desfazerstatus':
				
				$this->processosModel->setStatus($_GET['valor']);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->desfazerStatus();
				
				break;
				
			case 'voltar':
			
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->voltar();
				
				break;
				
			case 'desarquivar':
			
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->desarquivar();
				
				break;
				
			case 'definirresponsaveis':
			
				$responsaveis = $_POST['responsaveis'];
			
				$this->processosModel->setListaResponsaveis($responsaveis);
			
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->definirResponsaveis();
				
				break;
			
			case 'definirlider':
			
				$lider = $_POST['lider'];
			
				$this->processosModel->setResponsavelLider($lider);
			
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->definirResponsavelLider();
				
				break;
				
			case 'removerresponsavel':
			
				$this->processosModel->setResponsavel($_GET['valor']);
			
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->removerResponsavel();
				
				break;
				
			case 'excluirdocumento':
			
				$this->processosModel->setDocumento($_GET['valor']);
			
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->excluirDocumento();
				
				break;
				
			case 'mensagem': 
				
				$mensagem = (isset($_POST['mensagem'])) ? $_POST['mensagem'] : NULL;
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->enviarMensagem($mensagem);
		
				break;
				
			case 'solicitarsobrestado':
			
				$justificativa = (isset($_POST['justificativa'])) ? $_POST['justificativa'] : NULL;
				
				$this->processosModel->setJustificativaSobrestado($justificativa);
			
				$this->processosModel->setServidorSessao($_SESSION['ID']);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->solicitarSobrestado();
				
				break;	
					
			case 'anexardocumento':
			
				$tipo = $_POST['tipo'];
				
				$anexo = $_FILES['arquivoAnexo'];
				
				$this->processosModel->setTipoDocumento($tipo);
				
				$this->processosModel->setAnexoDocumento($anexo);
				
				$this->processosModel->setServidorSessao($_SESSION['ID']);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->cadastrarDocumento();
				
				break;
				
			case 'apensar':
			
				$apensos = $_POST['apensos'];
			
				$this->processosModel->setListaApensos($apensos);
			
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->apensarProcessos();
				
				break;
				
			case 'removerapenso':
			
				$processoApensado = $_GET['valor'];
			
				$this->processosModel->setApenso($processoApensado);
			
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->removerApenso();
				
				break;
				
			case 'tramitar': 
			
				$servidor = $_POST['tramitar'];
				
				$this->processosModel->setServidorLocalizacao($servidor);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->tramitar();
				
				$_SESSION['MENSAGEM'] = $this->processosModel->getMensagemResposta();
	
				Header('Location: /processos/ativos/0');
		
				die();
		
		}
		
		$_SESSION['MENSAGEM'] = $this->processosModel->getMensagemResposta();
	
		Header('Location: /processos/visualizar/'.$id);
		
	}
	
	public function excluir(){
		
		$this->processosModel->setID($_GET['id']);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->excluir();
		
		$_SESSION['MENSAGEM'] = $this->processosModel->getMensagemResposta();
		
		Header('Location: /processos/ativos/0');
		
	}
	
	public function listar(){
		
		if(!$_GET['filtro']){
			
			$this->processosModel->setStatus($_GET['status']);
		
			$this->processosModel->setServidorLocalizacao($_SESSION['ID']);
			
			$this->servidoresModel->setStatus($_GET['status']);
			
			$_REQUEST['LISTA_SERVIDORES'] = $this->servidoresModel->getListaServidoresStatus();
			
			$_REQUEST['LISTA_SETORES'] = $this->setoresModel->getSetores();
			
			$_REQUEST['LISTA_PROCESSOS'] = $this->processosModel->getListaProcessosStatus();
			
			$titulo = ($_GET['status']=='ATIVO') ? 'PROCESSOS > ATIVOS' : 'PROCESSOS > INATIVOS';
			
			$this->processosView->setTitulo($titulo);
			
			$this->processosView->setConteudo('lista');
			
			$this->processosView->carregar();
			
		}else{
			
			$this->servidoresModel->setStatus('ATIVO');
			
			$this->processosModel->setStatus($_GET['status']);
			
			$_REQUEST['LISTA_SERVIDORES'] = $this->servidoresModel->getListaServidoresStatus();
			
			$_REQUEST['LISTA_SETORES'] = $this->setoresModel->getSetores();
			
			$filtroServidor = $_POST['filtroservidor'];

			$filtroSetor = $_POST['filtrosetor'];

			$filtroSituacao = $_POST['filtrosituacao'];

			$filtroSobrestado = $_POST['filtrosobrestado'];
			
			$filtroRecebido = $_POST['filtrorecebido'];

			$filtroProcesso = $_POST['filtroprocesso'];
			
			$this->processosModel->setServidorLocalizacao($filtroServidor);
			
			$this->processosModel->setSetorLocalizacao($filtroSetor);
			
			$this->processosModel->setAtrasado($filtroSituacao);
			
			$this->processosModel->setSobrestado($filtroSobrestado);
			
			$this->processosModel->setRecebido($filtroRecebido);
			
			$this->processosModel->setNumero($filtroProcesso);
			
			$_REQUEST['LISTA_PROCESSOS'] = $this->processosModel->getListaProcessosStatusComFiltro();
		
			$this->processosView->listar();

		}

	}
	
	public function exportar(){
		
		$filtroServidor = $_GET['filtroservidor'];

		$filtroSetor = $_GET['filtrosetor'];

		$filtroSituacao = $_GET['filtrosituacao'];

		$filtroSobrestado = $_GET['filtrosobrestado'];
		
		$filtroRecebido = $_GET['filtrorecebido'];

		$filtroProcesso = $_GET['filtroprocesso'];
		
		$this->processosModel->setServidorLocalizacao($filtroServidor);
		
		$this->processosModel->setSetorLocalizacao($filtroSetor);
		
		$this->processosModel->setAtrasado($filtroSituacao);
		
		$this->processosModel->setSobrestado($filtroSobrestado);
		
		$this->processosModel->setRecebido($filtroRecebido);
		
		$this->processosModel->setNumero($filtroProcesso);
		
		$this->processosModel->setStatus('ATIVO');
	
		$_REQUEST['LISTA_PROCESSOS'] = $this->processosModel->getListaProcessosStatusComFiltro();
		
		$this->processosView->exportar();

	}
	
	public function visualizar(){
		
		$id = $_GET['id'];
		
		$this->processosModel->setID($id);
		
		$this->processosModel->setServidorSessao($_SESSION['ID']);
		
		$listaDados = $this->processosModel->getDadosID();
		
		$_REQUEST['LISTA_SERVIDORES'] = $this->servidoresModel->getListaServidoresTramitar();
		
		$_REQUEST['DOCUMENTOS_PROCESSO'] = $this->processosModel->getListaDocumentos();
		
		$_REQUEST['RESPONSAVEIS_PROCESSO'] = $this->processosModel->getListaResponsaveis();
		
		$_REQUEST['PROCESSOS_APENSADOS'] = $this->processosModel->getListaApensados();
	
		$_REQUEST['HISTORICO_PROCESSO'] = $this->processosModel->getHistorico();
		
		$_REQUEST['LISTA_PODEM_SER_RESPONSAVEIS'] = $this->processosModel->getListaPodemSerResponsaveis();
		
		$_REQUEST['LISTA_APENSAR'] = $this->processosModel->getListaProcessosApensar();
		
		$_REQUEST['ATIVO'] = ($listaDados['DS_STATUS'] != 'ARQUIVADO' && $listaDados['DS_STATUS'] != 'SAIU') ? 1 : 0;
	
		$this->processosModel->setTabela('tb_processos_apensados');	
	
		$_REQUEST['APENSADO'] = $this->processosModel->verificaExisteRegistro('ID_PROCESSO_APENSADO', $id);
		
		$this->processosModel->setTabela('tb_processos');	
	
		$situacao = ($listaDados['BL_ATRASADO']) ? "<font color='red'> (ATRASADO)</font>" : "<font color='green'> (DENTRO DO PRAZO)</font>";
		
		$this->processosView->setTitulo("PROCESSOS > ".$listaDados['DS_NUMERO']." > VISUALIZAR <br> $situacao");
		
		$this->processosView->setConteudo('visualizar');
		
		$_REQUEST['DADOS_PROCESSO'] = $listaDados;
		
		$this->processosView->carregar();
		
	}
	
}

?>