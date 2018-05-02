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
	
	public function getListaServidoresStatus($status){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, "SELECT * FROM tb_servidores WHERE DS_STATUS='$status' ORDER BY DS_NOME") or die(mysqli_error($this->conexao));
		
		$listaServidores = array();
		
		While($row = mysqli_fetch_array($resultado)){ 
			array_push($listaServidores, $row); 
		} 
		
		$this->desconectar();
		
		return $listaServidores;
	
	}
	
	
	
}	



















?>