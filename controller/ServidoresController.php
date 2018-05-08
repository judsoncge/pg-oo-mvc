<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class ServidoresController extends Controller{

	function __construct(){
		
		$this->servidoresModel = new ServidoresModel();
		$this->servidoresView  = new ServidoresView();
		$this->setoresModel    = new SetoresModel();
		
	}
	
	public function carregarCadastro(){
		
		$listaSetores = $this->setoresModel->getIDNomeSetores();
		
		$_REQUEST['LISTA_SETORES'] = $listaSetores;
	
		$this->servidoresView->setTitulo('SERVIDORES > CADASTRAR');
		
		$this->servidoresView->setConteudo('cadastro');
	
		$this->servidoresView->carregar();
		
	}
	
	public function listar($status){
		
		$this->servidoresModel->setStatus($status);
		
		$listaServidores = $this->servidoresModel->getListaServidoresStatus();
		
		$titulo = ($status=='ATIVO') ? 'SERVIDORES > ATIVOS' : 'SERVIDORES > INATIVOS';
		
		$this->servidoresView->setTitulo($titulo);
		
		$this->servidoresView->setConteudo('lista');
		
		$_REQUEST['LISTA_SERVIDORES'] = $listaServidores;
		
		$this->servidoresView->carregar();
		
	}
	
	public function carregarEdicao($id){
		
		$listaSetores = $this->setoresModel->getIDNomeSetores();
		
		$listaDados = $this->servidoresModel->getDadosId('tb_servidores', $id);
		
		$this->servidoresView->setTitulo("SERVIDORES > ".strtoupper($listaDados[0]['DS_NOME'])."> EDITAR");
		
		$this->servidoresView->setConteudo('edicao');
		
		$_REQUEST['LISTA_SETORES']  = $listaSetores;
		
		$_REQUEST['DADOS_SERVIDOR'] = $listaDados;
		
		$this->servidoresView->carregar();
		
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
		
		$resultado = $this->servidoresModel->cadastrar();
		
		header("Location: /servidores/ativos/".$resultado);
		
	}	
	
	public function editar(){

		$funcao      = $_POST['funcao'];
		
		$setor       = $_POST['setor'];
	
		$nome        = $_POST['nome'];
		
		$cpf         = $_POST['CPF'];
		
		$id          = $_GET['id'];

		$this->servidoresModel->setNome($nome);
		
		$this->servidoresModel->setCPF($cpf);
		
		$this->servidoresModel->setSetor($setor);
		
		$this->servidoresModel->setFuncao($funcao);
		
		$this->servidoresModel->setId($id);
		
		$resultado = $this->servidoresModel->editar();

		header("Location: /servidores/ativos/".$resultado);
		
	}
	
	public function alterarStatus($id, $status){
		
		$this->servidoresModel->setID($id);
		
		$this->servidoresModel->setStatus($status);
		
		$resultado = $this->servidoresModel->alterarStatus();
		
		header("Location: /arquivos/ativos/".$resultado);
		
	}
	
	public function excluir($id, $anexo){
		
		$this->servidoresModel->setID($id);
		
		$this->servidoresModel->setAnexo($anexo);
		
		$resultado = $this->servidoresModel->excluir();
		
		header("Location: /arquivos/ativos/".$resultado);
	
	}
	
}

?>