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
	private $legendas;
	private $creditos;
	private $pequenas;
	
	public function setChapeu($chapeu){
		
		$this->chapeu = $chapeu;
		
	}
	
	public function setTitulo($titulo){
		
		$this->titulo = $titulo;
		
	}
	
	public function setIntertitulo($intertitulo){
		
		$this->intertitulo = $intertitulo;
		
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
	
	public function setLegendas($legendas){
		
		$this->legendas = $legendas;
		
	}
	
	public function setCreditos($creditos){
		
		$this->creditos = $creditos;
		
	}
	
	public function setPequenas($pequenas){
		
		$this->pequenas = $pequenas;
		
	}
	
	public function cadastrar(){
		
		$query = "INSERT INTO tb_comunicacao (DS_CHAPEU, DS_TITULO, DS_INTERTITULO, DS_CREDITOS, TX_NOTICIA, DT_PUBLICACAO) VALUES ('".$this->chapeu."','".$this->titulo."','".$this->intertitulo."','".$this->creditosTexto."','".$this->texto."','".$this->dataPublicacao."')";
		
		$id = $this->executarQueryID($query);
		
		foreach ($this->anexos['error'] as $key => $error){
			
			$nomeAnexo = retiraCaracteresEspeciais($this->anexos['name'][$key]);	
				
			$caminho = $_SERVER['DOCUMENT_ROOT'].'/_registros/fotos-noticias/';
		
			if(file_exists($caminho.$nomeAnexo)){ 
				$a = 1;
				while(file_exists($caminho."[$a]".$nomeAnexo."")){
				$a++;
				}
				$nomeAnexo = "[".$a."]".$nomeAnexo;
			}
			if(!move_uploaded_file($this->anexos['tmp_name'][$key], $caminho.$nomeAnexo)){ 
			}
			
			$legenda = addslashes($this->legendas[$key]);
			
			$credito = addslashes($this->creditos[$key]);
			
			$pequena = $this->pequenas[$key];
			
			$query = "INSERT INTO tb_anexos_comunicacao (ID_COMUNICACAO, DS_LEGENDA, DS_CREDITOS, BL_PEQUENA, DS_ARQUIVO) VALUES ('".$id."','".$legenda."','".$credito."','".$pequena."','".$nomeAnexo."')";
			
			$resultado = $this->executarQuery($query);
			 
		}

		return $resultado;
		
	}
	
	public function getCincoNoticiasMaisAtuais(){
		
		$query = "SELECT ID, DS_TITULO, DS_INTERTITULO, DT_PUBLICACAO FROM tb_comunicacao WHERE DS_STATUS = 'PUBLICADA' ORDER BY DT_PUBLICACAO DESC LIMIT 5";
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;
	
	}
	
	public function getListaComunicacaoStatus(){
		
		$restricao_status = ($this->status == 'ATIVO') ? " IN ('OCULTADA', 'PUBLICADA') " : " = 'INATIVA' ";
		
		$query =
		
		"SELECT 
		
		ID, DS_CHAPEU, DS_TITULO, DT_PUBLICACAO, DS_STATUS
		
		FROM tb_comunicacao
		
		WHERE DS_STATUS ".$restricao_status." 
		
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
		
		WHERE ID = ".$this->id."
		
		";
		
		$lista = $this->executarQueryListaID($query);
		
		return $lista;
	}
	
}	

?>