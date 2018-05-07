<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Model.php';

class ServidoresModel extends Model{
	
	private $id;
	private $funcao;
	private $setor;
	private $nome;
	private $cpf;
	private $foto;
	private $status;
	private $senha;
	
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
	
	public function setStatus($status){
		$this->status = $status;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getListaServidoresStatus(){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, "
		
		SELECT 
		
		s1.ID, s1.DS_CPF, s1.DS_NOME, s1.DS_FUNCAO, s2.DS_ABREVIACAO
		
		FROM tb_servidores s1
		
		INNER JOIN tb_setores s2 ON s1.ID_SETOR = s2.ID 
		
		WHERE DS_STATUS='".$this->status."' 
		
		ORDER BY DS_NOME") or die(mysqli_error($this->conexao));
		
		$listaServidores = array();
		
		While($row = mysqli_fetch_array($resultado)){ 
			array_push($listaServidores, $row); 
		} 
		
		$this->desconectar();
		
		return $listaServidores;
	
	}
	
	public function getDadosId($tabela, $id){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, "
		
		SELECT 
		
		s1.ID, s1.DS_CPF, s1.DS_NOME, s1.DS_FUNCAO, s2.ID ID_SETOR, s2.DS_NOME DS_NOME_SETOR
		
		FROM $tabela s1
		
		INNER JOIN tb_setores s2 ON s1.ID_SETOR = s2.ID 

		WHERE s1.ID='$id'
		
		") or die(mysqli_error($this->conexao));
		
		$listaDados = array();
		
		While($row = mysqli_fetch_array($resultado)){ 
			array_push($listaDados, $row); 
		} 
		
		$this->desconectar();
		
		return $listaDados;
		
	}
	
	public function cadastrar(){
		
		$this->conectar();
		
		$existe = $this->verificaExisteRegistro('tb_servidores', 'DS_CPF', $this->cpf);
		
		if(existe){
			
			return 0;
		
		}else{
		
			$resultado = mysqli_query($this->conexao, "
			
			INSERT INTO tb_servidores
			
			(DS_FUNCAO, ID_SETOR, DS_NOME, DS_CPF)
			
			VALUES
			
			('".$this->funcao."','".$this->setor."','".$this->nome."','".$this->cpf."')
			
			") or die(mysqli_error($this->conexao));
			
			$cadastrou = mysqli_affected_rows($this->conexao);
			
			$this->desconectar();
			
			return $cadastrou;
		}
		
	}
	
	public function editar(){
		
		$this->conectar();
		
		$existe = $this->verificaExisteRegistroId('tb_servidores', 'DS_CPF', $this->cpf, $this->id);
		
		if(existe){
			
			return 0;
		
		}else{
		
			$resultado = mysqli_query($this->conexao, "
			
			UPDATE tb_servidores
			
			SET DS_FUNCAO = '".$this->funcao."',
			ID_SETOR = '".$this->setor."', 
			DS_NOME = '".$this->nome."', 
			DS_CPF = '".$this->cpf."',
			
			WHERE ID='".$this->id."'
			
			") or die(mysqli_error($this->conexao));
			
			$editou = mysqli_affected_rows($this->conexao);
			
			$this->desconectar();
			
			return $editou;
		
		}
		
	}
	
	
}	



















?>