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
	private $atrasado;
	private $sobrestado;
	
	
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
	
	public function setAtrasado($atrasado){
		$this->atrasado = $atrasado;
	}
	
	public function setSobrestado($sobrestado){
		$this->sobrestado = $sobrestado;
	}
	
	public function cadastrar(){
		
		$data = date('Y-m-d');
		
		$this->urgencia = ($this->assunto == 32) ? 1 : 0;
		
		$query = "SELECT NR_DIAS_PRAZO FROM tb_assuntos_processos WHERE ID='$this->assunto'";
		
		$qtdDiasPrazo = $this->executarQueryRegistro($query);
		
		$this->prazo = somarData($data, $qtdDiasPrazo);
		
		$query = "INSERT INTO tb_processos (DS_NUMERO, BL_URGENCIA, ID_ASSUNTO, DS_DETALHES, ID_ORGAO_INTERESSADO, DS_INTERESSADO, DT_ENTRADA, DT_PRAZO, ID_SERVIDOR_LOCALIZACAO) VALUES ('".$this->numero."','".$this->urgencia."', '".$this->assunto."','".strtoupper($this->detalhes)."','".$this->orgao."','".strtoupper($this->interessado)."','".$data."','".$this->prazo."', '".$this->servidorLocalizacao."')";
		
		$id = $this->executarQueryID($query);
		
		$resultado = $this->cadastrarHistorico('processos', $id, 'ABRIU UM NOVO PROCESSO', $this->servidorLocalizacao, 'ABERTURA');
		
		return $resultado;
		
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
	
	public function getListaProcessosStatus(){
		
		$restricaoStatus = ($this->status == 'ATIVO') ? " NOT IN ('ARQUIVADO', 'SAIU') " : " IN ('ARQUIVADO', 'SAIU') ";
		
		$query = "
		
		SELECT 
		
		a.*,
		DATE_FORMAT(a.DT_PRAZO, '%d/%m/%Y') DT_PRAZO,
		c.DS_NOME NOME_SERVIDOR,
		c.ID_SETOR,
		d.DS_ABREVIACAO NOME_SETOR
		
		FROM tb_processos a
		
		INNER JOIN tb_servidores c ON a.ID_SERVIDOR_LOCALIZACAO = c.ID
		INNER JOIN tb_setores d ON c.ID_SETOR = d.ID
		
		WHERE a.DS_STATUS ".$restricaoStatus." 
		
		AND a.ID_SERVIDOR_LOCALIZACAO = ".$this->servidorLocalizacao."
		
		ORDER BY BL_URGENCIA DESC, NR_DIAS DESC
		
		";
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;
		
	}
	
	public function getListaProcessosStatusComFiltro(){
		
		$restricaoStatus = ($this->status == 'ATIVO') ? " NOT IN ('ARQUIVADO', 'SAIU') " : " IN ('ARQUIVADO', 'SAIU') ";
		
		if($this->servidorLocalizacao == '%' and $this->setorLocalizacao != '%'){
			
			$restricaoServidorSetor = "ID_SERVIDOR_LOCALIZACAO IN (SELECT ID FROM tb_servidores WHERE ID_SETOR like '$this->setorLocalizacao')";
		
		}elseif($this->servidorLocalizacao != '%' and $this->setorLocalizacao == '%'){
			
			$restricaoServidorSetor = "ID_SERVIDOR_LOCALIZACAO like '$this->servidorLocalizacao'";
		
		}elseif($this->servidorLocalizacao != '%' and $this->setorLocalizacao != '%'){
			
			$restricaoServidorSetor = "(ID_SERVIDOR_LOCALIZACAO like '$this->servidorLocalizacao' OR ID_SERVIDOR_LOCALIZACAO IN (SELECT ID FROM tb_servidores WHERE ID_SETOR = '$this->setorLocalizacao'))";
			
		}elseif($this->servidorLocalizacao == '%' and $this->setorLocalizacao == '%'){
			
			$restricaoServidorSetor = "ID_SERVIDOR_LOCALIZACAO like '%'";
		}
		
		$query = "
		
		SELECT 
		
		a.*,
		DATE_FORMAT(a.DT_PRAZO, '%d/%m/%Y') DT_PRAZO,
		c.DS_NOME NOME_SERVIDOR,
		c.ID_SETOR,
		d.DS_ABREVIACAO NOME_SETOR
		
		FROM tb_processos a
		
		INNER JOIN tb_servidores c ON a.ID_SERVIDOR_LOCALIZACAO = c.ID
		INNER JOIN tb_setores d ON c.ID_SETOR = d.ID
		
		WHERE a.DS_STATUS ".$restricaoStatus." 
		
		AND ".$restricaoServidorSetor."
		
		AND BL_ATRASADO like '$this->atrasado' 
		
		AND BL_SOBRESTADO like '$this->sobrestado' 
		
		AND DS_NUMERO LIKE '%$this->numero%'
		
		ORDER BY BL_URGENCIA DESC, NR_DIAS DESC
		
		";
		
		$lista = $this->executarQueryLista($query);
		
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
	
	public function receber(){
		
		$query = "UPDATE tb_processos SET BL_RECEBIDO = 1, ID_SERVIDOR_LOCALIZACAO = $this->servidorLocalizacao WHERE ID = $this->id";
		
		$this->executarQuery($query);
		
	}
	
	public function devolver(){
		
		$query = "UPDATE tb_processos SET BL_RECEBIDO = 0, ID_SERVIDOR_LOCALIZACAO = (SELECT ID_SERVIDOR FROM tb_historico_processos WHERE DS_ACAO = 'TRAMITAÇÃO' AND ID_REFERENTE = $this->id ORDER BY DT_MENSAGEM DESC LIMIT 1) WHERE ID = $this->id";
		
		$this->executarQuery($query);
		
	}


}	

?>