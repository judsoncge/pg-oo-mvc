<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class ChamadosController extends Controller{

	function __construct(){
		
		$this->chamadosView    = new ChamadosView();
		$this->chamadosModel   = new ChamadosModel();
		
	}
	
	public function carregarCadastro(){
		
		$this->chamadosView->setTitulo('CHAMADOS > ABRIR CHAMADO');
		
		$this->chamadosView->setConteudo('cadastro');
	
		$this->chamadosView->carregar();
		
	}
	
	public function listar(){
		
		$this->chamadosModel->setStatus($_GET['status']);
		
		$listaChamados = $this->chamadosModel->getListaChamadosStatus();
		
		$titulo = ($_GET['status']=='ATIVO') ? 'CHAMADOS > ATIVOS' : 'CHAMADOS > INATIVOS';
		
		$this->chamadosView->setTitulo($titulo);
		
		$this->chamadosView->setConteudo('lista');
		
		$_REQUEST['LISTA_CHAMADOS'] = $listaChamados;
		
		$this->chamadosView->carregar();
		
	}
	
	public function cadastrar(){
		
		$nome   = $_POST['nome'];
		
		$cpf    = $_POST['CPF'];
		
		$setor  = $_POST['setor'];
		
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

		$funcao        = (isset($_POST['funcao']))         ? $_POST['funcao']        : NULL;
		
		$setor         = (isset($_POST['setor']))          ? $_POST['setor']         : NULL;
	
		$nome          = (isset($_POST['nome']))           ? $_POST['nome']          : NULL;
		
		$cpf           = (isset($_POST['CPF']))            ? $_POST['CPF']           : NULL;
		
		$status        = (isset($_GET['status']))          ? $_GET['status']         : NULL;
		
		$foto          = (isset($_FILES['arquivoFoto']))    ? $_FILES['arquivoFoto'] : NULL;
		
		$senha         = (isset($_POST['senha']))          ? $_POST['senha']         : NULL;
		
		$confirmaSenha = (isset($_POST['confirmaSenha']))  ? $_POST['confirmaSenha'] : NULL;
		
		$id            = $_GET['id'];

		$this->servidoresModel->setNome($nome);
		
		$this->servidoresModel->setCPF($cpf);
		
		$this->servidoresModel->setSetor($setor);
		
		$this->servidoresModel->setFuncao($funcao);
		
		$this->servidoresModel->setStatus($status);
		
		$this->servidoresModel->setFoto($foto);
		
		$this->servidoresModel->setSenha($senha);
		
		$this->servidoresModel->setConfirmaSenha($confirmaSenha);
		
		$this->servidoresModel->setId($id);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->servidoresModel->editar();
		
		$_SESSION['MENSAGEM'] = $this->servidoresModel->getMensagemResposta();
		
		if($_SESSION['RESULTADO_OPERACAO']){
			Header('Location: /servidores/ativos/');
		}else{
			Header('Location: /servidores/editar/'.$id);
		}
		
		
		
	}
	
	public function carregarEdicao(){
		
		switch($_GET['tipo']){
			
			case 'info':
			
				$listaSetores = $this->setoresModel->getIDNomeSetores();
		
				$this->servidoresModel->setID($_GET['id']);
		
				$listaDados = $this->servidoresModel->getDadosId();
				
				$this->servidoresView->setTitulo("SERVIDORES > ".strtoupper($listaDados['DS_NOME'])." > EDITAR");
				
				$_REQUEST['LISTA_SETORES']  = $listaSetores;
				
				$_REQUEST['DADOS_SERVIDOR'] = $listaDados;
				
				break;
			
			case 'senha':
				$this->servidoresView->setTitulo("EDITAR SENHA");
				break;
			
			case 'foto':
				$this->servidoresView->setTitulo("EDITAR FOTO");
				break;
			
			
		}
		
		
		$this->servidoresView->setConteudo('edicao');
		
		$this->servidoresView->setTipoEdicao($_GET['tipo']);
		
		$this->servidoresView->carregar();
		
	}
	
}

?>