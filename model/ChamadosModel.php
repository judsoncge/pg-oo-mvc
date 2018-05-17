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
		
		s1.DS_NOME DS_NOME_REQUISITANTE
		
		FROM  tb_chamados a
		
		INNER JOIN tb_servidores s1 ON a.ID_SERVIDOR_REQUISITANTE = s1.ID 
		
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
		
		//to do
		
		$this->desconectar();
		
		if(isset($anexoAntigo)){
			unlink($_SERVER['DOCUMENT_ROOT'].'/_registros/anexos/'.$anexoAntigo);
		}
		
		$mensagemResposta = ($resultado) ? 'O chamado foi editado com sucesso!' : 'Ocorreu alguma falha na operação. Por favor, procure o suporte';
			
		$this->setMensagemResposta($mensagemResposta);
		
		return $resultado;

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