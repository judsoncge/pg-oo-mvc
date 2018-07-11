<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';
require_once $_SESSION['PATH_VIEW'].'ChamadosView.php';


class ChamadosController extends Controller{

	/*
	.inicia o model e o view do modulo chamados
	.
	.definindo a tabela como tb_chamados pois o modulo é de chamados
	.
	.há também a definição da tabela de historico, pois muitas operacoes gravam registros la
	.
	*/
	function __construct(){
	
		$this->chamadosModel = new ChamadosModel();
		$this->chamadosModel->setTabela('tb_chamados');
		$this->chamadosModel->setTabelaHistorico('tb_historico_chamados');
		
		$tipoView = $_SESSION['TYPE_VIEW'];
		$tipoView .= 'ChamadosView';
		$this->chamadosView = new $tipoView();
		
	}
	
	/*
	.esta funcao solicita que a view carregue a pagina de cadastrar
	.
	.a funcao também define o titulo e o conteudo da pagina e pede para que a view carregue a pagina
	*/
	public function carregarCadastro(){
		
		$this->chamadosView->setTitulo('CHAMADOS > ABRIR CHAMADO');
		
		$this->chamadosView->setConteudo('cadastro');
	
		$this->chamadosView->carregar();
		
	}
	
	
	/*
	.esta funcao solicita que a view carregue a pagina de listagem
	.
	.para isso, necessita da lista de chamados para que a view imprima a tabela de registros e solicita ao model
	.
	.o status é passado via get pelo menu selecionado pelo usuario (o link com mais detalhes se vê no .htaccess)
	.
	.a funcao também define o titulo (de acordo com o status) e o conteudo da pagina e pede para que a view carregue a pagina
	*/
	public function listar(){
		
		$this->chamadosModel->setStatus($_GET['status']);
		
		$_REQUEST['LISTA_CHAMADOS'] = $this->chamadosModel->getListaChamadosStatus();
		
		$titulo = ($_GET['status']=='ATIVO') ? 'CHAMADOS > ATIVOS' : 'CHAMADOS > INATIVOS';
		
		$this->chamadosView->setTitulo($titulo);
		
		$this->chamadosView->setConteudo('lista');
		
		$this->chamadosView->carregar();
		
	}
	
	/*
	.esta funcao executa a ação de cadastrar um chamado
	.
	.ela recebe os dados via POST do formulario de cadastro gerado pela view
	.
	.para que os dados sejam cadastrados no banco, o controller seta os dados para o model e pede que ele cadastre
	.
	.a mensagem de sucesso/falha é recebida do model e o resultado de operacao também. se for 1, é porque ocorreu sucesso, se for 0, falha.
	*/
	public function cadastrar(){
		
		$natureza = (isset($_POST['natureza'])) ? $_POST['natureza'] : NULL;
		
		$problema = (isset($_POST['problema'])) ? $_POST['problema'] : NULL;
		
		$this->chamadosModel->setNatureza($natureza);
		
		$this->chamadosModel->setProblema($problema);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->chamadosModel->cadastrar();
		
		$_SESSION['MENSAGEM'] = $this->chamadosModel->getMensagemResposta();
		
		if($_SESSION['RESULTADO_OPERACAO']){
			Header('Location: /chamados/ativos/');
		}else{
			Header('Location: /chamados/cadastrar/');
		}
		
	}	
	

	/*
	.esta funcao executa a ação de editar um chamado
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
		
		$this->chamadosModel->setId($id);
		
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
	
	
	/*
	.esta funcao executa a ação de excluir um chamado
	.
	.a funcao recebe da view o id do chamado a ser excluido
	.
	.o controller seta as informacoes no model e pede que ele exclua
	.
	.a mensagem de sucesso/falha é recebida do model e o resultado de operacao também. se for 1, é porque ocorreu sucesso, se for 0, falha.
	*/
	public function excluir(){
		
		$this->chamadosModel->setID($_GET['id']);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->chamadosModel->excluir();
		
		$_SESSION['MENSAGEM'] = $this->chamadosModel->getMensagemResposta();
		
		Header('Location: /chamados/ativos/');
		
	}
	
	
	/*
	.esta funcao solicita que a view carregue a pagina de visualizar
	.
	.para isso ela recebe da view o id do chamado e solicita todas as informacoes daquele chamado ao model
	.
	.a funcao também define o titulo e o conteudo da pagina e pede para que a view carregue a pagina
	*/
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