<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';
require_once $_SESSION['PATH_VIEW'].'ArquivosView.php';

class ArquivosController extends Controller{
	
	/*
	.inicia o model e o view do modulo arquivos
	.
	.inicia o model de servidores porque vai precisar de alguma lista de servidores
	.
	.definindo a tabela como tb_arquivos pois o modulo é de arquivos
	.
	*/
	function __construct(){
		
		$this->arquivosModel   = new ArquivosModel();
		$this->servidoresModel = new ServidoresModel();
		$this->arquivosModel->setTabela('tb_arquivos');
		
		$tipoView = $_SESSION['TYPE_VIEW'];
		$tipoView .= 'ArquivosView';
		$this->arquivosView = new $tipoView();
		
	}
	
	/*
	.esta funcao solicita que a view carregue a pagina de cadastrar
	.
	.para isso, necessita da lista de servidores para que a view imprima num select e solicita ao model
	.
	.a funcao também define o titulo e o conteudo da pagina e pede para que a view carregue a pagina
	.
	*/
	public function carregarCadastro(){
		
		$this->servidoresModel->setStatus('ATIVO');
		
		$_REQUEST['LISTA_SERVIDORES'] = $this->servidoresModel->getListaServidoresStatus();
		
		$this->arquivosView->setTitulo('ARQUIVOS > CADASTRAR');
		
		$this->arquivosView->setConteudo('cadastro');
		
		$this->arquivosView->carregar();
	}
	
	/*
	.esta funcao solicita que a view carregue a pagina de listagem
	.
	.para isso, necessita da lista de arquivos para que a view imprima a tabela de registros e solicita ao model
	.
	.o status é passado via get pelo menu selecionado pelo usuario (o link com mais detalhes se vê no .htaccess)
	.
	.a funcao também define o titulo (de acordo com o status) e o conteudo da pagina e pede para que a view carregue a pagina
	*/
	public function listar(){
		
		$this->arquivosModel->setStatus($_GET['status']);
		
		$this->arquivosModel->setServidorCriacao($_SESSION['ID']);
		
		$_REQUEST['LISTA_ARQUIVOS'] = $this->arquivosModel->getListaArquivosStatus();
		
		$titulo = ($_GET['status']=='ATIVO') ? 'ARQUIVOS > ATIVOS' : 'ARQUIVOS > INATIVOS';
		
		$this->arquivosView->setTitulo($titulo);
		
		$this->arquivosView->setConteudo('lista');
		
		$this->arquivosView->carregar();
		
	}
	
	
	/*
	.esta funcao executa a ação de cadastrar um arquivo
	.
	.ela recebe os dados via POST do formulario de cadastro gerado pela view
	.
	.para que os dados sejam cadastrados no banco, o controller seta os dados para o model e pede que ele cadastre
	.
	.a mensagem de sucesso/falha é recebida do model e o resultado de operacao também. se for 1, é porque ocorreu sucesso, se for 0, falha.
	*/
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
	
	/*
	.esta funcao executa a ação de editar um arquivo
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
		
		$this->arquivosModel->setID($id);
		
		switch($_GET['operacao']){
			
			case 'status':
				
				$status = (isset($_GET['status'])) ? $_GET['status'] : NULL;
				
				$this->arquivosModel->setStatus($status);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->arquivosModel->editarStatus();
				
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
	
	
	/*
	.esta funcao executa a ação de excluir um arquivo
	.
	.a funcao recebe da view o id e o nome do arquivo a ser excluido
	.
	.o controller seta as informacoes no model e pede que ele exclua
	.
	.a mensagem de sucesso/falha é recebida do model e o resultado de operacao também. se for 1, é porque ocorreu sucesso, se for 0, falha.
	*/
	public function excluir(){
		
		$this->arquivosModel->setID($_GET['id']);
		
		$this->arquivosModel->setAnexo($_GET['anexo']);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->arquivosModel->excluir();
		
		$_SESSION['MENSAGEM'] = $this->arquivosModel->getMensagemResposta();
		
		Header('Location: /arquivos/ativos/');
	
	}
	
}

?>