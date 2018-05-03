<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/BancoDados.php';

class ServidoresModel extends BancoDados{
	
	private $id;
	private $funcao;
	private $setor;
	private $nome;
	private $foto;
	private $status;
	private $senha;
	
	public function setStatus($status){
		$this->status = $status;
	}
	
	public function getListaServidoresStatus(){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, "
		
		SELECT 
		
		s1.ID, s1.DS_CPF, s1.DS_NOME, s1.DS_FUNCAO, s2.DS_ABREVIACAO
		
		FROM tb_servidores s1
		
		INNER JOIN tb_setores s2 ON s1.ID_SETOR = s2.ID 
		
		WHERE DS_STATUS='".$this->status."' 
		
		ORDER BY DS_NOME") or die(mysqli_error($this->conexao));
		
		$listaServidores = array();
		
		While($row = mysqli_fetch_array($resultado)){ 
			array_push($listaServidores, $row); 
		} 
		
		$this->desconectar();
		
		return $listaServidores;
	
	}
	
	
	
}	



















?>