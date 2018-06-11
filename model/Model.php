<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/FuncoesGlobais.php';

class Model{

	protected $conexao;
	protected $mensagemResposta;
	protected $id;
	protected $status;
	protected $servidorSessao;
	
	public function setID($id){
		$this->id = $id;
	}
	
	public function setStatus($status){
		$this->status = $status;
	}
	
	public function setMensagemResposta($mensagemResposta){
		$this->mensagemResposta = $mensagemResposta;
	}
	
	public function getMensagemResposta(){
		return $this->mensagemResposta;
	}
	
	public function setServidorSessao($servidorSessao){
		$this->servidorSessao = $servidorSessao;
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
	
	public function executarQuery($query){
		
		$this->conectar();
		
		mysqli_query($this->conexao, $query) or die(mysqli_error($this->conexao));
		
		$resultado = mysqli_affected_rows($this->conexao);
		
		$this->desconectar();
		
		$mensagemResposta = ($resultado) 
			? 'Operação realizada com sucesso!' 
			: 'Ocorreu alguma falha na operação. Por favor, procure o suporte';
			
		$this->setMensagemResposta($mensagemResposta);
		
		return $resultado;
		
	}
	
	public function executarQueryID($query){
		
		$this->conectar();
		
		mysqli_query($this->conexao, $query) or die(mysqli_error($this->conexao));
		
		$id = mysqli_insert_id($this->conexao);
		
		$this->desconectar();
		
		return $id;
		
	}
	
	public function executarQueryLista($query){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, $query) or die(mysqli_error($this->conexao));
		
		$lista = array();
	
		While($row = mysqli_fetch_array($resultado)){ 
			array_push($lista, $row); 
		} 
		
		$this->desconectar();
		
		return $lista;

	}
	
	public function executarQueryListaID($query){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, $query) or die(mysqli_error($this->conexao));
		
		$lista = mysqli_fetch_array($resultado);
		
		$this->desconectar();
		
		return $lista;

	}
	
	public function executarQueryRegistro($query){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, $query) or die(mysqli_error($this->conexao));
		
		$registro = mysqli_fetch_row($resultado);
		
		$this->desconectar();
		
		return $registro[0];

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
	
	public function cadastrarHistorico($tabela, $mensagem, $acao){
		
		$data = date('Y-m-d H:i:s');
		
		$query = "INSERT INTO tb_historico_$tabela (ID_REFERENTE, TX_MENSAGEM, ID_SERVIDOR, DT_MENSAGEM, DS_ACAO) VALUES
		($this->id, '$mensagem', $this->servidorSessao, '$data', '$acao')";
		
		$resultado = $this->executarQuery($query);
		
		return $resultado;
		
	}
	
	public function getHistorico($modulo, $id){
		
		$query = "
		
		SELECT a.*,
		
		s.DS_NOME, s.DS_FOTO
		
		FROM tb_historico_$modulo a
		
		INNER JOIN tb_servidores s ON a.ID_SERVIDOR = s.ID
		
		WHERE a.ID_REFERENTE = ".$id." 
		
		ORDER BY DT_MENSAGEM DESC
		
		";

		$historico = $this->executarQueryLista($query);
		
		return $historico;
		
	}
	
	public function editarCampo($modulo, $campo, $valor){
		
		$query = "UPDATE tb_$modulo SET $campo = '$valor' WHERE ID = $this->id";
		
		$resultado = $this->executarQuery($query);
		
		return $resultado;
		
	}
	
	public function excluir($tabela, $id){
		
		$query = "DELETE FROM ".$tabela." WHERE ID=".$id."";
		
		
		
		$resultado = $this->executarQuery($query);
		
		return $resultado;

	}
	
	public function excluirArquivo($pasta, $nomeArquivo){
		
		unlink($_SERVER['DOCUMENT_ROOT']."/_registros/$pasta/$nomeArquivo");
		
	}

	public function getDadosID(){

	

	}
	
}

?>