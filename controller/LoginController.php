<?php 

//carregando model de login para verificacao de login e o de comunicacao, pois a pagina de home mostra as noticias
include $_SERVER['DOCUMENT_ROOT'].'/model/LoginModel.php';
include $_SERVER['DOCUMENT_ROOT'].'/model/ComunicacaoModel.php';
include $_SERVER['DOCUMENT_ROOT'].'/view/HomeView.php';

class LoginController{
	
	public function login(){
	
		if(isset($_SESSION['ID'])){
			
			$this->mostrarHome();
			exit();
			
		}
		
		$CPF = $_POST['CPF'];
		
		$senha = $_POST['senha'];
		
		$loginModel = new LoginModel();
		
		$dadosUsuario = $loginModel->login($CPF, $senha);
		
		if($dadosUsuario != NULL){
			
			$_SESSION['ID']     =  $dadosUsuario['ID'];
			$_SESSION['NOME']   =  $dadosUsuario['NM_SERVIDOR'];
			$_SESSION['SETOR']  =  $dadosUsuario['ID_SETOR'];
			$_SESSION['FOTO']   =  $dadosUsuario['NM_ARQUIVO_FOTO'];
			$_SESSION['FUNCAO'] =  $dadosUsuario['NM_FUNCAO'];
			
			$this->mostrarHome();
		
		}else{
			
			echo "login não encontrado";
			
		}
		
	}

	public function mostrarHome(){
		
		$comunicacaoModel = new ComunicacaoModel();
		
		$listaComunicacao = $comunicacaoModel->getCincoNoticiasMaisAtuais();
		
		$homeView = new HomeView();
		
		$homeView->setTitulo("Bem vindo(a) ao Painel de Gestão, " . $_SESSION['NOME']);
		
		$homeView->setLista($listaComunicacao);
		
		$homeView->carregar();
		
	}
	
	public function logoff(){
		
		$_SESSION = array();

		if(ini_get("session.use_cookies")) {
			
			$params = session_get_cookie_params();
			
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		
		}
		
		session_destroy();

		header("Location:../index.php");

	}
	
}

?>