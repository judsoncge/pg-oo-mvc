<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class ProcessosView extends View{
	
	//a lista de processos carrega alguns scripts adicionais dependendo de seu conteúdo
	public function adicionarScripts(){
	
		//se o conteúdo for lista, carrega três scripts. o primeiro é o de receber/recusar processo (quando ele é tramitado). o segundo é o que carrega a busca quando os filtros são alterados e o terceiro é o que exporta em pdf a tabela atual de processos.
		if($this->conteudo == 'lista'){ ?>
			<script src='/view/_libs/js/receber.js'></script>
			<script src='/view/_libs/js/filtros.js'></script>
			<script src='/view/_libs/js/exportar.js'></script>

	
		<?php //se o conteúdo for de visualizar, carrega o scripts de multiselect, usados em definir responsáveis de processos e apensar processos (estilo diferente de select multiple)
		}elseif($this->conteudo == 'visualizar'){ ?>
			
			<link rel='stylesheet' type='text/css' href='/view/_libs/css/multiple-select.css'>
			<script type='text/javascript' src='/view/_libs/js/multiple-select.js'></script>
			<script type='text/javascript'>
				window.onload = function(){
					$('#responsaveis').multipleSelect();
					$('#apensos').multipleSelect();
					
				}
			</script>	

<?php			
		}
	}
	
	//esta função carrega todos os campos de filtro de processo
	public function carregarFiltro(){
		
		//pegando com o controller a lista de servidores e a lista de setores com o processos controller
		$listaServidores = $_REQUEST['LISTA_SERVIDORES']; 
		
		$listaSetores = $_REQUEST['LISTA_SETORES']; 

?>	

		<div class='well'>
			<form>
				<div class='row'>	
					<!-- filtro de servidor (com quem o processo está) -->
					<div class='col-md-4'>
						<div class='form-group'>
							<label class='control-label' for='exampleInputEmail1'>Filtro de servidor</label><br>
							<select id='filtroservidor' name='filtroservidor' >
								<option value='<?php echo $_SESSION['ID'] ?>'><?php echo $_SESSION['NOME'] ?></option>
								<option value='%'>Todos</option>
								<?php foreach($listaServidores as $servidor){ ?>
										<option value='<?php echo $servidor['ID'] ?>'>
											<?php echo $servidor['DS_NOME']; ?>
										</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<!-- filtro de setor (em que setor o processo está) -->
					<div class='col-md-2'>
						<div class='form-group'>
							<label class='control-label' for='exampleInputEmail1'>Filtro de setor</label><br>
								<select id='filtrosetor' name='filtrosetor' >
									<option value='<?php echo $_SESSION['SETOR'] ?>'><?php echo $_SESSION['NOME_SETOR'] ?></option>
									<option value='%'>Todos</option>
									<?php foreach($listaSetores as $setor){ ?>
										<option value='<?php echo $setor['ID'] ?>'>
											<?php echo $setor['DS_ABREVIACAO']; ?>
										</option>
									<?php } ?>
								</select>
						</div>
					</div>
					<!-- filtro de situação (no prazo ou atrasado) -->
					<div class='col-md-2'>
						<div class='form-group'>
							<label class='control-label' for='exampleInputEmail1'>Filtro de situação</label><br>
								<select id='filtrosituacao' name='filtrosituacao' >
									<option value='%'>Todos</option>
									<option value='0'>NO PRAZO</option>
									<option value='1'>ATRASADO</option>
								</select>
						</div>
					</div>
					<!-- filtro de sobrestado (se o processo está com alguma dependencia no momento) -->
					<div class='col-md-2'>
						<div class='form-group'>
							<label class='control-label' for='exampleInputEmail1'>Sobrestado</label><br>
							<select id='filtrosobrestado' name='filtrosobrestado' >
								<option value='%'>Todos</option>
								<option value='0'>NÃO</option>
								<option value='1'>SIM</option>
							</select>
						</div>
					</div>
					<!-- filtro de recebido (se o processo foi recebido por alguém após ser tramitado -->
					<div class='col-md-2'>
						<div class='form-group'>
							<label class='control-label' for='exampleInputEmail1'>Recebido</label><br>
							<select id='filtrorecebido' name='filtrorecebido' >
								<option value='%'>Todos</option>
								<option value='0'>NÃO</option>
								<option value='1'>SIM</option>
							</select>
						</div>
					</div>
				</div>
				<div class='row'>
					<!-- filtro de processo. o usuário digita o número do um determinado processo -->
					<div class='col-md-12'>
						<div class='form-group'>
							<div class='input-group margin-bottom-sm'>
								<span class='input-group-addon'><i class='fa fa-search fa-fw'></i></span> <input type='text' class='input-search form-control' alt='tabela-dados' placeholder='Busque pelo numero do processo' id='filtroprocesso' name='filtroprocesso' autofocus='autofocus' />
							</div>
						</div>	
					</div>
				</div>
			</form>
		</div>
		
		

<?php
	}
	
	//carrega a tabela com os registros de processos
	public function listar(){
		
		//pegando a lista de processos com o processos controller
		$listaProcessos = $_REQUEST['LISTA_PROCESSOS'];
		
?>		
		<!-- tabela que traz os processos. de acordo com o filtro, ela se altera. o script usa esse id resultado para atualizá-la -->
		<div id='resultado' class='col-md-12 table-responsive' style='overflow: auto; width: 100%; height: 300px;'>
			
			<!--gif de carregando que aparece enquanto a tabela não é atualizada após o filtro ser alterado -->
			<div id='carregando' class='carregando'><i class='fa fa-refresh spin' aria-hidden='true'></i> <span>Carregando dados...</span></div>
			
			<!-- mostra a quantidade de processos da tabela atual -->
			<h5>
				<div id='qtde'>Total: <?php echo sizeof($listaProcessos) . " " ?>
					<button onclick='javascript: exportar();' class='btn btn-sm btn-success' name='submit' value='Send'>Exportar</button>
				</div>
			</h5>
		
			<table class='table table-hover tabela-dados'>
				<thead>
					<tr>
						<th>Número</th>
						<th>Servidor</th>
						<th>Setor</th>
						<th>Prazo</th>
						<th>Status</th>
						<th>Situação</th>
						<th>Dias</th>
						<th>Recebido</th>
						<th>Ação</th>
					</tr>	
				</thead>
				<tbody>
						
					<?php 
					
						foreach($listaProcessos as $processo){ 
						
						//se o processo for urgente, a linha fica amarela
						if($processo['BL_URGENCIA']){ ?>
				
						<tr style='background-color:#f1c40f;'>
					
						<?php }else{ ?>
					
						<tr>
					
					    <?php } ?>
							<td><?php echo $processo['DS_NUMERO'] ?></td>
							<!-- este id foi criado para quando o servidor clicar em receber o processo atualizar a linha servidor para 'Agora está com você'-->
							<td id="servidorLocalizacao<?php echo $processo['ID'] ?>"><?php echo $processo['NOME_SERVIDOR'] ?></td>
							<td><?php echo $processo['NOME_SETOR']  ?></td>
							<td><?php echo $processo['DT_PRAZO'] ?></td>
							<td><?php echo $processo['DS_STATUS'] ?></td>
							<td><?php 
									if($processo['BL_ATRASADO']){
										echo "<font color='red'>ATRASADO</font>";
									}else{
										echo "<font color='green'>DENTRO DO PRAZO</font>";
									} 
								?>
							</td>
							<td><?php echo $processo['NR_DIAS'] ?></td>
							<td id="statusRecebido<?php echo $processo['ID'] ?>">
								<?php 
									if($processo['BL_RECEBIDO']){
										echo 'SIM';
									}else{ 
										echo 'NÃO';
									} 
								?>
							</td>				
							
							<!-- aqui é onde funciona o script receber. quando o processo ainda não está recebido, aparecerão as palavras RECEBER/DEVOLVER. caso o servidor clique em receber, o status de recebido do processo se atualiza (funcionalidade do script) e o botão de visualizar aparece os dados do processo aparece. caso clique em devolver, o processo é tramitado de volta para o servidor que tramitou -->
							<td id="recebido<?php echo $processo['ID'] ?>">
								
								<?php if(!$processo['BL_RECEBIDO']){ ?>
									
										<a id="receber<?php echo $processo['ID'] ?>" onclick="receber(<?php echo $processo['ID'] ?>)" href='javascript:void(0);'>RECEBER</a>
										
										<br> 
												
										<a href="/editar/processo/devolver/<?php echo $processo['ID'] ?>">DEVOLVER</a>
								
								
								<?php //caso o processo esteja recebido já, o botão de visualizar aparece
									} else{ ?>
									
										<a href="/processos/visualizar/<?php echo $processo['ID'] ?>">
											<button type='button' class='btn btn-secondary btn-sm' title='Visualizar'>
												<i class='fa fa-eye' aria-hidden='true'></i>
											</button>
										</a>

							  <?php } ?>
							</td>
						</tr>
				  <?php } ?>		
				</tbody>
			</table>
		</div>
<?php 
		
	}
	
	//função que exporta a tabela de processos atual para PDF
	public function exportar(){
		
		include($_SERVER['DOCUMENT_ROOT'].'/view/_libs/mpdf60/mpdf.php');
		
		$listaProcessos = $_REQUEST['LISTA_PROCESSOS'];
		
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
					<th>Número</th>
					<th>Servidor</th>
					<th>Setor</th>
					<th>Prazo</th>
					<th>Status</th>
					<th>Situação</th>
					<th>Dias</th>
					<th>Recebido</th>
				</tr>	
			</thead>";
			
		foreach($listaProcessos as $processo){
			
			$atrasado = ($processo['BL_ATRASADO']) ? 'ATRASADO' : 'DENTRO DO PRAZO';

			$recebido = ($processo['BL_RECEBIDO']) ? 'SIM' : 'NÃO';
			
			$html .= 
		 "<tr> 
			<td>
				
					".$processo['DS_NUMERO']."
				
			</td>
			<td>
				
					".$processo['NOME_SERVIDOR']."
				
			</td>
			<td>
				
					".$processo['NOME_SETOR']."
				
			</td>
			<td>
				
					".$processo['DT_PRAZO']."
				
			</td>
			<td>
				
					".$processo['DS_STATUS']."
				
			</td>
			<td>
				
					".$atrasado."
				
			</td>
			<td>
				
					".$processo['NR_DIAS']."
				
			</td>
			<td>
				
					".$recebido."
				
			</td>				
		</tr>";

		}
		
		$html .= 
		"  </tbody>	
		</table>";
				
		$mpdf = new mPDF();
		
		$mpdf -> WriteHTML($html);   
		
		$mpdf -> Output();
		
		exit();
		
	}
	
	//tanto cadastrar quanto editar informações utilizam o mesmo formulário. para que o mesmo formulario nao seja implementado duas vezes, a função cadastrar chama o método carregarFormulario que lá verifica se o conteudo da pagina é de cadastro ou edição.
	public function cadastrar(){ 

		$this->carregarFormulario();
	
	}
	
	//tanto cadastrar quanto editar informações utilizam o mesmo formulário. para que o mesmo formulario nao seja implementado duas vezes, a função editar chama o método carregarFormulario que lá verifica se o conteudo da pagina é de cadastro ou edição.
	public function editar(){
		
		$this->carregarFormulario();	
		
	}
	
	//função que carrega o formulario para cadastro/edição de processos
	public function carregarFormulario(){
		
		//pegando as listas de assuntos, orgaos 
		$listaAssuntos = $_REQUEST['LISTA_ASSUNTOS'];
		
		$listaOrgaos = $_REQUEST['LISTA_ORGAOS'];
		
		//pegando a lista de dados do processo (caso o conteudo seja de edição) com o processos controller. o action do formulario e nome do botao de submit também mudam dependendo do conteudo da página
		if($this->conteudo == 'edicao'){
			
			$listaDados = $_REQUEST['DADOS_PROCESSO'];
			$action = "/editar/processo/info/".$listaDados['ID']."/";
			$nomeBotao = 'Editar';
	
		}else{
			
			$listaDados = NULL;
			$action = '/cadastrar/servidor/';
			$nomeBotao = 'Cadastrar';
			
		}
		
		if($listaDados != NULL){
			
			//o numero do processo é formado assim: 9999 1111/2222. o primeiro explode é utilizado para pegar a primeira parte do numero, para ser colocado no primeiro campo de numero de processo (tirando pelo espaço). Após o primeiro explode, o array resultado fica [0] -> 9999 [1] -> 1111/2222
			$numeroProcesso = explode(' ', $listaDados['DS_NUMERO']);
			
			//pegando a posicao zero, ou seja, a primeira parte do numero
			$numeroParte1 = $numeroProcesso[0];
			
			//segundo explode (tirando pela /) para pegar a segunda parte do número. ele pega a partir da posição 1 do primeiro array resultado, que é 9999/9999. assim, o array resultado fica [0] -> 1111 [1] -> 2222
			$numeroProcesso2 = explode('/', $numeroProcesso[1]);
			
			$numeroParte2 = $numeroProcesso2[0];
			
			$numeroParte3 = $numeroProcesso2[1];
			
		}		
?>		
		<!-- formulario. no value de cada campo é verificado se o tipo de conteúdo da página é de edição. se sim, carrega o valor do campo do servidor correspondente, que está na lista de dados solicitada acima. caso não, não imprime nada (pois é de cadastro). -->
		<form name='cadastro' method='POST' action='<?php echo $action; ?>' enctype='multipart/form-data'> 
			<div class='row'>
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Número do processo</label>
						<div class='row'>
							<div class='col-md-4'>
								<input class='form-control' id='numeroParte1' name='numeroParte1' placeholder='Órgão' type='text' maxlength='6' value="<?php if($this->conteudo=='edicao'){echo $numeroParte1;} ?>" required />
							</div>
							<div class='col-md-4'>
								<input class='form-control' id='numeroParte2' name='numeroParte2' placeholder='Número' type='text' maxlength='6' value="<?php if($this->conteudo=='edicao'){echo $numeroParte2;} ?>" required />
							</div>
							<div class='col-md-4'>
								<input class='form-control' id='numeroParte3' name='numeroParte3' placeholder='Ano' type='text' maxlength='4' value="<?php if($this->conteudo=='edicao'){echo $numeroParte3;} ?>" required />
							</div>
						</div>
					</div>  
				</div>
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Assunto</label>
						<select class='form-control' id='assunto' name='assunto' required />
							<option value="<?php if($this->conteudo=='edicao'){echo $listaDados['ID_ASSUNTO'];} ?>"><?php if($this->conteudo=='edicao'){echo $listaDados['NOME_ASSUNTO'];} ?></option>
								<?php foreach($listaAssuntos as $assunto){ ?>
									<option value="<?php echo $assunto['ID'] ?>"><?php echo $assunto['DS_NOME'] ?></option> 
								<?php } ?>
						</select>
					</div>  
				</div>
			</div>
			<div class='row'>						
				<div class='col-md-12'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Órgão Interessado</label>
						<select class='form-control' id='orgao' name='orgao' required />
							<option value="<?php if($this->conteudo=='edicao'){echo $listaDados['ID_ORGAO_INTERESSADO'];} ?>"><?php if($this->conteudo=='edicao'){echo $listaDados['NOME_ORGAO'];} ?></option>
								<?php foreach($listaOrgaos as $orgao){ ?>
									<option value="<?php echo $orgao['ID'] ?>"><?php echo $orgao['DS_ABREVIACAO'] . " - " . $orgao['DS_NOME'] ?></option> 
								<?php } ?>
						</select>
					</div>  
				</div>
			</div>
			<div class='row'>
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Nome do Interessado</label>
						<input class='form-control' id='interessado' name='interessado' placeholder='Digite o interessado' type='text' maxlength='255' value="<?php if($this->conteudo=='edicao'){echo $listaDados['DS_INTERESSADO'];} ?>" required />
					</div>  
				</div>
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Detalhes</label>
						<input class='form-control' id='detalhes' name='detalhes' placeholder='Digite os detalhes do processo' type='text' maxlength='255' value="<?php if($this->conteudo=='edicao'){echo $listaDados['DS_DETALHES'];} ?>" required />
					</div>  
				</div>
			</div>
			<div class='row' id='cad-button'>
				<div class='col-md-12'>
					<button type='submit' class='btn btn-default' name='submit' value='Send' id='submit'><?php echo $nomeBotao; ?></button>
				</div>
			</div>
		</form>
		
<?php	
	}
	
	//carrega a visualizaçao do processo. aqui, além das informações gerais de um processo, são carregadas também várias outras funcionalidades.
	public function visualizar(){
		
		//pegando dados do processo com o processos controller
		$lista = $_REQUEST['DADOS_PROCESSO'];
		
		$listaDocumentos = $_REQUEST['DOCUMENTOS_PROCESSO'];
		
		$listaResponsaveis = $_REQUEST['RESPONSAVEIS_PROCESSO'];
		
		$listaApensados = $_REQUEST['PROCESSOS_APENSADOS'];
		
		$historico = $_REQUEST['HISTORICO_PROCESSO'];
		
		//recebe do processos controller a informação de que o processo está ativo ou inativo (arquivado ou saiu)
		$ativo = $_REQUEST['ATIVO'];
		
		//recebe do processos controller a informação de que o processo é apenso a outro processo
		$apensado = $_REQUEST['APENSADO'];
		
		$listaServidores = $_REQUEST['LISTA_SERVIDORES'];
		
		$listaPodemSerResponsaveis = $_REQUEST['LISTA_PODEM_SER_RESPONSAVEIS'];
		
		$listaProcessosApensar = $_REQUEST['LISTA_APENSAR']; ?>	
	
		<!-- se o processo nao for recebido e mesmo assim o servidor conseguir entrar na página de visualizar, é perguntado se o processo foi recebido e logo após o carregamento da página é interrompido. -->
		<div class='container'>
			
			<?php if($ativo and !$lista['BL_RECEBIDO']){ ?>
			
					<div class='row linha-modal-processo'>
						<div class='alert alert-warning'>O processo físico foi recebido?
							<a href='/editar/processo/receber/<?php echo $lista['ID'] ?>/'>Sim</a>
							/
							<a href='/editar/processo/devolver/<?php echo $lista['ID'] ?>/'>Não</a>
						</div>
					</div>
 
		<?php		// carregamento da página é interrompido		
					exit();
				} ?>
		</div>
		
				
<?php 	//caso o processo esteja ativo e ele seja urgente, aparece um aviso na página.

		if($ativo){
			
			if($lista['BL_URGENCIA']){	?>						

				<div class='alert alert-warning'>&#9888; ESTE PROCESSO É URGENTE!</div>
 
<?php		} 
			//caso o processo esteja em ativo e ele esteja em sobrestado, aparece um aviso na página.
			
			if($lista['BL_SOBRESTADO']){ ?>

				<div class='alert alert-warning'>&#9888; ESTE PROCESSO ESTÁ EM SOBRESTADO!: <?php echo $lista['DS_JUSTIFICATIVA'] ?></div>
					
<?php   	} 
			
			//so se pode fazer qualquer ação em um processo se ele não estiver apensado ou for o processo-mãe de outros processo
			if((!$apensado)){
						
?>						
						<div class='row linha-modal-processo'>

<?php	
							if(!$lista['BL_SOBRESTADO']){
?>
								<!-- botão para marcar o processo como sobrestado -->
								<a href="/editar/processo/sobrestado/<?php echo $lista['ID'] ?>/1"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Marcar sobrestado&nbsp;&nbsp;&nbsp;<i class='fa fa-warning' aria-hidden='true'></i></button></a>
							
<?php	
							}else{
?>
								<!-- botão para desmarcar o processo como sobrestado -->
								<a href="/editar/processo/sobrestado/<?php echo $lista['ID'] ?>/0"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Desmarcar sobrestado&nbsp;&nbsp;&nbsp;<i class='fa fa-warning' aria-hidden='true'></i></button></a>
							
<?php	
							}
							
							if(!$lista['BL_URGENCIA']){
?>
								<!-- botão para marcar o processo como urgente -->
								<a href="/editar/processo/urgencia/<?php echo $lista['ID'] ?>/1"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-urgencia'>Marcar como urgente&nbsp;&nbsp;&nbsp;<i class='fa fa-warning' aria-hidden='true'></i></button></a>
							
<?php	
							}else{
?>
								<!-- botão para desmarcar a urgencia do processo -->
								<a href="/editar/processo/urgencia/<?php echo $lista['ID'] ?>/0"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-urgencia'>Desmarcar urgência&nbsp;&nbsp;&nbsp;<i class='fa fa-warning' aria-hidden='true'></i></button></a>
							
<?php	
							}
?>
								<!-- botão para ir a página de editar -->
								<a href="/processo/editar/<?php echo $lista['ID'] ?>"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Editar&nbsp;&nbsp;&nbsp;<i class='fa fa-pencil' aria-hidden='true'></i></button></a>
						
								<!-- botão para excluir o processo -->
								<a href="/excluir/processo/<?php echo $lista['ID'] ?>"><button type='submit' onclick="return confirm('Você tem certeza que deseja apagar este processo?');" class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Excluir&nbsp;&nbsp;&nbsp;<i class='fa fa-trash' aria-hidden='true'></i></button></a>
							
						</div>

						<div class='row linha-modal-processo'>

<?php 						
							if($lista['DS_STATUS']=='EM ANDAMENTO'){
								
								
?>								<!-- botão para finalizar o processo em nome do setor -->
								<a href="/editar/processo/status/<?php echo $lista['ID'] ?>/FINALIZADO PELO SETOR"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Finalizar em nome do setor&nbsp;&nbsp;&nbsp;<i class='fa fa-calendar-check-o' aria-hidden='true'></i></button></a>	
<?php	
							}
							
							if($lista['DS_STATUS']=='FINALIZADO PELO SETOR'){
?>
								<!-- botão para finalizar o processo em nome do gabinete -->	
								<a href="/editar/processo/status/<?php echo $lista['ID'] ?>/FINALIZADO PELO GABINETE"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Finalizar em nome do gabinete&nbsp;&nbsp;&nbsp;<i class='fa fa-calendar-check-o' aria-hidden='true'></i></button></a>
								
								<!-- botão para desfazer a finalização do setor -->
								<a href="/editar/processo/desfazerstatus/<?php echo $lista['ID'] ?>/EM ANDAMENTO"><button type='submit' class='btn btn-sm btn-success pull-left' name='submit' value='Send' id='botao-dar-saida'>Desfazer finalização do setor&nbsp;&nbsp;<i class='fa fa-external-link-square' aria-hidden='true'></i></button></a>	
								
<?php	
							}
					
							if($lista['DS_STATUS']=='FINALIZADO PELO GABINETE'){
?>
								<!-- botão para desfazer a finalização do gabinete -->
								<a href="/editar/processo/desfazerstatus/<?php echo $lista['ID'] ?>/FINALIZADO PELO SETOR"><button type='submit' class='btn btn-sm btn-success pull-left'name='submit' value='Send' id='botao-dar-saida'>Desfazer finalização do gabinete&nbsp;&nbsp;<i class='fa fa-external-link-square' aria-hidden='true'></i></button></a>
								
								<!-- botão para dar saída no processo. o processo so pode sair quando for finalizado pelo gabinete -->
								<a href="/editar/processo/status/<?php echo $lista['ID'] ?>/SAIU"><button type='submit' class='btn btn-sm btn-success pull-left' name='submit' value='Send' id='botao-dar-saida'>Dar saída&nbsp;&nbsp;<i class='fa fa-external-link-square' aria-hidden='true'></i></button></a>						
<?php	
							}if($lista['DS_STATUS']=='FINALIZADO PELO GABINETE' || $lista['DS_STATUS']=='FINALIZADO PELO SETOR'){
?>								
								<!-- botão para arquivar o processo. o processo so pode ser arquivado se for finalizado pelo setor -->
								<a href="/editar/processo/status/<?php echo $lista['ID'] ?>/ARQUIVADO"><button type='submit' class='btn btn-sm btn-warning pull-left' name='submit' value='Send' id='botao-arquivar'>Arquivar&nbsp;&nbsp;<i class='fa fa-folder' aria-hidden='true'></i></button></a>	
<?php
							}

?>					</div>
								
<?php			
			}
		
		//se o processo estiver inativo e também não for apensado a outro processo...
		}elseif(!$apensado){
					
					
			if($lista['DS_STATUS'] == 'SAIU'){ 
			
?>				<!-- botão para voltar o processo para o órgão (caso tenha saído) -->
				<div class='row linha-modal-processo'>
					
					<a href="/editar/processo/voltar/<?php echo $lista['ID'] ?>"><button type='submit' class='btn btn-sm btn-success pull-left'name='submit' value='Send' id='botao-dar-saida'>Voltar processo&nbsp;&nbsp;<i class='fa fa-external-link-square' aria-hidden='true'></i></button></a>
					
				</div>
						
<?php

			}elseif($lista['DS_STATUS'] == 'ARQUIVADO'){

?>				<!-- botão para desarquivar o processo -->
				<div class='row linha-modal-processo'>
					
					<a href="/editar/processo/desarquivar/<?php echo $lista['ID'] ?>"><button type='submit' class='btn btn-sm btn-success pull-left' name='submit' value='Send' id='botao-dar-saida'>Desarquivar&nbsp;&nbsp;<i class='fa fa-external-link-square' aria-hidden='true'></i></button></a>

				</div>
	
<?php		} 
		}
?>				<!-- informações do processo -->
				<div class='row linha-modal-processo'>
					
					<div class='col-md-12'>
						
						STATUS: <?php echo $lista['DS_STATUS'] ?><br><br>
						
						Está com: <?php echo $lista['NOME_SERVIDOR'] ?><br>
						
						No Setor: <?php echo $lista['NOME_SETOR'] ?><br>

						Assunto: <?php echo $lista['NOME_ASSUNTO'] ?><br>
						
						Detalhes: <?php echo $lista['DS_DETALHES'] ?><br><br>
						
						Órgão interessado: <?php echo $lista['NOME_ORGAO'] ?><br>
						
						Nome do interessado: <?php echo $lista['DS_INTERESSADO'] ?><br><br>
						
						Dias no órgão: <?php echo $lista['NR_DIAS'] ?><br>
							
						Dias em sobrestado: <?php echo $lista['NR_DIAS_SOBRESTADO'] ?><br>	
												
						Data de entrada: <?php echo $lista['DT_ENTRADA'] ?><br>
						
						Prazo: <?php echo $lista['DT_PRAZO'] ?><br>
						
						Data de saída: <?php echo $lista['DT_SAIDA'] ?>	
						
						<br><br>
						
						<!-- lista de responsáveis do processo. a lista de responsáveis (que foi recebida acima) é iterada mostrando o nome dos responsáveis do processo em questão -->
						Responsáveis: 
							
<?php 					foreach($listaResponsaveis as $responsavel){
																		
							echo $responsavel['NOME_SERVIDOR'];
							
							//so pode remover um responsavel do processo se ele estiver ativo
							if($ativo){ ?>										
								<a href="/editar/processo/removerresponsavel/<?php echo $lista['ID'] ?>/<?php echo $responsavel['ID_SERVIDOR'] ?>" title='remover responsável'><i class='fa fa-remove' aria-hidden='true'></i></a>,
								
<?php							}
								
						} ?>							
						<br>
						
						<!-- mostra o responsavel lider do processo -->
						Responsável líder:      
<?php                                 
							
							foreach($listaResponsaveis as $responsavel){

								if($responsavel['BL_LIDER']){
									
									echo $responsavel['NOME_SERVIDOR'];
									
								}

							}
							
?>
						<br><br>
						
						<!-- lista de processos apensados. mesma lógica dos responsaveis de processo -->
						Processos apensados:
<?php 						foreach($listaApensados as $processoApensado){ ?>
							
								<a href='/processos/visualizar/<?php echo $processoApensado['ID_PROCESSO_APENSADO'] ?>'><?php echo $processoApensado['DS_NUMERO'] ?></a>
							
<?php							if($ativo){ ?>

									<a href="/editar/processo/removerapenso/<?php echo $lista['ID'] ?>/<?php echo $processoApensado['ID_PROCESSO_APENSADO'] ?>" title='remover apenso'><i class='fa fa-remove' aria-hidden='true'></i></a>,
								
<?php							}
							} ?>
							<br>
						
						<!-- mostra o processo mae do processo em questão, caso haja. -->
						Processo mãe:
							<a href='/processos/visualizar/<?php echo $lista['ID_PROCESSO_MAE'] ?>'><?php echo $lista['NUMERO_PROCESSO_MAE'] ?></a><br><br>
					</div>
				
				</div>
				
				<!-- tabela que mostra os documentos do processo em questão -->
				<div class='row linha-modal-processo'>
					
					<b>Documentos do processo</b>:<br>
					
					<table class='table table-hover tabela-dados'>
						<thead>
							<tr>
								<th>Tipo</th>
								<th>Criador</th>
								<th>Data de criação</th>
								<th>Baixar</th>
								<th>Ação</th>
							</tr>	
						</thead>
						<tbody>
<?php 
							//iterando a lista de documentos que foi recebida la em cima
							foreach($listaDocumentos as $documento){
								
?>
								<tr>
									<td><?php echo $documento['DS_TIPO']; ?></td>
									<td><?php echo $documento['NOME_CRIADOR']; ?></td>
									<td><?php echo $documento['DT_CRIACAO']; ?></td>
									<td>
										<a href="/_registros/anexos/<?php echo $documento['DS_ANEXO'] ?>" title="<?php echo $documento['DS_ANEXO']; ?>" download><?php echo substr($documento['DS_ANEXO'], 0, 20) . "..." ; ?>
										</a>
									</td>
									<td>
<?php 									//so pode deletar um documento do processo caso ele esteja ativo
										if($ativo){
?> 							
											<a href="/editar/processo/excluirdocumento/<?php echo $lista['ID'] ?>/<?php echo $documento['ID'] ?>">Excluir</a>
											
<?php									}
							} ?>
									</td>
								</tr>
						</tbody>
					</table>
				</div>
				
<?php 			
				//carrega o historico do processo passando o array recebido la em cima. o metodo esta definido na classe mae
				$this->carregarHistorico($historico);
				
		if($ativo){
											
				//carrega o input para enviar mensagem, passando os parametros necessarios. o metodo esta definido na classe mae
				$this->carregarEnviarMensagem('processo', $lista['ID']); ?>
				
				<!-- formulario para anexar um documento ao processo -->
				<div class='row linha-modal-processo'>
					<form method='POST' action="/editar/processo/anexardocumento/<?php echo $lista['ID'] ?>" enctype='multipart/form-data'>	
						<div class='col-md-6'>
							<div class='form-group'>
								<label class='control-label' for='exampleInputEmail1'><b>Anexar documento:</b></label>
									<!-- carrega o select dos tipos de documento. o metodo esta definido na classe mae -->
									<?php $this->carregarSelectTiposDocumento(); ?>
							</div>  
						</div>
						<div class='col-md-4'>
							<div class='form-group'>
								<label class='control-label' for='exampleInputEmail1'>Enviar anexo</label><br>
								<input type='file' class='' name='arquivoAnexo' id='arquivoAnexo'/>
							</div>
						</div>	
						<div class='col-md-2'>
							<br>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar'>Anexar &nbsp;&nbsp;<i class='fa fa-arrow-circle-right'  aria-hidden='true'></i></button>
						</div>
					</form>	
				</div>
				
<?php 		//muitas funcionalidades nao sao permitidas serem executadas quando o processo é apensado a outro
			if(!$apensado){ 
				
				//se o processo nao estiver em sobrestado...
				if(!$lista['BL_SOBRESTADO']){
			
?>					<!-- formulario para solicitar sobrestado -->
					<div class='row linha-modal-processo'>
						<label class='control-label' for='exampleInputEmail1'><b>Solicitar Sobrestado:</b></label>
						<form method='POST' action="/editar/processo/solicitarsobrestado/<?php echo $lista['ID']?>" enctype='multipart/form-data'>	
							<div class='col-md-10'>
								<input class='form-control' id='justificativa' name='justificativa' placeholder='Digite aqui a sua justificativa (Máximo de 100 caracteres)' type='text' maxlength='100' required />	
							</div>
							<div class='col-md-2'>
								<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar' >Solicitar &nbsp;&nbsp;<i class='fa fa-arrow-circle-right' aria-hidden='true'></i></button>
							</div>
						</form>
					</div>	
<?php 		
				}
	
?>
				<!-- formulario para definir responsaveis -->
				<div class='row linha-modal-processo'>
					<form method='POST' action="/editar/processo/definirresponsaveis/<?php echo $lista['ID'] ?>" enctype='multipart/form-data'>	
						<div class='col-md-10'>
							<label class='control-label' for='exampleInputEmail1'><b>Defina os responsáveis</b>:</label><br>
							<select multiple id='responsaveis' name='responsaveis[]' style='width: 96%;' required>
<?php 								//lista de pessoas que podem ser responsaveis que foi recebida la em cima para montagem do select box
									foreach($listaPodemSerResponsaveis as $podeSerResponsavel){			
?>
										<option value="<?php echo $podeSerResponsavel['ID'] ?>">
											<?php echo "  " .$podeSerResponsavel['DS_NOME']; ?>
										</option>	
<?php 
									} 
?>
							</select>
						</div>
						<div class='col-md-2'>
							<br>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar'>Definir &nbsp;&nbsp;<i class='fa fa-arrow-circle-right' aria-hidden='true'></i></button>
						</div>
					</form>	
				</div>
				
<?php 			//aqui o usuário define o responsável líder do processo. o formulário só aparece quando o processo tem mais de um responsavel (a lista é recebida do processos controller lá em cima)
				if(count($listaResponsaveis) > 1){
?>				
					<form name='teste' method='POST' action="/editar/processo/definirlider/<?php echo $lista['ID'] ?>" enctype='multipart/form-data'>
						<div class='row linha-modal-processo'>
							<div class='col-md-10'>
								<label class='control-label' for='exampleInputEmail1'><b>Defina o responsável líder</b>:</label><br>
								<select class='form-control' id='lider' name='lider' required >
									<option value=''>Selecione</option>
<?php									foreach($listaResponsaveis as $responsavel){ ?>	
										
											<option value="<?php echo $responsavel['ID_SERVIDOR'] ?>"><?php echo $responsavel['NOME_SERVIDOR']; ?></option>
										
<?php 									} 
?>								</select>
							</div>
							<div class='col-md-2'>
								<br>
								<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar'>Definir &nbsp;&nbsp;<i class='fa fa-arrow-circle-right' aria-hidden='true'></i></button>
							</div>
						</div>
					</form>
				
<?php 							
				} 
?>
				<!-- select multiple box para o usuário definir apensos ao processo em questão. a lista de processos para apensar é recebida pelo processos controller lá em cima -->
				<div class='row linha-modal-processo'>
					<form method='POST' action="/editar/processo/apensar/<?php echo $lista['ID'] ?>" enctype='multipart/form-data'>	
						<div class='col-md-10'>
							<label class='control-label' for='exampleInputEmail1'><b>Defina os Apensos</b>:</label><br>
							<select multiple id='apensos' name='apensos[]' style='width: 96%;' required>
<?php 							
								foreach($listaProcessosApensar as $processo){
?>
									<option value="<?php echo $processo['ID'] ?>"><?php echo $processo['DS_NUMERO'] ?></option>
								
<?php 							} 
?>
							</select>
						</div>
						<div class='col-md-2'>
							<br>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar'>Apensar &nbsp;&nbsp;<i class='fa fa-arrow-circle-right'  aria-hidden='true'></i></button>
						</div>
					</form>	
				</div>
				
				<!-- select para o usuário escolher um outro usuário para enviar o processo. a lista de servidores é recebida do processos controller lá em cima -->
				<form name='teste' method='POST' action='/editar/processo/tramitar/<?php echo $lista['ID']?>/' enctype='multipart/form-data'>	
					<div class='row linha-modal-processo'>
						<div class='col-md-10'>
							<select class='form-control' id='tramitar' name='tramitar' required />
								<option value=''>Selecione o servidor para tramitar</option>
<?php 
									foreach($listaServidores as $servidor){
?>	
										<option value='<?php echo $servidor['ID'] ?>'><?php echo $servidor['DS_NOME'] ?></option>		
										
<?php									
									}
?>
							</select>
						</div>
						<div class='col-md-2'>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-tramitar'>Tramitar &nbsp;&nbsp;<i class='fa fa-arrow-circle-right' aria-hidden='true'></i></button>
						</div>
					</div>
				</form>
<?php
			}
		}
	}
	
	//esta função carrega o formulario que so contem um input text relativo ao numero do processo que se quer saber as informações. o usuario digita o numero do processo e clica em consultar para que o sistema busque se existe ou nao o processo digitado.
	public function consulta(){

?>
		<form name='cadastro' method='POST' action='/consultar/processo/' enctype='multipart/form-data'> 
			<div class='row'>
				<div class='col-md-12'>
					<div class='form-group'>
						<input class='form-control' id='processoConsultar' name='processoConsultar' placeholder='Digite o número do processo que deseja consultar' type='text' maxlength='20' required />
					</div>  
				</div>
			</div>
			<div class='row' id='cad-button'>
				<div class='col-md-12'>
					<button type='submit' class='btn btn-default' name='submit' value='Send' id='submit'>Consultar</button>
				</div>
			</div>
		</form>

<?php
	}

	//esta funcao imprime os dados do processo buscado (caso encontrado). somente alguns botões, as informações, documentos e o histórico são carregados.
	public function consultar(){
		
		$lista = $_REQUEST['DADOS_PROCESSO'];
		
		$historico = $_REQUEST['HISTORICO_PROCESSO'];
		
		$listaDocumentos = $_REQUEST['DOCUMENTOS_PROCESSO'];
		
		if($lista['DS_STATUS'] == 'SAIU'){
?>
			<div class='row linha-modal-processo'>
								
				<a href="/editar/processo/voltar/<?php echo $lista['ID'] ?>"><button type='submit' class='btn btn-sm btn-success pull-left'name='submit' value='Send' id='botao-dar-saida'>Voltar processo&nbsp;&nbsp;<i class='fa fa-external-link-square' aria-hidden='true'></i></button></a>
				
			</div>
<?php
		
		}elseif($lista['DS_STATUS'] == 'ARQUIVADO'){

?>	
			<div class='row linha-modal-processo'>
								
				<a href="/editar/processo/desarquivar/<?php echo $lista['ID'] ?>"><button type='submit' class='btn btn-sm btn-success pull-left' name='submit' value='Send' id='botao-dar-saida'>Desarquivar&nbsp;&nbsp;<i class='fa fa-external-link-square' aria-hidden='true'></i></button></a>

			</div>
		
<?php
		
		}
		
?>		
		<div class='row linha-modal-processo'>
					
			<div class='col-md-12'>
				
				STATUS: <?php echo $lista['DS_STATUS'] ?><br><br>
				
				Está com: <?php echo $lista['NOME_SERVIDOR'] ?><br>
				
				No Setor: <?php echo $lista['NOME_SETOR'] ?><br>

				Assunto: <?php echo $lista['NOME_ASSUNTO'] ?><br>
				
				Detalhes: <?php echo $lista['DS_DETALHES'] ?><br><br>
				
				Órgão interessado: <?php echo $lista['NOME_ORGAO'] ?><br>
				
				Nome do interessado: <?php echo $lista['DS_INTERESSADO'] ?><br><br>
				
				Dias no órgão: <?php echo $lista['NR_DIAS'] ?><br>
					
				Dias em sobrestado: <?php echo $lista['NR_DIAS_SOBRESTADO'] ?><br>	
										
				Data de entrada: <?php echo $lista['DT_ENTRADA'] ?><br>
				
				Prazo: <?php echo $lista['DT_PRAZO'] ?><br>
				
				Data de saída: <?php echo $lista['DT_SAIDA'] ?>
				
			</div>
		
		</div>
		
		<div class='row linha-modal-processo'>
					
			<b>Documentos do processo</b>:<br>
			
			<table class='table table-hover tabela-dados'>
				<thead>
					<tr>
						<th>Tipo</th>
						<th>Criador</th>
						<th>Data de criação</th>
						<th>Baixar</th>
					</tr>	
				</thead>
				<tbody>
<?php 
					
					foreach($listaDocumentos as $documento){
						
?>
						<tr>
							<td><?php echo $documento['DS_TIPO']; ?></td>
							<td><?php echo $documento['NOME_CRIADOR']; ?></td>
							<td><?php echo $documento['DT_CRIACAO']; ?></td>
							<td>
								<a href="/_registros/anexos/<?php echo $documento['DS_ANEXO'] ?>" title="<?php echo $documento['DS_ANEXO']; ?>" download><?php echo substr($documento['DS_ANEXO'], 0, 20) . "..." ; ?>
								</a>
							</td>							
<?php								 
								
					}

?>
						</tr>
				</tbody>
			</table>
		</div>
<?php 
		$this->carregarHistorico($historico);
	}
	
	
	//esta função carrega a pagina de relatorio de processos
	public function carregarRelatorio(){
		
?>	
		<div class='row linha-grafico'>
			<div class='col-md-12' style='height: 40px;'>
				<center>
					<b>
						Total de processos: (ativos, arquivados e saíram): 
						
						<!-- todas essas variáveis são recebidas do processos controller. a seguinte é mostrado o número total de processos total do órgão -->
						<?php echo $_REQUEST['QTD_PROCESSOS_TOTAL']; ?>
					</b>
				</center>
			</div>
		</div>	
		
		<div class='row linha-grafico'>		
			<div class='col-md-12'>
				<div class='grafico' id='processos-ativos' >
					<center>
						<b>
							<?php 
								//primeiro é mostrada a quantidade de processos ativos (que não estão arquivados e não saiu) e depois, desses, os que estão no prazo e atrasados
								echo $_REQUEST['QTD_PROCESSOS_ATIVOS'];
							
								echo " (" . $_REQUEST['QTD_PROCESSOS_PRAZO'] . " dentro do prazo e "
							
								. $_REQUEST['QTD_PROCESSOS_ATRASADOS'] . " atrasados)";
							?>
						</b>
						
						<br>
						<br>
						
						<table class='table table-bordered'>
							<thead>
								<tr>
									<th>Setor</th>
									<th>Total de processos</th>
								</tr>
							</thead>
							<tbody>
<?php								//aqui é impressa uma tabela com o número de processos ativos por setor	
									foreach($_REQUEST['QTD_PROCESSOS_ATIVOS_SETOR'] as $setor){ ?>
										
										<tr>
											<td><?php echo $setor['NOME_SETOR'] ?></td>
											<td><?php echo $setor['QUANTIDADE'] ?></td>
										</tr>
<?php	
									}
?>								
							</tbody>	
						</table>	
					</center>
				</div>
			</div>
		</div>
		
		<div class='row linha-grafico'>		
			<div class='col-md-12'>
				<div class='grafico' id='processos-ativos' >
					<center>
						<table class='table table-bordered'>
							<thead>
								<tr>
									<th>Setor</th>
									<th>Total de processos dentro do prazo</th>
								</tr>
							</thead>
							<tbody>
<?php								//agora, dos ativos, os que estão dentro do prazo	
									foreach($_REQUEST['QTD_PROCESSOS_PRAZO_SETOR'] as $setor){ ?>
										
										<tr>
											<td><?php echo $setor['NOME_SETOR'] ?></td>
											<td><?php echo $setor['QUANTIDADE'] ?></td>
										</tr>
<?php	
									}
?>								
							</tbody>	
						</table>	
					</center>
				</div>
			</div>
		</div>
		
		<div class='row linha-grafico'>		
			<div class='col-md-12'>
				<div class='grafico' id='processos-ativos' >
					<center>
						<table class='table table-bordered'>
							<thead>
								<tr>
									<th>Setor</th>
									<th>Total de processos atrasados</th>
								</tr>
							</thead>
							<tbody>
<?php								//agora, dos ativos, os que estão atrasados	
									foreach($_REQUEST['QTD_PROCESSOS_ATRASADOS_SETOR'] as $setor){ ?>
										
										<tr>
											<td><?php echo $setor['NOME_SETOR'] ?></td>
											<td><?php echo $setor['QUANTIDADE'] ?></td>
										</tr>
<?php	
									}
?>								
							</tbody>	
						</table>	
					</center>
				</div>
			</div>
		</div>
		
		<div class='row linha-grafico'>		
			<div class='col-md-12'>
				<div class='grafico' id='processos-ativos' >
					<center>
						<table class='table table-bordered'>
							<thead>
								<tr>
									<th>Setor</th>
									<th>Total de processos em andamento</th>
								</tr>
							</thead>
							<tbody>
<?php								//agora, dos ativos, os que estão com o status de andamento, ou seja, que ainda não foram finalizados por algum setor		
									foreach($_REQUEST['QTD_PROCESSOS_ANDAMENTO_SETOR'] as $setor){ ?>
										
										<tr>
											<td><?php echo $setor['NOME_SETOR'] ?></td>
											<td><?php echo $setor['QUANTIDADE'] ?></td>
										</tr>
<?php	
									}
?>								
							</tbody>	
						</table>	
					</center>
				</div>
			</div>
		</div>
		
		<div class='row linha-grafico'>		
			<div class='col-md-12'>
				<div class='grafico' id='processos-ativos' >
					<center>
						<table class='table table-bordered'>
							<thead>
								<tr>
									<th>Setor</th>
									<th>Total de processos finalizados pelo setor</th>
								</tr>
							</thead>
							<tbody>
<?php								//agora, dos ativos, os que estão com o status de finalizados pelo setor, ou seja, prontos para serem finalizados pelo gabinete ou arquivados
									foreach($_REQUEST['QTD_PROCESSOS_FINALIZADOS_S_SETOR'] as $setor){ ?>
										
										<tr>
											<td><?php echo $setor['NOME_SETOR'] ?></td>
											<td><?php echo $setor['QUANTIDADE'] ?></td>
										</tr>
<?php	
									}
?>								
							</tbody>	
						</table>	
					</center>
				</div>
			</div>
		</div>
		
		<div class='row linha-grafico'>		
			<div class='col-md-12'>
				<div class='grafico' id='processos-ativos' >
					<center>
						<table class='table table-bordered'>
							<thead>
								<tr>
									<th>Setor</th>
									<th>Total de processos finalizados pelo gabinete</th>
								</tr>
							</thead>
							<tbody>
<?php								//agora, dos ativos, os que estão com o status de finalizados pelo gabinete, que estão preparados para serem arquivados ou sair do órgão
									foreach($_REQUEST['QTD_PROCESSOS_FINALIZADOS_G_SETOR'] as $setor){ ?>
										
										<tr>
											<td><?php echo $setor['NOME_SETOR'] ?></td>
											<td><?php echo $setor['QUANTIDADE'] ?></td>
										</tr>
<?php	
									}
?>								
							</tbody>	
						</table>	
					</center>
				</div>
			</div>
		</div>
		
		
		<div class='row linha-grafico'>		
			<div class='col-md-12'>
				<div class='grafico' id='processos-ativos'>
					<center>
						<b>
							<?php //aqui é mostrado o tempo médio dos processos no órgão
								echo 'Tempo médio dos processos: ' . number_format($_REQUEST['TEMPO_MEDIO_PROCESSO'],0) . ' dias';
							?>
						</b>
					</center>
						<table class='table table-bordered'>
							<thead>
								
									<tr>
										<th><center>Assunto</center></th>
										<th><center>Média</center></th>
									</tr>
					
							</thead>
							<tbody>
					
<?php
									$lista = $_REQUEST['TEMPO_MEDIO_ASSUNTO'];
									
									//nesta tabela é mostrada a quantidade de dias em média que leva para um processo, de determinado assunto, sair ou ser aquivado no órgão
									foreach($lista as $assunto){ 
?>
										<tr>
											<td><center><?php echo $assunto['NOME_ASSUNTO'] ?></center></td>
											<td><center><?php echo number_format($assunto['MEDIA'],0) . " dias" ?></center></td>
										</tr>
<?php								}
?>
								
							</tbody>	
						</table>
					</center>
				</div>
			</div>
		</div>

<?php	
	
	}

}