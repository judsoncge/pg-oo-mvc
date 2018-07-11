<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';
require_once $_SESSION['PATH_VIEW'].'ProcessosView.php';

class ProcessosController extends Controller{
	
	/*
	.inicia o model e o view do modulo processos, 
	.
	.inicia o model de servidores e setores, pois precisa de informacoes vindo deles
	.
	.definindo a tabela como tb_processos pois o modulo é de processos
	.
	.há também a definição da tabela de historico, pois muitas operacoes gravam registros la
	.
	*/
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
	
	/*
	.esta funcao solicita que a view carregue a pagina de cadastrar
	.
	.para isso ela precisa da lista de assuntos e de orgaos para que a view monte os selects. as informacoes sao solicitadas ao model
	.
	.a funcao também define o titulo e o conteudo da pagina e pede para que a view carregue a pagina
	*/
	public function carregarCadastro(){
		
		$_REQUEST['LISTA_ASSUNTOS'] = $this->processosModel->getListaAssuntos();
		
		$_REQUEST['LISTA_ORGAOS'] = $this->processosModel->getListaOrgaos();
		
		$this->processosView->setTitulo('PROCESSOS > ABRIR PROCESSO');
		
		$this->processosView->setConteudo('cadastro');
	
		$this->processosView->carregar();
		
	}
	
	/*
	.esta funcao solicita que a view carregue a pagina de edicao
	.
	.para isso ela recebe da view o id do registro a ser editado
	.
	.solicita ao model todas as informacoes daquele registro
	.
	.solicita ao model a lista de assuntos e de orgaos para que a view monte os selects
	.
	.a funcao também define o titulo e o conteudo da pagina e pede para que a view carregue a pagina
	*/
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
	
	/*
	.esta funcao solicita que a view carregue a pagina de consulta
	.
	.a funcao também define o titulo e o conteudo da pagina e pede para que a view carregue a pagina
	*/
	public function carregarConsulta(){
		
		$this->processosView->setTitulo('PROCESSOS > CONSULTAR');
		
		$this->processosView->setConteudo('consulta');
	
		$this->processosView->carregar();
		
	}
	
	/*
	.esta funcao solicita que a view carregue a pagina de relatorio
	.
	.para isso ela precisa que o model traga uma serie de dados para que sejam enviados a view e ela mostre as informacoes ao usuario
	.
	.a funcao também define o titulo e o conteudo da pagina e pede para que a view carregue a pagina
	*/
	public function carregarRelatorio(){
		
		$_REQUEST['QTD_PROCESSOS_TOTAL'] = $this->processosModel->getQuantidadeProcessos();
		
		$_REQUEST['QTD_PROCESSOS_ATIVOS'] = $this->processosModel->getQuantidadeProcessosAtivos();
		
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
	
	/*
	.esta funcao executa a ação de consultar um processo
	.
	.ela recebe os dados via POST do formulario de consulta gerado pela view
	.
	.verifica se existe o processo com o numero enviado. se nao, volta para a pagina mostrando a mensagem de erro
	.
	.se sim, solicita ao model que traga as informacoes para serem enviadas ao view
	.
	.a mensagem de sucesso/falha é recebida do model e o resultado de operacao também. se for 1, é porque ocorreu sucesso, se for 0, falha.
	*/
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
	
	/*
	.esta funcao executa a ação de cadastrar um processo
	.
	.ela recebe os dados via POST do formulario de cadastro gerado pela view
	.
	.o numero do processo é recebido em três partes e juntado em uma só no formato 9999 1111/2222
	.
	.para que os dados sejam cadastrados no banco, o controller seta os dados para o model e pede que ele cadastre
	.
	.a mensagem de sucesso/falha é recebida do model e o resultado de operacao também. se for 1, é porque ocorreu sucesso, se for 0, falha.
	*/
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
			Header('Location: /processos/ativos/0');
		}else{
			Header('Location: /processos/cadastrar/');
		}
		
	}	
	
	/*
	.esta funcao executa a ação de editar um processo
	.
	.os dados podem vir de um POST (quando há formulario) ou GET quando vem de uma ação de botão. o id do registro a ser editado é passado via GET
	.
	.a variavel operacao diz o que vai ser editado (o link com mais detalhes se vê no .htaccess)
	.
	.dependendo da operacao, o controller seta no model os dados a serem editados e pede que ele edite
	.
	.a mensagem de sucesso/falha é recebida do model e o resultado de operacao também. se for 1, é porque ocorreu sucesso, se for 0, falha.
	*/
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
	
	/*
	.esta funcao executa a ação de excluir um processo
	.
	.a funcao recebe da view o id do processo a ser excluido
	.
	.o controller seta as informacoes no model e pede que ele exclua
	.
	.a mensagem de sucesso/falha é recebida do model e o resultado de operacao também. se for 1, é porque ocorreu sucesso, se for 0, falha.
	*/
	public function excluir(){
		
		$this->processosModel->setID($_GET['id']);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->processosModel->excluir();
		
		$_SESSION['MENSAGEM'] = $this->processosModel->getMensagemResposta();
		
		Header('Location: /processos/ativos/0');
		
	}
	
	/*
	.esta funcao solicita que a view carregue a pagina de listagem
	.
	.para isso, necessita da lista de servidores e setores para que a view imprima os campos de filtro
	.
	.o status é passado via get pelo menu selecionado pelo usuario (o link com mais detalhes se vê no .htaccess)
	.
	.tambem é passada a variável filtro que verifica se foi alterado algum campo de filtro. se vier 0, é porque não houve alteração. se vier 1, teve.
	.
	.a funcao também define o titulo (de acordo com o status) e o conteudo da pagina e pede para que a view carregue a pagina
	*/
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
			
			$_REQUEST['FRASE'] = $this->processosModel->getFraseTabelaProcessosComFiltro();
		
			$this->processosView->listar();

		}

	}
	
	/*
	.esta funcao solicita que a view exporte em pdf a tabela de processos atual 
	.
	.para isso, pega os valores de todos os campos do filtro para fazer a busca
	.
	.os dados sao setados no model e solicita que ele retorne a lista dos processos
	.
	.a funcao pede que a view execute a exportação
	*/
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
	
	/*
	.esta funcao solicita que a view carregue a pagina de visualizar
	.
	.para isso ela recebe da view o id do chamado e solicita todas as informacoes daquele chamado ao model
	.
	.é solicitado ao model várias listas: de servidores, documentos, responsaveis, historico, processos a apensar para que a view imprima na tela
	.
	.a funcao também define o titulo e o conteudo da pagina e pede para que a view carregue a pagina
	*/
	public function visualizar(){
		
		$id = $_GET['id'];
		
		$this->processosModel->setID($id);
		
		$listaDados = $this->processosModel->getDadosID();
		
		$_REQUEST['LISTA_SERVIDORES'] = $this->processosModel->getListaServidoresTramitar();
		
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