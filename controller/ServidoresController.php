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
		
		$listaSetores = $this->setoresModel->getListaSetores();
		
		$this->servidoresView->setTitulo("Cadastrar um Servidor");
		
		$this->servidoresView->setTipo("cadastrar");
		
		$this->servidoresView->setListaSetores($listaSetores);
		
		$this->servidoresView->carregar();
		
	}
	
	public function carregarEditar($id){
		
		$listaSetores  = $this->setoresModel->getListaSetores();
		
		$listaDados    = $this->servidoresModel->getDadosId('tb_servidores', $id);
		
		$this->servidoresView->setTitulo('Editar um Servidor');
		
		$this->servidoresView->setTipo('editar');
		
		$this->servidoresView->setLista($listaDados);
		
		$this->servidoresView->setListaSetores($listaSetores);
		
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
		
		$resultado = $this->servidoresModel->cadastrar();
		
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