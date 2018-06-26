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
	private $responsavel;
	private $documento;
	private $justificativaSobrestado;
	private $tipoDocumento;
	private $anexoDocumento;
	private $listaResponsaveis;
	private $listaApensos;
	private $responsavelLider;
	private $apenso;
	
	public function setListaResponsaveis($listaResponsaveis){
		
		$this->listaResponsaveis = $listaResponsaveis;
	}
	
	public function setApenso($apenso){
		
		$this->apenso = $apenso;
	}
	
	public function setListaApensos($listaApensos){
		
		$this->listaApensos = $listaApensos;
	}
	
	public function setTipoDocumento($tipoDocumento){
		
		$this->tipoDocumento = $tipoDocumento;
	}
	
	public function setAnexoDocumento($anexoDocumento){
		
		$this->anexoDocumento = $anexoDocumento;
	}
	
	public function setJustificativaSobrestado($justificativaSobrestado){
		
		$this->justificativaSobrestado = $justificativaSobrestado;
	}
	
	public function setDocumento($documento){
		$this->documento = $documento;
	}
	
	public function setResponsavel($responsavel){
		$this->responsavel = $responsavel;
	}
	
	public function setResponsavelLider($responsavelLider){
		$this->responsavelLider = $responsavelLider;
	}
	
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
		
		$existe = $this->verificaExisteRegistro('DS_NUMERO', $this->numero);
		
		if($existe){
			
			$this->setMensagemResposta('Já existe um(a) processo com este número. Por favor, tente outro.');
			
			return 0;
		
		}else{
			
		$data = date('Y-m-d');
		
		$query = "SELECT NR_DIAS_PRAZO FROM tb_assuntos_processos WHERE ID='$this->assunto'";
		
		$qtdDiasPrazo = $this->executarQueryRegistro($query);
		
		$this->prazo = $this->somarData($data, $qtdDiasPrazo);
		
		$this->urgencia = ($this->assunto == 32) ? 1 : 0;
		
		$query = "INSERT INTO tb_processos (DS_NUMERO, BL_URGENCIA, ID_ASSUNTO, DS_DETALHES, ID_ORGAO_INTERESSADO, DS_INTERESSADO, DT_ENTRADA, DT_PRAZO, ID_SERVIDOR_LOCALIZACAO) VALUES ('$this->numero','$this->urgencia', $this->assunto,'".strtoupper($this->detalhes)."',$this->orgao,'".strtoupper($this->interessado)."','$data','$this->prazo', $this->servidorLocalizacao)";
		
		$id = $this->executarQueryID($query);
		
		$this->setID($id);
		
		$resultado = $this->cadastrarHistorico('ABRIU UM NOVO PROCESSO', 'ABERTURA');
		
		return $resultado;
		
		}
		
	}
	
	public function editar(){
		
		$existe = $this->verificaExisteRegistroId('DS_NUMERO', $this->numero);
		
		if($existe){
		
			$this->setMensagemResposta('Já existe um(a) processo com este número. Por favor, tente outro.');
			
			return 0;
	
		}
		
		$this->urgencia = ($this->assunto == 32) ? 1 : 0;
		
		$query = "UPDATE tb_processos SET DS_NUMERO = '$this->numero', BL_URGENCIA = '$this->numero', ID_ASSUNTO = $this->assunto, DS_DETALHES = '$this->detalhes', ID_ORGAO_INTERESSADO = $this->orgao, DS_INTERESSADO = '$this->interessado' WHERE ID = $this->id";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('EDITOU O PROCESSO', 'EDIÇÃO');
	
		return $resultado;	
	
	}
	
	public function cadastrarDocumento(){
		
		$data = date('Y-m-d');
		
		$nomeAnexo = $this->registrarAnexo($this->anexoDocumento, 'anexos');
		
		$query = "INSERT INTO tb_documentos (ID_PROCESSO, DS_TIPO, DT_CRIACAO, ID_SERVIDOR_CRIACAO, DS_ANEXO) VALUES ($this->id, '$this->tipoDocumento', '$data', $this->servidorSessao, '$nomeAnexo')";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('ANEXOU UM DOCUMENTO AO PROCESSO','CRIAÇÃO DE DOCUMENTO');
		
		return $resultado;
		
	}
	
	public function getListaPodemSerResponsaveis(){
		
		$query = "SELECT ID, DS_NOME FROM tb_servidores WHERE DS_FUNCAO = 'TÉCNICO ANALISTA' AND DS_STATUS = 'ATIVO' AND ID NOT IN (SELECT ID_SERVIDOR FROM tb_responsaveis_processos WHERE ID_PROCESSO='$this->id') ORDER BY DS_NOME";
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;

	}
	
	public function getListaProcessosApensar(){
		
		$query = "SELECT ID, DS_NUMERO FROM tb_processos WHERE ID != $this->id AND ID_SERVIDOR_LOCALIZACAO = $this->servidorSessao AND BL_RECEBIDO = 1";
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;

	}
	
	public function tramitar(){
		
		$query = "UPDATE tb_processos SET BL_RECEBIDO = 0, ID_SERVIDOR_LOCALIZACAO = $this->servidorLocalizacao WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
		$this->executarQuery($query);
		
		$query = "SELECT DS_NOME FROM tb_servidores WHERE ID = $this->servidorLocalizacao";
		
		$nomeServidor = strtoupper($this->executarQueryRegistro($query));
		
		$resultado = $this->cadastrarHistorico("TRAMITOU O PROCESSO PARA $nomeServidor",'TRAMITAÇÃO');
		
		return $resultado;
		
	}
	
	public function marcarSobrestado(){
		
		$query = "UPDATE tb_processos SET BL_SOBRESTADO = $this->sobrestado WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
		$this->executarQuery($query);
				
		$mensagem = ($_GET['valor']) ? 'MARCOU O PROCESSO COMO SOBRESTADO' : 'DESMARCOU O SOBRESTADO DESTE PROCESSO';
		
		$resultado = $this->cadastrarHistorico($mensagem, 'SOBRESTADO');
		
		return $resultado; 
		
	}
	
	public function marcarUrgencia(){
		
		$query = "UPDATE tb_processos SET BL_URGENCIA = $this->urgencia WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
		$this->executarQuery($query);
				
		$mensagem = ($_GET['valor']) ? 'MARCOU COMO URGENTE' : 'DESMARCOU A URGENCIA DESTE PROCESSO';
		
		$resultado = $this->cadastrarHistorico($mensagem, 'URGENTE');
		
		return $resultado; 
		
	}
	
	public function apensarProcessos(){
		
		for($i=0;$i<count($this->listaApensos);$i++){
	
			$query = "INSERT INTO tb_processos_apensados (ID_PROCESSO, ID_PROCESSO_APENSADO) VALUES ($this->id, ".$this->listaApensos[$i].")";
			
			$this->executarQuery($query);
	
		}
		
		$query = "SELECT MAX(DT_PRAZO) FROM tb_processos WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
		$maiorData = $this->executarQueryRegistro($query);
		
		$query = "UPDATE tb_processos SET DT_PRAZO = '$maiorData' WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
		$this->executarQuery($query);

		$resultado = $this->cadastrarHistorico('APENSOU PROCESSOS A ESTE PROCESSO','APENSAR');
		
		return $resultado; 
		
	}
	
	public function removerApenso(){
		
		$query = "DELETE FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id AND ID_PROCESSO_APENSADO = $this->apenso";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('REMOVEU UM APENSO DO PROCESSO','REMOÇÃO DE APENSO');
		
		return $resultado; 

	}
	
	public function definirResponsaveis(){
		
		for ($i=0;$i<count($this->listaResponsaveis);$i++){
	
			$query = "INSERT INTO tb_responsaveis_processos (ID_PROCESSO, ID_SERVIDOR, BL_LIDER) VALUES ($this->id, ".$this->listaResponsaveis[$i].", 0)";
			
			$this->executarQuery($query);
	
		}

		$query = "SELECT count(*) FROM tb_responsaveis_processos WHERE ID_PROCESSO = $this->id";
		
		$quantidadeResponsaveis = $this->executarQueryRegistro($query);
		
		//se existir exatamente 1 responsável, ele se torna o líder.
		if($quantidadeResponsaveis == 1){
			
			$query = "UPDATE tb_responsaveis_processos SET BL_LIDER = 1 WHERE ID_PROCESSO = $this->id";
			
			$this->executarQuery($query);;
			
		}
		
		$resultado = $this->cadastrarHistorico('DEFINIU OS RESPONSÁVEIS DO PROCESSO','RESPONSÁVEIS');
		
		return $resultado; 
		
	}
	
	public function definirResponsavelLider(){
		
		$query = "UPDATE tb_responsaveis_processos SET BL_LIDER = 1 WHERE ID_PROCESSO = $this->id AND ID_SERVIDOR = $this->responsavelLider";
		
		$this->executarQuery($query);
		
		$query = "UPDATE tb_responsaveis_processos SET BL_LIDER = 0 WHERE ID_PROCESSO = $this->id AND ID_SERVIDOR != $this->responsavelLider";
		
		$this->executarQuery($query);
		
		$query = "SELECT ID_SETOR FROM tb_servidores WHERE ID = $this->responsavelLider";
		
		$setor = $this->executarQueryRegistro($query);
		
		$query = "UPDATE tb_processos SET ID_SETOR_RESPONSAVEL = $setor WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('DEFINIU O RESPONSÁVEL LÍDER','LÍDER');
		
		return $resultado; 
		
	}
	
	public function removerResponsavel(){
		
		$query = "DELETE FROM tb_responsaveis_processos WHERE ID_SERVIDOR = $this->responsavel AND ID_PROCESSO = $this->id"; 
		
		$this->executarQuery($query);
		
		$query = "SELECT * FROM tb_responsaveis_processos WHERE ID_PROCESSO = $this->id";
		
		$listaResponsaveis = $this->executarQueryLista($query);
		
		if(count($listaResponsaveis) === 1){
			
			$query = "UPDATE tb_responsaveis_processos SET BL_LIDER = 1 WHERE ID_PROCESSO = $this->id";
			
			$this->executarQuery($query);
		}
	
		$resultado = $this->cadastrarHistorico('REMOVEU UM RESPONSÁVEL', 'REMOVER RESPONSÁVEL');
		
		return $resultado;
		
	}
	
	public function editarStatus(){
		
		$query = "UPDATE tb_processos SET DS_STATUS = '$this->status' WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
		$this->executarQuery($query);
		
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
			
				$data = date('Y-m-d');
				
				$query = "UPDATE tb_processos SET DT_SAIDA = '$data' WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
				
				$this->executarQuery($query);
				
				$mensagem = 'DEU SAÍDA NO PROCESSO';
				
				$acao = 'SAÍDA';
				
				break;
				
			case 'ARQUIVADO':
			
				$data = date('Y-m-d');
				
				$query = "UPDATE tb_processos SET DT_SAIDA = '$data' WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
				
				$this->executarQuery($query);
				
				$mensagem = 'ARQUIVOU O PROCESSO';
				
				$acao = 'ARQUIVAMENTO';
				
				break;
				
		}
		
		$resultado = $this->cadastrarHistorico($mensagem, $acao);
		
		return $resultado;

	}
	
	public function desfazerStatus(){
		
		$query = "UPDATE tb_processos SET DS_STATUS = '$this->status' WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
		$this->executarQuery($query);
		
		switch($this->status){
			
			case 'EM ANDAMENTO':	
			case 'FINALIZADO PELO SETOR':
				
				$mensagem = 'DESFEZ A FINALIZAÇÃO';
				
				$acao = 'FINALIZAÇÃO DESFEITA';
				
				break;

		}
		
		$resultado = $this->cadastrarHistorico($mensagem, $acao);
		
		return $resultado;

	}
	
	public function excluirDocumento(){
		
		$query = "SELECT DS_ANEXO FROM tb_documentos WHERE ID = $this->documento";
		
		$nomeDocumento = $this->executarQueryRegistro($query);
		
		$this->excluirArquivo('anexos', $nomeDocumento);
		
		$query = "DELETE FROM tb_documentos WHERE ID = $this->documento";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('EXCLUIU UM DOCUMENTO', 'EXCLUSÃO DE DOCUMENTO');
		
		return $resultado;
		
	}
	
	public function voltar(){
		
		$this->dataEntrada = date('Y-m-d');
		
		$query = "SELECT ID_ASSUNTO FROM tb_processos WHERE ID = $this->id";
		
		$this->assunto = $this->executarQueryRegistro($query);
		
		$query = "SELECT NR_DIAS_PRAZO FROM tb_assuntos_processos WHERE ID = $this->assunto";
		
		$qtdDiasPrazo = $this->executarQueryRegistro($query);
		
		$this->prazo = $this->somarData($this->dataEntrada, $qtdDiasPrazo);
		
		$query = "UPDATE tb_processos SET DT_ENTRADA = '$this->dataEntrada', DT_PRAZO = '$this->prazo', DT_SAIDA = NULL, NR_DIAS = 0, DS_STATUS = 'EM ANDAMENTO' WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('COLOCOU O PROCESSO DE VOLTA NO ORGAO', 'VOLTAR');
		
		return $resultado;		
		
	}
	
	public function desarquivar(){
		
		$status = ($_SESSION['FUNCAO']=='CHEFE DE GABINETE' || $_SESSION['FUNCAO']=='GABINETE') ? 'FINALIZADO PELO GABINETE' : 'FINALIZADO PELO SETOR';
		
		$query = "UPDATE tb_processos SET DS_STATUS = '$status', DT_SAIDA = NULL WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('DESARQUIVOU O PROCESSO', 'DESARQUIVAMENTO');
		
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
		f.ID_PROCESSO,
		g.DS_NUMERO NUMERO_PROCESSO_MAE,
		g.ID ID_PROCESSO_MAE,
		h.DS_JUSTIFICATIVA
		
		FROM tb_processos a
		
		LEFT JOIN tb_servidores b ON a.ID_SERVIDOR_LOCALIZACAO = b.ID 
		LEFT JOIN tb_setores c ON b.ID_SETOR = c.ID 
		LEFT JOIN tb_assuntos_processos d ON a.ID_ASSUNTO = d.ID 
		LEFT JOIN tb_orgaos e ON a.ID_ORGAO_INTERESSADO = e.ID
		LEFT JOIN tb_processos_apensados f ON a.ID = f.ID_PROCESSO_APENSADO
		LEFT JOIN tb_processos g ON f.ID_PROCESSO = g.ID
		LEFT JOIN tb_processos_sobrestados h ON h.ID_PROCESSO = a.ID
		
		WHERE a.ID = $this->id
		
		";
		
		$lista = $this->executarQueryListaID($query);
		
		return $lista;
	}
	
	public function getDadosNumero(){
		
		$existe = $this->verificaExisteRegistro('DS_NUMERO', $this->numero);
		
		if(!$existe){
			
			$this->setMensagemResposta('Não foi encontrado processo com este número.');
			
			return 0;		
			
		}
		
		$query =
		
		"SELECT 
		
		a.*, 
		DATE_FORMAT(a.DT_ENTRADA, '%d/%m/%Y') DT_ENTRADA,
		DATE_FORMAT(a.DT_SAIDA, '%d/%m/%Y') DT_SAIDA,
		DATE_FORMAT(a.DT_PRAZO, '%d/%m/%Y') DT_PRAZO,
		b.DS_NOME NOME_SERVIDOR,
		c.DS_NOME NOME_SETOR,
		d.DS_NOME NOME_ASSUNTO,
		e.DS_NOME NOME_ORGAO
			
		FROM tb_processos a
		
		LEFT JOIN tb_servidores b ON a.ID_SERVIDOR_LOCALIZACAO = b.ID 
		LEFT JOIN tb_setores c ON b.ID_SETOR = c.ID 
		LEFT JOIN tb_assuntos_processos d ON a.ID_ASSUNTO = d.ID 
		LEFT JOIN tb_orgaos e ON a.ID_ORGAO_INTERESSADO = e.ID
		
		WHERE a.DS_NUMERO = '$this->numero'
		
		";
		
		$lista = $this->executarQueryListaID($query);
		
		$this->setMensagemResposta('O processo foi encontrado!');
		
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
		
		$query = "UPDATE tb_processos SET BL_RECEBIDO = 1, ID_SERVIDOR_LOCALIZACAO = $this->servidorLocalizacao WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id) OR ID IN (SELECT ID_PROCESSO FROM tb_processos_apensados WHERE ID_PROCESSO_APENSADO = $this->id)";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('CONFIRMOU O RECEBIMENTO', 'CONFIRMAR PROCESSO');
		
		return $resultado;
		
	}
	
	public function devolver(){
		
		$query = "UPDATE tb_processos SET BL_RECEBIDO = 1, ID_SERVIDOR_LOCALIZACAO = (SELECT ID_SERVIDOR FROM tb_historico_processos WHERE DS_ACAO = 'TRAMITAÇÃO' AND ID_REFERENTE = $this->id ORDER BY DT_MENSAGEM DESC LIMIT 1) WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id) OR ID IN (SELECT ID_PROCESSO FROM tb_processos_apensados WHERE ID_PROCESSO_APENSADO = $this->id)";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('DEVOLVEU O PROCESSO', 'RETORNAR PROCESSO');
		
		return $resultado;
		
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
	
	public function solicitarSobrestado(){
		
		$data = date('Y-m-d H:i:s');
		
		$query = "INSERT INTO tb_processos_sobrestados (ID_PROCESSO, ID_SERVIDOR_SOLICITANTE, DS_JUSTIFICATIVA, ID_SERVIDOR_RESPOSTA, DT_SOLICITACAO, DT_RESPOSTA, DS_STATUS) VALUES ($this->id, $this->servidorSessao, '$this->justificativaSobrestado', $this->servidorSessao, '$data', '$data', 'ACEITO')";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico("SOLICITOU COLOCAR PROCESSO EM SOBRESTADO: $this->justificativaSobrestado", 'SOBRESTADO');
		
		$query = "UPDATE tb_processos SET BL_SOBRESTADO = 1 WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('ACEITOU A SOLICITAÇÃO E MARCOU O PROCESSO COMO SOBRESTADO', 'SOBRESTADO');
		
		return $resultado;
		
	}
	
	public function getListaApensados(){
	
		$query = "
		
		SELECT b.ID_PROCESSO_APENSADO, c.DS_NUMERO 

		FROM tb_processos a 

		INNER JOIN tb_processos_apensados b ON a.ID = b.ID_PROCESSO 
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
	
	public function excluir(){
		
		$query = "SELECT DS_ANEXO FROM tb_documentos WHERE ID_PROCESSO = $this->id OR ID_PROCESSO IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
		$listaDocumentos = $this->executarQueryLista($query);
		
		foreach($listaDocumentos as $documento){
			
			$this->excluirArquivo('anexos', $documento['DS_ANEXO']);
	
		}
	
		$query = "DELETE FROM tb_processos WHERE ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
		$this->executarQuery($query);
		
		$resultado = parent::excluir();
		
		return $resultado;
	
	}

}	

?>