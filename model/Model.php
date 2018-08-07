<?php

class Model{

	protected $conexao;
	protected $mensagemResposta;
	protected $id;
	protected $status;
	protected $tabela;
	protected $tabelaHistorico;
	protected $coluna;
	
	public function setID($id){
		$this->id = $id;
	}
	
	public function getID(){
		return $this->id;
	}
	
	public function setTabela($tabela){
		$this->tabela = $tabela;
	}
	
	public function setTabelaHistorico($tabelaHistorico){
		$this->tabelaHistorico = $tabelaHistorico;
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
	
	
	//esta funcao faz a conexao com o banco de dados
	public function conectar(){
		
		//conecta
		//$this->conexao = mysqli_connect('10.50.119.149', 'desenvolvedor', 'cgeagt', 'pg-oo-mvc') or die(mysqli_error($nome_banco));
		
		$this->conexao = mysqli_connect('localhost', 'root', '', 'pg-oo-mvc') or die(mysqli_error($nome_banco));	

		
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
	
	public function verificaExisteRegistro($campo, $valor){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, "SELECT * FROM $this->tabela WHERE $campo='$valor'") or die(mysqli_error($this->conexao));
		
		$this->desconectar();
		
		return mysqli_num_rows($resultado);
		
	}
	
	public function verificaExisteRegistroQuery($query){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, $query) or die(mysqli_error($this->conexao));
		
		$this->desconectar();
		
		return mysqli_num_rows($resultado);
		
	}
	
	public function verificaExisteRegistroId($campo, $valor){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, "SELECT * FROM $this->tabela WHERE $campo='$valor' and ID!= $this->id") or die(mysqli_error($this->conexao));
		
		$this->desconectar();
		
		return mysqli_num_rows($resultado);
		
	}	
	
	public function cadastrarHistorico($mensagem, $acao){
		
		$data = date('Y-m-d H:i:s');
		
		$query = "INSERT INTO $this->tabelaHistorico (ID_REFERENTE, TX_MENSAGEM, ID_SERVIDOR, DT_ACAO, DS_ACAO) VALUES ($this->id, '$mensagem', ".$_SESSION['ID'].", '$data', '$acao')";
		
		$resultado = $this->executarQuery($query);
		
		return $resultado;
		
	}
	
	public function enviarMensagem($mensagem){
		
		$resultado = $this->cadastrarHistorico("DISSE: $mensagem", 'MENSAGEM');
		
		return $resultado;
		
	}
	
	public function getHistorico(){
		
		$query = "
		
		SELECT a.*,
		
		DATE_FORMAT(a.DT_ACAO, '%d/%m/%Y às %H:%i:%s') DT_ACAO,
		
		s.DS_NOME, s.DS_FOTO
		
		FROM $this->tabelaHistorico a
		
		INNER JOIN tb_servidores s ON a.ID_SERVIDOR = s.ID
		
		WHERE a.ID_REFERENTE = $this->id
		
		ORDER BY ID DESC
		
		";

		$historico = $this->executarQueryLista($query);
		
		return $historico;
		
	}
	
	public function editarStatus(){
		
		$query = "UPDATE $this->tabela SET DS_STATUS = '$this->status' WHERE ID = $this->id";
		
		$resultado = $this->executarQuery($query);
		
		return $resultado;
		
	}
	
	
	
	public function excluir(){
		
		$query = "DELETE FROM $this->tabela WHERE ID = $this->id";
		
		$resultado = $this->executarQuery($query);
		
		return $resultado;

	}
	
	public function excluirArquivo($pasta, $nomeArquivo){
		
		unlink($_SERVER['DOCUMENT_ROOT']."/_registros/$pasta/$nomeArquivo");
		
	}

	public function getDadosID(){

	

	}
	
	public function somarData($data, $dias, $meses = 0, $ano = 0){
	
	   $data = explode("-", $data);
	   
	   $novaData = date("Y-m-d", mktime(0, 0, 0, $data[1] + $meses, $data[2] + $dias, $data[0] + $ano) );
	   
	   return $novaData;
   
	}

	public function retiraCaracteresEspeciais($string){
		
		$string = str_replace(" ","-",$string);
		
		$string = str_replace("á","a",$string);
		$string = str_replace("Á","A",$string);
		$string = str_replace("à","a",$string);
		$string = str_replace("ã","a",$string);
		$string = str_replace("Ã","A",$string);
		$string = str_replace("â","a",$string);
		$string = str_replace("ä","a",$string);
		
		$string = str_replace("é","e",$string);
		$string = str_replace("è","e",$string);
		$string = str_replace("ê","e",$string);
		$string = str_replace("ë","e",$string);
		
		$string = str_replace("í","i",$string);
		$string = str_replace("ì","i",$string);
		$string = str_replace("î","i",$string);
		$string = str_replace("ï","i",$string);
		
		$string = str_replace("ó","o",$string);
		$string = str_replace("ò","o",$string);
		$string = str_replace("õ","o",$string);
		$string = str_replace("ô","o",$string);
		$string = str_replace("ö","o",$string);
		
		$string = str_replace("ú","u",$string);
		$string = str_replace("ù","u",$string);
		$string = str_replace("û","u",$string);
		$string = str_replace("ü","u",$string);
		
		$string = str_replace("ç","c",$string);
		
		$string = str_replace("Á","A",$string);
		$string = str_replace("À","A",$string);
		$string = str_replace("Ã","A",$string);
		$string = str_replace("Â","A",$string);
		$string = str_replace("Ä","A",$string);
		
		$string = str_replace("É","E",$string);
		$string = str_replace("È","E",$string);
		$string = str_replace("Ê","E",$string);
		$string = str_replace("Ë","E",$string);
		
		$string = str_replace("Í","I",$string);
		$string = str_replace("Ì","I",$string);
		$string = str_replace("Î","I",$string);
		$string = str_replace("Ï","I",$string);
		
		$string = str_replace("Ó","O",$string);
		$string = str_replace("Ò","O",$string);
		$string = str_replace("Õ","O",$string);
		$string = str_replace("Ô","O",$string);
		$string = str_replace("Ö","O",$string);
		
		$string = str_replace("Ú","U",$string);
		$string = str_replace("Ù","U",$string);
		$string = str_replace("Û","U",$string);
		$string = str_replace("Ü","U",$string);
		
		$string = str_replace("Ç","C",$string);
		
		return $string;

	}


	public function registrarAnexo($file, $pasta){
		
		$caminho = $_SERVER['DOCUMENT_ROOT']."/_registros/$pasta/";
	
		$nomeAnexo = $file['name'];
	
		$nomeAnexo = $this->retiraCaracteresEspeciais($nomeAnexo);
		
		if(file_exists($caminho.$nomeAnexo)){ 
				
				$a = 1;
				while(file_exists($caminho."[$a]".$nomeAnexo."")){
				$a++;
				}
				
				$nomeAnexo = "[$a]".$nomeAnexo;
		}
			
		move_uploaded_file($file['tmp_name'], $caminho.$nomeAnexo);
		return $nomeAnexo;
		
	}

}

?>