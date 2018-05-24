<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Model.php';

class ComunicacaoModel extends Model{
	
	public function getCincoNoticiasMaisAtuais(){
		
		$query = "SELECT DS_TITULO, DS_INTERTITULO, DT_PUBLICACAO FROM tb_comunicacao WHERE DS_STATUS = 'PUBLICADA' ORDER BY DT_PUBLICACAO DESC LIMIT 5";
		
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
	
}	



















?>