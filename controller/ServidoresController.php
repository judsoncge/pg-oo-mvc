<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class ServidoresController extends Controller{
	
	/*
	.inicia o model e o view do modulo servidores
	.
	.tambem inicia o model de setores pois precisa da lista de setores para imprimir no cadastro
	.
	.definindo a tabela como tb_servidores pois o modulo é de processos
	.
	.há também a definição da tabela de historico, pois muitas operacoes gravam registros la
	.
	*/
	function __construct(){
		
		$this->servidoresModel = new ServidoresModel();		
		$this->servidoresView  = new ServidoresView();
		$this->setoresModel    = new SetoresModel();
		
		$this->servidoresModel->setTabela('tb_servidores');
		
	}
	
	/*
	.esta funcao solicita que a view carregue a pagina de cadastrar
	.
	.para isso ela precisa da lista de setores para que a view monte os selects. as informacoes sao solicitadas ao model
	.
	.a funcao também define o titulo e o conteudo da pagina e pede para que a view carregue a pagina
	*/
	public function carregarCadastro(){
		
		$_REQUEST['LISTA_SETORES'] = $this->setoresModel->getSetores();
	
		$this->servidoresView->setTitulo('SERVIDORES > CADASTRAR');
		
		$this->servidoresView->setConteudo('cadastro');
	
		$this->servidoresView->carregar();
		
	}
	
	/*
	.esta funcao solicita que a view carregue a pagina de listagem
	.
	.o status é passado via get pelo menu selecionado pelo usuario (o link com mais detalhes se vê no .htaccess)
	.
	.a funcao também define o titulo (de acordo com o status) e o conteudo da pagina e pede para que a view carregue a pagina
	*/
	public function listar(){
		
		$this->servidoresModel->setStatus($_GET['status']);
		
		$listaServidores = $this->servidoresModel->getListaServidoresStatus();
		
		$titulo = ($_GET['status']=='ATIVO') ? 'SERVIDORES > ATIVOS' : 'SERVIDORES > INATIVOS';
		
		$this->servidoresView->setTitulo($titulo);
		
		$this->servidoresView->setConteudo('lista');
		
		$_REQUEST['LISTA_SERVIDORES'] = $listaServidores;
		
		$this->servidoresView->carregar();
		
	}
	
	/*
	.esta funcao executa a ação de cadastrar um servidor
	.
	.ela recebe os dados via POST do formulario de cadastro gerado pela view
	.
	.para que os dados sejam cadastrados no banco, o controller seta os dados para o model e pede que ele cadastre
	.
	.a mensagem de sucesso/falha é recebida do model e o resultado de operacao também. se for 1, é porque ocorreu sucesso, se for 0, falha.
	*/
	public function cadastrar(){
		
		$nome = $_POST['nome'];
		
		$cpf = $_POST['CPF'];
		
		$setor = $_POST['setor'];
		
		$funcao = $_POST['funcao'];
		
		$this->servidoresModel->setNome($nome);
		
		$this->servidoresModel->setCPF($cpf);
		
		$this->servidoresModel->setSetor($setor);
		
		$this->servidoresModel->setFuncao($funcao);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->servidoresModel->cadastrar();
		
		$_SESSION['MENSAGEM'] = $this->servidoresModel->getMensagemResposta();
		
		if($_SESSION['RESULTADO_OPERACAO']){
			Header('Location: /servidores/ativos/');
		}else{
			Header('Location: /servidores/cadastrar/');
		}
		
	}	
	
	/*
	.esta funcao executa a ação de editar um servidor
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
		
		$this->servidoresModel->setID($id);
		
		switch($_GET['operacao']){
			
			case 'status':
			
				$status = (isset($_GET['status'])) ? $_GET['status'] : NULL;
				
				$this->servidoresModel->setStatus($status);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->servidoresModel->editarStatus();
				
				$_SESSION['MENSAGEM'] = $this->servidoresModel->getMensagemResposta();
				
				Header('Location: /servidores/ativos/');
				
				break;
			
			case 'info':
				
				$funcao = (isset($_POST['funcao'])) ? $_POST['funcao'] : NULL;
		
				$setor = (isset($_POST['setor'])) ? $_POST['setor'] : NULL;
	
				$nome = (isset($_POST['nome'])) ? $_POST['nome'] : NULL;
		
				$cpf = (isset($_POST['CPF'])) ? $_POST['CPF'] : NULL;
				
				$this->servidoresModel->setNome($nome);
		
				$this->servidoresModel->setCPF($cpf);
				
				$this->servidoresModel->setSetor($setor);
				
				$this->servidoresModel->setFuncao($funcao);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->servidoresModel->editar();
				
				$_SESSION['MENSAGEM'] = $this->servidoresModel->getMensagemResposta();
				
				if($_SESSION['RESULTADO_OPERACAO']){
					Header('Location: /servidores/ativos/');
				}else{
					Header('Location: /servidores/editar/'.$id);
				}
				
				break;
			
			case 'senha':
							
				$senha = (isset($_POST['senha'])) ? $_POST['senha'] : NULL;
		
				$confirmaSenha = (isset($_POST['confirmaSenha'])) ? $_POST['confirmaSenha'] : NULL;
				
				$this->servidoresModel->setSenha($senha);
		
				$this->servidoresModel->setConfirmaSenha($confirmaSenha);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->servidoresModel->editarSenha();
				
				$_SESSION['MENSAGEM'] = $this->servidoresModel->getMensagemResposta();
		
				Header('Location: /servidores/senha/');
				
				break;
			
			case 'foto': 
			
				$foto = (isset($_FILES['arquivoFoto'])) ? $_FILES['arquivoFoto'] : NULL;
				
				$this->servidoresModel->setFoto($foto);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->servidoresModel->editarFoto();
				
				$_SESSION['MENSAGEM'] = $this->servidoresModel->getMensagemResposta();
				
				$_SESSION['FOTO'] = $this->servidoresModel->getFoto();
				
				Header('Location: /servidores/foto/');
			
				break;

		}

	}
	
	/*
	.esta funcao solicita que a view carregue a pagina de edicao
	.
	.para isso ela recebe da view o id do registro a ser editado
	.
	.solicita ao model todas as informacoes daquele registro
	.
	.existe tambem uma variavel tipo recebida via GET informando que tipo de formulario é para ser carregado, se é de informacoes, senha ou foto 
	.
	.se for informacoes, solicita ao model a lista de setores para que a view monte os selects
	.
	.a funcao também define o titulo e o conteudo da pagina e pede para que a view carregue a pagina
	*/
	public function carregarEdicao(){
		
		switch($_GET['tipo']){
			
			case 'info':			
		
				$this->servidoresModel->setID($_GET['id']);
				
				$_REQUEST['LISTA_SETORES']  = $this->setoresModel->getSetores();
		
				$_REQUEST['DADOS_SERVIDOR'] = $listaDados = $this->servidoresModel->getDadosID();
				
				$this->servidoresView->setTitulo("SERVIDORES > ".strtoupper($listaDados['DS_NOME'])." > EDITAR");
				
				break;
			
			case 'senha':
				$this->servidoresView->setTitulo('EDITAR SENHA');
				break;
			
			case 'foto':
				$this->servidoresView->setTitulo('EDITAR FOTO');
				break;
			
			
		}
		
		$this->servidoresView->setConteudo('edicao');
		
		$this->servidoresView->setTipoEdicao($_GET['tipo']);
		
		$this->servidoresView->carregar();
		
	}
	
}

?>