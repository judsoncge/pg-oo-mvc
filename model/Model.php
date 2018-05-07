<?php

class Model{
	
	//atributo da conexao com banco de dados
	public $conexao;
	
	//esta funcao faz a conexao com o banco de dados
	public function conectar(){
		
		//conecta
		$this->conexao = mysqli_connect('10.50.119.149', 'desenvolvedor', 'cgeagt', 'pg-oo-mvc') or die(mysqli_error($nome_banco));
		
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
	
	public function getDadosId($tabela, $id){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, "SELECT * FROM $tabela WHERE ID=$id") or die(mysqli_error($this->conexao));
		
		$listaDados = array();
		
		While($row = mysqli_fetch_array($resultado)){ 
			array_push($listaDados, $row); 
		} 
		
		$this->desconectar();
		
		return $listaDados;
	
	}
	
	public function verificaExisteRegistro($tabela, $campo, $valor){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, "SELECT * FROM $tabela WHERE $campo='$valor'") or die(mysqli_error($this->conexao));
		
		$this->desconectar();
		
		return mysqli_num_rows($resultado);
		
	}
	
	public function verificaExisteRegistroId($tabela, $campo, $valor, $id){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, "SELECT * FROM $tabela WHERE $campo='$valor' and ID!='$id'") or die(mysqli_error($this->conexao));
		
		$this->desconectar();
		
		return mysqli_num_rows($resultado);
		
	}
	
}

?>