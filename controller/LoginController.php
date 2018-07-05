<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/controller/HomeController.php';

class LoginController extends Controller{
	
	/*
	.inicia o model de login
	.
	.inicia o controller de home para fazer um redirecionamento
	*/
	function __construct(){
		
		$this->loginModel = new LoginModel();
		$this->homeController = new HomeController();
		
	}
	
	/*
	.esta funcao verifica se as credenciais digitadas pelo usuario existem no banco de dados
	.
	.primeiramente verifica se ja existe sessao. se sim, ja leva o usuario ativo para a pagina de home
	.
	.a funcao pega as credenciais, seta no model e pede que ele faça a verificacao
	.
	.se retornar uma lista de informacoes, é porque encontrou um registro e grava todas as informacoes na variavel de sessao
	.
	.se nao, leva de volta para a pagina de login
	*/
	public function login(){
		
		if(isset($_SESSION['ID'])){
			
			$this->homeController->listar();
			exit();
			
		}
		
		$CPF = (isset($_POST['CPF'])) ? $_POST['CPF'] : NULL ;
		
		$senha = (isset($_POST['senha'])) ? $_POST['senha'] : NULL ;
		
		$dadosUsuario = $this->loginModel->login($CPF, $senha);
		
		if($dadosUsuario != NULL){
			
			$_SESSION['ID']     =     $dadosUsuario['ID'];
			$_SESSION['FUNCAO'] =     $dadosUsuario['DS_FUNCAO'];
			$_SESSION['SETOR']  =     $dadosUsuario['ID_SETOR'];
			$_SESSION['NOME']   =     $dadosUsuario['DS_NOME'];
			$_SESSION['FOTO']   =     $dadosUsuario['DS_FOTO'];
			$_SESSION['NOME_SETOR'] = $dadosUsuario['NOME_SETOR'];
		
			$this->homeController->listar();
		
		}else{
			
			header('Location: /index.php');
			
		}
		
	}
	
	//efetua logoff no sistema
	public function logoff(){
		
		$_SESSION = array();
		
		session_destroy();

		header('Location: /index.php');

	}
	
}

?>