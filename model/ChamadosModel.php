<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Model.php';

class ChamadosModel extends Model{
	
	private $id;
	private $problema;
	private $natureza;
	private $servidorRequisitante;
	private $status;
	private $avaliacao;
	
	
	public function setID($id){
		$this->id = $id;
	}
	
	public function setProblema($problema){
		$this->problema = $problema;
	}
	
	public function setNatureza($natureza){
		$this->natureza = $natureza;
	}
	
	public function setServidorRequisitante($servidorRequisitante){
		$this->servidorRequisitante = $servidorRequisitante;
	}
	
	public function setStatus($status){
		$this->status = $status;
	}
	
	public function setAvaliacao($avaliacao){
		$this->avaliacao = $avaliacao;
	}
	
	public function cadastrar(){
		
		$this->conectar();
		
		$data = date('Y-m-d H:i:s');
		
		$resultado = mysqli_query($this->conexao, "
			
		INSERT INTO tb_chamados
		
		(DS_PROBLEMA, DS_NATUREZA, ID_SERVIDOR_REQUISITANTE, DT_ABERTURA)
		
		VALUES
		
		('".$this->problema."','".$this->natureza."','".$this->servidorRequisitante."','".$data."')
		
		") or die(mysqli_error($this->conexao));
		
		$this->setID(mysqli_insert_id($this->conexao));
		
		$this->cadastrarHistorico('chamados', $this->id, 'ABRIU UM NOVO CHAMADO', $this->servidorRequisitante, 'ABERTURA');
		
		$this->desconectar();
		
		$mensagemResposta = ($resultado) ? 'O chamado foi aberto com sucesso!' : 'Ocorreu alguma falha na operação. Por favor, procure o suporte';
			
		$this->setMensagemResposta($mensagemResposta);
		
		return $resultado;
		
	}

	public function getListaChamadosStatus(){
		
		$this->conectar();
		
		$restricao_status = ($this->status == 'ATIVO') ? " IN ('ABERTO', 'FECHADO') " : " = 'ENCERRADO' ";
		
		$restricao_servidor = ($_SESSION['FUNCAO'] != 'TI') ? " AND ID_SERVIDOR_REQUISITANTE = ".$_SESSION['ID']."" : "";
		
		$resultado = mysqli_query($this->conexao, 
		
		"SELECT 
		
		a.ID, a.DS_NATUREZA, a.DT_ABERTURA, a.DS_STATUS, a.DS_AVALIACAO, 
		
		s.DS_NOME DS_NOME_REQUISITANTE
		
		FROM  tb_chamados a
		
		INNER JOIN tb_servidores s ON a.ID_SERVIDOR_REQUISITANTE = s.ID 
		
		WHERE a.DS_STATUS ".$restricao_status." 
		
		".$restricao_servidor."
		
		ORDER BY a.DT_ABERTURA desc
		
		");
		
		$listaChamados = array();
	
		While($row = mysqli_fetch_array($resultado)){ 
			array_push($listaChamados, $row); 
		} 
		
		$this->desconectar();
		
		return $listaChamados;
		
	}
	
	public function editar(){
		
		$this->conectar();
		
		$data = date('Y-m-d H:i:s');
		
		$query  = "UPDATE tb_chamados SET ";
		
		if($this->status != NULL){
			
			$query .= "DS_STATUS = '".$this->status."', ";

		    switch($this->status){
				
				case 'FECHADO':
					$query .= "DT_FECHAMENTO = '".$data."', ";
					$textoMensagem = "FECHOU O CHAMADO";
					$acao = 'FECHAMENTO';
					break;
				
				case 'ENCERRADO':
					$query .= "DT_ENCERRAMENTO = '".$data."', ";
					$textoMensagem = "ENCERROU O CHAMADO";
					$acao = 'ENCERRAMENTO';
					break;
				
			}
			
		}elseif($this->avaliacao != NULL){
			
			$query .= ($this->avaliacao != NULL)  ?  "DS_AVALIACAO = '".$this->avaliacao."', " : ""; 
			
			$textoMensagem = "AVALIOU O CHAMADO: " . $this->avaliacao;
			$acao = 'AVALIAÇÃO';
		
		}
		
		$query .= ($this->avaliacao != NULL)  ?  "DS_AVALIACAO = '".$this->avaliacao."', " : ""; 
		
		$query .= "WHERE ID=".$this->id."";	

		$query = str_replace(", WHERE", " WHERE", $query);
	
		mysqli_query($this->conexao, $query) or die(mysqli_error($this->conexao));
		
		$resultado = mysqli_affected_rows($this->conexao);
		
		$this->cadastrarHistorico('chamados', $this->id, $textoMensagem, $_SESSION['ID'], $acao);

		$this->desconectar();

		$mensagemResposta = ($resultado) ? 'O chamado foi editado com sucesso!' : 'Ocorreu alguma falha na operação. Por favor, procure o suporte';
			
		$this->setMensagemResposta($mensagemResposta);
		
		return $resultado;

	}
	
	public function getDadosID(){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, 
		
		"SELECT 
		
		a.*, 
		
		s.DS_NOME DS_NOME_REQUISITANTE
		
		FROM  tb_chamados a
		
		INNER JOIN tb_servidores s ON a.ID_SERVIDOR_REQUISITANTE = s.ID 
		
		WHERE a.ID = ".$this->id."
		
		");
		
		$listaDados = mysqli_fetch_array($resultado);
		
		$this->desconectar();
		
		return $listaDados;
		
	}
	
	public function excluir(){
		
		$this->conectar();
		
		$resultado = mysqli_query($this->conexao, 
		
		"DELETE FROM tb_chamados 
		WHERE ID=".$this->id."
		
		") or die(mysqli_error($this->conexao));
		
		$resultado = mysqli_affected_rows($this->conexao);
		
		$this->desconectar();
		
		$mensagemResposta = ($resultado) ? 'O chamado foi excluído com sucesso!' : 'Ocorreu alguma falha na operação. Por favor, procure o suporte';
			
		$this->setMensagemResposta($mensagemResposta);
		
		return $resultado;

	}

}	



















?>