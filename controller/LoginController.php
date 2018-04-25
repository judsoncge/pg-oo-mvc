<?php 

//carregando model de login para verificacao de login e o de comunicacao, pois a pagina de home mostra as noticias
include $_SERVER['DOCUMENT_ROOT'].'/model/LoginModel.php';
include $_SERVER['DOCUMENT_ROOT'].'/model/ComunicacaoModel.php';
include $_SERVER['DOCUMENT_ROOT'].'/view/HomeView.php';

class LoginController{
	
	//esta funcao valida os dados digitados pelo usuario e passa para o model verificar se existe o usuario
	public function login(){
		
		//primeiro verifica se ja existe uma sessao ativa. se sim, leva direto para a home
		if(isset($_SESSION['ID'])){
			
			$this->mostrarHome();
			exit();
			
		}
		
		//pegando o CPF digitado pelo usuario na tela de login
		$CPF = $_POST['CPF'];
		
		//pegando a senha digitada pelo usuario na tela de login
		$senha = $_POST['senha'];
		
		//criando um model de login para enviar o CPF e senha e ele verificar se existe ou nao usuario
		$loginModel = new LoginModel();
		
		//passando para o model verificar se existe usuario ou nao
		$dadosUsuario = $loginModel->login($CPF, $senha);
		
		//se for diferente de null, ou seja, se existir usuario, pegue as informacoes dele em variaveis de sessao
		if($dadosUsuario != NULL){
			
			//pegando os dados do usuario e guardando em variaveis de sessao, para serem mostradas na tela
			$_SESSION['ID']     =  $dadosUsuario['ID'];
			$_SESSION['NOME']   =  $dadosUsuario['NM_SERVIDOR'];
			$_SESSION['SETOR']  =  $dadosUsuario['ID_SETOR'];
			$_SESSION['FOTO']   =  $dadosUsuario['NM_ARQUIVO_FOTO'];
			$_SESSION['FUNCAO'] =  $dadosUsuario['NM_FUNCAO'];
			
			//depois, chama a pagina home
			$this->mostrarHome();
		
		//se for igual a null, e pq nao encontrou usuario
		}else{
			
			echo "login não encontrado";
			
		}
		
	}

	
	//esta funcao chama a pagina home, que vem de HomeView, importada no comeco do arquivo
	public function mostrarHome(){
		
		//este controller pede ao model de comunicacao as cinco primeiras noticias atuais publicadas para enviar a view
		$comunicacaoModel = new ComunicacaoModel();
		
		$listaComunicacao = $comunicacaoModel->getCincoNoticiasMaisAtuais();
		
		//criando uma view de home passando a lista das cinco noticias para serem mostradas na tela
		$homeView = new HomeView();
		
		$titulo = "Bem vindo(a) ao Painel de Gestão, " . $_SESSION['NOME'];
		
		$homeView->carregar($titulo, $listaComunicacao);
		
	}
	
	//esta funcao efetua o logoff do sistema
	public function logoff(){
		
		// Apaga todas as variáveis da sessão
		$_SESSION = array();

		// Se é preciso matar a sessão, então os cookies de sessão também devem ser apagados.
		// Nota: Isto destruirá a sessão, e não apenas os dados!
		if(ini_get("session.use_cookies")) {
			
			$params = session_get_cookie_params();
			
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		
		}

		// Por último, destrói a sessão
		session_destroy();

		header("Location:../index.php");

	}
	
}

?>