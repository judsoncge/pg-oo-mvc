<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/model/Model.php';

class ProcessosModel extends Model{

	private $numero;
	private $urgencia;
	private $assunto;
	private $orgao;
	private $interessado;
	private $detalhes;	
	private $dataEntrada;	
	private $dataSaida;	
	private $prazo;	
	private $servidorLocalizacao;	
	private $setorLocalizacao;	
	private $atrasado;
	private $sobrestado;
	private $recebido;
	
	
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
	
	public function setRecebido($recebido){
		$this->recebido = $recebido;
	}
	
	public function setDataEntrada($dataEntrada){
		$this->dataEntrada = $dataEntrada;
	}
	
	public function setDataSaida($dataSaida){
		$this->dataSaida = $dataSaida;
	}
	
	public function cadastrar(){
		
		$existe = $this->verificaExisteRegistro('tb_processos', 'DS_NUMERO', $this->numero);
		
		if($existe){
			
			$this->setMensagemResposta('Já existe um(a) processo com este número. Por favor, tente outro.');
			
			return 0;
		
		}else{
			
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
		
	}
	
	public function marcarSobrestado(){
		
		$this->editarCampo('processos', 'BL_SOBRESTADO', $this->sobrestado);
				
		$mensagem = ($_GET['valor']) ? 'MARCOU O PROCESSO COMO SOBRESTADO' : 'DESMARCOU O SOBRESTADO DESTE PROCESSO';
		
		$resultado = $this->cadastrarHistorico('processos', $mensagem, 'SOBRESTADO');
		
		return $resultado; 
		
	}
	
	public function marcarUrgencia(){
		
		$this->editarCampo('processos', 'BL_URGENCIA', $this->urgencia);
				
		$mensagem = ($_GET['valor']) ? 'MARCOU COMO URGENTE' : 'DESMARCOU A URGENCIA DESTE PROCESSO';
		
		$resultado = $this->cadastrarHistorico('processos', $mensagem, 'URGENTE');
		
		return $resultado; 
		
	}
	
	public function sair(){
		
		$this->editarCampo('processos', 'DS_STATUS', 'SAIU');
				
		$mensagem = 'DEU SAÍDA NO PROCESSO';
		
		$resultado = $this->cadastrarHistorico('processos', $mensagem, 'URGENTE');
		
		return $resultado; 
		
	}
	
	public function editarStatus(){
		
		$this->editarCampo('processos', 'DS_STATUS', $this->status);
		
		switch($this->status){
				
			case 'FINALIZADO PELO SETOR':
				
				$mensagem = 'FINALIZOU O PROCESSO EM NOME DO SETOR';
				
				$acao = 'FINALIZAÇÃO';
				
				break;
			
			case 'FINALIZADO PELO GABINETE':
				
				$mensagem = 'FINALIZOU O PROCESSO EM NOME DO GABINETE';
				
				$acao = 'FINALIZAÇÃO';
				
				break;
				
			case 'SAIU':
			
				$this->editarCampo('processos', 'DT_SAIDA', date('Y-m-d H:i:s'));
				
				$mensagem = 'DEU SAÍDA NO PROCESSO';
				
				$acao = 'SAÍDA';
				
				break;
				
		}
		
		$resultado = $this->cadastrarHistorico('processos', $mensagem, $acao);
		
		return $resultado;

	}
	
	public function voltar(){
		
		$this->dataEntrada = date('Y-m-d');
		
		$query = "SELECT ID_ASSUNTO FROM tb_processos WHERE ID = $this->id";
		
		$this->assunto = $this->executarQueryRegistro($query);
		
		$query = "SELECT NR_DIAS_PRAZO FROM tb_assuntos_processos WHERE ID = $this->assunto";
		
		$qtdDiasPrazo = $this->executarQueryRegistro($query);
		
		$this->prazo = somarData($this->dataEntrada, $qtdDiasPrazo);
		
		$query = "UPDATE tb_processos SET DT_ENTRADA = '$this->dataEntrada', DT_PRAZO = '$this->prazo', DT_SAIDA = NULL, NR_DIAS = 0, DS_STATUS = 'EM ANDAMENTO' WHERE ID = $this->id";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('processos', 'COLOCOU O PROCESSO DE VOLTA NO ORGAO', 'VOLTAR');
		
		return $resultado;		
		
	}
	
	public function getDadosID(){
		
		$query =
		
		"SELECT 
		
		a.*, 
		DATE_FORMAT(a.DT_ENTRADA, '%d/%m/%Y') DT_ENTRADA,
		DATE_FORMAT(a.DT_SAIDA, '%d/%m/%Y') DT_SAIDA,
		DATE_FORMAT(a.DT_PRAZO, '%d/%m/%Y') DT_PRAZO,
		b.DS_NOME NOME_SERVIDOR,
		c.DS_NOME NOME_SETOR,
		d.DS_NOME NOME_ASSUNTO,
		e.DS_NOME NOME_ORGAO,
		f.ID_PROCESSO_MAE,
		g.DS_NUMERO NUMERO_PROCESSO_MAE
		
		FROM tb_processos a
		
		LEFT JOIN tb_servidores b ON a.ID_SERVIDOR_LOCALIZACAO = b.ID 
		LEFT JOIN tb_setores c ON b.ID_SETOR = c.ID 
		LEFT JOIN tb_assuntos_processos d ON a.ID_ASSUNTO = d.ID 
		LEFT JOIN tb_orgaos e ON a.ID_ORGAO_INTERESSADO = e.ID
		LEFT JOIN tb_processos_apensados f ON a.ID = f.ID_PROCESSO_APENSADO
		LEFT JOIN tb_processos g ON f.ID_PROCESSO_MAE = g.ID
		
		WHERE a.ID = $this->id
		
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
		
		AND BL_RECEBIDO like '$this->recebido'
		
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
	
	public function getListaResponsaveis(){
	
		$query = "
		
		SELECT a.*, 
		
		b.DS_NOME NOME_SERVIDOR 
		
		FROM tb_responsaveis_processos a
		
		INNER JOIN tb_servidores b ON a.ID_SERVIDOR = b.ID
		
		WHERE ID_PROCESSO = $this->id

		";
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;
		
		
	}
	
	public function getListaApensados(){
	
		$query = "
		
		SELECT b.ID_PROCESSO_APENSADO, c.DS_NUMERO 

		FROM tb_processos a 

		INNER JOIN tb_processos_apensados b ON a.ID = b.ID_PROCESSO_MAE 
		INNER JOIN tb_processos c ON b.ID_PROCESSO_APENSADO = c.ID 

		WHERE a.ID = $this->id
		
		";
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;
		
	}
	
	public function getListaDocumentos(){
	
		$query = "
		
		SELECT 
		
		a.*,
		DATE_FORMAT(a.DT_CRIACAO, '%d/%m/%Y') DT_CRIACAO,
		b.DS_NOME NOME_CRIADOR
		
		FROM tb_documentos a 

		INNER JOIN tb_servidores b ON a.ID_SERVIDOR_CRIACAO = b.ID 

		WHERE a.ID_PROCESSO = $this->id
		
		";
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;
		
	}

}	

?>