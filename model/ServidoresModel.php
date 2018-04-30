<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/BancoDados.php';

class ServidoresModel extends BancoDados{
	
	//funcao que retorna as cinco primeiras noticias com o status de publicada
	public function getListaServidoresStatus($status){
		
		//conecta com o banco de dados
		$this->conectar();
		
		//fazendo a query para buscar as cinco noticias mais atuais com o status de publicada
		$resultado = mysqli_query($this->conexao, "SELECT * FROM tb_servidores WHERE NM_STATUS='$status' ORDER BY NM_SERVIDOR") or die(mysqli_error($this->conexao));
		
		//criando um array para ser enviado ao controller
		$listaServidores = array();
		
		//passando todas as informacoes do resultado da query para o array criado
		While($row = mysqli_fetch_array($resultado)){ 
			array_push($listaServidores, $row); 
		} 
		
		//desconecta do banco de dados
		$this->desconectar();
		
		//retorna os dados para o controller
		return $listaServidores;
	
	}
	
	
	
}	



















?>