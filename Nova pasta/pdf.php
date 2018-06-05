

<?php 

include("../../banco-dados/conectar.php");
include("../../funcoes.php");
include("../../../interface/mpdf60/mpdf.php");
session_start();

$filtroservidor = $_GET['filtroservidor'];

$filtrosetor = $_GET['filtrosetor'];

$filtrosituacao = $_GET['filtrosituacao'];

$filtrosobrestado = $_GET['filtrosobrestado'];

$id = $_SESSION['id'];
	
$funcao = $_SESSION["funcao"];

$setor = $_SESSION["setor"];

$setor_sub = $_SESSION['setor-subordinado'];

if($funcao=='PROTOCOLO' or $funcao=='SUPERINTENDENTE' or $funcao=='ASSESSOR TÉCNICO' or $funcao=='GABINETE' or $funcao=='COMUNICAÇÃO' or $funcao=='TÉCNICO ANALISTA CORREÇÃO'){ 
	
	//o todos desses perfis é só o que ele pode realmente ver, por isso a query fica personalizada
	if($filtroservidor == '%'){
		$filtroservidor = "(ID_SERVIDOR_LOCALIZACAO IN (SELECT ID FROM tb_servidores WHERE ID_SETOR='$setor' or ID_SETOR='$setor_sub'))";
	}else{
		$filtroservidor = "ID_SERVIDOR_LOCALIZACAO like '$filtroservidor'";
	}

	if($filtrosetor == '%'){
		$filtrosetor = "(ID_SETOR_LOCALIZACAO='$setor' or ID_SETOR_LOCALIZACAO='$setor_sub')";
	}else{
		$filtrosetor = "ID_SETOR_LOCALIZACAO like '$filtrosetor'";
	}

	$lista = mysqli_query($conexao_com_banco, 

	"SELECT * FROM tb_processos WHERE $filtroservidor and $filtrosetor and BL_ATRASADO like '$filtrosituacao' and BL_SOBRESTADO like '$filtrosobrestado' and NM_STATUS NOT IN ('ARQUIVADO', 'SAIU') ORDER BY BL_URGENCIA DESC, NR_DIAS DESC"
	
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

	"SELECT * FROM tb_processos WHERE $filtroservidor and $filtrosetor and BL_ATRASADO like '$filtrosituacao' and BL_SOBRESTADO like '$filtrosobrestado' and NM_STATUS NOT IN ('ARQUIVADO', 'SAIU') ORDER BY BL_URGENCIA DESC, NR_DIAS DESC"
	
	);


}elseif($funcao=='CONTROLADOR' or $funcao=='CHEFE DE GABINETE' or $funcao=='TI'){
	
	
	$filtroservidor = "ID_SERVIDOR_LOCALIZACAO like '$filtroservidor'";
	
	$filtrosetor = "ID_SETOR_LOCALIZACAO like '$filtrosetor'";
	
	$lista = mysqli_query($conexao_com_banco, 

	"SELECT * FROM tb_processos WHERE $filtroservidor and $filtrosetor and BL_ATRASADO like '$filtrosituacao' and BL_SOBRESTADO like '$filtrosobrestado' and NM_STATUS NOT IN ('ARQUIVADO', 'SAIU') ORDER BY BL_URGENCIA DESC, NR_DIAS DESC"
	
	);

}

$html = "<style type='text/css'>
		#customers {
		font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;
		border-collapse: collapse;
		width: 100%;
		}

		#customers td, #customers th {
			border: 1px solid #ddd;
			padding: 8px;
		}

		#customers tr:nth-child(even){background-color: #f2f2f2;}

		#customers tr:hover {background-color: #ddd;}

		#customers th {
			padding-top: 12px;
			padding-bottom: 12px;
			text-align: left;
			background-color: #4CAF50;
			color: white;
		}
	</style>
	<table id='customers'>
		<thead>
			<tr>
				<th><center>Número  </center></th>
				<th><center>Servidor</center></th>
				<th><center>Setor</center></th>
				<th><center>Prazo   </center></th>
				<th><center>Status  </center></th>
				<th><center>Situação</center></th>
				<th><center>Dias    </center></th>
				<th><center>Recebido</center></th>
			</tr>	
		</thead>";

while($r = mysqli_fetch_object($lista)){ 
				
		$id = $r->ID;
		
		$tem_tramitacao = retorna_tem_tramitacao_processo($id, $conexao_com_banco);

		$nome_servidor = retorna_nome_servidor($r->ID_SERVIDOR_LOCALIZACAO, $conexao_com_banco);
		
		$sigla_setor = retorna_sigla_setor($r->ID_SETOR_LOCALIZACAO, $conexao_com_banco);
		
		$data = date_format(new DateTime($r->DT_PRAZO), 'd/m/Y');
		
		$atrasado = ($r->BL_ATRASADO) ? "ATRASADO" : "DENTRO DO PRAZO";

		$recebido = (retorna_recebido_processo($id, $conexao_com_banco)) ? "SIM" : "NÃO";

		
		
		$html .= 
		 "<tr> 
			<td>
				<center>
					$r->CD_PROCESSO
				</center>
			</td>
			<td>
				<center>
					$nome_servidor
				</center>
			</td>
			<td>
				<center>
					$sigla_setor
				</center>
			</td>
			<td>
				<center>
					$data
				</center>
			</td>
			<td>
				<center>
					$r->NM_STATUS
				</center>
			</td>
			<td>
				<center>
					$atrasado
				</center>
			</td>
			<td>
				<center>
					$r->NR_DIAS
				</center>
			</td>
			<td>
				<center>
					$recebido
				</center>
			</td>				
		</tr>";
		
}

$html .= "  </tbody>	
		</table>";
		
		
$mpdf=new mPDF();
$mpdf->WriteHTML($html);   
$mpdf->Output();
exit();

?>