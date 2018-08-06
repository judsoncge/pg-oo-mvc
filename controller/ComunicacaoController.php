<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php';
require_once $_SESSION['PATH_VIEW'].'ComunicacaoView.php';

class ComunicacaoController extends Controller{
	
	function __construct(){

		$this->comunicacaoModel = new ComunicacaoModel();
		$this->comunicacaoModel->setTabela('tb_comunicacao');
		
		$tipoView = $_SESSION['TYPE_VIEW'];
		$tipoView .= 'ComunicacaoView';
		$this->comunicacaoView = new $tipoView();
		
	}
	
	public function carregarCadastro(){
		
		$this->comunicacaoView->setTitulo('COMUNICAÇÃO > CADASTRAR COMUNICAÇÃO');
		
		$this->comunicacaoView->setConteudo('cadastrar');
	
		$this->comunicacaoView->carregar();
		
	}
	
	public function listar(){
		
		$this->comunicacaoModel->setStatus($_GET['status']);
		
		$_REQUEST['LISTA_COMUNICACAO'] = $this->comunicacaoModel->getListaComunicacaoStatus();
		
		$titulo = ($_GET['status']=='ATIVO') ? 'COMUNICAÇÃO > ATIVOS' : 'COMUNICAÇÃO > INATIVOS';
		
		$this->comunicacaoView->setTitulo($titulo);
		
		$this->comunicacaoView->setConteudo('listar');
		
		$this->comunicacaoView->carregar();
		
	}
	
	public function carregarEdicao(){
		
		$id = $_GET['id'];
		
		$this->comunicacaoModel->setID($id);
		
		$_REQUEST['DADOS_COMUNICACAO'] = $this->comunicacaoModel->getDadosID();
	
		if(!$_REQUEST['DADOS_COMUNICACAO']){
			
			$_SESSION['RESULTADO_OPERACAO'] = 0;
			
			$_SESSION['MENSAGEM'] = 'Comunicação não encontrada';
			
			Header('Location: /comunicacao/ativos/');
			
		}else{
			
			$_REQUEST['DADOS_IMAGENS'] = $this->comunicacaoModel->getDadosImagensID();
			
			$this->comunicacaoView->setTitulo('COMUNICAÇÃO > EDITAR COMUNICAÇÃO');
			
			$this->comunicacaoView->setConteudo('editar');
		
			$this->comunicacaoView->carregar();
			
		}
		
	}
	
	public function cadastrar(){
		
		$chapeu = (isset($_POST['chapeu'])) ? $_POST['chapeu'] : NULL;
		
		$titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : NULL;
		
		$intertitulo = (isset($_POST['intertitulo'])) ? $_POST['intertitulo'] : NULL;
		
		$creditosTexto = (isset($_POST['creditosTexto'])) ? $_POST['creditosTexto'] : NULL;
		
		$texto = (isset($_POST['texto'])) ? $_POST['texto'] : NULL;
		
		$dataPublicacao = (isset($_POST['dataPublicacao'])) ? $_POST['dataPublicacao'] : NULL;
		
		$anexos = (isset($_FILES['imagens'])) ? $_FILES['imagens'] : NULL;
				
		$legendas = (isset($_POST['legendas'])) ? $_POST['legendas'] : NULL;
		
		$creditos = (isset($_POST['creditos'])) ? $_POST['creditos'] : NULL;
		
		$pequenas = (isset($_POST['pequenas'])) ? $_POST['pequenas'] : NULL;
		
		$this->comunicacaoModel->setChapeu($chapeu);
		
		$this->comunicacaoModel->setTitulo($titulo);
		
		$this->comunicacaoModel->setIntertitulo($intertitulo);
		
		$this->comunicacaoModel->setCreditosTexto($creditosTexto);
		
		$this->comunicacaoModel->setTexto($texto);
		
		$this->comunicacaoModel->setDataPublicacao($dataPublicacao);
		
		$this->comunicacaoModel->setAnexos($anexos);
		
		$this->comunicacaoModel->setLegendas($legendas);
		
		$this->comunicacaoModel->setCreditos($creditos);
		
		$this->comunicacaoModel->setPequenas($pequenas);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->comunicacaoModel->cadastrar();
		
		$_SESSION['MENSAGEM'] = $this->comunicacaoModel->getMensagemResposta();
		
		if($_SESSION['RESULTADO_OPERACAO']){
			Header('Location: /comunicacao/ativos/');
		}else{
			Header('Location: /comunicacao/cadastrar/');
		}
		
	}	

