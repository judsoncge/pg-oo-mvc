<?php

//tempo máximo para a execução do arquivo
ini_set('max_execution_time', 5000);

//definindo a hora local
date_default_timezone_set('America/Bahia');

//conectando ao banco de dados
$conexao = mysqli_connect('localhost', 'root', '', 'pg-oo-mvc');

//setando todos os nomes para o UTF8 encoding
mysqli_query($conexao, "SET NAMES 'utf8'"); 
mysqli_query($conexao, 'SET character_set_connection=utf8');
mysqli_query($conexao, 'SET character_set_client=utf8');
mysqli_query($conexao, 'SET character_set_results=utf8');


$resultado = mysqli_query($conexao, "SELECT ID, CD_PROCESSO FROM tb_historico_processos_antigo");

while($r = mysqli_fetch_array($resultado)){
	
	$numerosProcesso = explode(" ", $r['CD_PROCESSO']);
	
	$primeiraParte = (int)$numerosProcesso[0];
	
	$sp = explode("/", $numerosProcesso[1]);
	
	$segundaParte = (int)$sp[0];
	
	$terceiraParte = $sp[1];
	
	$numeroFinal = $primeiraParte . " " . $segundaParte . "/" . $terceiraParte;
	
	$id = $r['ID'];
	
	//echo "UPDATE tb_historico_processos_antigo SET CD_PROCESSO = $numeroFinal WHERE ID=$id"; exit();
	
	mysqli_query($conexao, "UPDATE tb_historico_processos_antigo SET CD_PROCESSO = $numeroFinal WHERE ID='$id'");
	
} 
















?>