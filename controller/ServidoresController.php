<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';
require_once $_SESSION['PATH_VIEW'].'ServidoresView.php';

class ServidoresController extends Controller{
	
	function __construct(){

		$this->servidoresModel = new ServidoresModel();		
		$this->setoresModel = new SetoresModel();
		$this->servidoresModel->setTabela('tb_servidores');
		
		$tipoView = $_SESSION['TYPE_VIEW'];
		$tipoView .= 'ServidoresView';
		$this->servidoresView = new $tipoView();
		
	}
	
	public function carregarCadastro(){
		
		$_REQUEST['LISTA_SETORES'] = $this->setoresModel->getSetores();
	
		$this->servidoresView->setTitulo('SERVIDORES > CADASTRAR');
		
		$this->servidoresView->setConteudo('cadastrar');
	
		$this->servidoresView->carregar();
		
	}

	public function listar(){
		
		$this->servidoresModel->setStatus($_GET['status']);
		
		$listaServidores = $this->servidoresModel->getListaServidoresStatus();
		
		$titulo = ($_GET['status']=='ATIVO') ? 'SERVIDORES > ATIVOS' : 'SERVIDORES > INATIVOS';
		
		$this->servidoresView->setTitulo($titulo);
		
		$this->servidoresView->setConteudo('listar');
		
		$_REQUEST['LISTA_SERVIDORES'] = $listaServidores;
		
		$this->servidoresView->carregar();
		
	}
	
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

	public function carregarEdicao(){
		
		switch($_GET['tipo']){
			
			case 'info':			
		
				$this->servidoresModel->setID($_GET['id']);
		
				$_REQUEST['DADOS_SERVIDOR'] = $listaDados = $this->servidoresModel->getDadosID();
				
				if(!$_REQUEST['DADOS_SERVIDOR']){
					
					$_SESSION['RESULTADO_OPERACAO'] = 0;
					
					$_SESSION['MENSAGEM'] = 'Servidor não encontrado';
					
					Header('Location: /servidores/ativos/');
					
					die();
				
				}else{
					
					$_REQUEST['LISTA_SETORES']  = $this->setoresModel->getSetores();
				
					$this->servidoresView->setTitulo("SERVIDORES > ".strtoupper($listaDados['DS_NOME'])." > EDITAR");
					
					break;
				}
			
			case 'senha':
				$this->servidoresView->setTitulo('EDITAR SENHA');
				break;
			
			case 'foto':
				$this->servidoresView->setTitulo('EDITAR FOTO');
				break;
			
			
		}
		
		$this->servidoresView->setConteudo('editar');
		
		$this->servidoresView->setTipoEdicao($_GET['tipo']);
		
		$this->servidoresView->carregar();
		
	}
	
}

?>