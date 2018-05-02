<?php 

//carregando model de login para verificacao de login e o de comunicacao, pois a pagina de home mostra as noticias
include $_SERVER['DOCUMENT_ROOT'].'/controller/HomeController.php';
include $_SERVER['DOCUMENT_ROOT'].'/model/LoginModel.php';


class LoginController{
	
	private $loginModel;
	private $homeController;
	
	function __construct(){
		
		$this->loginModel = new LoginModel();
		$this->homeController = new homeController();
		
	}

	public function login(){
		
		if(isset($_SESSION['ID'])){
			
			$this->homeController->carregarHome();
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
		
			$this->homeController->carregarHome();
		
		}else{
			
			header("Location: /index.php");
			
		}
		
	}
	
	public function logoff(){
		
		$_SESSION = array();
		
		session_destroy();

		header("Location: /index.php");

	}
	
}

?>