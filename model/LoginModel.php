<?php

//incluindo os dados da conexao de banco de dados
require_once $_SERVER['DOCUMENT_ROOT'].'/model/Model.php';

class LoginModel extends Model{
	
	public function login($CPF, $senha){
		
		//encriptando a senha
		$senha = md5($senha);
		
		//conecta ao banco de dados
		$this->conectar();
		
		//fazendo a query para buscar o servidor com as credenciais enviadas pelo controller
		$resultado = mysqli_query($this->conexao, "SELECT a.ID, DS_FUNCAO, ID_SETOR, a.DS_NOME, DS_FOTO, b.DS_NOME NOME_SETOR FROM tb_servidores a, tb_setores b WHERE a.ID_SETOR = b.ID AND DS_CPF = '$CPF' AND SENHA = '$senha'") or die(mysqli_error($this->conexao));
		
		//pegando o resultado da query em um array, que pode ser nulo caso nao encontre nenhum usuario
		$dadosUsuario = mysqli_fetch_array($resultado);
		
		//desconecta do banco de dados
		$this->desconectar();
		
		//retorna os dados para o controller
		return $dadosUsuario;
	
	}
	
}



















?>