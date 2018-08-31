<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';
require_once $_SESSION['PATH_VIEW'].'ProcessosView.php';

class ProcessosController extends Controller{
	
	function __construct(){
		
		$this->processosModel   = new ProcessosModel();
		$this->servidoresModel  = new ServidoresModel();
		$this->setoresModel     = new SetoresModel();
		$this->processosModel->setTabela('tb_processos');
		$this->processosModel->setTabelaHistorico('tb_historico_processos');
		
		$tipoView = $_SESSION['TYPE_VIEW'];
		$tipoView .= 'ProcessosView';
		$this->processosView = new $tipoView();
	}
	
	public function carregarCadastro(){
		
		$_REQUEST['LISTA_ASSUNTOS'] = $this->processosModel->getListaAssuntos();
		
		$_REQUEST['LISTA_ORGAOS'] = $this->processosModel->getListaOrgaos();
		
		$this->processosView->setTitulo('PROCESSOS > ABRIR PROCESSO');
		
		$this->processosView->setConteudo('cadastrar');
	
		$this->processosView->carregar();
		
	}
	
	public function carregarEdicao(){
		
		$id = $_GET['id'];
		
		$this->processosModel->setID($id);
		
		$listaDados = $this->processosModel->getDadosID();
		
		if(!$listaDados){
			
			$_SESSION['RESULTADO_OPERACAO'] = 0;
			
			$_SESSION['MENSAGEM'] = 'Processo não encontrado';
			
			Header('Location: /processos/ativos/0');
		
		}else{
			
			$_REQUEST['LISTA_ASSUNTOS'] = $this->processosModel->getListaAssuntos();
		
			$_REQUEST['LISTA_ORGAOS'] = $this->processosModel->getListaOrgaos();
		
			$this->processosView->setTitulo("PROCESSOS > ".$listaDados['DS_NUMERO']." > EDITAR");
			
			$_REQUEST['DADOS_PROCESSO'] = $listaDados;
			
			$this->processosView->setConteudo('editar');
		
			$this->processosView->carregar();
			
		}
		
	}
	
	public function carregarConsulta(){
		
		$this->processosView->setTitulo('PROCESSOS > CONSULTAR');
		
		$this->processosView->setConteudo('consulta');
	
		$this->processosView->carregar();
		
	}
	
	public function carregarRelatorio(){
		
		$_REQUEST['QTD_PROCESSOS_TOTAL'] = $this->processosModel->getQuantidadeProcessos();
		
		$_REQUEST['QTD_PROCESSOS_ATIVOS'] = $this->processosModel->getQuantidadeProcessosAtivos();
		
		$_REQUEST['QTD_PROCESSOS_ATRASADOS_PRAZO_SETOR'] = $this->processosModel->getQuantidadeProcessosAtrasadosNoPrazoSetor();
		
		$_REQUEST['QTD_PROCESSOS_PRAZO'] = $this->processosModel->getQuantidadeProcessosSituacao(0);
		
		$_REQUEST['QTD_PROCESSOS_ATRASADOS'] = $this->processosModel->getQuantidadeProcessosSituacao(1);
		
		$_REQUEST['QTD_PROCESSOS_ATIVOS_SETOR'] = $this->processosModel->getQuantidadeProcessosSetor();
		
		$_REQUEST['QTD_PROCESSOS_PRAZO_SETOR'] = $this->processosModel->getQuantidadeProcessosSetorSituacao(0);
		
		$_REQUEST['QTD_PROCESSOS_ATRASADOS_SETOR'] = $this->processosModel->getQuantidadeProcessosSetorSituacao(1);
		
		$_REQUEST['QTD_PROCESSOS_ANDAMENTO_SETOR'] = $this->processosModel->getQuantidadeProcessosStatusSetor('EM ANDAMENTO');
		
		$_REQUEST['QTD_PROCESSOS_FINALIZADOS_S_SETOR'] = $this->processosModel->getQuantidadeProcessosStatusSetor('FINALIZADO PELO SETOR');
		
		$_REQUEST['QTD_PROCESSOS_FINALIZADOS_G_SETOR'] = $this->processosModel->getQuantidadeProcessosStatusSetor('FINALIZADO PELO GABINETE');
		
		$_REQUEST['TEMPO_MEDIO_PROCESSO'] = $this->processosModel->getTempoMedioProcessos();
		
		$_REQUEST['TEMPO_MEDIO_ASSUNTO'] = $this->processosModel->getTempoMedioAssunto();
		
		$this->processosView->setTitulo('PROCESSOS > RELATÓRIO');
		
		$this->processosView->setConteudo('relatorio');
	
		$this->processosView->carregar();
		
	}
	