	public function visualizar(){
		
		$id = $_GET['id'];
		
		$this->comunicacaoModel->setID($id);
		
		$_REQUEST['DADOS_COMUNICACAO'] = $this->comunicacaoModel->getDadosID();
		
		if(!$_REQUEST['DADOS_COMUNICACAO']){
			
			$_SESSION['RESULTADO_OPERACAO'] = 0;
			
			$_SESSION['MENSAGEM'] = 'Comunicação não encontrada';
			
			Header('Location: /comunicacao/ativos/');
			
		}else{

			$_REQUEST['IMAGENS_GRANDES'] = $this->comunicacaoModel->getImagens(0);

			$_REQUEST['IMAGENS_PEQUENAS'] = $this->comunicacaoModel->getImagens(1);
			
			$this->comunicacaoView->setConteudo('visualizar');
			
			$this->comunicacaoView->carregar();	
		
		}
		
	}

	public function editar(){
		
		$id = (isset($_GET['id'])) ? $_GET['id'] : NULL;
		
		$this->comunicacaoModel->setId($id);
		
		switch($_GET['operacao']){
			
			case 'status':
		
				$status = (isset($_GET['status'])) ? $_GET['status'] : NULL;
				
				$this->comunicacaoModel->setStatus($status);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->comunicacaoModel->editarStatus();
				
				break;
				
			case 'info':
				
				$chapeu = (isset($_POST['chapeu'])) ? $_POST['chapeu'] : NULL;
		
				$titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : NULL;
				
				$intertitulo = (isset($_POST['intertitulo'])) ? $_POST['intertitulo'] : NULL;
				
				$creditosTexto = (isset($_POST['creditosTexto'])) ? $_POST['creditosTexto'] : NULL;
				
				$texto = (isset($_POST['texto'])) ? $_POST['texto'] : NULL;
				
				$dataPublicacao = (isset($_POST['dataPublicacao'])) ? $_POST['dataPublicacao'] : NULL;
				
				$anexos = (isset($_FILES['imagens'])) ? $_FILES['imagens'] : NULL;
				
				$legendas = (isset($_POST['legendas'])) ? $_POST['legendas'] : NULL;
				
				$creditos = (isset($_POST['creditos'])) ? $_POST['creditos'] : NULL;
				
				$pequenas = (isset($_POST['pequenas'])) ? $_POST['pequenas'] : NULL;
				
				$this->comunicacaoModel->setChapeu($chapeu);
				
				$this->comunicacaoModel->setTitulo($titulo);
				
				$this->comunicacaoModel->setIntertitulo($intertitulo);
				
				$this->comunicacaoModel->setCreditosTexto($creditosTexto);
				
				$this->comunicacaoModel->setTexto($texto);
				
				$this->comunicacaoModel->setDataPublicacao($dataPublicacao);
				
				$this->comunicacaoModel->setAnexos($anexos);
				
				$this->comunicacaoModel->setLegendas($legendas);
				
				$this->comunicacaoModel->setCreditos($creditos);
				
				$this->comunicacaoModel->setPequenas($pequenas);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->comunicacaoModel->editar();
				
				break;
				
			case 'imagem':
				
				$idImagem = $_GET['img'];
				
				$legenda = (isset($_POST['legendaEditar'])) ? $_POST['legendaEditar'] : NULL;
				
				$credito = (isset($_POST['creditosEditar'])) ? $_POST['creditosEditar'] : NULL;
				
				$pequena = (isset($_POST['pequenaEditar'])) ? $_POST['pequenaEditar'] : NULL;
				
				$this->comunicacaoModel->setIDImagem($idImagem);
				
				$this->comunicacaoModel->setLegendas($legenda);
				
				$this->comunicacaoModel->setCreditos($credito);
				
				$this->comunicacaoModel->setPequenas($pequena);
				
				$_SESSION['RESULTADO_OPERACAO'] = $this->comunicacaoModel->editarImagem();
		
				break;
				
			case 'excluir-imagem':
			
				$this->comunicacaoModel->setTabela('tb_anexos_comunicacao');
					
				$this->comunicacaoModel->setID($_GET['img']);
				
				$this->comunicacaoModel->setNomeImagem($_GET['nome']);
				
				$this->comunicacaoModel->excluir();
				
				$this->comunicacaoModel->setTabela('tb_comunicacao');
				
				$this->comunicacaoModel->setID($id);
				
				break;
		
		}
		
		$_SESSION['MENSAGEM'] = $this->comunicacaoModel->getMensagemResposta();
	
		Header('Location: /comunicacao/visualizar/'.$id);
		
	}
	
	public function excluir(){
		
		$this->comunicacaoModel->setID($_GET['id']);
		
		$_SESSION['RESULTADO_OPERACAO'] = $this->comunicacaoModel->excluir();
		
		$_SESSION['MENSAGEM'] = $this->comunicacaoModel->getMensagemResposta();
		
		Header('Location: /comunicacao/ativos/');
		
	}	

}

?>