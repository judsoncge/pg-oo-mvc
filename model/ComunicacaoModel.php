<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Model.php';

class ComunicacaoModel extends Model{
	
	private $chapeu;
	private $titulo;
	private $intertitulo;
	private $creditosTexto;
	private $texto;
	private $dataPublicacao;
	private $anexos;
	private $idImagem;
	private $legendas;
	private $creditos;
	private $pequenas;
	private $nomeImagem;
	
	public function setChapeu($chapeu){
		
		$this->chapeu = addslashes($chapeu);
		
	}
	
	public function setTitulo($titulo){
		
		$this->titulo = addslashes($titulo);
		
	}
	
	public function setIntertitulo($intertitulo){
		
		$this->intertitulo = addslashes($intertitulo);
		
	}
	
	public function setCreditosTexto($creditosTexto){
		
		$this->creditosTexto = $creditosTexto;
		
	}
	
	public function setTexto($texto){
		
		$this->texto = $texto;
	
	}
	
	public function setDataPublicacao($dataPublicacao){
		
		$this->dataPublicacao = $dataPublicacao;
		
	}
	
	public function setAnexos($anexos){
		
		$this->anexos = $anexos;
		
	}
	
	public function setIDImagem($idImagem){
		
		$this->idImagem = $idImagem;
		
	}
	
	public function setLegendas($legendas){
		
		$this->legendas = $legendas;
		
	}
	
	public function setCreditos($creditos){
		
		$this->creditos = $creditos;
		
	}
	
	public function setPequenas($pequenas){
		
		$this->pequenas = $pequenas;
		
	}
	
	public function setNomeImagem($nomeImagem){
		
		$this->nomeImagem = $nomeImagem;
		
	}
	
	public function cadastrar(){
		
		$query = "INSERT INTO tb_comunicacao (DS_CHAPEU, DS_TITULO, DS_INTERTITULO, DS_CREDITOS, TX_NOTICIA, DT_PUBLICACAO) VALUES ('$this->chapeu','$this->titulo','$this->intertitulo','$this->creditosTexto','$this->texto','$this->dataPublicacao')";
		
		$this->setID($this->executarQueryID($query));
		
		$resultado = $this->cadastrarImagens($this->id);
			
		return $resultado;
	
	}
	
	public function editar(){
		
		$query = "UPDATE tb_comunicacao SET DS_CHAPEU = '$this->chapeu', DS_TITULO = '$this->titulo', DS_INTERTITULO = '$this->intertitulo', DS_CREDITOS = '$this->creditosTexto', TX_NOTICIA = '$this->texto', DT_PUBLICACAO = '$this->dataPublicacao' WHERE ID = $this->id";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarImagens($this->id);

		return $resultado;
		
	}
	
	public function editarImagem(){
		
		$query = "UPDATE tb_anexos_comunicacao SET DS_LEGENDA = '$this->legendas', DS_CREDITOS = '$this->creditos', BL_PEQUENA = $this->pequenas WHERE ID = $this->idImagem";
		
		$resultado = $this->executarQuery($query);

		return $resultado;
		
	}
	
	public function cadastrarImagens(){
		
		if($this->anexos != NULL){
		
			foreach ($this->anexos['error'] as $key => $error){
					
				$nomeAnexo = $this->retiraCaracteresEspeciais($this->anexos['name'][$key]);	
					
				$caminho = $_SERVER['DOCUMENT_ROOT'].'/_registros/fotos-noticias/';
			
				if(file_exists($caminho.$nomeAnexo)){ 
					$a = 1;
					while(file_exists($caminho."[$a]".$nomeAnexo."")){
					$a++;
					}
					$nomeAnexo = "[".$a."]".$nomeAnexo;
				}
				
				move_uploaded_file($this->anexos['tmp_name'][$key], $caminho.$nomeAnexo);
				
				$legenda = addslashes($this->legendas[$key]);
				
				$credito = addslashes($this->creditos[$key]);
				
				$pequena = $this->pequenas[$key];
				
				$query = "INSERT INTO tb_anexos_comunicacao (ID_COMUNICACAO, DS_LEGENDA, DS_CREDITOS, BL_PEQUENA, DS_ARQUIVO) VALUES ('$this->id','$legenda','$credito','$pequena','$nomeAnexo')";
				
				$resultado = $this->executarQuery($query);
				
				$mensagemResposta = ($resultado) 
					? 'Operação realizada com sucesso!' 
					: 'Ocorreu alguma falha na operação. Por favor, procure o suporte';
					
				$this->setMensagemResposta($mensagemResposta);
				
			}
			
			return $resultado;
			
		}else{
			$mensagemResposta = 'Operação realizada com sucesso!';
			
			$this->setMensagemResposta($mensagemResposta);
			
			return 1;
			
		}
	}
	
	public function getCincoNoticiasMaisAtuais(){
		
		$query = "SELECT ID, DS_TITULO, DS_INTERTITULO, DATE_FORMAT(DT_PUBLICACAO, '%d/%m/%Y às %H:%i') DT_NOTICIA FROM tb_comunicacao WHERE DS_STATUS = 'PUBLICADA' ORDER BY DT_PUBLICACAO DESC LIMIT 5";
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;
	
	}
	
	public function getListaComunicacaoStatus(){
		
		$restricao_status = ($this->status == 'ATIVO') ? " IN ('OCULTADA', 'PUBLICADA') " : " = 'INATIVA' ";
		
		$query =
		
		"SELECT 
		
		ID, DS_CHAPEU, DS_TITULO, DT_PUBLICACAO, DS_STATUS
		
		FROM tb_comunicacao
		
		WHERE DS_STATUS $restricao_status
		
		ORDER BY DT_PUBLICACAO desc
		
		";
	
		$lista = $this->executarQueryLista($query);
		
		return $lista;
		
	}

	public function getImagens($tamanho){

		$query = "SELECT * FROM tb_anexos_comunicacao WHERE BL_PEQUENA = $tamanho AND ID_COMUNICACAO = $this->id";

		$lista = $this->executarQueryLista($query);
		
		return $lista;
	
	}
	
	public function getDadosImagensID(){
		
		$query = "SELECT * FROM tb_anexos_comunicacao WHERE ID_COMUNICACAO = $this->id";

		$lista = $this->executarQueryLista($query);
		
		return $lista;
		
	}

	public function getDadosID(){
		
		$query =
		
		"SELECT 
		
		ID, DS_CHAPEU, DS_TITULO, DS_INTERTITULO, DS_CREDITOS, TX_NOTICIA, DATE_FORMAT(DT_PUBLICACAO, '%Y-%m-%dT%H:%i') AS DT_PUBLICACAO, DS_STATUS
		
		FROM tb_comunicacao
		
		WHERE ID = '$this->id'
		
		";
		
		$lista = $this->executarQueryListaID($query);
		
		return $lista;
	}
	
	public function excluir(){
		
		switch($this->tabela){
			
			case 'tb_comunicacao':
			
				$query = "SELECT DS_ARQUIVO FROM tb_anexos_comunicacao WHERE ID_COMUNICACAO = $this->id";
		
				$listaNomesImagens = $this->executarQueryLista($query);
		
				foreach($listaNomesImagens as $imagem){
			
					$this->excluirArquivo('fotos-noticias', $imagem['DS_ARQUIVO']);
			
				}
				
				break;
				
			case 'tb_anexos_comunicacao':
			
				$this->excluirArquivo('fotos-noticias', $this->nomeImagem);
				
				break;
		
		}

		$resultado = parent::excluir();		
		
		return $resultado;
		
	}
	
}	

?>