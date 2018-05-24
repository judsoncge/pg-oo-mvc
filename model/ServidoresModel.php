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
		$this->nome = $nome;
	}
	
	public function setCPF($cpf){
		$this->cpf = $cpf;	
	}
	
	public function setSenha($senha){
		$this->senha = $senha;
	}
	
	public function setConfirmaSenha($confirmaSenha){
		$this->confirmaSenha = $confirmaSenha;
	}
	
	public function setFoto($foto){
		$this->foto = $foto;
	}
	
	public function getFoto(){
		return $this->foto;
	}
	
	public function getListaServidoresStatus(){
		
		$query = "
		
		SELECT 
		
		s1.ID, s1.DS_CPF, s1.DS_NOME, s1.DS_FUNCAO, s1.DS_STATUS, s2.DS_ABREVIACAO
		
		FROM tb_servidores s1
		
		INNER JOIN tb_setores s2 ON s1.ID_SETOR = s2.ID 
		
		WHERE DS_STATUS='".$this->status."' 
		
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

		WHERE s1.ID=".$this->id."
		
		";
		
		
		$lista = $this->executarQueryListaID($query);
		
		return $lista;
		
	}
	
	public function cadastrar(){
		
		$existe = $this->verificaExisteRegistro('tb_servidores', 'DS_CPF', $this->cpf);
		
		if($existe){
			
			$this->setMensagemResposta('Já existe um(a) servidor(a) com este CPF. Por favor, tente outro.');
			
			return 0;
		
		}else{
			
			$query = "INSERT INTO tb_servidores (DS_FUNCAO, ID_SETOR, DS_NOME, DS_CPF) VALUES ('".$this->funcao."','".$this->setor."','".$this->nome."','".$this->cpf."')";
			
			$resultado = $this->executarQuery($query);
			
			return $resultado;
		}
		
	}
	
	public function editar(){
		
		if($this->cpf != NULL){
			
			$existe = $this->verificaExisteRegistroId('tb_servidores', 'DS_CPF', $this->cpf, $this->id);
		
			if($existe){
			
				$this->setMensagemResposta('Já existe um(a) servidor(a) com este CPF. Por favor, tente outro.');
			
				return 0;
		
			}
			
		}		
		
		$query  = "UPDATE tb_servidores SET DS_FUNCAO = '".$this->funcao."', ID_SETOR = ".$this->setor.", DS_NOME = '".$this->nome."', DS_CPF = '".$this->cpf."' WHERE ID=".$this->id."";
		
		$resultado = $this->executarQuery($query);
		
		return $resultado;
		
	}
	
	public function editarSenha(){
		
		if($this->senha != $this->confirmaSenha){
			
			$this->setMensagemResposta('As senhas não conferem!');
			
			return 0;
			
		}else{
			
			$this->senha = md5($this->senha);
			
			$query = "UPDATE tb_servidores SET SENHA = '".$this->senha."' WHERE ID = ".$this->id."";
			
			$resultado = $this->executarQuery($query);
			
			return $resultado;
		
		}
	}
	
	public function editarFoto(){
		
		$nomeAnexo = registrarAnexo($this->foto, $_SERVER['DOCUMENT_ROOT'].'/_registros/fotos/');		
		
		$query = "UPDATE tb_servidores SET DS_FOTO = '".$nomeAnexo."' WHERE ID = ".$this->id."";
		
		$resultado = $this->executarQuery($query);
		
		$this->setFoto($nomeAnexo);
		
		return $resultado;
		
	}
	
	public function excluirFoto($foto){
		
		if($foto != 'default.jpg'){
			
			unlink($_SERVER['DOCUMENT_ROOT'].'/_registros/fotos/'.$foto);
			
		}
	
	}
	
}	

?>