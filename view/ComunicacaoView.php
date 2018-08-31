<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/View.php';

class ComunicacaoView extends View{

	
	public function adicionarScripts(){ ?>
		
		
		<script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
		
		<script>tinymce.init({ selector:'textarea' })</script>
		
		
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
			
		</script>

		
		<script type='text/javascript' src='/view/_libs/js/js_responsiveslides.js'></script>
		<link rel='stylesheet' href='/view/_libs/css/responsiveslides.css'>
		<script>
		  $(function() {
			$('.rslides').responsiveSlides();
		  });
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
						<td><?php echo date_format(new DateTime($comunicacao['DT_PUBLICACAO']), 'd/m/Y H:i'); ?></td>
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
		
		$this->carregarFormulario();
	
	}
	
	
	public function editar(){
		
		$this->carregarFormulario();
		
	}
	
	
	public function carregarFormulario(){
		
		
		if($this->conteudo == 'editar'){
			
			$listaDados = $_REQUEST['DADOS_COMUNICACAO'];
			$listaDadosImagens = $_REQUEST['DADOS_IMAGENS'];
			$action = "/editar/comunicacao/info/".$listaDados['ID']."/";
			$nomeBotao = 'Editar Informações';
			
		}else{
			
			$action = '/cadastrar/comunicacao/';
			$nomeBotao = 'Cadastrar';
			
		}

?>
		
		
		<form name='cadastro' id='cadastro' method='POST' action="<?php echo $action; ?>" enctype='multipart/form-data'>
			<div class='row'>
				<div class='col-md-12'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Chapéu</label>
						<input class='form-control' id='chapeu' name='chapeu' placeholder='Máximo de 30 caracteres' 
						type='text' maxlength='30' value="<?php if($this->conteudo=='editar'){echo $listaDados['DS_CHAPEU'];} ?>" required />	
					</div> 
				</div>
			</div>
			<div class='row'>
				<div class='col-md-12'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Título</label>
						<input class='form-control' id='titulo' name='titulo' placeholder='Máximo de 100 caracteres' 
						type='text' maxlength='100' value="<?php if($this->conteudo=='editar'){echo $listaDados['DS_TITULO'];} ?>" required />	
					</div>  
				</div>
			</div>
			<div class='row'>
				<div class='col-md-12'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Intertítulo</label>
						<input class='form-control' id='intertitulo' name='intertitulo' placeholder='Máximo de 200 caracteres' 
						type='text' maxlength='200' value="<?php if($this->conteudo=='editar'){echo $listaDados['DS_INTERTITULO'];} ?>" required />	
					</div>  
				</div>
			</div>
			<div class='row'>
				<div class='col-md-12'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Créditos</label>
						<input class='form-control' id='creditos' name='creditosTexto' placeholder='Máximo de 30 caracteres' 
						type='text' maxlength='30' value="<?php if($this->conteudo=='editar'){echo $listaDados['DS_CREDITOS'];} ?>" required />	
					</div>  
				</div>
			</div>
			<div class='row'>
				<div class='col-md-12'>
					<div class='form-group'>
						<label class='control-label' for='exampleInputEmail1'>Texto</label>
						<textarea class='form-control' id='texto' name='texto' rows='15' required /><?php if($this->conteudo=='editar'){echo $listaDados['TX_NOTICIA'];}else{echo "Seu texto aqui";} ?></textarea>	
					</div>  
				</div>
			</div>
			<div class='row'>
				<div class='col-md-12'>
					<label class='control-label' for='exampleInputEmail1'>Data de publicação</label>
					<input type='datetime-local' name='dataPublicacao' id='dataPublicacao' value="<?php if($this->conteudo=='editar'){echo $listaDados['DT_PUBLICACAO'];} ?>" required /><br>
				</div>
			</div>	
			<div class='row'>
				<div class='col-md-6' >
					<label class='control-label' for='exampleInputEmail1'>Adicionar imagens</label>
					<a href='javascript:void(0)' onclick='adicionarImagem()'>
						<i class='fa fa-plus-circle' aria-hidden='true'></i>
					</a>
				</div>
			</div>
			
			<div id='adicionarImagem'>
			
			
			</div>	
			
			<div class='row' id='cad-button'>
				<div class='col-md-12'>
					<button type='submit' class='btn btn-default' name='submit' value='Send' id='submit'><?php echo $nomeBotao ?></button>
				</div>
			</div>	
		</form>

		
<?php if($this->conteudo == 'editar'){ ?>
		
		
		<div class='row linha-modal-processo'>
		<h3>Edição de Imagens</h3><br>
			<div>
					
				<?php foreach($listaDadosImagens as $imagem){
				
					$caminho = $_SERVER['DOCUMENT_ROOT'] . "/_registros/fotos-noticias/".$imagem['DS_ARQUIVO']; ?>
					
					<form name='cadastro' id='cadastro' method='POST' action="/editar/comunicacao/imagem/<?php echo $listaDados['ID'] ?>/<?php echo $imagem['ID'] ?>" enctype='multipart/form-data'>
						
						
						<div class='row'>
							<div class='col-md-12'>
								<strong>Nome: <?php echo $imagem['DS_ARQUIVO'] ?> (<a onclick="return confirm('Tem certeza que deseja apagar este registro?')" href="/editar/comunicacao/excluir-imagem/<?php echo $listaDados['ID'] ?>/<?php echo $imagem['ID'] ?>/<?php echo $imagem['DS_ARQUIVO'] ?>" >Excluir</a>)</strong>
							</div>
						</div>
						
						
						<div class='row'>
							<div class='col-md-4'>
								Legenda:<br>
								<input class='form-control' id='legenda' name='legendaEditar' value='<?php echo $imagem['DS_LEGENDA'] ?>' placeholder='Máximo de 100 caracteres' type='text' maxlength='100' required />	
							</div>
							<div class='col-md-4'>
								Créditos:<br>
								<input class='form-control' id='creditos' name='creditosEditar' value='<?php echo $imagem['DS_CREDITOS'] ?>' placeholder='Máx. de 30 caracteres' type='text' maxlength='30' required />
							</div>
							<div class='col-md-2'>
								É pequena?<br>
								<select class='form-control' id='pequenas' name='pequenaEditar' placeholder='Máximo de 30 caracteres' type='text' maxlength='30' required />
									<option value='<?php echo $imagem['BL_PEQUENA'] ?>'><?php if($imagem['BL_PEQUENA']){echo "Sim";}else{echo "Não";} ?></option>
									<option value='0'>Não</option>
									<option value='1'>Sim</option>
								</select>
							</div>
							<div class='col-md-2'>
								<button type='submit' class='btn btn-sm btn-success' name='submit' value='Send' style='margin-top:32px;'>Editar</button>
							</div>
						</div>	
					</form>
					<hr>
	<?php       } ?>
			
			</div>
		</div>	

<?php } 

	}
	
	
	public function visualizar(){ 
		
		
		$lista = $_REQUEST['DADOS_COMUNICACAO'];		
		$listaImagensGrandes = $_REQUEST['IMAGENS_GRANDES'];
		$listaImagensPequenas = $_REQUEST['IMAGENS_PEQUENAS'];
		
?>		
		<div class='container caixa-conteudo'>
			<div class='row'>
				<div class='col-lg-12'>
					<div class='container'>
						<div class='row' style='margin-top: 10px;'>
							<?php if($lista['DS_STATUS'] != 'INATIVA'){ ?>
							<div class='col-md-12'>
								<div class='row linha-modal-processo'>
										<!-- botao de ocultar ou publicar uma noticia. quando ela esta ocultada, não se vÊ na lista de noticias da pagina home. quando esta publicada, esta visivel para todos na pagina home. 
										o botao oculta a noticia -->
										<?php if($lista['DS_STATUS'] == 'OCULTADA'){ ?>
										
											<a href="/editar/comunicacao/status/<?php echo $lista['ID'] ?>/PUBLICADA"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Publicar</button></a>
											
										<?php } 
										
										
										if($lista['DS_STATUS'] == 'PUBLICADA'){ ?>

											<a href="/editar/comunicacao/status/<?php echo $lista['ID'] ?>/OCULTADA"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Ocultar</button></a>
										
										<?php } ?>
										
										
										<a href="/editar/comunicacao/status/<?php echo $lista['ID'] ?>/INATIVA"><button type='submit' class='btn btn-sm btn-info pull-left' name='submit' value='Send' id='botao-dar-saida'>Inativar</button></a>
																	
																						
										<a onclick="return confirm('Tem certeza que deseja apagar esta comunicação?')" href="/excluir/comunicacao/<?php echo $lista['ID'] ?>"><button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-dar-saida'>Excluir</button></a>
											
										<a href="/comunicacao/editar/<?php echo $lista['ID'] ?>"><button type='submit' class='btn btn-sm btn-info pull-right' name='submit' value='Send' id='botao-dar-saida'>Editar</button></a>					
								
								<?php } ?>
								
								</div>
														
								<div class='row linha-modal-processo'>
									
									<font size='2px'>Publicada em: <?php echo date_format(new DateTime($lista['DT_PUBLICACAO']), 'd/m/Y H:i'); ?></font><br><br>
									
									<h5><?php echo $lista['DS_CHAPEU'] ?></h5><br>
									
									<h3><strong><?php echo $lista['DS_TITULO'] ?></strong></h3><br>
									
									<h5><?php echo $lista['DS_INTERTITULO'] ?></h5><br>
									
									
									<?php if(count($listaImagensGrandes) > 0) { ?>
										
												<ul id='imagensgrandes' class='rslides'>
												
													<?php $this->carregarImagens($listaImagensGrandes); ?> 
												
												</ul>
									<br>
									
									<h6>
									<?php } echo $lista['DS_CREDITOS']; ?>
									
									</h6><br><br>				
									
									<div>
										
										<?php if(count($listaImagensPequenas) > 0) { ?>
											
												<ul id='imagenspequenas' class='rslides'>
												
													<?php $this->carregarImagens($listaImagensPequenas); ?> 
												
												</ul>
											
										<?php }	echo $lista['TX_NOTICIA']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	

<?php		
	}
	
	
	public function carregarImagens($lista){
		
		foreach($lista as $imagem){

?>
			<li class='modal-card-foto3'>	
				<img src="/_registros/fotos-noticias/<?php echo $imagem['DS_ARQUIVO'] ?>" ></img>
				<p style='text-align:center;'><small><?php echo $imagem['DS_LEGENDA'] . " (" . $imagem['DS_CREDITOS'] . ") " ?></small></p>
			</li>
					
<?php  	}
		
	}
	
}

?>