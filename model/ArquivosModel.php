<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/BancoDados.php';

class ArquivosModel extends BancoDados{
	
	//funcao que retorna as cinco primeiras noticias com o status de publicada
	public function getListaArquivosStatus($servidor, $status){
		
		//conecta com o banco de dados
		$this->conectar();
		
		//fazendo a query para buscar as cinco noticias mais atuais com o status de publicada
		$resultado = mysqli_query($this->conexao, "SELECT a.*, s1.NM_SERVIDOR CRIACAO, s2.NM_SERVIDOR ENVIADO FROM tb_arquivos a
		INNER JOIN tb_servidores s1 ON a.ID_SERVIDOR_CRIACAO = s1.ID INNER JOIN tb_servidores s2 ON a.ID_SERVIDOR_ENVIADO = s2.ID WHERE a.NM_STATUS = '$status' AND (a.ID_SERVIDOR_CRIACAO = $servidor OR a.ID_SERVIDOR_ENVIADO = $servidor) ORDER BY a.DT_CRIACAO desc");
		
		//criando um array para ser enviado ao controller
		$listaArquivos = array();
		
		//passando todas as informacoes do resultado da query para o array criado
		While($row = mysqli_fetch_array($resultado)){ 
			array_push($listaArquivos, $row); 
		} 
		
		//desconecta do banco de dados
		$this->desconectar();
		
		//retorna os dados para o controller
		return $listaArquivos;
	
	}
	
	
	
}	



















?>