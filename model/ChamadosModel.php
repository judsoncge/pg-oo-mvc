<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Model.php';

class ChamadosModel extends Model{

	private $problema;
	private $natureza;
	private $avaliacao;	
	
	public function setProblema($problema){
		$this->problema = $problema;
	}
	
	public function setNatureza($natureza){
		$this->natureza = $natureza;
	}

	public function setAvaliacao($avaliacao){
		$this->avaliacao = $avaliacao;
	}
	
	public function setMensagem($mensagem){
		$this->mensagem = $mensagem;
	}
	
	public function cadastrar(){
		
		$data = date('Y-m-d H:i:s');
		
		$query = "INSERT INTO tb_chamados (DS_PROBLEMA, DS_NATUREZA, ID_SERVIDOR_REQUISITANTE, DT_ABERTURA) VALUES ('".$this->problema."','".$this->natureza."','".$this->servidorSessao."','".$data."')";
		
		$id = $this->executarQueryID($query);
		
		$resultado = $this->cadastrarHistorico('chamados', $id, 'ABRIU UM NOVO CHAMADO', $this->servidorSessao, 'ABERTURA');
		
		return $resultado;
		
	}

	public function getListaChamadosStatus(){
		
		$restricao_status = ($this->status == 'ATIVO') ? " IN ('ABERTO', 'FECHADO') " : " = 'ENCERRADO' ";
		
		$restricao_servidor = ($this->servidorSessao != NULL) ? $this->servidorSessao : '%' ;
		
		$query =
		
		"SELECT 
		
		a.ID, a.DS_NATUREZA, a.DT_ABERTURA, a.DS_STATUS, a.DS_AVALIACAO, 
		
		s.DS_NOME DS_NOME_REQUISITANTE
		
		FROM  tb_chamados a
		
		INNER JOIN tb_servidores s ON a.ID_SERVIDOR_REQUISITANTE = s.ID 
		
		WHERE a.DS_STATUS ".$restricao_status." 
		
		AND ID_SERVIDOR_REQUISITANTE LIKE '".$restricao_servidor."' 
		
		ORDER BY a.DT_ABERTURA desc
		
		";
	
		$lista = $this->executarQueryLista($query);
		
		return $lista;
		
	}
	
	public function editarStatus($modulo, $status, $id){
		
		$this->conectar();
		
		parent::editarStatus($modulo, $status, $id);
		
		$data = date('Y-m-d H:i:s');
		
		$query  = "UPDATE tb_chamados SET ";
		
		switch($this->status){
				
			case 'FECHADO':
				
				$query .= "DT_FECHAMENTO = '".$data."' ";
				
				$textoMensagem = "FECHOU O CHAMADO";
				
				$acao = 'FECHAMENTO';
				
				break;
			
			case 'ENCERRADO':
				
				$query .= "DT_ENCERRAMENTO = '".$data."' ";
				
				$textoMensagem = "ENCERROU O CHAMADO";
				
				$acao = 'ENCERRAMENTO';
				
				break;
				
		}
		
		$query .= "WHERE ID=".$this->id."";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('chamados', $this->id, $textoMensagem, $_SESSION['ID'], $acao);
		
		return $resultado;

	}
	
	public function avaliar(){
		
		$query = "UPDATE tb_chamados SET DS_AVALIACAO = '".$this->avaliacao."' WHERE ID = ".$this->id."";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('chamados', $this->id, 'AVALIOU O CHAMADO: ' . $this->avaliacao, $_SESSION['ID'], $acao);
		
		return $resultado;
		
	}
	
	public function getDadosID(){
		
		$query =
		
		"SELECT 
		
		a.*, 
		
		s.DS_NOME DS_NOME_REQUISITANTE
		
		FROM  tb_chamados a
		
		INNER JOIN tb_servidores s ON a.ID_SERVIDOR_REQUISITANTE = s.ID 
		
		WHERE a.ID = ".$this->id."
		
		";
		
		$lista = $this->executarQueryListaID($query);
		
		return $lista;
	}


}	

?>