	public function consultar(){
		
		$numero = $_POST['processoConsultar'];
		
		$this->processosModel->setNumero($numero);
		
		$listaDados = $this->processosModel->getDadosNumero();
		
		if(!$listaDados){
			
			$_SESSION['RESULTADO_OPERACAO'] = 0;
			
			$_SESSION['MENSAGEM'] = $this->processosModel->getMensagemResposta();
			
			Header('Location: /processos/consulta/');
		
		}else{
			
			$this->processosModel->setID($listaDados['ID']);
			
			$_REQUEST['DOCUMENTOS_PROCESSO'] = $this->processosModel->getListaDocumentos();
		
			$_REQUEST['HISTORICO_PROCESSO'] = $this->processosModel->getHistorico();
			
			$this->processosView->setTitulo("PROCESSOS > ".$listaDados['DS_NUMERO']." > CONSULTA");
		
			$this->processosView->setConteudo('consultar');
		
			$_REQUEST['DADOS_PROCESSO'] = $listaDados;
			
			$this->processosView->carregar();
		}
		
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
		
		$id = $this->processosModel->getID();
		
		$_SESSION['MENSAGEM'] = $this->processosModel->getMensagemResposta();
		
		if($_SESSION['RESULTADO_OPERACAO']){
			Header("Location: /processos/visualizar/$id");
		}else{
			Header('Location: /processos/cadastrar/');
		}
		
	}	
	
