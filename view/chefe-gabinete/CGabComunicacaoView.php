<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/view/ComunicacaoView.php';

class CGabComunicacaoView extends ComunicacaoView{

	
	//esta função mostra a noticia em si. ela é utilizada em dois momentos. uma é mostrada ao usuario que acessa com o botao visualizar na tabela de registros, e a outra é quando o usuário clica na noticia na pagina de home
	public function visualizar(){ 
		
		//as variaveis sao solicitadas ao comunicacao controller
		$lista = $_REQUEST['DADOS_COMUNICACAO'];		
		$listaImagensGrandes = $_REQUEST['IMAGENS_GRANDES'];
		$listaImagensPequenas = $_REQUEST['IMAGENS_PEQUENAS'];
		
?>		
		<div class='container caixa-conteudo'>
			<div class='row'>
				<div class='col-lg-12'>
					<div class='container'>
						<div class='row' style='margin-top: 10px;'>
							<div class='col-md-12'>
								<div class='row linha-modal-processo'>
									
									<font size='2px'>Publicada em: <?php echo date_format(new DateTime($lista['DT_PUBLICACAO']), 'd/m/Y H:i'); ?></font><br><br>
									
									<h5><?php echo $lista['DS_CHAPEU'] ?></h5><br>
									
									<h3><strong><?php echo $lista['DS_TITULO'] ?></strong></h3><br>
									
									<h5><?php echo $lista['DS_INTERTITULO'] ?></h5><br>
									
									<!-- mostra as imagens grandes da noticia -->
									<?php if(count($listaImagensGrandes) > 0) { ?>
								
											<ul id='imagensgrandes' class='rslides'>
											
												<?php $this->carregarImagens($listaImagensGrandes); ?> 
											
											</ul>
									<br>
									
									<h6>
									<?php } echo $lista['DS_CREDITOS']; ?>
									
									</h6><br><br>				
									
									<div>
										<!-- mostra as imagens pequenas da noticia -->
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
	
}

?>