<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class ComunicacaoView extends View{

	public function adicionarScripts(){ ?>
	
		<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
		
		<script>tinymce.init({ selector:'textarea' });</script>
		
		<script type='text/javascript'>
		
			var id_row = 1;
			var id = 1;

			function adicionarImagem(){
				
				var newdiv = document.createElement('div');
				
				newdiv.setAttribute("name", "campos"+id);
				
				newdiv.setAttribute("id", id);
				
				newdiv.innerHTML = 
				"<div class='row'>"+
					"<div class='col-md-4'>"+
						"Selecione a imagem:<br>"+
							"<input type='file' id='selecao-arquivo' name='imagens[]' accept='.jpg, .jpeg, .pjpeg, .gif, .png' id='imagem' required />"+	
					"</div>"+
					"<div class='col-md-3'>"+
						"Legenda:<br>"+
						"<input class='form-control' id='legenda' name='legendas[]' placeholder='Máximo de 100 caracteres' type='text' maxlength='100' required />"+	
					"</div>"+
					"<div class='col-md-2' >"+
						"Créditos:<br>"+
						"<input class='form-control' id='creditos' name='creditos[]' placeholder='Máx. de 30 caracteres' type='text' maxlength='30' required />"+
					"</div>"+
					"<div class='col-md-2' >"+
						"É pequena?<br>"+
						"<select class='form-control' id='pequenas' name='pequenas[]' placeholder='Máximo de 30 caracteres' type='text' maxlength='30' required />"+
							"<option value='0'>Não</option>"+
							"<option value='1'>Sim</option>"+
						"</select>"+
					"</div>"+
					"<div class='col-md-1' >"+
						"Remover:<br>"+
						"<center><a href='javascript:void(0)' title='remover' onclick='removerImagem("+id+");'><i class='fa fa-times' aria-hidden='true'></i></a></center>"+
					"</div>"+
				"</div>";
				
				var nova_imagem = document.getElementById("adicionarImagem");

				nova_imagem.appendChild(newdiv);
				
				id++;
			}

			function removerImagem(id){
				
				document.getElementById(id).innerHTML=""; 
				
			}

			function aparecerSubmit(){
				
				document.getElementById("submitImagens").style.display="block";
				
			}
		
		</script>
	
<?php
	
	}
		

	
	public function listar(){ ?>
		
		<div class='col-md-12 table-responsive' style='overflow: auto; width: 100%; height: 320px;'>
			<table class='table table-hover tabela-dados'>
				<thead>
					<tr>
						<th>Chapéu</th>
						<th>Título</th>
						<th>Data</th>
						<th>Status</th>
						<th>Ação</th>
					</tr>	
				</thead>
				<tbody>
					<?php 
					
					$lista = $_REQUEST['LISTA_COMUNICACAO'];
						
					foreach($lista as $comunicacao){ 	
						
					?>
					<tr>
						<td><?php echo $comunicacao['DS_CHAPEU'] ?></td>
						<td><?php echo $comunicacao['DS_TITULO'] ?></td>
						<td><?php echo date_format(new DateTime($comunicacao['DT_PUBLICACAO']), 'd/m/Y H:i') ?></td>
						<td><?php echo $comunicacao['DS_STATUS'] ?></td>
						<td>	
							<center>
								<a href="/comunicacao/visualizar/<?php echo $comunicacao['ID'] ?>">
									<button type='button' class='btn btn-secondary btn-sm' title='Visualizar'>
										<i class='fa fa-eye' aria-hidden='true'></i>
									</button>
								</a>
							</center>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
<?php 
	
	}
	
	public function cadastrar(){

?>
	
		<form name='cadastro' id='cadastro' method='POST' action='/cadastrar/comunicacao/' enctype='multipart/form-data'>
			<div class='row'>
				<div class='col-md-12'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Chapéu</label>
						<input class='form-control' id='chapeu' name='chapeu' placeholder='Máximo de 30 caracteres' 
						type='text' maxlength='30' required />	
					</div> 
				</div>
			</div>
			<div class='row'>
				<div class='col-md-12'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Título</label>
						<input class='form-control' id='titulo' name='titulo' placeholder='Máximo de 100 caracteres' 
						type='text' maxlength='100' required />	
					</div>  
				</div>
			</div>
			<div class='row'>
				<div class='col-md-12'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Intertítulo</label>
						<input class='form-control' id='intertitulo' name='intertitulo' placeholder='Máximo de 200 caracteres' 
						type='text' maxlength='200' required />	
					</div>  
				</div>
			</div>
			<div class='row'>
				<div class='col-md-12'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Créditos</label>
						<input class='form-control' id='creditos' name='creditosTexto' placeholder='Máximo de 30 caracteres' 
						type='text' maxlength='30' required />	
					</div>  
				</div>
			</div>
			<div class='row'>
				<div class='col-md-12'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Texto</label>
						<textarea class='form-control' id='texto' name='texto' rows='15' required />Seu texto aqui</textarea>	
					</div>  
				</div>
			</div>
			<div class='row'>
				<div class='col-md-12'>
					<label class='control-label' for='exampleInputEmail1'>Data de publicação</label>
					<input type='datetime-local' name='dataPublicacao' id='dataPublicacao' required /><br>
				</div>
			</div>
			
			<div class='row'>
				<div class='col-md-6' >
					<label class='control-label' for='exampleInputEmail1'>Adicionar imagens</label>
					<a href='javascript:void(0)' onclick='adicionarImagem()'><i class='fa fa-plus-circle' aria-hidden='true'></i></a>
				</div>
			</div>
			<div id='adicionarImagem'>
			
			
			</div>
			<div class='row' id='cad-button'>
				<div class='col-md-12'>
					<button type='submit' class='btn btn-default' name='submit' value='Send' id='submit'>Cadastrar</button>
				</div>
			</div>	
		</form>
	
<?php	
	
	}
	
	public function visualizar(){
		
		$lista = $_REQUEST['DADOS_CHAMADO'];
		
		$historico = $_REQUEST['HISTORICO_CHAMADO'];
		
?>		
	
		<div class="row linha-modal-processo">
			<div class="col-md-12">
				<?php if($lista['DS_STATUS'] =='ABERTO'){ ?>
				
						<a href="/editar/chamado/status/<?php echo $lista['ID'] ?>/FECHADO"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Fechar chamado&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar-check-o" aria-hidden="true"></i></button></a>
				
				<?php } 	
				
				if($lista['DS_STATUS']=='FECHADO' and $lista['DS_AVALIACAO'] != "SEM AVALIAÇÃO"){ ?>
				
						<a href="/editar/chamado/status/<?php echo $lista['ID'] ?>/ENCERRADO"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Encerrar chamado&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar-check-o" aria-hidden="true"></i></button></a>
				<?php } 
				
				if($lista['DS_STATUS']=='ABERTO'){ ?>
						
						<a href="/excluir/chamado/<?php echo $lista['ID'] ?>"><button type='submit' onclick="return confirm('Você tem certeza que deseja apagar este chamado?');" class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Excluir&nbsp;&nbsp;&nbsp;<i class="fa fa-trash" aria-hidden="true"></i></button></a>
					
				<?php } ?>
			</div> 
		</div>
		<div class="row linha-modal-processo">
			<div class="col-md-12">
				<b>Status</b>: <?php echo $lista['DS_STATUS'] ?><br><br>	
				<b>Data de abertura  </b>: <?php echo date_format(new DateTime($lista['DT_ABERTURA']), 'd/m/Y H:i:s') ?><br> 
				<b>Data de fechamento  </b>: 
					<?php 
						
						$data = ($lista['DT_FECHAMENTO'] == NULL) 
							? "Sem data" 
							: date_format(new DateTime($lista['DT_FECHAMENTO']), 'd/m/Y H:i:s');
						
						echo $data;
						
					?>
				<br> 
				<b>Data de encerramento  </b>: 
					<?php 
						
						$data = ($lista['DT_ENCERRAMENTO'] == NULL) 
							? "Sem data" 
							: date_format(new DateTime($lista['DT_ENCERRAMENTO']), 'd/m/Y H:i:s');
						
						echo $data;
						
					?>
				<br>  
				<b>Requisitante</b>: <?php echo $lista['DS_NOME_REQUISITANTE'] ?><br>
				<b>Problema</b>: <?php echo $lista['DS_PROBLEMA'] ?><br> 
				<b>Natureza</b>: <?php echo $lista['DS_NATUREZA'] ?>	
			</div>
		</div>
		<?php 
		
			$this->carregarHistorico($historico); 
			
			if($lista['DS_AVALIACAO'] == 'SEM AVALIAÇÃO' and $lista['DS_STATUS'] != 'ENCERRADO'){
			
				$this->carregarEnviarMensagem('chamado', $lista['ID']);
			
			}
			
			if($lista['DS_AVALIACAO'] == 'SEM AVALIAÇÃO' and $lista['DS_STATUS'] == 'FECHADO'){
				
		?>
		
				<div class="row linha-modal-processo">
					<form name="cadastro" method="POST" action="/editar/chamado/avaliar/<?php echo $lista['ID'] ?>/" enctype="multipart/form-data">
						<div class="col-md-10">
							<select class="form-control" id="avaliacao" name="avaliacao" required/>
								<option value="">Avalie o atendimento</option>
								<option value="PÉSSIMO">PÉSSIMO</option>
								<option value="RUIM">RUIM</option>
								<option value="REGULAR">REGULAR</option>
								<option value="BOM">BOM</option>
								<option value="EXCELENTE">EXCELENTE</option>
							</select>
						</div>
						<div class='col-md-2'>
							<button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-dar-saida'>Avaliar &nbsp;&nbsp;<i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
						</div>
					</form>				
				</div>

		<?php
			
			}
			
		?>

<?php		
	}
}

?>