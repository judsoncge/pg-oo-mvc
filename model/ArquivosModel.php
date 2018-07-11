<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Model.php';

class ArquivosModel extends Model{

	private $tipo;
	private $dataCriacao;
	private $servidorCriacao;
	private $servidorDestino;
	private $anexo;
	
	public function getID(){
		return $this->id;
	}
	
	public function getTipo(){
		return $this->tipo;
	}
	
	public function getDataCriacao(){
		return $this->dataCriacao;
	}
	
	public function getServidorCriacao(){
		return $this->servidorCriacao;
	}
	
	public function getServidorDestino(){
		return $this->servidorDestino;
	}
	
	public function getStatus(){
		return $this->status;
	}
	
	public function getAnexo(){
		return $this->anexo;
	}
	
	public function setID($id){
		$this->id = $id;
	}
	
	public function setTipo($tipo){
		$this->tipo = $tipo;
	}
	
	public function setDataCriacao($dataCriacao){
		$this->dataCriacao = $dataCriacao;
	}
	
	public function setServidorCriacao($servidorCriacao){
		$this->servidorCriacao = $servidorCriacao;
	}
	
	public function setServidorDestino($servidorDestino){
		$this->servidorDestino = $servidorDestino;
	}
	
	public function setStatus($status){
		$this->status = $status;
	}
	
	public function setAnexo($anexo){
		$this->anexo = $anexo;
	}
	
	public function cadastrar(){
		
		$data = date('Y-m-d');
		
		$nomeAnexo = $this->registrarAnexo($this->anexo, 'anexos');
	
		$query = "INSERT INTO tb_arquivos (DS_TIPO, DT_CRIACAO, ID_SERVIDOR_CRIACAO, ID_SERVIDOR_DESTINO, DS_STATUS, DS_ANEXO) VALUES ('$this->tipo','$data', ".$_SESSION['ID']." , $this->servidorDestino, 'ATIVO', '$nomeAnexo')";
		
		$resultado = $this->executarQuery($query);
		
		return $resultado;
		
	}
	
	public function editar(){
		
		$query = "UPDATE tb_arquivos SET DS_TIPO = '$this->tipo', ID_SERVIDOR_DESTINO = $this->servidorDestino WHERE ID = $this->id";

		$resultado = $this->executarQuery($query);
		
		return $resultado;

	}
	
	public function excluir(){
		
		$this->excluirArquivo('anexos', $this->anexo);
		
		$resultado = parent::excluir();
		
		return $resultado;

	}

	public function getListaArquivosStatus(){
		
		$restricao_status = ($this->status == 'ATIVO') ? " IN ('ATIVO', 'APROVADO') " : " = 'INATIVO' ";
		
		$query = 
		
		"SELECT 
		
		a.ID, a.DS_TIPO, a.DT_CRIACAO, a.ID_SERVIDOR_CRIACAO, a.DS_STATUS, a.DS_ANEXO, 
		
		s1.DS_NOME NOME_SERVIDOR_CRIACAO,
		
		s2.DS_NOME NOME_SERVIDOR_DESTINO
		
		FROM  tb_arquivos a
		
		INNER JOIN tb_servidores s1 ON a.ID_SERVIDOR_CRIACAO = s1.ID 
		
		INNER JOIN tb_servidores s2 ON a.ID_SERVIDOR_DESTINO = s2.ID 
		
		WHERE a.DS_STATUS $restricao_status
		
		AND   (a.ID_SERVIDOR_CRIACAO = $this->servidorCriacao
		
		OR    a.ID_SERVIDOR_DESTINO = $this->servidorCriacao) 
		
		ORDER BY a.DT_CRIACAO desc
		
		";
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;
		
	}

}	

?>