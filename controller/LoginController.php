<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class LoginController extends Controller{
	
	function __construct(){
		
		$this->loginModel       = new LoginModel();
		$this->homeView         = new HomeView();
		$this->comunicacaoModel = new ComunicacaoModel();
		
	}

	public function login(){
		
		if(isset($_SESSION['ID'])){
			
			$this->carregarHome();
			exit();
			
		}
		
		$CPF = (isset($_POST['CPF'])) ? $_POST['CPF'] : NULL ;
		
		$senha = (isset($_POST['senha'])) ? $_POST['senha'] : NULL ;
		
		$dadosUsuario = $this->loginModel->login($CPF, $senha);
		
		if($dadosUsuario != NULL){
			
			$_SESSION['ID']     =  $dadosUsuario['ID'];
			$_SESSION['FUNCAO'] =  $dadosUsuario['DS_FUNCAO'];
			$_SESSION['SETOR']  =  $dadosUsuario['ID_SETOR'];
			$_SESSION['NOME']   =  $dadosUsuario['DS_NOME'];
			$_SESSION['FOTO']   =  $dadosUsuario['DS_FOTO'];
		
			$this->carregarHome();
		
		}else{
			
			header("Location: /index.php");
			
		}
		
	}
	
	public function carregarHome(){
		
		$listaComunicacao = $this->comunicacaoModel->getCincoNoticiasMaisAtuais();
		
		$this->homeView->setTitulo("Bem vindo(a) ao Painel de Gestão, " . $_SESSION['NOME']);
		
		$_REQUEST['LISTA_NOTICIAS'] = $listaComunicacao;
		
		$this->homeView->setPagina('home');
		
		$this->homeView->carregar();
		
	}
	
	public function logoff(){
		
		$_SESSION = array();
		
		session_destroy();

		header("Location: /index.php");

	}
	
}

?>