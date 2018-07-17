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
	
	//echo "Antes:   " . $r['CD_PROCESSO'] . "<br>"; 
	
	$id = $r['ID'];
	
	$numerosProcesso = explode(" ", $r['CD_PROCESSO']);
	$numerosProcesso2 = explode("/", $r['CD_PROCESSO']);
	
	$primeiraParte = (int)$numerosProcesso[0];
	
	$segundaParte = (int)$numerosProcesso[1];
	
	$terceiraParte = $numerosProcesso2[1];
	
	$numeroProcessoNovo = $primeiraParte . " " . $segundaParte . "/" . $terceiraParte;
	
	//echo "Segunda parte (parte 1): " . $segundaParte1 . " ;  "; 
	//echo "Segunda parte (parte 1) Consertada: " . $segundaParte1Consertada . " ;  "; 
	//echo "Número do processo final: " . $numeroProcessoNovo . " ;  <br>";
	
	//echo "Depois: " .$numeroProcessoNovo . "<br><br><br>"; 
	
	
	
	mysqli_query($conexao, "UPDATE tb_historico_processos_antigo SET CD_PROCESSO = '$numeroProcessoNovo' WHERE ID='$id'");
	
	
} 
















?>