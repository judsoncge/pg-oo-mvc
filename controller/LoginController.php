<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';

class LoginController extends Controller{
	
	function __construct(){
		
		$this->servidoresModel = new servidoresModel();
	
	}
	
	public function login(){
		
		$CPF = (isset($_POST['CPF'])) ? $_POST['CPF'] : NULL;
		
		$senha = (isset($_POST['senha'])) ? $_POST['senha'] : NULL;
		
		$this->servidoresModel->setCPF($CPF);
		
		$this->servidoresModel->setSenha($senha);
		
		$dadosUsuario = $this->servidoresModel->login();
		
		if($dadosUsuario != NULL){
			
			$_SESSION['ID'] = $dadosUsuario[0]['ID'];
			$_SESSION['FUNCAO'] = $dadosUsuario[0]['DS_FUNCAO'];
			$_SESSION['SETOR'] = $dadosUsuario[0]['ID_SETOR'];
			$_SESSION['NOME'] = $dadosUsuario[0]['DS_NOME'];
			$_SESSION['FOTO'] = $dadosUsuario[0]['DS_FOTO'];
			$_SESSION['NOME_SETOR'] = $dadosUsuario[0]['NOME_SETOR'];
			
			switch($_SESSION['FUNCAO']){
				
				case 'PROTOCOLO':
					$pasta = 'protocolo';
					$_SESSION['TYPE_VIEW'] = 'Pro';
					break;
				
				case 'SUPERINTENDENTE':
					$pasta = 'superintendente';
					$_SESSION['TYPE_VIEW'] = 'Sup';
					break;
				
				case 'ASSESSOR TÉCNICO':
					$pasta = 'assessor-tecnico';
					$_SESSION['TYPE_VIEW'] = 'Ass';
					break;
				
				case 'TÉCNICO ANALISTA':
					$pasta = 'tecnico-analista';
					$_SESSION['TYPE_VIEW'] = 'Ta';
					break;
					
				case 'GABINETE':
					$pasta = 'gabinete';
					$_SESSION['TYPE_VIEW'] = 'Gab';
					break;
					
				case 'CONTROLADOR':
					$pasta = 'controlador';
					$_SESSION['TYPE_VIEW'] = 'Con';
					break;
					
				case 'TI':
					$pasta = 'ti';
					$_SESSION['TYPE_VIEW'] = 'Ti';
					break;
				
				case 'COMUNICAÇÃO':
					$pasta = 'comunicacao';
					$_SESSION['TYPE_VIEW'] = 'Com';
					break;
					
				case 'CHEFE DE GABINETE':
					$pasta = 'chefe-gabinete';
					$_SESSION['TYPE_VIEW'] = 'CGab';
					break;
					
				
				case 'TÉCNICO ANALISTA CORREÇÃO':
					$pasta = 'tecnico-analista-correcao';
					$_SESSION['TYPE_VIEW'] = 'Tac';
					break;
				
			}
			
			$_SESSION['PATH_VIEW'] = $_SERVER['DOCUMENT_ROOT']."/view/$pasta/".$_SESSION['TYPE_VIEW']."";
				
			Header('Location: /home');
		
		}else{
			
			header('Location: /index.php');
			
		}
		
	}

	public function logoff(){
		
		$_SESSION = array();
		
		session_destroy();

		header('Location: /index.php');

	}
	
	
}

?>