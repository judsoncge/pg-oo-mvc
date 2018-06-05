<?php 

include("../../banco-dados/conectar.php");
include("../../funcoes.php");
session_start();

$filtroservidor = $_POST['filtroservidor'];

$filtrosetor = $_POST['filtrosetor'];

$filtrosituacao = $_POST['filtrosituacao'];

$filtrosobrestado = $_POST['filtrosobrestado'];

$filtroprocesso = $_POST['filtroprocesso'];

$id = $_SESSION['id'];
	
$funcao = $_SESSION["funcao"];

$setor = $_SESSION["setor"];

$setor_sub = $_SESSION['setor-subordinado'];

$setor_sup = retorna_setor_superior($setor, $conexao_com_banco);

if($funcao=='PROTOCOLO' or $funcao=='SUPERINTENDENTE' or $funcao=='ASSESSOR TÉCNICO' or $funcao=='GABINETE' or $funcao=='COMUNICAÇÃO' or $funcao=='TÉCNICO ANALISTA CORREÇÃO'){ 
	
	//o todos desses perfis é só o que ele pode realmente ver, por isso a query fica personalizada
	if($filtroservidor == '%'){
		$filtroservidor = "(ID_SERVIDOR_LOCALIZACAO IN (SELECT ID FROM tb_servidores WHERE ID_SETOR='$setor' or ID_SETOR='$setor_sub' or ID_SETOR='$setor_sup'))";
	}else{
		$filtroservidor = "ID_SERVIDOR_LOCALIZACAO like '$filtroservidor'";
	}

	if($filtrosetor == '%'){
		$filtrosetor = "(ID_SETOR_LOCALIZACAO='$setor' or ID_SETOR_LOCALIZACAO='$setor_sub' or ID_SETOR_LOCALIZACAO = '$setor_sup')";
	}else{
		$filtrosetor = "ID_SETOR_LOCALIZACAO like '$filtrosetor'";
	}

	$lista = mysqli_query($conexao_com_banco, 

	"SELECT * FROM tb_processos WHERE $filtroservidor and $filtrosetor and BL_ATRASADO like '$filtrosituacao' and BL_SOBRESTADO like '$filtrosobrestado' and CD_PROCESSO LIKE '%$filtroprocesso%' and NM_STATUS NOT IN ('ARQUIVADO', 'SAIU') ORDER BY BL_URGENCIA DESC, NR_DIAS DESC"
	
	);

}elseif($funcao=='TÉCNICO ANALISTA' or $funcao=='TÉCNICO ANALISTA CORREÇÃO' or $funcao=='OUTRO'){	

	if($filtroservidor == '%'){
		$filtroservidor = "(ID_SERVIDOR_LOCALIZACAO = '$id')";
	}else{
		$filtroservidor = "ID_SERVIDOR_LOCALIZACAO like '$filtroservidor'";
	}

	if($filtrosetor == '%'){
		$filtrosetor = "(ID_SETOR_LOCALIZACAO='$setor')";
	}else{
		$filtrosetor = "ID_SETOR_LOCALIZACAO like '$filtrosetor'";
	}
	
	$lista = mysqli_query($conexao_com_banco, 

	"SELECT * FROM tb_processos WHERE $filtroservidor and $filtrosetor and BL_ATRASADO like '$filtrosituacao' and BL_SOBRESTADO like '$filtrosobrestado' and CD_PROCESSO LIKE '%$filtroprocesso%' and NM_STATUS NOT IN ('ARQUIVADO', 'SAIU') ORDER BY BL_URGENCIA DESC, NR_DIAS DESC"
	
	);


}elseif($funcao=='CONTROLADOR' or $funcao=='CHEFE DE GABINETE' or $funcao=='TI'){
	
	
	$filtroservidor = "ID_SERVIDOR_LOCALIZACAO like '$filtroservidor'";
	
	$filtrosetor = "ID_SETOR_LOCALIZACAO like '$filtrosetor'";
	
	$lista = mysqli_query($conexao_com_banco, 

	"SELECT * FROM tb_processos WHERE $filtroservidor and $filtrosetor and BL_ATRASADO like '$filtrosituacao' and BL_SOBRESTADO like '$filtrosobrestado' and CD_PROCESSO LIKE '%$filtroprocesso%' and NM_STATUS NOT IN ('ARQUIVADO', 'SAIU') ORDER BY BL_URGENCIA DESC, NR_DIAS DESC"
	
	);

}

include('../tabela-ativos.php');

include('../../foot.php')?>
