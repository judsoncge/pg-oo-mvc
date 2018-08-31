<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Model.php';

class ServidoresModel extends Model{

	private $funcao;
	private $setor;
	private $nome;
	private $cpf;
	private $foto;
	private $senha;
	private $confirmaSenha;
	
	public function setFuncao($funcao){
		$this->funcao = $funcao;
	}
	
	public function setSetor($setor){
		$this->setor = $setor;
	}
	
	public function setNome($nome){
		$this->nome = addslashes($nome);
	}
	
	public function setCPF($cpf){
		$this->cpf = $cpf;	
	}
	
	public function setSenha($senha){
		$this->senha = md5($senha);
	}
	
	public function setConfirmaSenha($confirmaSenha){
		$this->confirmaSenha = md5($confirmaSenha);
	}
	
	public function setFoto($foto){
		$this->foto = $foto;
	}
	
	public function getFoto(){
		return $this->foto;
	}
	
	public function login(){
		
		$query = "
		
		SELECT 
		
		a.ID, a.DS_FUNCAO, a.ID_SETOR, a.DS_NOME, a.DS_FOTO, 
		
		b.DS_ABREVIACAO NOME_SETOR 
		
		FROM tb_servidores a, tb_setores b
		
		WHERE a.ID_SETOR = b.ID
		
		AND a.DS_CPF = '$this->cpf' 
		
		AND a.SENHA = '$this->senha'";
		
		$dadosUsuario = $this->executarQueryLista($query);
		
		return $dadosUsuario;
	
	}
	
	public function getListaServidoresStatus(){
		
		$query = "
		
		SELECT 
		
		s1.ID, s1.DS_CPF, s1.DS_NOME, s1.DS_FUNCAO, s1.DS_STATUS, s2.DS_ABREVIACAO
		
		FROM tb_servidores s1
		
		INNER JOIN tb_setores s2 ON s1.ID_SETOR = s2.ID 
		
		WHERE DS_STATUS= '$this->status' 
		
		ORDER BY DS_NOME";
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;
	
	}
	
	public function getDadosID(){
		
		$query = "
		
		SELECT 
		
		s1.ID, s1.DS_CPF, s1.DS_NOME, s1.DS_FUNCAO, s2.ID ID_SETOR, s2.DS_NOME NOME_SETOR
		
		FROM tb_servidores s1
		
		INNER JOIN tb_setores s2 ON s1.ID_SETOR = s2.ID 

		WHERE s1.ID = '$this->id'
		
		";
		
		
		$lista = $this->executarQueryListaID($query);
		
		return $lista;
		
	}
	
	public function cadastrar(){
		
		$existe = $this->verificaExisteRegistro('DS_CPF', $this->cpf);
		
		if($existe){
			
			$this->setMensagemResposta('Já existe um(a) servidor(a) com este CPF. Por favor, tente outro.');
			
			return 0;
		
		}else{
			
			$query = "INSERT INTO tb_servidores (DS_FUNCAO, ID_SETOR, DS_NOME, DS_CPF) VALUES ('$this->funcao', $this->setor, '$this->nome','$this->cpf')";
			
			$resultado = $this->executarQuery($query);
			
			return $resultado;
		}
		
	}
	
	public function editar(){
		
		if($this->cpf != NULL){
			
			$existe = $this->verificaExisteRegistroId('DS_CPF', $this->cpf);
		
			if($existe){
			
				$this->setMensagemResposta('Já existe um(a) servidor(a) com este CPF. Por favor, tente outro.');
			
				return 0;
		
			}
			
		}		
		
		$query  = "UPDATE tb_servidores SET DS_FUNCAO = '$this->funcao', ID_SETOR = $this->setor, DS_NOME = '$this->nome', DS_CPF = '$this->cpf' WHERE ID = $this->id";
		
		$resultado = $this->executarQuery($query);
		
		return $resultado;
		
	}
	
	public function editarSenha(){
		
		if($this->senha != $this->confirmaSenha){
			
			$this->setMensagemResposta('As senhas não conferem!');
			
			return 0;
			
		}else{
			
			$query = "UPDATE tb_servidores SET SENHA = '$this->senha' WHERE ID = $this->id";
			
			$resultado = $this->executarQuery($query);
			
			return $resultado;
		
		}
	}
	
	public function editarFoto(){
		
		$this->excluirFoto($_SESSION['FOTO']);
		
		$nomeAnexo = $this->registrarAnexo($this->foto, 'fotos');		
		
		$query = "UPDATE tb_servidores SET DS_FOTO = '$nomeAnexo' WHERE ID = $this->id";
		
		$resultado = $this->executarQuery($query);
		
		$this->setFoto($nomeAnexo);
		
		return $resultado;
		
	}
	
	public function excluirFoto($foto){
		
		if($foto != 'default.jpg'){
			
			$this->excluirArquivo('fotos', $foto);
			
		}
	
	}	
	
}	

?>