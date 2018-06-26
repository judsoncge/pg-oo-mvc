<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Model.php';

class SetoresModel extends Model{
	
	public function getSetores(){
		
		$query = 'SELECT * FROM tb_setores ORDER BY DS_NOME';
		
		$listaSetores = $this->executarQueryLista($query);
		
		return $listaSetores;
	
	}

}	

?>