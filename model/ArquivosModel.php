<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/BancoDados.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/FuncoesGlobais.php';

class ArquivosModel extends BancoDados{
	
	private $tipo;
	private $dataCriacao;
	private $servidorCriacao;
	private $servidorEnviado;
	private $status;
	private $anexo;
	
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
		return $this->servidorEnviado;
	}
	
	public function getStatus(){
		return $this->status;
	}
	
	public function getAnexo(){
		return $this->anexo;
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
	
	public function setServidorEnviado($servidorEnviado){
		$this->servidorEnviado = $servidorEnviado;
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
		
		//$nomeAnexo = registrarAnexo($this->anexo, $_SERVER['DOCUMENT_ROOT'].'/_registros/anexos/');
	
		//mysqli_query($this->conexao, 
		
		//"INSERT INTO tb_arquivos 
		//(NM_TIPO, DT_CRIACAO, ID_SERVIDOR_CRIACAO, ID_SERVIDOR_ENVIADO, NM_STATUS, NM_ANEXO)
		
		//VALUES
		
		//('".$this->tipo."','".$data."','".$_SESSION['ID']."','".$this->servidorEnviado."','ATIVO', '".$nomeAnexo."')
		
		//");
		
		$cadastrou = mysqli_affected_rows($this->conexao);
		
		$this->desconectar();
		
		
	}

	public function getListaArquivosStatus(){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, 
		
		"SELECT a.*, s1.NM_SERVIDOR CRIACAO, s2.NM_SERVIDOR ENVIADO 
		FROM tb_arquivos a
		INNER JOIN tb_servidores s1 ON a.ID_SERVIDOR_CRIACAO = s1.ID 
		INNER JOIN tb_servidores s2 ON a.ID_SERVIDOR_ENVIADO = s2.ID 
		WHERE a.NM_STATUS = '".$this->status."' 
		AND (a.ID_SERVIDOR_CRIACAO = ".$this->servidorCriacao." 
		OR a.ID_SERVIDOR_ENVIADO = ".$this->servidorCriacao.") ORDER BY a.DT_CRIACAO desc
		
		");
		
		$listaArquivos = array();
	
		While($row = mysqli_fetch_array($resultado)){ 
			array_push($listaArquivos, $row); 
		} 
		
		$this->desconectar();
		
		return $listaArquivos;
		
	}

}	



















?>