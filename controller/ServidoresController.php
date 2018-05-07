<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class ServidoresController extends Controller{

	function __construct(){
		
		$this->servidoresModel = new ServidoresModel();
		$this->servidoresView  = new ServidoresView();
		$this->setoresModel    = new SetoresModel();
		
	}
	
	public function carregarLista($status){
		
		$this->servidoresModel->setStatus($status);
		
		$listaServidores = $this->servidoresModel->getListaServidoresStatus();
		
		$titulo = ($status=='ATIVO') ? "Servidores Ativos" : "Servidores Inativos";
		
		$this->servidoresView->setTitulo($titulo);
		
		$this->servidoresView->setTipo("listagem");
		
		$this->servidoresView->setLista($listaServidores);
		
		$this->servidoresView->carregar();
		
	}
	
	public function carregarCadastrar(){
		
		
		$this->servidoresView->setTitulo('Cadastrar um Servidor');
		
		$this->servidoresView->setTipo('cadastrar');
	
		$this->servidoresView->carregar();
		
	}
	
	public function carregarEditar($id){
		
		$listaSetores = $this->setoresModel->getListaSetores();
		
		$listaDados = $this->servidoresModel->getDadosId('tb_servidores', $id);
		
		$this->servidoresView->setTitulo('Editar um Servidor');
		
		$this->servidoresView->setTipo('formulario');
		
		$this->servidoresView->setListaSetores($listaSetores);
		
		$this->servidoresView->setNome($listaDados['DS_NOME']);
		
		$this->servidoresView->setCPF($listaDados['DS_CPF']);
		
		$this->servidoresView->setIdSetor($listaDados['ID_SETOR']);
		
		$this->servidoresView->setNomeSetor($listaDados['DS_NOME_SETOR']);
		
		$this->servidoresView->setFuncao($listaDados['DS_FUNCAO']);	
		
		$this->servidoresView->setNomeBotao('Editar');	
		
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