<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Model.php';

class ChamadosModel extends Model{

	private $problema;
	private $natureza;
	private $avaliacao;	
	
	public function setProblema($problema){
		$this->problema = addslashes($problema);
	}
	
	public function setNatureza($natureza){
		$this->natureza = $natureza;
	}

	public function setAvaliacao($avaliacao){
		$this->avaliacao = $avaliacao;
	}
	
	public function cadastrar(){
		
		$data = date('Y-m-d H:i:s');
		
		$query = "INSERT INTO tb_chamados (DS_PROBLEMA, DS_NATUREZA, ID_SERVIDOR_REQUISITANTE, DT_ABERTURA) VALUES ('$this->problema','$this->natureza', ".$_SESSION['ID'].",'$data')";
		
		$this->setID($this->executarQueryID($query));
		
		$resultado = $this->cadastrarHistorico('ABRIU UM NOVO CHAMADO', 'ABERTURA');
		
		return $resultado;
		
	}

	public function getListaChamadosStatus(){
		
		$restricao_status = ($this->status == 'ATIVO') ? " IN ('ABERTO', 'FECHADO') " : " = 'ENCERRADO' ";
		
		$restricao_servidor = ($_SESSION['FUNCAO'] != 'TI') ? $_SESSION['ID'] : '%' ;
		
		$query =
		
		"SELECT 
		
		a.ID, a.DS_NATUREZA, DATE_FORMAT(a.DT_ABERTURA, '%d/%m/%Y às %H:%i:%s') DT_ABERTURA , a.DS_STATUS, a.DS_AVALIACAO, 
		
		s.DS_NOME DS_NOME_REQUISITANTE
		
		FROM tb_chamados a
		
		INNER JOIN tb_servidores s ON a.ID_SERVIDOR_REQUISITANTE = s.ID 
		
		WHERE a.DS_STATUS $restricao_status 
		
		AND ID_SERVIDOR_REQUISITANTE LIKE '$restricao_servidor' 
		
		ORDER BY a.DT_ABERTURA desc
		
		";
	
		$lista = $this->executarQueryLista($query);
		
		return $lista;
		
	}
	
	public function editarStatus(){
		
		$query = "UPDATE tb_chamados SET DS_STATUS = '$this->status' WHERE ID = $this->id";
		
		$this->executarQuery($query);
		
		$data = date('Y-m-d H:i:s');
		
		switch($this->status){
				
			case 'FECHADO':
				
				$query = "UPDATE tb_chamados SET DT_FECHAMENTO = '$data' WHERE ID = $this->id";
				
				$this->executarQuery($query);
				
				$mensagem = 'FECHOU O CHAMADO';
				
				$acao = 'FECHAMENTO';
				
				break;
			
			case 'ENCERRADO':
				
				$query = "UPDATE tb_chamados SET DT_ENCERRAMENTO = '$data' WHERE ID = $this->id";
				
				$this->executarQuery($query);
				
				$mensagem = 'ENCERROU O CHAMADO';
				
				$acao = 'ENCERRAMENTO';
				
				break;
				
		}
		
		$resultado = $this->cadastrarHistorico($mensagem, $acao);
		
		return $resultado;

	}
	
	public function avaliar(){
		
		$query = "UPDATE tb_chamados SET DS_AVALIACAO = '$this->avaliacao' WHERE ID = $this->id";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('AVALIOU O CHAMADO: ' . $this->avaliacao,  'AVALIAÇÃO');
		
		return $resultado;
		
	}
	
	public function getDadosID(){
		
		$query =
		
		"SELECT 
		
		a.*, 
		
		DATE_FORMAT(a.DT_ABERTURA, '%d/%m/%Y às %H:%i:%s') DT_ABERTURA,
		DATE_FORMAT(a.DT_FECHAMENTO, '%d/%m/%Y às %H:%i:%s') DT_FECHAMENTO,
		DATE_FORMAT(a.DT_ENCERRAMENTO, '%d/%m/%Y às %H:%i:%s') DT_ENCERRAMENTO,
		
		s.DS_NOME DS_NOME_REQUISITANTE
		
		FROM  tb_chamados a
		
		INNER JOIN tb_servidores s ON a.ID_SERVIDOR_REQUISITANTE = s.ID 
		
		WHERE a.ID = '$this->id'
		
		";
		
		$lista = $this->executarQueryListaID($query);
		
		return $lista;
	}


}	

?>