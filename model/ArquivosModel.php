<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Model.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/FuncoesGlobais.php';

class ArquivosModel extends Model{
	
	private $id;
	private $tipo;
	private $dataCriacao;
	private $servidorCriacao;
	private $servidorDestino;
	private $status;
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
	
	public function getServidorEnviado(){
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
	
	public function setServidorEnviado($servidorDestino){
		$this->servidorDestino = $servidorDestino;
	}
	
	public function setStatus($status){
		$this->status = $status;
	}
	
	public function setAnexo($anexo){
		$this->anexo = $anexo;
	}
	
	public function cadastrar(){
		
		$this->conectar();
		
		$data = date('Y-m-d');
		
		$nomeAnexo = registrarAnexo($this->anexo, $_SERVER['DOCUMENT_ROOT'].'/_registros/anexos/');
	
		mysqli_query($this->conexao, 
		
		"INSERT INTO tb_arquivos 
		
		(DS_TIPO, DT_CRIACAO, ID_SERVIDOR_CRIACAO, ID_SERVIDOR_DESTINO, DS_STATUS, DS_ANEXO)
		
		VALUES
		
		('".$this->tipo."','".$data."','".$_SESSION['ID']."','".$this->servidorDestino."','ATIVO', '".$nomeAnexo."')
		
		");
		
		$cadastrou = mysqli_affected_rows($this->conexao);
		
		$this->desconectar();
		
		return $cadastrou;
		
	}

	public function getListaArquivosStatus(){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, 
		
		"SELECT 
		
		a.ID, a.DS_TIPO, a.DT_CRIACAO, a.ID_SERVIDOR_CRIACAO, a.DS_STATUS, a.DS_ANEXO, 
		
		s1.DS_NOME NOME_SERVIDOR_CRIACAO,
		
		s2.DS_NOME NOME_SERVIDOR_DESTINO
		
		FROM  tb_arquivos a
		
		INNER JOIN tb_servidores s1 ON a.ID_SERVIDOR_CRIACAO = s1.ID 
		
		INNER JOIN tb_servidores s2 ON a.ID_SERVIDOR_DESTINO = s2.ID 
		
		WHERE a.DS_STATUS = '".$this->status."' 
		
		AND   (a.ID_SERVIDOR_CRIACAO = ".$this->servidorCriacao." 
		
		OR    a.ID_SERVIDOR_DESTINO = ".$this->servidorCriacao.") ORDER BY a.DT_CRIACAO desc
		
		");
		
		$listaArquivos = array();
	
		While($row = mysqli_fetch_array($resultado)){ 
			array_push($listaArquivos, $row); 
		} 
		
		$this->desconectar();
		
		return $listaArquivos;
		
	}
	
	public function alterarStatus(){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, 
		
		"UPDATE tb_arquivos 
		SET DS_STATUS='$this->status'
		WHERE ID='$this->id'
		
		") or die(mysqli_error($this->conexao));
		
		$inativou = mysqli_affected_rows($this->conexao);
		
		$this->desconectar();
		
		return $inativou;

	}
	
	public function excluir(){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, 
		
		"DELETE FROM tb_arquivos 
		WHERE ID='$this->id'
		
		") or die(mysqli_error($this->conexao));
		
		$excluiu = mysqli_affected_rows($this->conexao);
		
		$this->desconectar();
		
		if($excluiu){
			unlink($_SERVER['DOCUMENT_ROOT']."/_registros/anexos/$this->anexo");
		}
		
		return $excluiu;

	}

}	



















?>