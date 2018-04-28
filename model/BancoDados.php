<?php

class BancoDados{
	
	//atributo da conexao com banco de dados
	public $conexao;
	
	//esta funcao faz a conexao com o banco de dados
	public function conectar(){
		
		//conecta
		$this->conexao = mysqli_connect('localhost', 'root', '', 'pg2') or die(mysqli_error($nome_banco));
		
		//informando que todo tipo de variavel que vai ou vem do banco sera UFT8
		mysqli_query($this->conexao, "SET NAMES 'utf8'");
		
		mysqli_query($this->conexao, 'SET character_set_connection=utf8');
		
		mysqli_query($this->conexao, 'SET character_set_client=utf8');
		
		mysqli_query($this->conexao, 'SET character_set_results=utf8');

	}
	
	//esta funcao faz a desconexao com o banco de dados
	public function desconectar(){
		
		//fecha a conexao, ou seja, desconecta
		mysqli_close($this->conexao);
		
	}
	
}

?>