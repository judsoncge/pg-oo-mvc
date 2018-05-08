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
	
	public function editar(){
		
		$this->conectar();
		
		$query = "UPDATE tb_arquivos SET ";
		
		$query .= ($this->tipo != NULL) ? "DS_TIPO = ".$this->tipo.", " : "";  
		
		$query .= ($this->servidorDestino != NULL) ? "ID_SERVIDOR_DESTINO = ".$this->servidorDestino.", " : "";  
		
		if($this->anexo != NULL){
			
			$nomeAnexo = registrarAnexo($this->anexo, $_SERVER['DOCUMENT_ROOT'].'/_registros/anexos/');
			
			$anexoAntigo = $this->getNomeAnexo();
			
			$query .= "DS_ANEXO = ".$nomeAnexo.", ";
			
		}
		
		$query .= ($this->status != NULL) ? "DS_STATUS = '".$this->status."' " : ""; 

		$query .= " WHERE ID='".$this->id."'";
		
		mysqli_query($this->conexao, $query) or die(mysqli_error($this->conexao));
		
		$resultado = mysqli_affected_rows($this->conexao);
		
		$this->desconectar();
		
		if(isset($anexoAntigo)){
			unlink($_SERVER['DOCUMENT_ROOT'].'/_registros/anexos/'.$anexoAntigo);
		}
		
		return $resultado;

	}
	
	public function excluir(){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, 
		
		"DELETE FROM tb_arquivos 
		WHERE ID=".$this->id."
		
		") or die(mysqli_error($this->conexao));
		
		$resultado = mysqli_affected_rows($this->conexao);
		
		$this->desconectar();
		
		if($resultado){
			unlink($_SERVER['DOCUMENT_ROOT']."/_registros/anexos/".$this->anexo);
		}
		
		return $resultado;

	}
	
	public function getNomeAnexo(){
		
		$resultado = mysqli_query($this->conexao, "SELECT DS_ANEXO FROM tb_arquivos WHERE ID = ".$this->id."");
		
		$nomeAnexo = mysqli_fetch_row($resultado);
		
		return $nomeAnexo[0];

	}

}	



















?>