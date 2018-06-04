<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Model.php';

class ProcessosModel extends Model{

	private $numero;
	private $urgencia;
	private $assunto;
	private $orgao;
	private $interessado;
	private $detalhes;	
	private $prazo;	
	private $servidorLocalizacao;	
	private $setorLocalizacao;	
	
	
	public function setNumero($numero){
		$this->numero = $numero;
	}
	
	public function setUrgencia($urgencia){
		$this->urgencia = $urgencia;
	}
	
	public function setAssunto($assunto){
		$this->assunto = $assunto;
	}
	
	public function setOrgao($orgao){
		$this->orgao = $orgao;
	}
	
	public function setInteressado($interessado){
		$this->interessado = $interessado;
	}
	
	public function setDetalhes($detalhes){
		$this->detalhes = $detalhes;
	}
	
	public function setPrazo($prazo){
		$this->prazo = $prazo;
	}
	
	public function setServidorLocalizacao($servidorLocalizacao){
		$this->servidorLocalizacao = $servidorLocalizacao;
	}
	
	public function setSetorLocalizacao($setorLocalizacao){
		$this->setorLocalizacao = $setorLocalizacao;
	}
	
	public function cadastrar(){
		
		$data = date('Y-m-d');
		
		$this->urgencia = ($this->assunto == 32) ? 1 : 0;
		
		$query = "SELECT NR_DIAS_PRAZO FROM tb_assuntos_processos WHERE ID='$this->assunto'";
		
		$qtdDiasPrazo = $this->executarQueryRegistro($query);
		
		$this->prazo = somarData($data, $qtdDiasPrazo);
		
		$query = "INSERT INTO tb_processos (DS_NUMERO, BL_URGENCIA, ID_ASSUNTO, DS_DETALHES, ID_ORGAO_INTERESSADO, DS_INTERESSADO, DT_ENTRADA, DT_PRAZO, ID_SETOR_LOCALIZACAO, ID_SERVIDOR_LOCALIZACAO) VALUES ('".$this->numero."','".$this->urgencia."', '".$this->assunto."','".strtoupper($this->detalhes)."','".$this->orgao."','".strtoupper($this->interessado)."','".$data."','".$this->prazo."','".$this->setorLocalizacao."', '".$this->servidorLocalizacao."')";
		
		$id = $this->executarQueryID($query);
		
		$resultado = $this->cadastrarHistorico('processos', $id, 'ABRIU UM NOVO PROCESSO', $this->servidorLocalizacao, 'ABERTURA');
		
		return $resultado;
		
	}

	public function getListaChamadosStatus(){
		
		$restricao_status = ($this->status == 'ATIVO') ? " IN ('ABERTO', 'FECHADO') " : " = 'ENCERRADO' ";
		
		$restricao_servidor = ($this->servidorRequisitante != NULL) ? $this->servidorRequisitante : '%' ;
		
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
	
	public function getListaAssuntos(){
		
		$query = "SELECT * FROM tb_assuntos_processos";
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;
		
	}
	
	public function getListaOrgaos(){
		
		$query = "SELECT * FROM tb_orgaos";
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;
		
	}


}	

?>