<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/controller/HomeController.php';

class LoginController extends Controller{
	
	function __construct(){
		
		$this->loginModel = new LoginModel();
		$this->homeController = new HomeController();
		
	}

	public function login(){
		
		if(isset($_SESSION['ID'])){
			
			$this->homeController->listar();
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
		
			$this->homeController->listar();
		
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