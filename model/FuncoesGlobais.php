<?php

ini_set('max_execution_time', 10000);

date_default_timezone_set('America/Bahia');

function somarData($data, $dias, $meses = 0, $ano = 0){
	
   $data = explode("-", $data);
   
   $novaData = date("Y-m-d", mktime(0, 0, 0, $data[1] + $meses, $data[2] + $dias, $data[0] + $ano) );
   
   return $novaData;
   
}

function retiraCaracteresEspeciais($string){
	
	$string = str_replace(" ","-",$string);
	
	$string = str_replace("á","a",$string);
	$string = str_replace("Á","A",$string);
	$string = str_replace("à","a",$string);
	$string = str_replace("ã","a",$string);
	$string = str_replace("Ã","A",$string);
	$string = str_replace("â","a",$string);
	$string = str_replace("ä","a",$string);
	
	$string = str_replace("é","e",$string);
	$string = str_replace("è","e",$string);
	$string = str_replace("ê","e",$string);
	$string = str_replace("ë","e",$string);
	
	$string = str_replace("í","i",$string);
	$string = str_replace("ì","i",$string);
	$string = str_replace("î","i",$string);
	$string = str_replace("ï","i",$string);
	
	$string = str_replace("ó","o",$string);
	$string = str_replace("ò","o",$string);
	$string = str_replace("õ","o",$string);
	$string = str_replace("ô","o",$string);
	$string = str_replace("ö","o",$string);
	
	$string = str_replace("ú","u",$string);
	$string = str_replace("ù","u",$string);
	$string = str_replace("û","u",$string);
	$string = str_replace("ü","u",$string);
	
	$string = str_replace("ç","c",$string);
	
	$string = str_replace("Á","A",$string);
	$string = str_replace("À","A",$string);
	$string = str_replace("Ã","A",$string);
	$string = str_replace("Â","A",$string);
	$string = str_replace("Ä","A",$string);
	
	$string = str_replace("É","E",$string);
	$string = str_replace("È","E",$string);
	$string = str_replace("Ê","E",$string);
	$string = str_replace("Ë","E",$string);
	
	$string = str_replace("Í","I",$string);
	$string = str_replace("Ì","I",$string);
	$string = str_replace("Î","I",$string);
	$string = str_replace("Ï","I",$string);
	
	$string = str_replace("Ó","O",$string);
	$string = str_replace("Ò","O",$string);
	$string = str_replace("Õ","O",$string);
	$string = str_replace("Ô","O",$string);
	$string = str_replace("Ö","O",$string);
	
	$string = str_replace("Ú","U",$string);
	$string = str_replace("Ù","U",$string);
	$string = str_replace("Û","U",$string);
	$string = str_replace("Ü","U",$string);
	
	$string = str_replace("Ç","C",$string);
	
	return $string;

}

//funcao que anexa um arquivo
function registrarAnexo($file, $caminho){
	
	//verifica se de fato é um arquivo que foi anexado
	if(is_file($file['tmp_name'])){

		//a variavel recebe o nome do arquivo anexado pelo usuário
		$nomeAnexo = $file['name'];
		
		//a variavel recebe o novo nome sem os caracteres especiais 
		$nomeAnexo = retiraCaracteresEspeciais($nomeAnexo);
		
		//verifica se este anexo já está gravado na pasta	
		if(file_exists($caminho.$nomeAnexo)){ 
				
				//se sim, coloca um número na frente do anexo, para diferenciar o nome
				$a = 1;
				while(file_exists($caminho."[$a]".$nomeAnexo."")){
				$a++;
				}
				//a variavel recebe [1]nome caso já tenha um gravado, [2]nome caso já tenham dois gravados na pasta, e assim por diante
				$nomeAnexo = "[".$a."]".$nomeAnexo;
			}
		
		//salva o arquivo na pasta de acordo com o tipo de anexo
		move_uploaded_file($file['tmp_name'], $caminho.$nomeAnexo);
		
		return $nomeAnexo;
			
	}

}

?>