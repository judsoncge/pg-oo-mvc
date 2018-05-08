<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Model.php';

class SetoresModel extends Model{
	
	public function getIDNomeSetores(){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, "
		
		SELECT 
		
		ID, DS_NOME
		
		FROM tb_setores
		
		ORDER BY DS_NOME
		
		") or die(mysqli_error($this->conexao));
		
		$listaSetores = array();
		
		While($row = mysqli_fetch_array($resultado)){ 
			array_push($listaSetores, $row); 
		} 
		
		$this->desconectar();
		
		return $listaSetores;
	
	}
	
	
	
}	



















?>