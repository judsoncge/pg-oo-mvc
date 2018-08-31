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
	private $dias;
	private $responsavel;
	private $documento;
	private $justificativaSobrestado;
	private $tipoDocumento;
	private $anexoDocumento;
	private $listaResponsaveis;
	private $listaApensos;
	private $responsavelLider;
	private $apenso;
	
	public function setDias($dias){
		
		$this->dias = $dias;
		
	}
	
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
		
		$this->justificativaSobrestado = addslashes($justificativaSobrestado);
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
		$this->interessado = addslashes($interessado);
	}
	
	public function setDetalhes($detalhes){
		$this->detalhes = addslashes($detalhes);
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
		
		$query = "INSERT INTO tb_processos (DS_NUMERO, BL_URGENCIA, ID_ASSUNTO, DS_DETALHES, ID_ORGAO_INTERESSADO, DS_INTERESSADO, DT_ENTRADA, DT_PRAZO, ID_SERVIDOR_LOCALIZACAO) VALUES ('$this->numero',$this->urgencia, $this->assunto,'".strtoupper($this->detalhes)."',$this->orgao,'".strtoupper($this->interessado)."','$data','$this->prazo', $this->servidorLocalizacao)";
		
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
		
		$query = "INSERT INTO tb_documentos (ID_PROCESSO, DS_TIPO, DT_CRIACAO, ID_SERVIDOR_CRIACAO, DS_ANEXO) VALUES ($this->id, '$this->tipoDocumento', '$data', ".$_SESSION['ID'].", '$nomeAnexo')";
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('ANEXOU UM DOCUMENTO AO PROCESSO','CRIAÇÃO DE DOCUMENTO');
		
		return $resultado;
		
	}
	
	public function getListaPodemSerResponsaveis(){
		
		
		
		switch($_SESSION['FUNCAO']){
			
			case 'SUPERINTENDENTE':
			case 'ASSESSOR TÉCNICO':
			case 'COMUNICAÇÃO':
				$setor = $_SESSION['SETOR'];
				$query = "SELECT ID, DS_NOME FROM tb_servidores WHERE DS_FUNCAO IN ('TÉCNICO ANALISTA', 'TÉCNICO ANALISTA CORREÇÃO', 'SUPERINTENDENTE', 'ASSESSOR TÉCNICO', 'COMUNICAÇÃO') AND (DS_STATUS = 'ATIVO') AND (ID_SETOR = $setor OR ID_SETOR = (SELECT ID_SETOR_SUBORDINADO FROM tb_setores WHERE ID = $setor)) AND ID NOT IN (SELECT ID_SERVIDOR FROM tb_responsaveis_processos WHERE ID_PROCESSO='$this->id') ORDER BY DS_NOME";
				break;
			
			case 'TI':
			case 'GABINETE':
			case 'CHEFE DE GABINETE':
			case 'CONTROLADOR':
				$query = "SELECT ID, DS_NOME FROM tb_servidores WHERE DS_FUNCAO IN ('TÉCNICO ANALISTA', 'TÉCNICO ANALISTA CORREÇÃO', 'SUPERINTENDENTE', 'ASSESSOR TÉCNICO') AND DS_STATUS = 'ATIVO' ORDER BY DS_NOME";
				break;
				
			
		}
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;

	}
	
	public function getListaProcessosApensar(){
		
		$query = "SELECT ID, DS_NUMERO FROM tb_processos WHERE ID != $this->id AND ID_SERVIDOR_LOCALIZACAO = ".$_SESSION['ID']." AND BL_RECEBIDO = 1 AND ID NOT IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados)";
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;

	}
	
	public function tramitar(){
		
		$query = "SELECT ID_SETOR FROM tb_servidores WHERE ID = $this->servidorLocalizacao";
		
		$setor = $this->executarQueryRegistro($query);
		
		$recebido = ($setor == 14) ? 1 : 0;
		
		$query = "UPDATE tb_processos SET BL_RECEBIDO = $recebido, ID_SERVIDOR_LOCALIZACAO = $this->servidorLocalizacao WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
		$this->executarQuery($query);
		
		$nomeServidor = $this->getNomeServidorLocalizacao();
		
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
			
			$this->executarQuery($query);
			
		}
		
		$resultado = $this->cadastrarHistorico('DEFINIU OS RESPONSÁVEIS DO PROCESSO','RESPONSÁVEIS');
		
		return $resultado; 
		
	}
	
	public function definirResponsavelLider(){
		
		$query = "UPDATE tb_responsaveis_processos SET BL_LIDER = 1 WHERE ID_PROCESSO = $this->id AND ID_SERVIDOR = $this->responsavelLider";
		
		$this->executarQuery($query);
		
		$query = "UPDATE tb_responsaveis_processos SET BL_LIDER = 0 WHERE ID_PROCESSO = $this->id AND ID_SERVIDOR != $this->responsavelLider";
		
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
			
				$setor = $_SESSION['SETOR'];
				
				$query = "UPDATE tb_processos SET ID_SETOR_RESPONSAVEL = $setor WHERE ID = $this->id";
				
				$this->executarQuery($query);
				
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
		
		if($this->assunto == NULL){
			
			$qtdDiasPrazo = 60;
		
		}else{
			
			$query = "SELECT NR_DIAS_PRAZO FROM tb_assuntos_processos WHERE ID = $this->assunto";
		
			$qtdDiasPrazo = $this->executarQueryRegistro($query);
			
		}
		
		$this->prazo = $this->somarData($this->dataEntrada, $qtdDiasPrazo);
		
		$query = "UPDATE tb_processos SET DT_ENTRADA = '$this->dataEntrada', DT_PRAZO = '$this->prazo', DT_SAIDA = NULL, ID_SERVIDOR_LOCALIZACAO = $this->servidorLocalizacao, NR_DIAS = 0, DS_STATUS = 'EM ANDAMENTO', BL_ATRASADO = 0 WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
		
		$this->executarQuery($query);
		
		$resultado = $this->cadastrarHistorico('COLOCOU O PROCESSO DE VOLTA NO ORGAO', 'VOLTAR');
		
		return $resultado;		
		
	}
	
	public function desarquivar(){
		
		$status = ($_SESSION['FUNCAO']=='CHEFE DE GABINETE' || $_SESSION['FUNCAO']=='GABINETE') ? 'FINALIZADO PELO GABINETE' : 'FINALIZADO PELO SETOR';
		
		$data = date('Y-m-d');
		
		$query = "UPDATE tb_processos SET BL_ATRASADO = 0, DS_STATUS = '$status', ID_SERVIDOR_LOCALIZACAO = $this->servidorLocalizacao, DT_ENTRADA = '$data', DT_SAIDA = NULL, NR_DIAS = 0 WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id)";
		
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
		
		WHERE a.ID = '$this->id'
		
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
	
	public function getFraseTabelaProcessosSemFiltro(){
		
		$frase = 'Todos os processos que estão';
		
		switch($_SESSION['FUNCAO']){
			
			case 'PROTOCOLO':
			case 'GABINETE':
			case 'TÉCNICO ANALISTA CORREÇÃO':
			case 'COMUNICAÇÃO':
				$frase .= ' no meu setor';
				break;
			
			case 'SUPERINTENDENTE':
			case 'ASSESSOR TÉCNICO':
				$frase .= ' na minha superintendência';
				break;
				
			case 'TÉCNICO ANALISTA':
				$frase .= ' comigo';
				break;
				
			case 'CONTROLADOR':
			case 'CHEFE DE GABINETE':
			case 'TI':
				$frase = 'Todos os processos';
				break;

		}
		
		return $frase;
		
	}
	
	public function getListaServidoresFiltro(){
		
		$setor = $_SESSION['SETOR'];
			
		switch($_SESSION['FUNCAO']){
			
			case 'PROTOCOLO':
			case 'GABINETE':
				$query = "SELECT ID, DS_NOME FROM tb_servidores WHERE ID_SETOR = $setor AND DS_STATUS = 'ATIVO' ORDER BY DS_NOME";
				break;
				
			case 'TÉCNICO ANALISTA':
				$servidor = $_SESSION['ID'];
				$query = "SELECT ID, DS_NOME FROM tb_servidores WHERE ID = $servidor AND DS_STATUS = 'ATIVO' ORDER BY DS_NOME";
				break;
			
			case 'TÉCNICO ANALISTA CORREÇÃO':

				$query = "SELECT ID, DS_NOME FROM tb_servidores WHERE ID_SETOR = $setor OR ID_SETOR IN (SELECT ID FROM tb_setores WHERE ID_SETOR_SUBORDINADO = $setor) AND DS_STATUS = 'ATIVO' ORDER BY DS_NOME";
				break;
				
			case 'SUPERINTENDENTE':
			case 'ASSESSOR TÉCNICO':
			case 'COMUNICAÇÃO':
				$query = "SELECT ID, DS_NOME FROM tb_servidores WHERE ID_SETOR = $setor OR ID_SETOR IN (SELECT ID_SETOR_SUBORDINADO FROM tb_setores WHERE ID = $setor) AND DS_STATUS = 'ATIVO' ORDER BY DS_NOME";
				break;
				
			case 'CONTROLADOR':
			case 'CHEFE DE GABINETE':
			case 'TI':
				$query = "SELECT ID, DS_NOME FROM tb_servidores WHERE DS_STATUS = 'ATIVO' ORDER BY DS_NOME";
				break;
		}
		
		$listaServidores = $this->executarQueryLista($query);
		
		return $listaServidores;
	}

	public function getListaSetoresFiltro(){
		
		$setor = $_SESSION['SETOR'];
			
		switch($_SESSION['FUNCAO']){
			
			case 'SUPERINTENDENTE':
			case 'ASSESSOR TÉCNICO':
			case 'COMUNICAÇÃO':
				$query = "SELECT ID, DS_ABREVIACAO FROM tb_setores WHERE ID = $setor OR ID IN (SELECT ID_SETOR_SUBORDINADO FROM tb_setores WHERE ID = $setor)";
				break;
				
			case 'TÉCNICO ANALISTA CORREÇÃO':
				$query = "SELECT ID, DS_ABREVIACAO FROM tb_setores WHERE ID = $setor OR ID IN (SELECT ID FROM tb_setores WHERE ID_SETOR_SUBORDINADO = $setor)";
				break;
				
			case 'TÉCNICO ANALISTA':
			case 'TÉCNICO ANALISTA CORREÇÃO':
			case 'PROTOCOLO':
			case 'GABINETE':
				$servidor = $_SESSION['ID'];
				$query = "SELECT ID, DS_ABREVIACAO FROM tb_setores WHERE ID = $setor";
				break;
				
			case 'CONTROLADOR':
			case 'CHEFE DE GABINETE':
			case 'TI':
				$query = "SELECT ID, DS_ABREVIACAO FROM tb_setores";
				break;
		}
		
		$listaSetores = $this->executarQueryLista($query);
		
		return $listaSetores;
	}
	
	
	public function getListaProcessosStatus(){
		
		$setor = $_SESSION['SETOR'];
		$servidor = $_SESSION['ID'];
		
		$restricaoStatus = ($this->status == 'ATIVO') ? " NOT IN ('ARQUIVADO', 'SAIU') " : " IN ('ARQUIVADO', 'SAIU') ";
		
		$order = "ORDER BY BL_URGENCIA DESC, BL_ATRASADO DESC, NR_DIAS DESC";
		
		switch($_SESSION['FUNCAO']){
			
			case 'PROTOCOLO':
			case 'GABINETE':
			
				$query = "SELECT 
		
					a.*,
					DATE_FORMAT(a.DT_PRAZO, '%d/%m/%Y') DT_PRAZO,
					c.DS_NOME NOME_SERVIDOR,
					c.ID_SETOR,
					d.DS_ABREVIACAO NOME_SETOR
					
					FROM tb_processos a
					
					INNER JOIN tb_servidores c ON a.ID_SERVIDOR_LOCALIZACAO = c.ID
					INNER JOIN tb_setores d ON c.ID_SETOR = d.ID
					
					WHERE a.DS_STATUS $restricaoStatus 
					
					AND d.ID = $setor
					
					$order";
					
					break;
					
			case 'TÉCNICO ANALISTA CORREÇÃO':
			
				$query = "SELECT 
		
					a.*,
					DATE_FORMAT(a.DT_PRAZO, '%d/%m/%Y') DT_PRAZO,
					c.DS_NOME NOME_SERVIDOR,
					c.ID_SETOR,
					d.DS_ABREVIACAO NOME_SETOR
					
					FROM tb_processos a
					
					INNER JOIN tb_servidores c ON a.ID_SERVIDOR_LOCALIZACAO = c.ID
					INNER JOIN tb_setores d ON c.ID_SETOR = d.ID
					
					WHERE a.DS_STATUS $restricaoStatus 
					
					AND (d.ID = $setor OR d.ID IN (SELECT ID FROM tb_setores WHERE ID_SETOR_SUBORDINADO = $setor))
					
					$order";
					
					break;					
			
			case 'SUPERINTENDENTE':
			case 'ASSESSOR TÉCNICO':
			case 'COMUNICAÇÃO':
				
				$query = "SELECT 
		
					a.*,
					DATE_FORMAT(a.DT_PRAZO, '%d/%m/%Y') DT_PRAZO,
					c.DS_NOME NOME_SERVIDOR,
					c.ID_SETOR,
					d.DS_ABREVIACAO NOME_SETOR
					
					FROM tb_processos a
					
					INNER JOIN tb_servidores c ON a.ID_SERVIDOR_LOCALIZACAO = c.ID
					INNER JOIN tb_setores d ON c.ID_SETOR = d.ID
					
					WHERE a.DS_STATUS $restricaoStatus 
					
					AND (d.ID = $setor OR d.ID IN (SELECT ID_SETOR_SUBORDINADO FROM tb_setores WHERE ID = $setor))
					
					$order";
					
					break;
				
			case 'TÉCNICO ANALISTA':
				
				$query = "SELECT 
		
					a.*,
					DATE_FORMAT(a.DT_PRAZO, '%d/%m/%Y') DT_PRAZO,
					c.DS_NOME NOME_SERVIDOR,
					c.ID_SETOR,
					d.DS_ABREVIACAO NOME_SETOR
					
					FROM tb_processos a
					
					INNER JOIN tb_servidores c ON a.ID_SERVIDOR_LOCALIZACAO = c.ID
					INNER JOIN tb_setores d ON c.ID_SETOR = d.ID
					
					WHERE a.DS_STATUS $restricaoStatus 
					
					AND a.ID_SERVIDOR_LOCALIZACAO = $servidor 
					
					$order";
					
					break;
				
			case 'CONTROLADOR':
			case 'CHEFE DE GABINETE':
			case 'TI':
				
				$query = "SELECT 
		
					a.*,
					DATE_FORMAT(a.DT_PRAZO, '%d/%m/%Y') DT_PRAZO,
					c.DS_NOME NOME_SERVIDOR,
					c.ID_SETOR,
					d.DS_ABREVIACAO NOME_SETOR
					
					FROM tb_processos a
					
					INNER JOIN tb_servidores c ON a.ID_SERVIDOR_LOCALIZACAO = c.ID
					INNER JOIN tb_setores d ON c.ID_SETOR = d.ID
					
					WHERE a.DS_STATUS $restricaoStatus 
					
					$order";
					
					break;
			
		}
		
		//echo $query; exit();
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;
		
	}
	
	public function getListaProcessosStatusComFiltro(){
		
		$restricaoStatus = ($this->status == 'ATIVO') ? " NOT IN ('ARQUIVADO', 'SAIU') " : " IN ('ARQUIVADO', 'SAIU') ";
		
		$order = "ORDER BY BL_URGENCIA DESC, BL_ATRASADO DESC, NR_DIAS DESC";
		
		if($this->servidorLocalizacao == '%' and $this->setorLocalizacao != '%'){
			
			$restricaoServidorSetor = "ID_SERVIDOR_LOCALIZACAO IN (SELECT ID FROM tb_servidores WHERE ID_SETOR like '$this->setorLocalizacao')";
		
		}elseif($this->servidorLocalizacao != '%' and $this->setorLocalizacao == '%'){
			
			$restricaoServidorSetor = "ID_SERVIDOR_LOCALIZACAO like '$this->servidorLocalizacao'";
		
		}elseif($this->servidorLocalizacao != '%' and $this->setorLocalizacao != '%'){
			
			$restricaoServidorSetor = "(ID_SERVIDOR_LOCALIZACAO like '$this->servidorLocalizacao' OR ID_SERVIDOR_LOCALIZACAO IN (SELECT ID FROM tb_servidores WHERE ID_SETOR = '$this->setorLocalizacao'))";
			
		}elseif($this->servidorLocalizacao == '%' and $this->setorLocalizacao == '%'){
			
			$restricaoServidorSetor = "ID_SERVIDOR_LOCALIZACAO like '%'";
		}

		if($this->dias != '%'){
			
			$quantidadeDias = explode('-', $this->dias);
			$intervalo1 = $quantidadeDias[0];
			$intervalo2 = $quantidadeDias[1];
			$restricaoDias = "AND NR_DIAS BETWEEN $intervalo1 AND $intervalo2";
			
		}else{
			
			$restricaoDias = '';
			
		}

		switch($_SESSION['FUNCAO']){
			
			case 'PROTOCOLO':
			case 'GABINETE':
			case 'COMUNICAÇÃO':
			case 'SUPERINTENDENTE':
			case 'ASSESSOR TÉCNICO':
			
				$setor = $_SESSION['SETOR'];
				
				$restricaoSetor = ($this->setorLocalizacao == '%') 
				
				? 
				
				"(SELECT ID FROM tb_servidores WHERE ID_SETOR = $setor OR ID_SETOR IN (SELECT ID_SETOR_SUBORDINADO FROM tb_setores WHERE ID = $setor))" 
				
				: "(SELECT ID FROM tb_servidores WHERE ID_SETOR = $this->setorLocalizacao)";
				
				$restricaoServidor = ($this->servidorLocalizacao == '%') ? '' : "AND ID_SERVIDOR_LOCALIZACAO = '$this->servidorLocalizacao'";
			
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
					
					WHERE a.DS_STATUS $restricaoStatus 
					
					AND ID_SERVIDOR_LOCALIZACAO IN $restricaoSetor
					
					$restricaoServidor
					
					AND BL_ATRASADO like '$this->atrasado' 
					
					AND BL_SOBRESTADO like '$this->sobrestado'
					
					AND BL_RECEBIDO like '$this->recebido'
					
					AND DS_NUMERO LIKE '%$this->numero%'
					
					$restricaoDias
					
					$order
					
				";
				
				break;
				
			case 'TÉCNICO ANALISTA CORREÇÃO':
			
				$setor = $_SESSION['SETOR'];
				
				$restricaoSetor = ($this->setorLocalizacao == '%') 
				
				? 
				
				"(SELECT ID FROM tb_servidores WHERE ID_SETOR = $setor OR ID_SETOR IN (SELECT ID FROM tb_setores WHERE ID_SETOR_SUBORDINADO = $setor))" 
				
				: "(SELECT ID FROM tb_servidores WHERE ID_SETOR = $this->setorLocalizacao)";
				
				$restricaoServidor = ($this->servidorLocalizacao == '%') ? '' : "AND ID_SERVIDOR_LOCALIZACAO = '$this->servidorLocalizacao'";
			
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
					
					WHERE a.DS_STATUS $restricaoStatus 
					
					AND ID_SERVIDOR_LOCALIZACAO IN $restricaoSetor
					
					$restricaoServidor
					
					AND BL_ATRASADO like '$this->atrasado' 
					
					AND BL_SOBRESTADO like '$this->sobrestado'
					
					AND BL_RECEBIDO like '$this->recebido'
					
					AND DS_NUMERO LIKE '%$this->numero%'
					
					$restricaoDias
					
					$order
					
				";
				
				break;
				
			case 'TÉCNICO ANALISTA':
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
					
					WHERE a.DS_STATUS $restricaoStatus 
					
					AND ID_SERVIDOR_LOCALIZACAO = $this->servidorLocalizacao
					
					AND BL_ATRASADO like '$this->atrasado' 
					
					AND BL_SOBRESTADO like '$this->sobrestado'
					
					AND BL_RECEBIDO like '$this->recebido'
					
					AND DS_NUMERO LIKE '%$this->numero%'
					
					$restricaoDias
					
					$order
					
				";
				break;
				
			case 'CONTROLADOR':
			case 'CHEFE DE GABINETE':
			case 'TI':
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
					
					WHERE a.DS_STATUS $restricaoStatus 
					
					AND $restricaoServidorSetor
					
					AND BL_ATRASADO like '$this->atrasado' 
					
					AND BL_SOBRESTADO like '$this->sobrestado'
					
					AND BL_RECEBIDO like '$this->recebido'
					
					AND DS_NUMERO LIKE '%$this->numero%'
					
					$restricaoDias
					
					$order
					
					";
					break;
					

		}
				
		$lista = $this->executarQueryLista($query);
		
		return $lista;
		
	}
	
	public function getFraseTabelaProcessosComFiltro(){
		
		$nomeServidor = $this->getNomeServidorLocalizacao();
			
		$nomeSetor = $this->getNomeSetorLocalizacao();
		
		$funcao = $_SESSION['FUNCAO'];
		
		$frase = $this->getFraseTabelaProcessosSemFiltro();
		
		if($funcao != 'TÉCNICO ANALISTA'){
			
			if($this->servidorLocalizacao == '%'){
			
				$frase .= ($this->setorLocalizacao != '%') ? " que estão no setor $nomeSetor; " : '';
		
			}else{
				
				if($funcao == 'TÉCNICO ANALISTA CORREÇÃO' or $funcao == 'PROTOCOLO' or $funcao == 'GABINETE'){
					
					$frase .= " que estão com $nomeServidor;";
					
				}else{
					
					$frase .= ($this->setorLocalizacao != '%') ? " que estão com $nomeServidor e também no setor $nomeSetor; " : " que estão com $nomeServidor;";
					
				}

			}
			
		}
		
		
		if($this->atrasado != '%'){
			
			$frase .= ($this->atrasado) ? ' que estão atrasados;' : ' que estão no prazo;';
			
		}
		
		if($this->sobrestado != '%'){
			
			$frase .= ($this->sobrestado) ? ' que estão em sobrestado;' : ' que não estão em sobrestado;';
			
		}
		
		if($this->recebido != '%'){
			
			$frase .= ($this->recebido) ? ' que foram recebidos;' : ' que não foram recebidos;';
			
		}
		
		$frase .= ($this->numero != '') ? " que contém $this->numero no número" : '';
		
		return $frase;

	}
	
	public function getNomeServidorLocalizacao(){
		
		$query = "SELECT DS_NOME FROM tb_servidores WHERE ID like '$this->servidorLocalizacao'";
		
		$nomeServidor = strtoupper($this->executarQueryRegistro($query));
		
		return $nomeServidor;

	}
	
	public function getNomeSetorLocalizacao(){
		
		$query = "SELECT DS_NOME FROM tb_setores WHERE ID like '$this->setorLocalizacao'";
		
		$nomeSetor = strtoupper($this->executarQueryRegistro($query));
		
		return $nomeSetor;

	}
	
	public function getListaAssuntos(){
		
		$query = "SELECT * FROM tb_assuntos_processos ORDER BY DS_NOME";
		
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
		
		$servidor = $_SESSION['ID'];
		
		$setor = $_SESSION['SETOR'];
		
		$mes = date('m');
		
		$ano = date('Y');
		
		$query = "SELECT * FROM tb_processos_recebidos_setor WHERE ID_SETOR = $setor AND NR_MES = $mes AND NR_ANO = $ano";
		
		$existe = $this->verificaExisteRegistroQuery($query);
		
		if(!$existe){
			
			$query = "INSERT INTO tb_processos_recebidos_setor (ID_SETOR, NR_MES, NR_ANO) VALUES ($setor, $mes, $ano)";
			
			$resultado = $this->executarQuery($query);
			
		}
		
		$query = "SELECT * FROM tb_historico_processos a INNER JOIN tb_servidores b ON a.ID_SERVIDOR = b.ID WHERE a.ID_REFERENTE = $this->id AND a.DS_ACAO = 'CONFIRMAR PROCESSO' AND b.ID_SETOR = $setor AND a.ID_SERVIDOR != $servidor";
		
		$existe = $this->verificaExisteRegistroQuery($query);
		
		if(!$existe){
			
			$query = "UPDATE tb_processos_recebidos_setor SET NR_QUANTIDADE = NR_QUANTIDADE + 1 WHERE ID_SETOR = $setor AND NR_MES = $mes AND NR_ANO = $ano";
			
			$resultado = $this->executarQuery($query);
			
		}

		return $resultado;
		
	}
	
	public function devolver(){
		
		$query = "UPDATE tb_processos SET BL_RECEBIDO = 1, ID_SERVIDOR_LOCALIZACAO = (SELECT ID_SERVIDOR FROM tb_historico_processos WHERE DS_ACAO = 'TRAMITAÇÃO' AND ID_REFERENTE = $this->id ORDER BY DT_ACAO DESC LIMIT 1) WHERE ID = $this->id OR ID IN (SELECT ID_PROCESSO_APENSADO FROM tb_processos_apensados WHERE ID_PROCESSO = $this->id) OR ID IN (SELECT ID_PROCESSO FROM tb_processos_apensados WHERE ID_PROCESSO_APENSADO = $this->id)";
		
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

		ORDER BY b.DS_NOME";
		
		$lista = $this->executarQueryLista($query);
		
		return $lista;
		
		
	}
	
	public function solicitarSobrestado(){
		
		$data = date('Y-m-d H:i:s');
		
		$query = "INSERT INTO tb_processos_sobrestados (ID_PROCESSO, ID_SERVIDOR_SOLICITANTE, DS_JUSTIFICATIVA, ID_SERVIDOR_RESPOSTA, DT_SOLICITACAO, DT_RESPOSTA, DS_STATUS) VALUES ($this->id, ".$_SESSION['ID'].", '$this->justificativaSobrestado', ".$_SESSION['ID'].", '$data', '$data', 'ACEITO')";
		
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
	
	
	
	public function getListaServidoresTramitar(){
		
		$setor = $_SESSION['SETOR'];
		
		switch($_SESSION['FUNCAO']){
				
			case 'PROTOCOLO':
			
				$query = "SELECT ID, DS_NOME FROM tb_servidores WHERE (ID_SETOR = 5 OR ID_SETOR = 10) AND DS_STATUS = 'ATIVO' ORDER BY DS_NOME";
				
				break;
			
			case 'SUPERINTENDENTE':
			case 'ASSESSOR TÉCNICO':
			
				$query = "SELECT ID, DS_NOME FROM tb_servidores WHERE ID_SETOR = 5 OR ID_SETOR = $setor OR ID_SETOR IN (SELECT ID_SETOR_SUBORDINADO FROM tb_setores WHERE ID = $setor) OR DS_FUNCAO = 'SUPERINTENDENTE' AND DS_STATUS = 'ATIVO' ORDER BY DS_NOME";
				
				break;
			
			case 'TÉCNICO ANALISTA':

				$query = "SELECT ID, DS_NOME FROM tb_servidores WHERE (ID_SETOR IN (SELECT ID FROM tb_setores WHERE ID_SETOR_SUBORDINADO = $setor) OR (DS_FUNCAO = 'TÉCNICO ANALISTA CORREÇÃO' AND ID_SETOR = $setor)) AND DS_STATUS = 'ATIVO' ORDER BY DS_NOME";
				
				break;
				
			case 'TÉCNICO ANALISTA CORREÇÃO':
				
				$query = "SELECT ID, DS_NOME FROM tb_servidores WHERE ID_SETOR = $setor OR ID_SETOR IN (SELECT ID FROM tb_setores WHERE ID_SETOR_SUBORDINADO = $setor) AND DS_STATUS = 'ATIVO' ORDER BY DS_NOME";
				
				break;
				
			case 'GABINETE':
				
				$query = "SELECT ID, DS_NOME FROM tb_servidores WHERE DS_FUNCAO IN ('SUPERINTENDENTE', 'ASSESSOR TÉCNICO', 'PROTOCOLO') AND DS_STATUS = 'ATIVO' ORDER BY DS_NOME";
				
				break;
				
			case 'CONTROLADOR':
			case 'CHEFE DE GABINETE':
			case 'TI':
				
				$query = "SELECT ID, DS_NOME FROM tb_servidores WHERE DS_STATUS = 'ATIVO' ORDER BY DS_NOME";
				
				break;	

		}
		
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
	
	public function getQuantidadeProcessos(){
		
		$query = 'SELECT COUNT(*) FROM tb_processos';
		
		$quantidade = $this->executarQueryRegistro($query);
		
		return $quantidade;

	}
	
	public function getQuantidadeProcessosAtivos(){
		
		$query = "SELECT COUNT(*) FROM tb_processos WHERE DS_STATUS NOT IN ('ARQUIVADO', 'SAIU')";
		
		$quantidade = $this->executarQueryRegistro($query);
		
		return $quantidade;

	}
	
	public function getQuantidadeProcessosSituacao($situacao){
		
		$query = "SELECT COUNT(*) FROM tb_processos WHERE BL_ATRASADO = $situacao AND DS_STATUS NOT IN ('ARQUIVADO', 'SAIU')";
		
		$quantidade = $this->executarQueryRegistro($query);
		
		return $quantidade;

	}
	
	public function getQuantidadeProcessosSetor(){
		
		$query = "SELECT 
		
		d.ID,
		d.DS_NOME NOME_SETOR,
		COUNT(*) QUANTIDADE
		
		FROM tb_processos a
		
		LEFT JOIN tb_servidores c ON a.ID_SERVIDOR_LOCALIZACAO = c.ID
		LEFT JOIN tb_setores d ON c.ID_SETOR = d.ID
		
		WHERE a.DS_STATUS NOT IN ('ARQUIVADO', 'SAIU')
		
		AND d.DS_NOME IS NOT NULL
		
		GROUP BY d.ID
		
		ORDER BY QUANTIDADE DESC;
		
		";		
	
		$listaDados = $this->executarQueryLista($query);
		
		return $listaDados;
	
	}
	
	public function getQuantidadeProcessosAtrasadosNoPrazoSetor(){
		
		$query = "
		
		SELECT 
		
		c.ID,
		c.DS_NOME NOME_SETOR,
		COUNT(*) QUANTIDADE_TOTAL,
		COUNT(IF(a.BL_ATRASADO = 1,1,null)) QUANTIDADE_ATRASADOS,
		COUNT(IF(a.BL_ATRASADO = 0,1,null)) QUANTIDADE_NO_PRAZO
        

		FROM tb_processos a

		LEFT JOIN tb_servidores b ON a.ID_SERVIDOR_LOCALIZACAO = b.ID
       
        LEFT JOIN tb_setores c ON b.ID_SETOR = c.ID
       
		WHERE a.DS_STATUS NOT IN ('ARQUIVADO', 'SAIU')
		
		AND c.ID IS NOT NULL

		GROUP BY c.ID
		
		";		
	
		$listaDados = $this->executarQueryLista($query);
		
		return $listaDados;
	
	}
	
	public function getQuantidadeProcessosSetorSituacao($situacao){
		
		$query = "SELECT 
		
		c.ID,
		c.DS_NOME NOME_SETOR,
		COUNT(*) QUANTIDADE
		
		FROM tb_processos a

		LEFT JOIN tb_servidores b ON a.ID_SERVIDOR_LOCALIZACAO = b.ID
		LEFT JOIN tb_setores c ON b.ID_SETOR = c.ID

		WHERE a.DS_STATUS NOT IN ('ARQUIVADO', 'SAIU')

		AND BL_ATRASADO = $situacao
		
		AND c.DS_NOME IS NOT NULL

		GROUP BY c.ID
		
		ORDER BY QUANTIDADE DESC
		
		";		
	
		$listaDados = $this->executarQueryLista($query);
		
		return $listaDados;
	
	}
	
	public function getQuantidadeProcessosStatusSetor($status){
		
		$query = "SELECT 
		
		d.ID,
		d.DS_NOME NOME_SETOR,
		COUNT(*) QUANTIDADE
		
		FROM tb_processos a
		
		LEFT JOIN tb_servidores c ON a.ID_SERVIDOR_LOCALIZACAO = c.ID
		LEFT JOIN tb_setores d ON c.ID_SETOR = d.ID
		
		WHERE a.DS_STATUS = '$status'
		
		AND d.DS_NOME IS NOT NULL
		
		GROUP BY d.ID
		
		ORDER BY QUANTIDADE DESC
		
		";		
	
		$listaDados = $this->executarQueryLista($query);
		
		return $listaDados;
	
	}
	
	public function getTempoMedioProcessos(){
		
		$query = "SELECT 
		
		AVG(NR_DIAS) MEDIA
		
		FROM tb_processos 	
		
		WHERE DS_STATUS IN ('ARQUIVADO', 'SAIU')
		";
		
		$quantidade = $this->executarQueryRegistro($query);
		
		return $quantidade;

	}
	
	public function getTempoMedioAssunto(){
		
		$query = "SELECT 
		
		AVG(a.NR_DIAS) MEDIA,
		
		b.DS_NOME NOME_ASSUNTO
		
		FROM tb_processos a
		
		LEFT JOIN tb_assuntos_processos b ON a.ID_ASSUNTO = b.ID
		
		WHERE ID_ASSUNTO IS NOT NULL
		
		GROUP BY a.ID_ASSUNTO
		
		ORDER BY AVG(a.NR_DIAS) DESC

        		
		
		";
		
		$listaDados = $this->executarQueryLista($query);
		
		return $listaDados;

	}

}	

?>