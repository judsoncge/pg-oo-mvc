<?php


ini_set('max_execution_time', 5000);


date_default_timezone_set('America/Bahia');


$conexao = mysqli_connect('localhost', 'root', 'cgeagt', 'pg-oo-mvc');


mysqli_query($conexao, "SET NAMES 'utf8'"); 
mysqli_query($conexao, 'SET character_set_connection=utf8');
mysqli_query($conexao, 'SET character_set_client=utf8');
mysqli_query($conexao, 'SET character_set_results=utf8');


mysqli_query($conexao, "UPDATE tb_processos SET NR_DIAS= NR_DIAS + 1 WHERE DS_STATUS NOT IN ('ARQUIVADO', 'SAIU') AND BL_SOBRESTADO = 0");

mysqli_query($conexao, "UPDATE tb_processos SET NR_DIAS_SOBRESTADO = NR_DIAS_SOBRESTADO + 1 WHERE DS_STATUS NOT IN ('ARQUIVADO', 'SAIU') AND BL_SOBRESTADO = 1");

mysqli_query($conexao, "UPDATE tb_processos SET BL_ATRASADO = 1 WHERE DS_STATUS NOT IN ('ARQUIVADO', 'SAIU') AND NR_DIAS > 60 AND ID_ASSUNTO NOT IN (32, 35)");
	
mysqli_query($conexao, "UPDATE tb_processos SET BL_ATRASADO = 0 WHERE DS_STATUS NOT IN ('ARQUIVADO', 'SAIU') AND NR_DIAS < 61 AND ID_ASSUNTO NOT IN (32, 35)");

mysqli_query($conexao, "UPDATE tb_processos SET BL_ATRASADO = 1 WHERE DS_STATUS NOT IN ('ARQUIVADO', 'SAIU') AND NR_DIAS > 90 AND ID_ASSUNTO IN (32, 35)");
	
mysqli_query($conexao, "UPDATE tb_processos SET BL_ATRASADO = 0 WHERE DS_STATUS NOT IN ('ARQUIVADO', 'SAIU') AND NR_DIAS < 91 AND ID_ASSUNTO IN (32, 35)");

?>