	public function editar(){
		
		$id = (isset($_GET['id'])) ? $_GET['id'] : NULL;
	
		$this->processosModel->setId($id);
		
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
				
				if($_GET['valor'] == 'SAIU' or $_GET['valor'] == 'ARQUIVADO'){
					
					$_SESSION['MENSAGEM'] = $this->processosModel->getMensagemResposta();
					
					Header('Location: /processos/ativos/0');
		
					die();
				
				}
				
				break;
				
			case 'desfazerstatus':
				
				$this->processosModel->setStatus($_GET['valor']);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->desfazerStatus();
				
				break;
				
			case 'voltar':
			
				$this->processosModel->setServidorLocalizacao($_SESSION['ID']);
			
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->voltar();
				
				$_SESSION['MENSAGEM'] = $this->processosModel->getMensagemResposta();
	
				Header('Location: /processos/ativos/0');
				
				die();
				
			case 'desarquivar':
			
				$this->processosModel->setServidorLocalizacao($_SESSION['ID']);
			
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
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->solicitarSobrestado();
				
				break;	
					
			case 'anexardocumento':
			
				$tipo = $_POST['tipo'];
				
				$anexo = $_FILES['arquivoAnexo'];
				
				$this->processosModel->setTipoDocumento($tipo);
				
				$this->processosModel->setAnexoDocumento($anexo);
				
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
			
			$_REQUEST['LISTA_SERVIDORES'] = $this->processosModel->getListaServidoresFiltro();
			
			$_REQUEST['LISTA_SETORES'] = $this->processosModel->getListaSetoresFiltro();
			
			$_REQUEST['LISTA_PROCESSOS'] = $this->processosModel->getListaProcessosStatus();
			
			$_REQUEST['FRASE'] = $this->processosModel->getFraseTabelaProcessosSemFiltro();
			
			$titulo = ($_GET['status']=='ATIVO') ? 'PROCESSOS > ATIVOS' : 'PROCESSOS > INATIVOS';
			
			$this->processosView->setTitulo($titulo);
			
			$this->processosView->setConteudo('listar');
			
			$this->processosView->carregar();
			
		}else{
			
			$this->servidoresModel->setStatus('ATIVO');
			
			$this->processosModel->setStatus($_GET['status']);
			
			$_REQUEST['LISTA_SERVIDORES'] = $this->servidoresModel->getListaServidoresStatus();
			
			$_REQUEST['LISTA_SETORES'] = $this->setoresModel->getSetores();
			
			$filtroServidor = isset($_POST['filtroservidor']) ? $_POST['filtroservidor'] : '%';

			$filtroSetor = isset($_POST['filtrosetor']) ? $_POST['filtrosetor'] : '%';

			$filtroSituacao = isset($_POST['filtrosituacao']) ? $_POST['filtrosituacao'] : '%';

			$filtroSobrestado = isset($_POST['filtrosobrestado']) ? $_POST['filtrosobrestado'] : '%';
			
			$filtroRecebido = isset($_POST['filtrorecebido']) ? $_POST['filtrorecebido'] : '%';

			$filtroDias = isset($_POST['filtrodias']) ? $_POST['filtrodias'] : '%';
			
			$filtroProcesso = isset($_POST['filtroprocesso']) ? $_POST['filtroprocesso'] : '%';
			
			$this->processosModel->setServidorLocalizacao($filtroServidor);
			
			$this->processosModel->setSetorLocalizacao($filtroSetor);
			
			$this->processosModel->setAtrasado($filtroSituacao);
			
			$this->processosModel->setSobrestado($filtroSobrestado);
			
			$this->processosModel->setRecebido($filtroRecebido);
			
			$this->processosModel->setDias($filtroDias);
			
			$this->processosModel->setNumero($filtroProcesso);
			
			$_REQUEST['LISTA_PROCESSOS'] = $this->processosModel->getListaProcessosStatusComFiltro();
			
			$_REQUEST['FRASE'] = $this->processosModel->getFraseTabelaProcessosComFiltro();
		
			$this->processosView->listar();

		}

	}
	
	public function exportar(){
		
		$filtroServidor = $_GET['filtroservidor'];

		$filtroSetor = $_GET['filtrosetor'];

		$filtroSituacao = $_GET['filtrosituacao'];

		$filtroSobrestado = $_GET['filtrosobrestado'];
		
		$filtroRecebido = $_GET['filtrorecebido'];

		$filtroDias = $_GET['filtrodias'];
		
		$filtroProcesso = $_GET['filtroprocesso'];
		
		$this->processosModel->setServidorLocalizacao($filtroServidor);
		
		$this->processosModel->setSetorLocalizacao($filtroSetor);
		
		$this->processosModel->setAtrasado($filtroSituacao);
		
		$this->processosModel->setSobrestado($filtroSobrestado);
		
		$this->processosModel->setRecebido($filtroRecebido);
		
		$this->processosModel->setDias($filtroDias);
		
		$this->processosModel->setNumero($filtroProcesso);
		
		$this->processosModel->setStatus('ATIVO');
	
		$_REQUEST['LISTA_PROCESSOS'] = $this->processosModel->getListaProcessosStatusComFiltro();
		
		$this->processosView->exportar();

	}

	public function visualizar(){
		
		$id = $_GET['id'];
		
		$this->processosModel->setID($id);
		
		$listaDados = $this->processosModel->getDadosID();
		
		if(!$listaDados){
			
			$_SESSION['RESULTADO_OPERACAO'] = 0;
			
			$_SESSION['MENSAGEM'] = 'Processo não encontrado';
			
			Header('Location: /processos/ativos/0');
			
		}else{
		
			$_REQUEST['LISTA_SERVIDORES'] = $this->processosModel->getListaServidoresTramitar();
			
			$_REQUEST['DOCUMENTOS_PROCESSO'] = $this->processosModel->getListaDocumentos();
			
			$_REQUEST['RESPONSAVEIS_PROCESSO'] = $this->processosModel->getListaResponsaveis();
			
			$_REQUEST['PROCESSOS_APENSADOS'] = $this->processosModel->getListaApensados();
		
			$_REQUEST['HISTORICO_PROCESSO'] = $this->processosModel->getHistorico();
			
			$_REQUEST['LISTA_APENSAR'] = $this->processosModel->getListaProcessosApensar();
			
			if($_SESSION['FUNCAO'] != 'PROTOCOLO' AND $_SESSION['FUNCAO'] != 'TÉCNICO ANALISTA' AND $_SESSION['FUNCAO'] != 'TÉCNICO ANALISTA CORREÇÃO'){
			
				$_REQUEST['LISTA_PODEM_SER_RESPONSAVEIS'] = $this->processosModel->getListaPodemSerResponsaveis();	
				
			}
			
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
	
}

?>