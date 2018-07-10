<?php

//tempo máximo para a execução do arquivo
ini_set('max_execution_time', 5000);

//definindo a hora local
date_default_timezone_set('America/Bahia');

//conectando ao banco de dados
$conexao_com_banco = mysqli_connect('localhost', 'root', 'cgeagt', 'pg-oo-mvc');

//setando todos os nomes para o UTF8 encoding
mysqli_query($conexao_com_banco, "SET NAMES 'utf8'"); 
mysqli_query($conexao_com_banco, 'SET character_set_connection=utf8');
mysqli_query($conexao_com_banco, 'SET character_set_client=utf8');
mysqli_query($conexao_com_banco, 'SET character_set_results=utf8');

//somando +1 dia para cada processo que está ativo e não está em sobrestado
mysqli_query($conexao_com_banco, "UPDATE tb_processos SET NR_DIAS= NR_DIAS + 1 WHERE DS_STATUS!='ARQUIVADO' and DS_STATUS!='SAIU' and BL_SOBRESTADO = 0");

//somando +1 dia de sobrestado para cada processo que está ativo e está em sobrestado
mysqli_query($conexao_com_banco, "UPDATE tb_processos SET NR_DIAS_SOBRESTADO = NR_DIAS_SOBRESTADO + 1 WHERE DS_STATUS!='ARQUIVADO' and DS_STATUS!='SAIU' and BL_SOBRESTADO = 1");

//atualiza os processos que ainda estão com prazo em dia. Se não estiver, o status do processo fica em atraso
mysqli_query($conexao_com_banco,"UPDATE tb_processos SET BL_ATRASADO = 1 WHERE NM_STATUS!='ARQUIVADO' and NM_STATUS!='SAIU' and NR_DIAS > 60");
	
mysqli_query($conexao_com_banco, "UPDATE tb_processos SET BL_ATRASADO = 0 WHERE NM_STATUS!='ARQUIVADO' and NM_STATUS!='SAIU' and NR_DIAS < 61");


?>
