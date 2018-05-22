<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/FuncoesGlobais.php';

class Model{
	
	//atributo da conexao com banco de dados
	protected $conexao;
	protected $mensagemResposta;
	
	public function setMensagemResposta($mensagemResposta){
		$this->mensagemResposta = $mensagemResposta;
	}
	
	public function getMensagemResposta(){
		return $this->mensagemResposta;
	}
	
	
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
	
	public function cadastrarHistorico($tabela, $id_referente, $mensagem, $id_servidor, $acao){
		
		$data = date('Y-m-d H:i:s');
		
		$resultado = mysqli_query($this->conexao, "
		
		INSERT INTO tb_historico_".$tabela." 
		
		(ID_REFERENTE, TX_MENSAGEM, ID_SERVIDOR, DT_MENSAGEM, DS_ACAO)
		
		VALUES
		
		(".$id_referente.", '".$mensagem."', ".$id_servidor.", '".$data."', '".$acao."')
		
		") or die(mysqli_error($this->conexao));
		
	}
	
	public function getHistorico($modulo, $id){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, "
		
		SELECT a.*,
		
		s.DS_NOME, s.DS_FOTO
		
		FROM tb_historico_$modulo a
		
		INNER JOIN tb_servidores s ON a.ID_SERVIDOR = s.ID
		
		WHERE a.ID_REFERENTE = ".$id." 
		
		") or die(mysqli_error($this->conexao));

		$historico = array();
	
		While($row = mysqli_fetch_array($resultado)){ 
			array_push($historico, $row); 
		} 
		
		$this->desconectar();
		
		return $historico;
		
	}
	
	public function editarStatus($modulo, $status, $id){
		
		$this->conectar();
		
		$query = "UPDATE tb_".$modulo." SET DS_STATUS = '".$status."' WHERE ID = ".$id."";
		
		mysqli_query($this->conexao, $query) or die(mysqli_error($this->conexao));
		
		$resultado = mysqli_affected_rows($this->conexao);
		
		$this->desconectar();
		
		$mensagemResposta = ($resultado) 
			? "O status foi alterado para $status com sucesso!" 
			: 'Ocorreu alguma falha na operação. Por favor, procure o suporte';
			
		$this->setMensagemResposta($mensagemResposta);
		
		return $resultado;
		
	}
	
}

?>